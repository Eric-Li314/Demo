<?php
header('content-type:text/html;charset=utf-8');
//ajax调用
if(!$_REQUEST){die('非法访问！！！');}
$name = $_REQUEST['name'];
$nameArr = array('admin','root','yangbin','bingo');
$flag['ret'] = in_array($name,$nameArr)?'ok':'fail';
echo json_encode($flag);