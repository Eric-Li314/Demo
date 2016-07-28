<?php 
	include("conn.php");
	
	@session_start();
	header("Cache-control:private");
	if( $_GET['do'] ){
		if($_GET['do']=="logout"){
			unset($_SESSION['user']);
			unset($_SESSION['name']);
			@session_destroy();
		}
	}
	$result = $db->query("select * from sysconfig");
	$row = mysqli_fetch_assoc($result);
?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="initial-scale=2.0,width=device-width" /> 
<title></title>

<script type="text/javascript" src="admin/js/jquery.min.js"></script>
<link rel="stylesheet" href="main.css" type="text/css" media="screen" />

</head>
<body>
<div class="main">
	<div style="width:auto; height:auto; background:#F9F9F9; border-bottom:solid #F0F0F0 1px; text-align:right; ">
		<div style=" padding:0.25em  0.5em 0.25em  0;">
		<?php if( !isset($_SESSION['user']) || $_SESSION['user']!==true ){ ?>
			<a href="admin/login.html">登录投票</a>
		<?php }else{ ?>
			<span>你好,<?php echo $_SESSION['name']; ?></span>
			<a href="admin/index.php">&nbsp;查看投票数据</a>
			<a href="index.php?do=logout">&nbsp;登出</a>
		<?php } ?>
		</div>
	</div>
	<form action="vote.php" method="post">
	<div class="content">
		<div>
			<h1><?php echo $row['vote_name']; ?></h1>
			<div class="description">
				<?php echo $row['description']; ?>
			</div>
		</div>
		
		<?php
			$num = 0;
			$result_name = $db->query ( "select * from votename" );
			while ( $row_name = mysqli_fetch_assoc ( $result_name ) ) {
			$num += 1;
		?>
		<div class="mcontent">
			<h3><?php echo $num.".".$row_name['question_name']; ?></h3>
			<?php
				$result_option = $db->query ( "select * from voteoption where upid='" . $row_name ['cid'] . "';" );
				while ( $row_option = mysqli_fetch_assoc ( $result_option ) ) {
			?>
			<div class="obox">
				<?php 
					if($row_name['votetype']=="0"){
						echo '<input name="'.$row_name['cid'].'" type="radio" value="'.$row_option['cid'].'">'.$row_option['optionname'];
					}else if($row_name['votetype']=="1"){
						echo '<input name="'.$row_name['cid'].'" type="checkbox" value="'.$row_option['cid'].'">'.$row_option['optionname'];
					}
				?>
				
			</div>
			<?php } ?>
			<div style="clear:both;"></div>
		</div>
		<?php } ?>
		<?php if($result_name->num_rows > 0){
		?>
		<div class="votebu">
			<input style="width:4em; height:1em; float:left;" type="text" name="code_num" maxlength="4" />
		 	<img style="float:left;" onClick="this.src='img.php'" src="img.php"  alt="看不清，点击换一张">
			<input style="float:left; margin-left:0.5em;" name="" type="submit" value="投票">
			<input name="num" type="hidden" value="<?php echo $num; ?>">
			<div style="clear:both;"></div>
		</div>
		<?php }else{ ?>
			<h1>当前没有投票</h1>
		<?php } ?>
		<br>
	</div>
  </form>

	
</div>
</body>
</html>