<?php
header("content-type:text/html;charset=utf-8");
include "./public/db.class.php";

if(!isset($_REQUEST)){
    die("非法访问!!");
}

$db = new DB();
$nickname = $_REQUEST['nickname'];
$nowtime = time();
$time = $nowtime-1;

//获取最新数据 每秒读一次数据
$data = $db -> getAll("webim","*","time=$time and nickname != '$nickname'","id asc");
if($data){
    echo json_encode($data);
}else{
    echo 0;
}