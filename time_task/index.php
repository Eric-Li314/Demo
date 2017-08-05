<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>定时任务</title>
</head>
<body>
<p align="center">每间隔一段时间执行一次php脚本</p><hr/>
<p>每隔一段时间会向当前目录下的log.txt/log1.txt文件写入一条数据！</p>
<a href="index.php?start=true">运行脚本</a><hr/>

</body>
</html>

<?php
if(isset($_REQUEST['start'])){
    echo "定时任务脚本运行中...<br/>";
    $run = require_once 'switch.php'; //外部脚本控制开关
    echo "开关状态：";echo $run?"开":"关";echo "<br/>";
    //ignore_user_abort();//即使Client断开(如关掉浏览器)，PHP脚本也可以继续执行.
    //set_time_limit(0);//执行时间为无限制，php默认的执行时间是30秒，通过set_time_limit(0)可以让程序无限制的执行下去
    date_default_timezone_set('PRC'); //切换到中国的时间
    ini_set('memory_limit','512M');//内存使用限制
    $interval=5;//时间间隔 秒
    do{
        if(!$run){break;}//定时任务控制开关 ,switch.php文件不存在或返回false则停止定时任务
        //写入方式1 fopen/fwrite/fclose
        $fp = fopen("log.txt","a");//以追加方式打开
        fwrite($fp,date('Y-m-d H:i:s').' 记录点'."\r\n");
        fclose($fp);
        //写入方式2 file_put_content()-推荐使用
        file_put_contents('log2.txt', date('Y-m-d H:i:s ')."-记录点". "\r\n", FILE_APPEND);
        sleep($interval);//等待延迟到达后执行
    }while(true);
}
?>