<?php
	include('../conn.php');
	include('common.php');
	if($_POST['votename']){
		$votename = $_POST['votename'];
		$diedate = $_POST['dieddate'];
		$description = $_POST['description'];
		$type = $_POST['mradio'];
		$result = $db->query("update sysconfig set vote_name='$votename', dietime='$diedate', method='$type', description='$description'  where cid='1';");
		if($result){
			echo "<script>onload = function(){document.getElementById('errortext').innerHTML='配置保存成功';}</script>";
		}else{
			echo "<script>onload = function(){document.getElementById('errortext').innerHTML='配置保存失败';}</script>";
		}
	}
	if($_GET['do']=="reset"){
		$r = $db->query("DELETE FROM votename;");
		$r1 = $db->query("DELETE FROM voteoption;");
		$r2 = $db->query("UPDATE users SET isvote='0' WHERE admin='0';");
		$r3 = $db->query("update sysconfig set vote_name='', dietime='', method='1', description=''  where cid='1';");
		$r3 =  $db->query("DELETE FROM voteips;");
		if($r && $r1 && $r2 && $r3 && r4){
			echo "<script>onload = function(){document.getElementById('errortext').innerHTML='投票信息清空成功';}</script>";
		}else{
			echo "<script>onload = function(){document.getElementById('errortext').innerHTML='投票信息清失败';}</script>";
		}
		
	}
	$result = $db->query("select * from sysconfig where cid='1';");
	$row = mysqli_fetch_assoc($result);
	
?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title></title>

<script type="text/javascript" src="js/jquery.min.js"></script>
<script type="text/javascript" src="js/Calendar3.js"></script>

<link rel="stylesheet" href="css/add.css" type="text/css" media="screen" />
<link rel="stylesheet" href="utilLib/bootstrap.min.css" type="text/css" media="screen" />

</head>
<body>
<div class="div_from_aoto" style="width: 500px; margin:30px 40px;">
	<div id="result111" class="result111" style="width:300px; height:20px; margin:4px auto; color:#33FF99;">
	<h5 id="errortext"></h5>
	</div>
    <FORM action="Voteset.php" method="post" enctype="multipart/form-data" name="form1" id="form1">
        <DIV class="control-group">
            <label class="laber_from">投票主题</label>
            <DIV  class="controls" ><INPUT class="username" name="votename" type=text value="<?php echo $row['vote_name']; ?>"><P class=help-block></P></DIV>
        </DIV>
		
        <DIV class="control-group">
            <label class="laber_from">投票描述</label>
            <DIV  class="controls" >
			<textarea name="description" cols="" rows="" ><?php echo $row['description'];?></textarea>
            <P class=help-block></P>
			</DIV>
        </DIV>		
     
        <DIV class="control-group">
            <label class="laber_from">投票终止时间</label>
            <DIV  class="controls" >
			<input name="dieddate" type="text" value="<?php echo $row['dietime']; ?>" id="control_date" size="10" maxlength="10" onClick="new Calendar().show(this);" readonly="readonly" />
            <P class=help-block></P>
			</DIV>
        </DIV>  

        <DIV class="control-group">
            <label class="laber_from">投票方式</label>
            <DIV  class="controls" ><input name="mradio" type="radio" value="1" checked>免登录投票&nbsp;&nbsp;
									<input name="mradio" type="radio" value="2">登录投票<P class=help-block></P></DIV>
        </DIV> 		
		
        <DIV class="control-group">
            <LABEL class="laber_from" ></LABEL>
            <DIV class="controls" ><button class="btn btn-success" style="width:80px;" >保存配置</button>
			<button class="btn btn-warning" style="width:80px;" type="button" onClick="location.href='Voteset.php?do=reset'" >重置投票</button>
			</DIV>
        </DIV>
  </FORM>
</div>
</body>
</html>