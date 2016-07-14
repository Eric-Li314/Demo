<?php
header('content-type:text/html;charset=utf-8');
require_once 'db.class.php';
$db = new DB();

$res = $db -> getFields('vote');
var_dump($res);

$update = array('ip'=>'1.115.211.2','time'=>'1215111','name'=>'frd','idnum'=>'4444444','sex'=>'男');
$data = $db ->create('vote',$update);//处理数据，过滤无关字段
$res = $db->add('vote',$data);
var_dump($res);
var_dump($db->getLastId());
var_dump($db->getRowCount('vote'));
var_dump($db->getAffectedRows());




