<?php
	include('../conn.php');
	include('common.php');
	if($_POST['voteoption']){
		$voteoption = $_POST['voteoption'];
		$subject = $_POST['subject'];
		if($subject == ""){
			echo "<script>onload = function(){document.getElementById('errortext').innerHTML='请选择问题！';}</script>";
		}else{
			$result = $db->query("insert into voteoption (optionname, upid, votenum) values ('$voteoption', '$subject', '0')");
			if($result){
				echo "<script>onload = function(){document.getElementById('errortext').innerHTML='添加选项成功';}</script>";
			}else{
				echo "<script>onload = function(){document.getElementById('errortext').innerHTML='添加选项失败';}</script>";
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
    <FORM action="Addvoteoption.php" method="post" enctype="multipart/form-data" name="form1" id="form1">
	<div id="result111" class="result111" style="width:300px; height:20px; margin:4px auto; color:#33FF99;  ">
	<h5 id="errortext"></h5>
	</div>	
        <DIV class="control-group">
            <label class="laber_from">投票选项</label>
            <DIV  class="controls" ><INPUT class="username" style="width:300px;" name="voteoption" type=text placeholder=" 请输入投票选项"><P class=help-block>不要超过20个字</P></DIV>
        </DIV>

        <DIV class="control-group">
            <label class="laber_from">所属问题</label>
            <DIV  class="controls" ><select style="width:300px;" name="subject">
										<option value="" checked>请选择问题</option>
									<?php
										$result = $db->query("select * from votename");
										while($row = mysqli_fetch_assoc($result)){
									?>
										<option value="<?php echo $row['cid']; ?>"><?php echo $row['question_name']; ?></option>
									<?php
										}
									?>
									</select>
			<P class=help-block></P></DIV>
        </DIV>

        <DIV class="control-group">
            <LABEL class="laber_from" ></LABEL>
            <DIV class="controls" ><button class="btn btn-success" style="width:120px;" >添加选项</button></DIV>
        </DIV>
  </FORM>
</div>
</body>
</html>