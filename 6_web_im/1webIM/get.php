<?php
header("content-type:text/html;charset=utf-8");
include "./public/db.class.php";

if(!isset($_REQUEST)){
    die("非法访问!!");
}

$db = new DB();

$time = time()-1;


$data = $db -> getAll("webim","*","time>$time","id desc");

if($data){
    echo json_encode($data);
}else{
    echo 0;
}