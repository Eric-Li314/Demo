<?php
header("Content-type: text/html; charset=utf-8");
date_default_timezone_set("PRC");
if(!isset($_POST)){
    die('no post data！');
}
$time = time();
$userip = $_SERVER["REMOTE_ADDR"];
$username = "游客";

$dsn = 'mysql:host=mysql.sql39.eznowdata.com;dbname=sq_boyyb88';
$pdo = new PDO($dsn,'sq_boyyb88','yb19870210');
$pdo -> exec("set names utf8");

$sql = "select score,lxdays,signtime from sign where userip='$userip'";
$pdos = $pdo -> prepare($sql);
$pdos -> execute();
$data = $pdos -> fetchAll(PDO::FETCH_ASSOC);

//处理签到文字状态ajax
if(isset($_POST['text']) && $_POST['text'] == 'ok'){
    if(!$data){die;}
    $signdate = date("Y-m-d",$data[0]['signtime']);//签到日期
    $nowdate = date("Y-m-d");//当前日期
    echo $signdate == $nowdate ? 'signed' : 'sign';
    die;
}

//存在签到数据则更新
if($data){
    $score = $data[0]['score'];

    $signdate = date("Y-m-d",$data[0]['signtime']);//签到日期
    $nowdate = date("Y-m-d");//当前日期
    $interval_days = floor((strtotime($nowdate) - strtotime($signdate))/86400);

    //一天之内重复签到
    if($interval_days == 0){
        echo '今天已经签过到了！！请勿重复签到。';
    }
    //连续签到
    else if( $interval_days == 1) {
        $lxdays = $data[0]['lxdays'] + 1;
        switch($lxdays){
            case 2:$score += 5;break;//连续签到2天加5分，以下同理
            case 3:$score += 10;break;
            case 4:$score += 18;break;
            default:$score += 30;
        }
        $sql = "update sq_boyyb88.sign set score='{$score}',lxdays='{$lxdays}',signtime='{$time}' where userip='$userip'";
        $pdos = $pdo -> prepare($sql);
        $pdos -> execute();
        echo $pdos->rowCount()>0 ? "连续签到{$lxdays}天！" : "连续签到失败！";
    }
    //签到间隔超过1天
    else if($interval_days > 1){
        $score = $data[0]['score']+2;
        $lxdays = 1;
        $sql = "update sq_boyyb88.sign set score='{$score}',lxdays='1',signtime='{$time}' where userip='$userip'";
        $pdos = $pdo -> prepare($sql);
        $pdos -> execute();
        echo $pdos->rowCount()>0 ? "签到成功！" : "签到失败！";
    }else{
        echo "时间设置错误，当前时间小于上次签到时间！";
    }

}else{
    //第一次签到 插入
    $sql = "insert sq_boyyb88.sign(userip,username,score,signtime) value('$userip','$username','2','$time');";
    $pdos = $pdo -> prepare($sql);
    $pdos -> execute();
    echo $pdos->rowCount()>0 ? "签到成功！" : "签到失败！！！";
}