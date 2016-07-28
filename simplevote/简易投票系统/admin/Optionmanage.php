<?php
	include("common.php");
	include("../conn.php");

	if($_GET['do'] == "delete"){
		$id = $_GET['id'];
		$result = $db->query("delete from voteoption where cid in ($id);");
		if($result){
			echo "<script>onload = function(){document.getElementById('errortext').innerHTML='删除成功';}</script>";
		}else{
			echo "<script>onload = function(){document.getElementById('errortext').innerHTML='删除失败';}</script>";
		}
	}
	if($_POST['Submit']){
		$id = $_POST['id'];
		$optionname = $_POST['optionname'];
		$votenum = $_POST['votenum'];
		$subject = $_POST['subject'];
		$result = $db->query("update voteoption set optionname='$optionname', votenum='$votenum', upid='$subject' where cid='$id';");
		if($result){
			echo "<script>onload = function(){document.getElementById('errortext').innerHTML='修改成功';}</script>";
		}else{
			echo "<script>onload = function(){document.getElementById('errortext').innerHTML='修改失败';}</script>";
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

<script language="javascript">
	function selectall()
	{
		var node = document.getElementsByName("checkboxitem");
		for(var i=0; i<node.length;i++){
			node[i].checked=true;
		}
	}
	function unselectall(){
		var node = document.getElementsByName("checkboxitem");
		for(var i=0; i<node.length;i++){
			node[i].checked = false;
		}
	}
	function deleteselect(){
		var node = document.getElementsByName("checkboxitem");
		id = "";
		for(var i=0; i<node.length;i++){
			if(node[i].checked){
				if(id == ""){
					id = node[i].value;
				}else{
					id = id+", "+node[i].value;
				}
			}
		}
		if(id == ""){
			alert("请选择删除项");
		}else{
			location.href="?do=delete&id="+id;
		}
		
	}
</script>

</head>
<body>

<div class="div_from_aoto" style="width: 800px; margin:30px 40px;">
	<div id="result111" class="result111" style="width:300px; height:20px; margin:4px auto; color:#33FF99;  ">
	<h5 id="errortext"></h5>
	</div>
  <form name="form1" method="post" action="">
    <table width="560" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td>ID</td>
        <td>投票选项</td>
		<td>投票数</td>
		<td>问题ID</td>
        <td>修改</td>
        <td>删除</td>
      </tr>
	  <?php 
			$result = mysqli_query($db,"select * from voteoption;");
	  		while($row = mysqli_fetch_assoc($result)){
	  ?>
      <tr>
        <td width="44" height="28" valign="middle"><input style="width:15px;" name="checkboxitem" type="checkbox" value="<?php echo $row['cid']; ?>"><?php echo $row['cid']; ?></td>
        <td width="300"><?php echo $row['optionname']; ?></td>
		<td width="60"><?php echo $row['votenum']; ?></td>
		<td width="60"><?php echo $row['upid']; ?></td>
        <td width="*"><input style="width:40px; height:22px;" value="修改" type="button" onClick="location.href='?do=change&id=<?php echo $row['cid']; ?>'"></td>
        <td width="34"><input style="width:40px; height:22px;" value="删除" type="button" onClick="location.href='?do=delete&id=<?php echo $row['cid']; ?>'"></td>
      </tr>
	  <?php }?>
	  <tr>
        <td colspan="4"><input value="选择全部" type="button" onClick="selectall()" />
						<input value="取消全选" type="button" onClick="unselectall()" />
						<input value="删除所选" type="button" onClick="deleteselect()" /></td>
	  </tr>
    </table>
  </form>
  
 <?php
	if($_GET['do'] == "change"){
		$id = $_GET['id'];
		$result = mysqli_query($db,"select * from voteoption where cid='$id';");
	  	$row = mysqli_fetch_assoc($result)
 ?>
  	<br/>
	<div class="div_from_aoto" style="width: 800px;">
	<form action="" method="post">
	  <input name="id" type="hidden" value="<?php echo $id; ?>">
	  <label>
	  <input name="optionname" type="text"  value="<?php echo $row['optionname']; ?>">
	  </label>
	  <label>
	  <input name="votenum" type="text"  value="<?php echo $row['votenum']; ?>">
	  </label>
	  <label>
	  <select style="width:300px;" name="subject">
		<?php
			$result2 = $db->query("select * from votename");
			while($row2 = mysqli_fetch_assoc($result2)){
				if($row2['cid'] == $row['upid']){
					echo '<option selected value="'.$row2['cid'].'">'.$row2['question_name'].'</option>';
				}else{
					echo '<option value="'.$row2['cid'].'">'.$row2['question_name'].'</option>';
				}
			}
		?>
	  </select>
	  </label>	  
	  <label>
	  <input type="submit" name="Submit" value="修改">
	  </label>
	</form>
	</div>
  
 <?php } ?>
</div>
</body>
</html>