<?php
header('content-type:text/html;charset=utf-8');
session_start();
if(isset($_REQUEST)){
    if(isset($_REQUEST['token']) && $_REQUEST['token']){
        $token_post = $_REQUEST['token'];
        $token_session = @$_SESSION['token'];
        if($token_post == $token_session){
            echo "合法提交";
            //验证通过可以销毁
            var_dump($_REQUEST);
            session_unset();
            session_destroy();
        }else{
            echo "重复提交";
            var_dump($_REQUEST);
        }
    }else{
        echo "非法提交，没有token参数";
    }
}else{
    echo "非法访问！！！";
}
