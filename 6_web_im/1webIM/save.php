<?php

header("content-type:text/html;charset=utf-8");
date_default_timezone_set("PRC");
include "./public/db.class.php";

if(!isset($_REQUEST)){
    die("非法访问!!");
}

$nowtime = time();

$dataArr = array(
    "nickname"=>$_REQUEST['nickname'],
    "time"=>$nowtime,
    "type"=>$_REQUEST['type'],
    "content"=>$_REQUEST['content'],
);

$db = new DB();
$db -> add("webim",$dataArr);
if($db->getLastId()){
    echo json_encode(array("status"=>"ok","time"=>date("Y-m-d H:i:s",$nowtime)));
}else{
    echo json_encode(array("status"=>"error"));
}