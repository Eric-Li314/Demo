<?php
header("content-type:text/html;charset=utf-8");
date_default_timezone_set("PRC");
include "./public/db.class.php";
$db = new DB();

if(!isset($_REQUEST)){
    die("非法访问!!");
}

$time = time();

$nickname = $_REQUEST['nickname'];

//更新用户下线时间，因为每隔10s轮询一次，下线时间为延迟30s,当用户据关闭网页后，等待30s后判断为下线
$db -> update("webim",array("offline"=>time()+30),"nickname='$nickname' and offline>$time");

//统计下线用户
$data = $db -> getAll("webim","distinct(nickname),offline","online=1 and offline<$time"); //distinct(nickname) 去除重复的昵称
if($data){
    foreach($data as $v){
        $nickname = $v["nickname"];
        //设置下线状态
        $db->update("webim",array("online"=>0),"nickname='$nickname'");

        //添加用户下线消息
        $dataArr = array(
            "nickname"=>$v['nickname'],
            "time"=>time(),
            "type"=>"提示",
            "content"=>" 下线了！ ",
            "offline"=>$v['offline'],
            "online"=>0,
        );

        $db -> add("webim",$dataArr);
    }
}

//每10轮询的话，取极端情况分析：如果用户离线时间尾数是0，则需要10秒（time-offline=10）
//如果尾数是9的话，则需要1秒，
//所以如果是活跃用户下线的话，time和offline的时间差在1和10之间。如果是用户很久下线了，time-offline就大于10
//根据这个条件可以排除之前用户下线的提示消息
