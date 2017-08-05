<?php
header("content-type:text/html;charset=utf-8");
include "./public/db.class.php";

if (!isset($_REQUEST)) {
    die("非法访问!!");
}

$db = new DB();
$nickname = $_REQUEST['nickname'];
$lastid = $_REQUEST['lastid'];

//获取最新数据 每秒读一次数据
//$data = $db->getAll("webim", "*", "time=$time and nickname != '$nickname'", "id asc");
$data = $db ->getAll("webim","*","id>$lastid and nickname != '$nickname'","id asc");//排除自己的发言信息，前端已经显示
if ($data) {
    //设置lastid到json中
    $lastarr = end($data);
    $lastid = $lastarr['id'];
    $ret['lastid']=$lastid; //lastid
    $ret['data']=$data;  //发言数据
    echo json_encode($ret);
} else {
    echo 0;
}
