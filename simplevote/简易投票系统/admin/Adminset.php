<?php
	include('../conn.php');
	include('common.php');
	if($_POST['oldpass']){
		$oldpass = $_POST['oldpass'];
		$newpass = $_POST['newpass'];
		$newpass2 = $_POST['newpass2'];
		$result = $db->query("select * from users where username='admin' and passwd='$oldpass'");
		if($result->num_rows == 0){
			echo "<script>onload = function(){document.getElementById('errortext').innerHTML='原始密码错误！';}</script>";
		}else{
			if($newpass != $newpass2){
				echo "<script>onload=function(){document.getElementById('errortext').innerHTML='两次密码输入不一致';}</script>";
				
			}else{
				$result = $db->query("update users set passwd='$newpass' where username='admin'");
					if($result){
						echo "<script>onload = function(){document.getElementById('errortext').innerHTML='修改成功';}</script>";
					}else{
						echo "<script>onload = function(){document.getElementById('errortext').innerHTML='修改失败';}</script>";
					}
			}
		}
	}
?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title></title>

<script type="text/javascript" src="js/jquery.min.js"></script>

<link rel="stylesheet" href="css/add.css" type="text/css" media="screen" />
<link rel="stylesheet" href="utilLib/bootstrap.min.css" type="text/css" media="screen" />

</head>
<body>
<div class="div_from_aoto" style="width: 500px; margin:30px 40px;">
	<div id="result111" class="result111" style="width:300px; height:20px; margin:4px auto; color:#33FF99;  ">
	<h5 id="errortext"></h5>
	</div>
    <FORM action="Adminset.php" method="post" enctype="multipart/form-data" name="form1" id="form1">
        <DIV class="control-group">
            <label class="laber_from">原密码</label>
            <DIV  class="controls" ><INPUT class="passwd" name="oldpass" type=password placeholder=" 请输入原密码"><P class=help-block></P></DIV>
        </DIV>
        <DIV class="control-group">
            <LABEL class="laber_from">新密码</LABEL>
            <DIV  class="controls" ><INPUT class="passwd" name="newpass" type=password placeholder=" 请输入新密码">
            <P class=help-block></P></DIV>
        </DIV>

        <DIV class="control-group">
            <LABEL class="laber_from">重复密码</LABEL>
            <DIV  class="controls" ><INPUT class="passwd" name="newpass2" type=password placeholder=" 请输入新密码">
            <P class=help-block></P></DIV>
        </DIV>		
		
        <DIV class="control-group">
            <LABEL class="laber_from" ></LABEL>
            <DIV class="controls" ><button class="btn btn-success" style="width:120px;" >修改管理员密码</button></DIV>
        </DIV>
  </FORM>
</div>
</body>
</html>