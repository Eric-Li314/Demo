<?php

header("content-type:text/html;charset=utf-8");
date_default_timezone_set("PRC");
include "./public/db.class.php";
$db = new DB();

if(!isset($_REQUEST)){
    die("非法访问!!");
}

$nowtime = time();

$nickname = $_REQUEST['nickname'];

//查询是否有在线同名的昵称
if($_REQUEST['action'] == "addnickname"){
    $res = $db->getOne("webim","*","nickname='$nickname' and offline>$nowtime");
    if($res){
        die("repeat");
    }
}

//保存发送内容
    $dataArr = array(
        "nickname"=>$_REQUEST['nickname'],
        "time"=>$nowtime,
        "type"=>$_REQUEST['type'],
        "content"=>$_REQUEST['content'],
        "offline"=>$nowtime+30, //设置离线时间为当前时间+30秒
        "online"=>1,   //设置在线状态
    );

    $db -> add("webim",$dataArr);
    if($db->getLastId()){
        echo json_encode(array("status"=>"ok","time"=>date("Y-m-d H:i:s",$nowtime)));
    }else{
        echo json_encode(array("status"=>"error"));
    }

