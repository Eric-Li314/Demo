<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>抢红包</title>
</head>
<body>
<form action="" method="post">
    金额 <input name="amount"><br/>
    人数 <input name="number">
    <input type="submit" value="提交">
</form>
<hr/>
</body>
</html>


<?php
header("Content-type: text/html; charset=utf-8");
//红包算法，每人金额随机，至少能收到0.01元

if(isset($_REQUEST['amount']) && isset($_REQUEST['number'])){
    if(!$_REQUEST['amount'] || !$_REQUEST['number']){die("信息输入不完整！");}

    $total=$_REQUEST['amount'];//红包总金额
    $num=$_REQUEST['number'];// 红包个数
    $min=0.01;//每个人最少能收到0.01元

    for ($i=1;$i<$num;$i++)
    {
        $safe_total=($total-($num-$i)*$min)/($num-$i);//随机安全上限
        $money=mt_rand($min*100,$safe_total*100)/100;
        $total=$total-$money;

        echo '第'.$i.'个红包：'.$money.' 元，余额：'.$total.' 元<br/> ';
    }
    echo '第'.$num.'个红包：'.$total.' 元，余额：0 元<br/>';
}
