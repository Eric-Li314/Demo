<?php
require 'memcached.class.php';
//实例化
$mOb=new memcached(array(
		'servers' => array('127.0.0.1:11211'),
		'debug'   => false,
		'compress_threshold' => 10240,
		'persistant' => true
)
);

$re=$mOb->get("a-1");
$re1=$mOb->get('name');

var_dump($re);
var_dump($re1);

