<?php
if(@$_POST){
    echo "已接收到post数据：<br/>";
    echo json_encode($_POST);
}