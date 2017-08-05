<?php
//模拟其他域的数据接口地址，本地模拟时，前面可以设置127段的其他私有地址 如127.0.0.111/...../data.php
if(!isset($_REQUEST['name'])){die;}
$info = array("yangbin"=>"good","xiaoming"=>"bad","lili"=>"great","gg"=>"perfect");
echo $info[$_REQUEST['name']];