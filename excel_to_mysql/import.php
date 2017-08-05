<?php
header('Content-Type: text/html; charset=utf-8');
set_time_limit(3600);//执行最大超时时间

//数据库连接参数
$host = "localhost";
$user = "root";
$pwd = "mysql";
$dbname = "yjp";
$dbtable = "yg_staff";

@$db = new mysqli($host, $user, $pwd, $dbname);
if (mysqli_connect_errno()) {
    echo "连接失败" . mysqli_connect_error();
    exit();
}
$db->query("set names utf8");

//引入PHPExcel类
require_once('./PHPExcel/Classes/PHPExcel.php');
require_once('./PHPExcel/Classes/PHPExcel/IOFactory.php');
require_once('./PHPExcel/Classes/PHPExcel/Reader/Excel5.php');
require_once('./PHPExcel/Classes/PHPExcel/Reader/Excel2007.php');


//导入文件路径
$file_name = './社区人员.xlsx';
$filePath = iconv('utf-8', 'gbk', $file_name);

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

//$key = array_search('杨家坪街道', $arr);//根据值来找键

//读取Excel文件
$PHPExcel = $PHPReader->load($filePath);
//读取excel文件中的第一个工作表 就是底部的sheet1,sheet2,sheet3
$sheet = $PHPExcel->getSheet(0);
//取得最大的列号, 字母
$allColumn = $sheet->getHighestColumn();
//取得最大的行号，数字
$allRow = $sheet->getHighestRow();
//从第几行开始读取数据
$startRow = 2;

$arr = array(
    '0100020100' => '杨家坪街道',
    '0100020101' => '西郊二村社区',
    '0100020102' => '西郊三村社区',
    '0100020103' => '杨渡路社区',
    '0100020104' => '前进路社区',
    '0100020105' => '杨渡村社区',
    '0100020106' => '团结路社区',
    '0100020107' => '兴胜路社区',
    '0100020108' => '天宝路社区',
    '0100020109' => '天兴路社区',
    '0100020110' => '新华一村社区',
    '0100020111' => '新华二村社区',
    '0100020112' => '华新三村社区',
    '0100020113' => '新胜村社区'
);

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

$check_repeat = 0;//是否检测重复数据，0为不检测直接插入
echo "导入开始！<br/>";
$time_s = time();
for ($currentRow = $startRow; $currentRow <= $allRow; $currentRow++) {
    //获取对应列的数值
    //$community = $PHPExcel->getActiveSheet()->getCell("C" . $currentRow)->getValue();
    //$acode = array_search($community, $arr);//根据值来找键
    //$name = $PHPExcel->getActiveSheet()->getCell("D" . $currentRow)->getValue();
    //$idnum = $PHPExcel->getActiveSheet()->getCell("E" . $currentRow)->getValue();
    //$cernum = $PHPExcel->getActiveSheet()->getCell("F" . $currentRow)->getValue();
    //$cjtype = $PHPExcel->getActiveSheet()->getCell("G" . $currentRow)->getValue();
    //$cjlevel = $PHPExcel->getActiveSheet()->getCell("H" . $currentRow)->getValue();
    //$guardian = $PHPExcel->getActiveSheet()->getCell("L" . $currentRow)->getValue();
    //$note = $PHPExcel->getActiveSheet()->getCell("M" . $currentRow)->getValue();
    $name = $PHPExcel->getActiveSheet()->getCell("B" . $currentRow)->getValue();
    $note = $PHPExcel->getActiveSheet()->getCell("A" . $currentRow)->getValue();
    $phone = $PHPExcel->getActiveSheet()->getCell("D" . $currentRow)->getValue();
    $position = $PHPExcel->getActiveSheet()->getCell("C" . $currentRow)->getValue();

    if($check_repeat){ //检测重名数据，更新旧数据 （检测条件具体分析，可能结合idnum、newest这些）
        //判断数据是否已经存在，存在则更新，不存在则插入
        $flag = $db -> query("select name from ".$dbtable." where name='$name'");
        if($flag->num_rows){
            $sql = "update ".$dbtable." set sex='$sex',age='$age' where name='$name'";
            $db->query($sql);
            if(!$db->affected_rows){
                $log_update['fail'] += 1;
                $log_update['failname'][] = $name;
            }else{
                $log_update['success'] += 1;
            }
        }else{
            $sql = "insert ".$dbtable."(name,age,sex) values('{$name}','{$age}','{$sex}')";
            $db -> query($sql);
            if(!$db->affected_rows){
                $log_insert['fail'] += 1;
                $log_insert['failname'][] = $name;
            }else{
                $log_insert['success'] += 1;
            }
        }
    }else{ //不检测旧数据，直接插入
        $sql = "insert ".$dbtable."(name,phone,position,note,newest,other_community) values('{$name}','{$phone}','{$position}','{$note}',0,1)";
        $db -> query($sql);
        if(!$db->affected_rows){
            $log_insert['fail'] += 1;
            $log_insert['failname'][] = $name.'-'.$phone;
        }else{
            $log_insert['success'] += 1;
        }
    }


}

$time_e = time();

echo "导入完成!<br/>";
echo "耗时：",$time_e-$time_s,"秒";
var_dump($log_insert);
//var_dump($log_update);

$db -> close();