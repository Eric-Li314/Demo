<?php
require_once 'db.class.php';
$db = new DB();

$action = isset($_GET['action'])?$_GET['action']:"";

if($action==""){ //读取数据，返回json
    //获得所有未抽中的手机号码
    $data = $db->getAll('member',"*","status=0");
    //处理手机号码
    foreach($data as $k=>$v){
        $data[$k]['mobile'] = substr($v['mobile'],0,3)."****".substr($v['mobile'],-4,4);
    }
    echo $data?json_encode($data):'';
}else{ //标识中奖号码
    $id = $_POST['id'];
    $db->update('member',array("status"=>1),"id=$id");
    if($db->getAffectedRows()){
        echo '1';
    }
}