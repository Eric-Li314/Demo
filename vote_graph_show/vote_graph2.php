<?php
@$db = new mysqli('localhost', 'root', '', 'test');
if (mysqli_connect_errno()) {
    echo "连接失败" . mysqli_connect_error();
    exit();
}
$db->query("set names utf8");
$query = "select number from vote";
$result = $db->query($query);
$res = $result->fetch_all(MYSQLI_ASSOC);
//计算各自的票数所占百分比
$yang = $res[0]['number'] * 100 / ($res[0]['number'] + $res[1]['number'] + $res[2]['number']);
$wang = $res[1]['number'] * 100 / ($res[0]['number'] + $res[1]['number'] + $res[2]['number']);
$li = $res[2]['number'] * 100 / ($res[0]['number'] + $res[1]['number'] + $res[2]['number']);

//处理投票结果
if (isset($_REQUEST['name'])) {
    $name = $_REQUEST['name'];
    $sql = "update vote set number=number+1 where name='$name'";
    $db->query($sql);
    if ($db->affected_rows) {
        header('location:vote_graph2.php');
    }

}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>投票系统demo</title>
    <style>
        #wrap{
            float:left;
            width: 400px;
            height: 300px;
            border: 1px solid grey;

        }

        #wrap div{
            height: 60px;
            text-align: right;
            line-height: 60px;
            font-size: 12px;
            margin-top: 25px;
            border-radius:2px;
        }

        #yang {
            width: <?php echo $yang;?>%;
            background: #0000cc;
            color: white;
        }

        #wang {
            width: <?php echo $wang;?>%;
            background: #5a0099;
            color: white;
        }

        #li {
            width: <?php echo $li;?>%;
            background: #b52b27;
            color: white;
        }

        #name {
            float:left;
            width: 400px;
            height: 300px;
            color:green;
            font-weight:bold;
        }
        .yang,.wang,.li{
            height: 60px;
            text-align: right;
            line-height: 60px;
            font-size: 16px;
            margin-right:5px;
        }
        .yang{
            margin-top:50px;
        }
        .wang{
            margin-top:20px;
        }
        .li{
            margin-top:30px;
        }

    </style>
</head>
<body>
<div style="height: 320px;">
    <div id="name">
        <div class="yang">yang </div>
        <div class="wang">wang </div>
        <div class="li">li </div>
    </div>
    <div id="wrap"><span style="margin-left:150px">姓氏投票</span>

        <div id="yang"><?php echo substr($yang, 0, 4); ?>%</div>
        <div id="wang"><?php echo substr($wang, 0, 4); ?>%</div>
        <div id="li"><?php echo substr($li, 0, 4); ?>%</div>
    </div>
</div>

<br/>
<hr/>
<form action="" method="post">
    yang<input type="radio" name="name" value="yang"/><br/>
    wang<input type="radio" name="name" value="wang"/><br/>
    li<input type="radio" name="name" value="li"/><br/>
    <input type="submit" value="提交">
    <span>（不限制投票人数）</span>
</form>
</body>
</html>

