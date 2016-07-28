<?php
	include ('../conn.php');
	@session_start();
	if( !isset($_SESSION['admin']) || !isset($_SESSION['user']) || ( $_SESSION['user']!== true && $_SESSION['admin']!== true ) ){
		echo "<meta http-equiv=\"Refresh\" content=\"0;url=login.html\">";
		exit();
	}

?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title></title>

<script type="text/javascript" src="js/jquery.min.js"></script>

<link rel="stylesheet" href="css/add.css" type="text/css" media="screen" />
<link rel="stylesheet" href="utilLib/bootstrap.min.css" type="text/css"
	media="screen" />

</head>
<body>
	<div class="div_from_aoto" style="width: 80%; margin: 3em 4em; ">
	<?php
	$num = 0;
	$result_name = $db->query ( "select * from votename" );
	while ( $row_name = mysqli_fetch_assoc ( $result_name ) ) {
		$num += 1;
		?>
        <DIV class="control-group" style=" height: auto;">
			<label class="laber_from" style="line-height: inherit; margin-bottom: 0;width:auto;"><?php echo $num.".".$row_name['question_name']; ?></label>
			<br />
			<?php
		$result_option = $db->query ( "select * from voteoption where upid='" . $row_name ['cid'] . "';" );
		$sumnum = $row_name['sumvotenum'];
		while ( $row_option = mysqli_fetch_assoc ( $result_option ) ) {
			
			?>
				<DIV class="controls"
				style=" float: left; width: 580px; margin: 2px 0 0 2em; clear: both;">
					<div style="width: 280px; float:left;"><?php echo $row_option['optionname']; ?></div>
					<div style="float:left;">
						<div style="float:left; text-align:right; width:40px;"><?php echo $row_option['votenum'] ?>票</div>&nbsp;
						<img src="../images/100.jpg" height="5" width="<?php echo $row_option['votenum']/$sumnum*100 ?>"/>
						<?php echo round($row_option['votenum']/$sumnum*100); ?>%
					</div>
				</DIV>
				
			<?php } ?>
			<div style="clear: both;"></div>

		</DIV>
	<?php } ?>
  
</div>
</body>
</html>