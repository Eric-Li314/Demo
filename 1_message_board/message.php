<?php
header("Content-type: text/html; charset=utf-8");
date_default_timezone_set("PRC");
if(!$_REQUEST){die('没有接收到数据');}
if(!$_REQUEST['message'] || strlen($_REQUEST['message'])<=5 || !$_REQUEST['contact']){
    die("留言内容至少大于5个字，联系方式不能为空");
}

function getip() {
    $unknown = 'unknown';
    if ( isset($_SERVER['HTTP_X_FORWARDED_FOR'])
        && $_SERVER['HTTP_X_FORWARDED_FOR']
        && strcasecmp($_SERVER['HTTP_X_FORWARDED_FOR'],
            $unknown) ) {
        $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
    } elseif ( isset($_SERVER['REMOTE_ADDR'])
        && $_SERVER['REMOTE_ADDR'] &&
        strcasecmp($_SERVER['REMOTE_ADDR'], $unknown) ) {
        $ip = $_SERVER['REMOTE_ADDR'];
    }
    if (false !== strpos($ip, ','))
        $ip = reset(explode(',', $ip));
    return $ip;
}

$ip = getip();
$contact = $_REQUEST['contact'];
$message = $_REQUEST['message'];
$time = time();

$dsn = 'mysql:host=mysql.sql39.eznowdata.com;dbname=sq_boyyb88';
$pdo = new PDO($dsn,'sq_boyyb88','yb19870210');
$pdo -> exec("set names utf8");

$sql = "insert sq_boyyb88.message(ip,contact,message,time) value('$ip','$contact','$message','$time');";
$pdos = $pdo -> prepare($sql);
$pdos -> execute();
echo $pdos->rowCount()>0 ? "留言成功！！请等待审核。" : "留言失败！！！";
echo '<br/>';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>留言板</title>
</head>
<body>
<br/>
<a href="index.php">返回留言板</a><br/>
<a href="/">返回主页</a><br/>
</body>
</html>



