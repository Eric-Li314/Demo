<?php
header("Content-type: text/html; charset=utf-8");
session_start();
if(@!$_SESSION['username'] && @!$_COOKIE['username']){
    header('location:login.php');
    die;
}
if(!isset($_REQUEST) || empty($_REQUEST)){die("非法访问！！！");}

$id = $_REQUEST['id'];

$dsn = 'mysql:host=mysql.sql39.eznowdata.com;dbname=sq_boyyb88';
$pdo = new PDO($dsn,'sq_boyyb88','yb19870210');
$pdo -> exec("set names utf8");

$sql = "select * from sq_boyyb88.message where id=$id";
$pdos = $pdo -> prepare($sql);
$pdos -> execute();
$data = $pdos -> fetchAll(PDO::FETCH_ASSOC);
$data = $data[0];

$ref = $_SERVER['HTTP_REFERER'];

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>修改留言</title>
</head>
<body>
<form action="action.php?action=update" method="post">
    <input type="hidden" name="ref" value="<?php echo $ref;?>">
    <input type="hidden" name="id" value="<?php echo $data['id'];?>">
    留言信息<textarea style="vertical-align: top" name="message" id="message" cols="30" rows="8"><?php echo $data['message'];?></textarea><br/>
    联系方式<input id="contact" name="contact" style="width: 257px;" value="<?php echo $data['contact'];?>"/>&nbsp;&nbsp;
    <button id="submit">提交更改</button>
</form>

</body>
</html>