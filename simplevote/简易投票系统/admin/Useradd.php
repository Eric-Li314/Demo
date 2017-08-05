<?php
	include("common.php");
	include("../conn.php");

	if($_POST['username']){
		$user = $_POST['username'];
		$pass = $_POST['passwd'];
		$result = $db->query("select username from users where username='$user';");
		if($result->num_rows > 0){
			echo "<script>onload = function(){document.getElementById('errortext').innerHTML='用户已存在';}</script>";
		}else{
			$result = $db->query("insert into users (username, passwd, admin) values ('$user', '$pass', '0');");
			if($result){
				echo "<script>onload = function(){document.getElementById('errortext').innerHTML='用户添加成功';}</script>";
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
    <FORM action="" method="post" enctype="multipart/form-data" name="form1" id="form1">
        <DIV class="control-group">
            <label class="laber_from">用户名</label>
            <DIV  class="controls" ><INPUT class="username" name="username" type=text placeholder=" 请输入用户名"><P class=help-block></P></DIV>
        </DIV>
        <DIV class="control-group">
            <LABEL class="laber_from">密码</LABEL>
            <DIV  class="controls" ><INPUT class="passwd" name="passwd" type=password placeholder=" 请输入密码">
            <P class=help-block></P></DIV>
        </DIV>

        <DIV class="control-group">
            <LABEL class="laber_from" ></LABEL>
            <DIV class="controls" ><button class="btn btn-success" style="width:120px;" >添加用户</button></DIV>
        </DIV>
  </FORM>
</div>
</body>
</html>