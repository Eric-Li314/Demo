<?php
session_start();
if(!$_REQUEST['logout']){die('非法操作！');}

session_unset();
session_destroy();
header("location:login.php");




