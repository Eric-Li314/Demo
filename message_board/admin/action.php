<?php
header("Content-type: text/html; charset=utf-8");
session_start();
if(@!$_SESSION['username'] && @!$_COOKIE['username']){
    header('location:login.php');
    die;
}
if(!isset($_REQUEST) || empty($_REQUEST)){die("非法访问！！！");}

$dsn = 'mysql:host=mysql.sql39.eznowdata.com;dbname=sq_boyyb88';
$pdo = new PDO($dsn,'sq_boyyb88','yb19870210');
$pdo -> exec("set names utf8");

$id = $_REQUEST['id'];

if(isset($_REQUEST['action']) && $_REQUEST['action'] == 'check'){
    $sql = "update sq_boyyb88.message set checked=1 where id=$id";
    $pdos = $pdo -> prepare($sql);
    $pdos -> execute();
    $url= $_SERVER['HTTP_REFERER'];
    header("location:$url");
}
if(isset($_REQUEST['action']) && $_REQUEST['action'] == 'update'){
    $message = $_REQUEST['message'];
    $contact = $_REQUEST['contact'];
    $ref = $_REQUEST['ref'];
    $sql = "update sq_boyyb88.message set message='$message',contact='$contact' where id=$id";
    $pdos = $pdo -> prepare($sql);
    $pdos -> execute();
    if(!$pdos->rowCount()){die("更新失败！！！<a href='admin.php'>返回管理页</a>");}
    header("location:$ref");

}
if(isset($_REQUEST['action']) && $_REQUEST['action'] == 'delete'){
    $sql = "delete from sq_boyyb88.message where id=$id";
    $pdos = $pdo -> prepare($sql);
    $pdos -> execute();
    $url= $_SERVER['HTTP_REFERER'];
    header("location:$url");
}

