<?php
header('Content-type: application/json');

$fun = $_REQUEST ['jsoncallback'];
if($fun=="get"){ //ajax传统请求，受到跨域限制
    echo "[11,22,33,44]";
}else{
    //获取回调函数名--jsonp 跨域
    $jsoncallback = htmlspecialchars($fun);
    //json数据
    $json_data = '["aa","bb","cc","dd"]';
    //输出jsonp格式的数据，是一个带有参数的函数的字符串 如 fun(4)
    echo $jsoncallback . "(" . $json_data . ")";
}

