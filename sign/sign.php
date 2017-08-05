<?php
if(!isset($_POST['sign'])){
    die('no post data！');
}

@$db = new mysqli('localhost','root','','test');
if(mysqli_connect_errno()){
    echo "连接失败".mysqli_connect_error();
    exit();
}

$db->query("set names utf8");
$time = time();
$res = $db->query('select score,lxdays,signtime from sign where name="bin"');
$num = $res->num_rows;
$data = $res->fetch_all(MYSQLI_ASSOC);
$data = $data[0];
$score = $data['score'];
if($num){
    //更新
    $interval = $time - $data['signtime'];
    //一天之内重复签到
    if($interval<86400){
        echo '今天已经签过到了！！请勿重复签到。';
    }
    //连续签到
    if($interval>=86400 && $interval<172800) {
        $lxdays = $data['lxdays'] + 1;
        switch($lxdays){
            case 2:$score += 5;break;//连续签到2天加5分，以下同理
            case 3:$score += 10;break;
            case 4:$score += 18;break;
            default:$score += 30;
        }
        $db->query("update sign set score='{$score}',lxdays='{$lxdays}',signtime='{$time}' where name='bin'");
        echo $db->affected_rows>0 ? "连续签到{$lxdays}天！" : "连续签到失败！";
    }
    //签到间隔超过1天
    if($interval>172800){
        $score = $data['score']+2;
        $lxdays = 1;
        $db->query("update sign set score='{$score}',lxdays='1',signtime='{$time}' where name='bin'");
        echo $db->affected_rows>0 ? '签到成功！' : '签到失败！';
    }

}else{
    //第一次签到 插入
    $db->query("insert sign(name,score,signtime) value('bin','2','$time');");
    echo $db->affected_rows>0 ? '签到成功！' : '签到失败！';
}