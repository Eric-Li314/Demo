<?php 
	include("sqlsafe.php");
	echo '<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />';
	include("conn.php");
	
	@session_start();
	$ss = $_POST;
	if($_POST[num] != (count($ss)-2)){
		echo "<script>alert('请完善你的选择');</script>";
		echo "<script>history.go(-1);</script>";	
		exit();
	}
	if($_POST['code_num'] != $_SESSION['VCODE'] || $_POST['code_num']==''){
		echo "<script>alert('严重码错误');</script>";
		echo "<script>history.go(-1);</script>";	
		exit();	
	}
	
	function voteing($ss, $db)
	{
		/************************************************************
		*功能：把投票信息一条条写进数据库
		*缺点：错误处理机制基本没有，对数据库读写太多，数据库开销大
		*************************************************************/
		
		$success = true;
		foreach($ss as &$value){
			$result = $db->query("select votenum from voteoption where cid='".$value."';");
			$row = mysqli_fetch_assoc($result);
			$result = $db->query("update voteoption set votenum='".($row['votenum']+1)."' where cid='".$value."'");
			if(!$result){
				$success = false;
			}
		}
		if($success){
			foreach($ss as $key => $value){
				$result = $db->query("select sum(votenum) from voteoption where upid='".$key."';");
				$row = mysqli_fetch_assoc($result);
				$result = $db->query("update votename set sumvotenum='".$row['sum(votenum)']."' where cid='$key';");
				if(!$result){
					$success = false;
				}
			}
			if($success){
				return true;
			}
		}
		return false;
	}	
	
	
	$result = $db->query("select * from sysconfig");
	$row = mysqli_fetch_assoc($result);
	
	$now = mktime(0, 0, 0, date("m")  , date("d"), date("Y"));
	$dietimelist = explode("-",$row['dietime']);
	$dietime = mktime(0, 0, 0, $dietimelist[1]  , $dietimelist[2], $dietimelist[0]);
	if(round(($dietime-$now)/3600/24) < 0){
		echo "<script>alert('已经过了投票日期');</script>";
		echo "<meta http-equiv=\"Refresh\" content=\"0;url=index.php\">";
		exit();
	}
	
	if($row['method'] == 1){//ip统计投票
		$clientip = getenv("REMOTE_ADDR");
		$ips = $db->query("select ip from voteips where ip='$clientip';");
		if($ips->num_rows > 0){
			echo "<script>alert('你已经投过票了');</script>";
			echo "<meta http-equiv=\"Refresh\" content=\"0;url=index.php\">";
			exit();
		}else{
			voteing($ss, $db);
			$db->query("insert into voteips (ip) values ('$clientip');");
			echo "<script>alert('投票成功');</script>";
			echo "<meta http-equiv=\"Refresh\" content=\"0;url=index.php\">";	
			exit();
		}
		
		
	}else if($row['method'] == 2){//登录投票
		if($_SESSION['user'] == true){
			$test = $db->query("select isvote from users where username='".$_SESSION['name']."';");
			$test_row = mysqli_fetch_assoc($test);
			if($test_row['isvote']==1){
				echo "<script>alert('你已经投过票了');</script>";
				echo "<meta http-equiv=\"Refresh\" content=\"0;url=index.php\">";
				exit();
			}else{
				voteing($ss, $db);
				$db->query("update users set isvote='1' where username='".$_SESSION['name']."';");
				echo "<script>alert('投票成功');</script>";
				echo "<meta http-equiv=\"Refresh\" content=\"0;url=index.php\">";
				exit();
			}
		}else{
			echo "<script>alert('请登录再投票');</script>";
			echo "<script>history.go(-1);</script>";
			exit();
		}
		
	}
	
	
	
?>