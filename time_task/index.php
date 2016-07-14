<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>定时任务</title>
</head>
<body>
<p align="center">每间隔一段时间执行一次php脚本</p><hr/>
<p>每隔一段时间会向当前目录下的log.txt文件写入一条数据！</p>
<a href="index.php?run=true">开始测试</a>
</body>
</html>

<?php
if(isset($_REQUEST['run'])){
    $run = require_once 'switch.php';
    //ignore_user_abort();//即使Client断开(如关掉浏览器)，PHP脚本也可以继续执行.
    //set_time_limit(0);//执行时间为无限制，php默认的执行时间是30秒，通过set_time_limit(0)可以让程序无限制的执行下去
    date_default_timezone_set('PRC'); //切换到中国的时间
    ini_set('memory_limit','512M');//内存使用限制
    $interval=5;//时间间隔 秒
    do{
        if(!$run){break;}//定时任务控制开关 ,switch.php文件不存在则停止定时任务
        $fp = fopen("log.txt","a");//以追加方式打开
        fwrite($fp,date('Y-m-d H:i:s',time()).' testdata'."\r\n");
        fclose($fp);
        sleep($interval);//等待延迟到达后执行
    }while(true);
}
?>