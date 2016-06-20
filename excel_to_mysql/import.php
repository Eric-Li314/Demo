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
//读取excel文件中的第一个工作表,sheet1、sheet2、sheet3
$sheet = $PHPExcel->getSheet(0);
//取得最大的列号, 字母
$allColumn = $sheet->getHighestColumn();
//取得最大的行号，数字
$allRow = $sheet->getHighestRow();

//定义日志数据记录插入和更新情况
$log_insert = array();
$log_insert['type'] = "insert";
$log_insert['success'] = 0;
$log_insert['fail'] = 0;
$log_insert['failname'] = array();
$log_update = array();
$log_update['type'] = "update";
$log_update['success'] = 0;
$log_update['fail'] = 0;
$log_update['failname'] = array();
//从第二行开始插入,第一行是标题，不导入数据库
for ($currentRow = 2; $currentRow <= $allRow; $currentRow++) {
    //获取各列的值
    $name = $PHPExcel->getActiveSheet()->getCell("A" . $currentRow)->getValue();
    $sex = $PHPExcel->getActiveSheet()->getCell("B" . $currentRow)->getValue();
    $age = $PHPExcel->getActiveSheet()->getCell("C" . $currentRow)->getValue();

    //判断数据是否已经存在，存在则更新，不存在则插入
    $flag = $db -> query("select * from member where name='$name'");
    if($flag->num_rows){
        $sql = "update member set sex='$sex',age='$age' where name='$name'";
        $db->query($sql);
        if(!$db->affected_rows){
            $log_update['fail'] += 1;
            $log_update['failname'][] = $name;
        }else{
            $log_update['success'] += 1;
        }
    }else{
        $sql = "insert member(name,age,sex) values('{$name}','{$age}','{$sex}')";
        $db -> query($sql);
        if(!$db->affected_rows){
            $log_insert['fail'] += 1;
            $log_insert['failname'][] = $name;
        }else{
            $log_insert['success'] += 1;
        }
    }

}

echo "导入完成!";
var_dump($log_insert);
var_dump($log_update);

$db -> close();
