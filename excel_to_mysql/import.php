<?php
header('Content-Type: text/html; charset=utf-8');

if($_FILES['inputExcel']['name'] == '' ){
    echo '您没有导入excel文件！','<br/>';
    echo "<a href='index.html'>重新导入</a>";
    die;
}

//处理文件上传
$fileName = "data";
$ext = substr($_FILES['inputExcel']['name'],strrpos($_FILES['inputExcel']['name'],'.'));
unlink($fileName.$ext);//删除之前上传的同名文件
$result=move_uploaded_file($_FILES['inputExcel']['tmp_name'],$fileName.$ext);//假如上传到当前目录下
if(!$result){
    die('文件上传失败');
}

//连接数据库，设置编码
@$db = new mysqli('localhost','root','','yb');
if(mysqli_connect_errno()){
    echo "连接失败".mysqli_connect_error();
    exit();
}
$db->query("set names utf8");


    //引入PHPExcel类（需下载PHPExcel扩展文件），实测只需引入PHPExcel.php即可
    require_once('./PHPExcel/Classes/PHPExcel.php');

    //待导入文件的路径
    $filePath = $fileName.$ext;
    //实例化PHPExcel类
    $PHPExcel = new PHPExcel();
    //默认用excel2007读取excel，若格式不对，则用之前的版本进行读取
    $PHPReader = new PHPExcel_Reader_Excel2007();
    if (!$PHPReader->canRead($filePath)) {
        $PHPReader = new PHPExcel_Reader_Excel5();
        if (!$PHPReader->canRead($filePath)) {
            echo 'no Excel';
            return;
        }
    }

    //读取Excel文件
    $PHPExcel = $PHPReader->load($filePath);
    //读取excel文件中的第一个工作表
    $sheet = $PHPExcel->getSheet(0);
    //取得最大的列号, 字母
    $allColumn = $sheet->getHighestColumn();
    //取得最大的行号，数字
    $allRow = $sheet->getHighestRow();

    //定义日志数据记录插入情况
    $log = array();
    $log['success'] = 0;
    $log['fail'] = 0;
    $log['failname'] = array();
    //从第二行开始插入,第一行是标题，不导入数据库
    for ($currentRow = 2; $currentRow <= $allRow; $currentRow++) {
        //获取A列的值--姓名
        $name = $PHPExcel->getActiveSheet()->getCell("A" . $currentRow)->getValue();
        //获取B列的值--性别
        $sex = $PHPExcel->getActiveSheet()->getCell("B" . $currentRow)->getValue();
        //获取C列的值--年龄
        $age = $PHPExcel->getActiveSheet()->getCell("C" . $currentRow)->getValue();

        //逐行插入到数据库member表
        $sql = "insert member(name,age,sex) values('{$name}','{$age}','{$sex}')";
        $res = $db -> query($sql);
        if(!$res){
            $log['fail'] += 1;
            $log['log'][] = $name;
        }else{
            $log['success'] += 1;
        }
    }


echo "导入完成！Last_Insert_Id：".$db->insert_id,'<br>';
var_dump($log);

$db -> close();
