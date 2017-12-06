<?php

/**
 * Created by PhpStorm.
 * User: USER
 * Date: 2017/10/24
 * Time: 11:11
 */
include_once "../common/db.class.php";
$db = new DB();
$lastid_temp = $_REQUEST['lastid'];

$data = $db ->getAll("monitor","id,time,avg","","id desc","200"); //查询结果 　　
$lastid = $data[0]['id'];
//有新数据插入，响应客户端请求
if($lastid != $lastid_temp){
    //构建返回数据格式
    foreach($data as $k=>$v){
        $his_time = date("H:i:s",strtotime($v['time']));
        $data[$k]['histime'] = $his_time;
        $data[$k]['name'] = $v['time'];
        $data[$k]['value'] = array($v['time'],$v['avg']);
    }
    krsort($data);
    $data = array_values($data);
    echo json_encode(array("lastid"=>$lastid,"data"=>$data));
}else{
    echo "";
}