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
$data = $db -> getAll("webim","distinct(nickname)","online=1 and offline<$time"); //distinct(nickname) 去除重复的昵称
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
            "offline"=>time()-60,
            "online"=>0,
        );

        $db -> add("webim",$dataArr);
    }
}

