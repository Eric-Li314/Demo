<?php
	include('../conn.php');
	include('common.php');
	if($_POST['votesubject']){
		$subject = $_POST['votesubject'];
		$type = $_POST['votetype'];
		$result = $db->query("insert into votename (question_name, votetype) values ('$subject', '$type')");
		if($result){
			echo "<script>onload = function(){document.getElementById('errortext').innerHTML='添加问题成功';}</script>";
		}else{
			echo "<script>onload = function(){document.getElementById('errortext').innerHTML='添加问题失败';}</script>";
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
    <FORM action="Addsubject.php" method="post" enctype="multipart/form-data" name="form1" id="form1">
	<div id="result111" class="result111" style="width:300px; height:20px; margin:4px auto; color:#33FF99;  ">
	<h5 id="errortext"></h5>
	</div>	
        <DIV class="control-group">
            <label class="laber_from">投票问题</label>
            <DIV  class="controls" ><INPUT class="username" style="width:300px;" name="votesubject" type=text placeholder=" 请输入投票问题"><P class=help-block></P></DIV>
        </DIV>

        <DIV class="control-group">
            <label class="laber_from">问题选项</label>
            <DIV  class="controls" ><input name="votetype" type="radio" value="0" checked />单选&nbsp;&nbsp;
									<input name="votetype" type="radio" value="1" />多选
			<P class=help-block></P></DIV>
        </DIV>

        <DIV class="control-group">
            <LABEL class="laber_from" ></LABEL>
            <DIV class="controls" ><button class="btn btn-success" style="width:120px;" >添加问题</button></DIV>
        </DIV>
  </FORM>
</div>
</body>
</html>