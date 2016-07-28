<?php
require_once('db.class.php'); //数据库连接文件
require_once('function.php');  //函数调用文件
if(isset($_POST['saytxt'])){
    $db = new DB();
    $ip=$_REQUEST['ip'];
    $location = $_REQUEST['location'];
    $txt=stripslashes($_POST['saytxt']); //删除反斜杠
    $txt=strip_tags($txt); //过滤HTML标签，
    $txt=htmlspecialchars($txt);//转义html实体，转义特殊字符
    if(mb_strlen($txt,"utf-8")<1 || mb_strlen($txt,"utf-8")>140)
        die("0"); //判断输入字符数是否符合要求
    $time=time(); //获取当前时间
    $userid=rand(0,4);
    //插入数据到数据表中
    $db->execSql("insert into say(userid,content,addtime,ip,location) values ('$userid','$txt','$time','$ip','$location')");
    if(!$db->getLastId())
        die("0");
    echo formatSay($txt,$time,$userid,$location); //调用函数输出结果
}else{
    die("非法访问！");
}
