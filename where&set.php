<?php
//模拟构建查询语句 where 和 set ，表单post过来的数据中，只处理不为空的数据
$_POST = array("name"=>"bb","sex"=>"boy",'age'=>'','addr'=>'china');
$where =  '';
$set = 'set';
foreach($_POST as $k => $v){
    if($v){
        $where .= " and $k='$v'";
    }
}

echo substr($where,4),'<br/>'; //去掉前面多余的“and”

foreach($_POST as $k => $v){
    if($v){
        $set .= " $k='$v',";
    }
}

echo substr($set,0,-1); //去掉最后一个逗号  -1表示总数减少一位
