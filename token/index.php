<?php
header('content-type:text/html;charset=utf-8');
session_start();
$_SESSION['token'] = md5(microtime(true));
var_dump($_SESSION);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>token</title>
    <script src="./jquery-2.2.4.min.js"></script>
    <script>
        $(document).ready(function(){
            $('#submit').click(function(){
                $(this).val('变为灰色防止重复提交').prop('disabled','disabled');
            });
        });
    </script>
</head>
<body>
<form action="server.php" method="post" target="_blank">
    <input type="hidden" name="token" value="<?php echo $_SESSION['token']?>">
    <input type="text" name="test" value="Default">
    <input type="submit" value="合法提交(有token)" id="submit" />
</form>
<form action="server.php" method="post" target="_blank">
    <input type="text" name="test" value="Default">
    <input type="submit" value="非法提交(无token或token错误)" />
</form>
<p>
    token主要用于判断是否人为提交，验证码也一样。<br/>
    token还可以用于防止重复提交<br/>
    重复提交验证方法：点击两次合法提交或者刷新合法提交后的server.php页面
</p>
</body>
</html>