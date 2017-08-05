<?php
header("content-type:text/html;charset=utf-8");
set_time_limit(0);
include "./public/db.class.php";

if (!isset($_REQUEST)) {
    die("非法访问!!");
}

$db = new DB();
$nickname = $_REQUEST['nickname'];
$lastid = $_REQUEST['lastid'];

//获取最新数据 每秒读一次数据
/*$data = $db ->getAll("webim","*","id>$lastid and nickname != '$nickname'","id asc");
if ($data) {
    //设置lastid到json中
    $lastarr = end($data);
    $lastid = $lastarr['id'];
    $ret['lastid']=$lastid;
    $ret['data']=$data;
    echo json_encode($ret);
} else {
    echo 0;
}*/

while (true) { //进入无限循环 　　　　
    $data = $db ->getAll("webim","*","id>$lastid and nickname != '$nickname' and `time`<offline+10","id asc"); //查询结果 　　
    if ($data) {
        //设置lastid到json中
        $lastarr = end($data);
        $lastid = $lastarr['id'];
        $ret['lastid']=$lastid;
        $ret['data']=$data;
        echo json_encode($ret);
        break;//输出信息后退出while循环，结束当前脚本 　　　
    }
    usleep(1000000);//单位是微秒，如果没有信息不会进入if块，但会执行一下等待1秒，防止PHP因循环假死。1秒后再执行循环
}

/*
 * `time`<offline+10 这个条件可以剔除之前已经下线的用户提示信息，不然昨天用户下线的提示，今天会显示到消息中。不合理
 * time和offline的差 在1-10之间




*/
