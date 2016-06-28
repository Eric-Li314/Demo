<?php
$db = mysql_connect('mysql.sql39.eznowdata.com', 'sq_boyyb88', 'yb19870210') or die("数据库连接失败！");
mysql_query("set names utf8");
mysql_select_db("sq_boyyb88");
$res = mysql_query("select * from vote");
$row=mysql_fetch_array($res,MYSQL_ASSOC);
var_dump($row);

die;
@$db = new mysqli('mysql.sql39.eznowdata.com', 'sq_boyyb88', 'yb19870210', 'sq_boyyb88');
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
        #wrap {
            float: left;
            width: 500px;
            height: 300px;
            border: 1px solid grey;

        }

        #wrap div {
            height: 50px;
            line-height: 50px;
            font-size: 12px;
            margin-top: 20px;
        }

        #num1, #num2, #num3 {
            float: left;
            width: 15px;
        }

        #yang {
            float: left;
            width: <?php echo $yang;?>%;
            background: #0000cc;
            color: white;
        }

        #wang {
            float: left;
            width: <?php echo $wang;?>%;
            background: #5a0099;
            color: white;
        }

        #li {
            float: left;
            width: <?php echo $li;?>%;
            background: #b52b27;
            color: white;
        }

        #name {
            float: left;
            width: 400px;
            height: 300px;
            color: green;
            font-weight: bold;
        }

        .yang, .wang, .li {
            height: 60px;
            text-align: right;
            line-height: 60px;
            font-size: 16px;
            margin-right: 5px;
        }

        .yang {
            margin-top: 55px;
        }

        .wang {
            margin-top: 15px;
        }

        .li {
            margin-top: 13px;
        }

    </style>
</head>
<body>
<div style="height: 320px;">
    <div id="name">
        <div class="yang">yang</div>
        <div class="wang">wang</div>
        <div class="li">li</div>
    </div>
    <div id="wrap"><span style="margin-left:150px">姓氏投票</span>

        <div>
            <div id="yang"></div>
            <div id="num1"><?php echo substr($yang, 0, 4); ?>%</div>
        </div>
        <div>
            <div id="wang"></div>
            <div id="num2"><?php echo substr($wang, 0, 4); ?>%</div>
        </div>
        <div>
            <div id="li"></div>
            <div id="num3"><?php echo substr($li, 0, 4); ?>%</div>
        </div>
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

