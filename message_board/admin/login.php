<?php
session_start();
?>

<html>
<!DOCTYPE html>
<html lang="en" class="no-js">
<head>
    <meta charset="utf-8">
    <title>登录(Login)</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">

    <!-- CSS -->
    <link rel="stylesheet" href="assets/css/reset.css">
    <link rel="stylesheet" href="assets/css/supersized.css">
    <link rel="stylesheet" href="assets/css/style.css">

    <script src="assets/js/html5.js"></script>
</head>

<body>

<div class="page-container">
    <h1>登录(Login)</h1>
    <form action="" method="post">
        <input type="text" name="username" class="username" placeholder="请输入您的用户名！">
        <input type="password" name="password" class="password" placeholder="请输入您的用户密码！">
        <input type="Captcha" class="Captcha" name="validate" placeholder="请输入验证码！">
        <img style="margin:25px 35px 0 15px;border-radius:3px;" title="点击刷新验证码" src="./validate_code/captcha.php" align="absbottom"
             onclick="this.src='validate_code/captcha.php?'+Math.random();"/>
        <div id="auto"><input type="checkbox" title="一天内免登录" name="autologin" value="1"></div>
        <button type="submit" class="submit_button">登录</button>
        <div class="error"><span>+</span></div>
    </form>
</div>

<!-- Javascript -->
<script src="assets/js/jquery-1.8.2.min.js" ></script>
<script src="assets/js/supersized.3.2.7.min.js" ></script>
<script src="assets/js/supersized-init.js" ></script>
<script src="assets/js/scripts.js" ></script>

</body>
<div style="text-align:center;">
    <p></p>
</div><br/>
</html>

<?php
if(!isset($_POST) || empty($_POST)){die;};
if($_REQUEST['validate'] != $_SESSION['authnum_session']){die("<b style='color:red'>验证码不正确！！！</b>");}
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
        if(isset($_REQUEST['autologin']) && $_REQUEST['autologin']){
            setcookie("username",$username, time()+3600*24);
        }
        $_SESSION['username'] = $username;
        header('location:admin.php');
    }else{
        die("<b style='color:red'>用户名或密码错误！！！</b>\"");
    }
}

?>
