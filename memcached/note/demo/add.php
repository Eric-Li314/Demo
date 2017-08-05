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
$re=$mOb->add('a-1',array(1,2,3));
var_dump($re);