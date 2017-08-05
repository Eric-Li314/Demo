<?php
//代理程序
if(!isset($_REQUEST['name'])){die;}
$name = $_REQUEST['name'];
$url = "http://127.0.0.111/more/demo/cross_domain_example/proxy/data.php?".http_build_query($_REQUEST); //其他域的接口地址并携带查询参数
$res = file_get_contents($url); //http请求其他域接口
echo $res;