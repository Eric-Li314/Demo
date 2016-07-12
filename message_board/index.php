<?php
$dsn = 'mysql:host=mysql.sql39.eznowdata.com;dbname=sq_boyyb88';
$pdo = new PDO($dsn,'sq_boyyb88','yb19870210');
$pdo -> exec("set names utf8");

$sql = "select * from sq_boyyb88.message where checked='1' order by time desc";//查询审核通过的留言
$pdos = $pdo -> prepare($sql);
$pdos -> execute();
$data = $pdos -> fetchAll(PDO::FETCH_ASSOC);

//按照日期分组
$newdata = array();
foreach($data as $k=>$v){
    $newdata[date('Y-m-d',$v['time'])][] = $v;
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>欢迎留言</title>
    <script src="./jquery-2.2.4.min.js"></script>
    <script>
        $(document).ready(function(){
            $('#submit').click(function(){
                if($('#message').val() == '' || $('#message').val().length <=5 || !$('#contact').val()){
                    alert("留言内容至少大于5个字，联系方式不能为空");
                    return false;
                }
            });
        });
    </script>
</head>
<body>
<form action="message.php" method="post">
    留言信息<textarea style="vertical-align: top" placeholder="请输入留言内容！！" name="message" id="message" cols="30" rows="8"></textarea><br/>
    联系方式<input id="contact" name="contact" style="width: 257px;" placeholder="电话或者邮箱"/>&nbsp;&nbsp;
    <button id="submit">提交留言</button>
</form>
<hr/>
<span style="color:green;font-family:隶书;font-size: 1.5em;"><a href="admin/admin.php">留言管理入口</a></span>
<table border="1" style="border:1px solid green;border-collapse: collapse">
    <tr>
        <th nowrap >序号</th>
        <th nowrap >留言者IP</th>
        <th nowrap >留言者联系方式</th>
        <th width="500">留言内容</th>
        <th nowrap >留言时间</th>
    </tr>
    <?php foreach($newdata as $k=>$v){?>
    <tr><td colspan="5" style="background: grey;"><?php echo $k;?></td></tr>
    <?php foreach($v as $k1=>$v1){ ?>
    <tr>
        <td><?php echo $k1+1;?></td>
        <td><?php echo $v1['ip'];?></td>
        <td><?php echo $v1['contact'];?></td>
        <td><?php echo $v1['message'];?></td>
        <td><?php echo date('Y-m-d H:i:s',$v1['time']);?></td>
    </tr>
    <?php }}?>
</table>
</body>
</html>