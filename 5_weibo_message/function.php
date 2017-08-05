<?php
/*时间转换函数*/
function tranTime($time) {
    $rtime = date("m-d H:i",$time);
    $htime = date("H:i",$time);
    $time = time() - $time;

    if ($time < 60) {
        $str = '刚刚';
    }
    elseif ($time < 60 * 60) {
        $min = floor($time/60);
        $str = $min.'分钟前';
    }
    elseif ($time < 60 * 60 * 24) {
        $h = floor($time/(60*60));
        $str = $h.'小时前 '.$htime;
    }
    elseif ($time < 60 * 60 * 24 * 3) {
        $d = floor($time/(60*60*24));
        if($d==1)
            $str = '昨天 '.$rtime;
        else
            $str = '前天 '.$rtime;
    }
    else {
        $str = $rtime;
    }
    return $str;
}

//格式化输出函数是将得到的用户信息和发布内容及时间按照一定的格式输出到前端页面的函数
function formatSay($say,$dt,$uid,$location){
    $say=htmlspecialchars(stripslashes($say));
    $location = $location?$location." 的网友":'';
    return'
    <div class="saylist"><a href="#"><img src="file/'.$uid.'.jpg" width="50" height="50"
    alt="demo" /></a>
    <div class="saytxt">
    <p><strong><a href="#">demo_'.$uid.'</a></strong> '.
    preg_replace('/((?:http|https|ftp):\/\/(?:[A-Z0-9][A-Z0-9_-]*(?:\.[A-Z0-9][A-Z0-9_-]*)+):
    ?(\d+)?\/?[^\s\"\']+)/i','<a href="$1" rel="nofollow" target="blank">$1</a>',$say).'
    </p><div class="date">'.tranTime($dt).'</div>
    <div class="location">'.$location.'</div>
    </div>
    <div class="clear"></div>
    </div>';
}

// 获取IP地址（摘自discuz）
function getIp(){
    $ip='未知IP';
    if(!empty($_SERVER['HTTP_CLIENT_IP'])){
        return is_ip($_SERVER['HTTP_CLIENT_IP'])?$_SERVER['HTTP_CLIENT_IP']:$ip;
    }elseif(!empty($_SERVER['HTTP_X_FORWARDED_FOR'])){
        return is_ip($_SERVER['HTTP_X_FORWARDED_FOR'])?$_SERVER['HTTP_X_FORWARDED_FOR']:$ip;
    }else{
        return is_ip($_SERVER['REMOTE_ADDR'])?$_SERVER['REMOTE_ADDR']:$ip;
    }
}
function is_ip($str){
    $ip=explode('.',$str);
    for($i=0;$i<count($ip);$i++) {
        if($ip[$i]>255){ return false; }
    } return preg_match('/^[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}$/',$str);
}

function getInfoByIp($ip){
    //利用淘宝接口
    $url = "http://ip.taobao.com/service/getIpInfo.php?ip=" . $ip;
    $ip = json_decode(file_get_contents($url));//将json格式的数据转换为对象
    $data = (array)$ip->data;//获得data下的数据并转换为数组
    return $data;//返回一个关联数组
}