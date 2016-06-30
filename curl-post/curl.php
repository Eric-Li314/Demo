<?php
header('content-type:text/html;charset=utf-8');
//初始化
$ch = curl_init();
$url = "http://localhost/Test/curl-post/curl_post.php";
$post_data = array ("username" => "bob","key" => "12345");
//设置
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
//执行，接受回传数据
$output = curl_exec($ch);
//关闭
curl_close($ch);

//打印获得的数据
print_r($output);