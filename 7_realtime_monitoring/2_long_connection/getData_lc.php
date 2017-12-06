<?php

/**
 * Created by PhpStorm.
 * User: USER
 * Date: 2017/10/24
 * Time: 11:11
 */
include_once "../common/db.class.php";
$db = new DB();
$lastid_temp = $_REQUEST['lastid'];

while (true) { //进入无限循环 　　　　
    $data = $db ->getAll("monitor","id,time,avg","","id desc","200"); //查询结果 　　
    $lastid = $data[0]['id'];
    //有新数据插入，响应客户端长连接请求
    if($lastid != $lastid_temp){
        //构建返回数据格式
        foreach($data as $k=>$v){
            $data[$k]['name'] = $v['time'];
            $data[$k]['value'] = array($v['time'],$v['avg']);
        }
        //数组反转或者排序，数据id大的在前面
        $data = array_reverse($data);
       //krsort($data); //排序
        $data = array_values($data); //key重排
        echo json_encode(array("lastid"=>$lastid,"data"=>$data));
        break;//输出信息后退出while循环，结束当前脚本
    }
    //单位是微秒，如果没有新数据不会进入if块，等待设置的时间后继续执行循环查数据库
    usleep(3*1000000);
}