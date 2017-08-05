<?php
	
	$db = new mysqli('127.0.0.1','root','root','simplevote');
	if(mysqli_connect_errno()){
		echo "据库连接失败";
		exit();
	}

 
?>