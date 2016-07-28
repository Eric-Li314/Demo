<?php 
	include("../sqlsafe.php");
	include("../conn.php");
	$_SESSION['user'] = $_SESSION['admin'] = NULL;
	$username = $_POST['username'];
	$passwd = $_POST['passwd'];
	
	$sql = "select * from users where username='$username' and passwd='$passwd';";
	$result = $db->query($sql);
	if($result->num_rows > 0){
		$rank = $db->query("select * from users where username='$username' and admin='1'");
		@session_start();
		if($rank->num_rows > 0){
			$_SESSION['admin']=true;
			$_SESSION['user']=false;
			$_SESSION['name']=$username;
			echo "<meta http-equiv=\"Refresh\" content=\"0;url=index.php\">";
		}else{
			$_SESSION['user']=true;
			$_SESSION['admin']=false;
			$_SESSION['name']=$username;
			echo "<meta http-equiv=\"Refresh\" content=\"0;url=../\">";
		}
		
	}else{
		echo "<script>alert('账户或密码错误')</script>";
		echo "<meta http-equiv=\"Refresh\" content=\"0;url=login.html\">";
	}

?>