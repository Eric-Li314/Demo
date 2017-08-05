<?php
@$db = new mysqli('localhost','root','','test');
if(mysqli_connect_errno()){
    echo "连接失败".mysqli_connect_error();
    exit();
}
$db->query("set names utf8");
$query = "select number from vote";
$result = $db -> query($query);
$res = $result->fetch_all(MYSQLI_ASSOC);
//计算各自的票数所占百分比
$yang = $res[0]['number']*100/($res[0]['number']+$res[1]['number']+$res[2]['number']);
$wang = $res[1]['number']*100/($res[0]['number']+$res[1]['number']+$res[2]['number']);
$li = $res[2]['number']*100/($res[0]['number']+$res[1]['number']+$res[2]['number']);

//处理投票结果
if(isset($_REQUEST['name'])){
    $name = $_REQUEST['name'];
    $sql = "update vote set number=number+1 where name='$name'";
    $db -> query($sql);
    if($db->affected_rows){
        header('location:vote_graph.php');
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
            position:relative;
            width:400px;
            height:200px;
            border:1px solid grey;

        }
        #wrap div,#name div{
            position: absolute;
            bottom:0;
            float:left;
            width:60px;
            text-align:center;
        }
        #yang{
            left:50px;
            height:<?php echo $yang;?>%;
            background: #0000cc;
            color:white;
        }
        #wang{
            left:150px;
            height:<?php echo $wang;?>%;
            background: #5a0099;
            color:white;
        }
        #li{
            left:250px;
            height:<?php echo $li;?>%;
            background: #b52b27;
            color:white;
        }
        #name{
            position:relative;
            width:400px;
            height:20px;
        }
        .yang{
            left:50px;
        }
        .wang{
            left:150px;
        }
        .li{
            left:250px;
        }
    </style>
</head>
<body>
<div id="wrap"><span style="margin-left:150px">姓氏投票</span>
    <div id="yang"><?php echo substr($yang,0,4);?>%</div>
    <div id="wang"><?php echo substr($wang,0,4);?>%</div>
    <div id="li"><?php echo substr($li,0,4);?>%</div>
</div>
<div id="name">
    <div class="yang">yang</div>
    <div class="wang">wang</div>
    <div class="li">li</div>
</div>
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

