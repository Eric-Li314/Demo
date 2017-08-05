<?php
header('Access-Control-Allow-Origin: *');  //后端利用header跨域，前端用传统的ajax请求
/**
 * Created by PhpStorm.
 * User: USER
 * Date: 2017/1/23
 * Time: 11:11
 */
echo json_encode(array("数据获取成功"),JSON_UNESCAPED_UNICODE);