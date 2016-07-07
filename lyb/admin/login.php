<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>登陆</title>
</head>
<body>
<h3>管理员登陆</h3><hr/>
<form action="" method="post">
    用户名：<input name="username" /><br/>
    &nbsp;&nbsp;  密码：<input name="password" type="password"/><br/>
    验证码：<input type="text" name="validate" value="" size=10>
    <img  title="点击刷新验证码" src="./validate_code/captcha.php" align="absbottom" onclick="this.src='validate_code/captcha.php?'+Math.random();"/><br/>
    <input type="submit" value="登陆">
</form>

</body>
</html>

<?php
if(!isset($_POST) || empty($_POST)){die;};
if($_REQUEST['validate'] != $_SESSION['authnum_session']){die("<b style='color:red'>验证码不正确！！！</b>！！");}
if(@!$_REQUEST['username'] || !$_REQUEST['password']){
    die("<b style='color:red'>用户名或密码不能为空！！！</b>");
}else{
    $username = $_REQUEST['username'];
    $password = $_REQUEST['password'];
    $dsn = 'mysql:host=mysql.sql39.eznowdata.com;dbname=sq_boyyb88';
    $pdo = new PDO($dsn,'sq_boyyb88','yb19870210');
    $pdo -> exec("set names utf8");

    $sql = "select username from sq_boyyb88.admin where username='$username' and password='$password';";
    $pdos = $pdo -> prepare($sql);
    $pdos -> execute();
    $data = $pdos -> fetch(PDO::FETCH_ASSOC);
    if($data){
        $_SESSION['username'] = $username;
        header('location:admin.php');
    }else{
        die("<b style='color:red'>用户名或密码错误！！！</b>\"");
    }
}

?>
