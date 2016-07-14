<?php
$dsn = 'mysql:host=mysql.sql39.eznowdata.com;dbname=sq_boyyb88';
$pdo = new PDO($dsn,'sq_boyyb88','yb19870210');
$pdo -> exec("set names utf8");

$sql = "select * from sq_boyyb88.message where checked='1' order by time desc";//查询审核通过的留言
$pdos = $pdo -> prepare($sql);
$pdos -> execute();
$data = $pdos -> fetchAll(PDO::FETCH_ASSOC);


//天分组和月分组的空数组
$ddata = array();
$mdata = array();
foreach($data as $k=>$v){
    //当月的数据按天分组
    if(date('Y-m') == date('Y-m',$v['time'])){
        $ddata[date('Y-m-d',$v['time'])][] = $v;
        continue;
    }
    //不是当月的数据按月进行分组
    $mdata[date('Y-m',$v['time'])][] = $v;
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>欢迎留言</title>
    <style>
        .parent{ /* 折叠行样式*/
            color:#fff;cursor:pointer;
            background: url('public/up.jpg') center right no-repeat lightslategrey;
            background-size:32px 32px;
        }
        .selected{
            background: url('public/down.jpg') center right no-repeat dimgray;
            background-size:32px 32px;
        }
    </style>
    <script src="./jquery-2.2.4.min.js"></script>
    <script>
        $(document).ready(function(){

            $('#submit').click(function(){
                if($('#message').val() == '' || $('#message').val().length <=5 || !$('#contact').val()){
                    alert("留言内容至少大于5个字，联系方式不能为空");
                    return false;
                }
            });
            $('tr.parent').click(function(){   // 获取所谓的父行并触发点击事件
                $(this).toggleClass("selected")   // 给parent类添加或删除selected类
                    .siblings('.child_'+this.id) //获得对应类名的兄弟节点(需要被隐藏的行)对象
                    .toggle();  // 隐藏/显示所谓的子行，toggle()方法切换元素的可见状态。

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
<table border="1" style="border:1px solid green;border-collapse: collapse;width:80%;">
    <tr>
        <th nowrap width="5%" >序号</th>
        <th nowrap width="10%" >留言者IP</th>
        <th nowrap width="15%" >留言者联系方式</th>
        <th width="55%">留言内容</th>
        <th nowrap >留言时间</th>
    </tr>
    <?php foreach($ddata as $k=>$v){?>
    <tr class="parent <?php echo $k==date('Y-m-d')?'':'selected';?>" id="row_<?php echo $k;?>" >
        <td colspan="5"><?php echo $k;?></td>
    </tr>
    <?php foreach($v as $k1=>$v1){ ?>
    <tr  class="child_row_<?php echo $k;?>" <?php echo $k==date('Y-m-d')?'style="display:table-row"':'style="display:none"';?>>
        <td><?php echo $k1+1;?></td>
        <td><?php echo $v1['ip'];?></td>
        <td><?php echo $v1['contact'];?></td>
        <td><?php echo $v1['message'];?></td>
        <td><?php echo date('Y-m-d H:i:s',$v1['time']);?></td>
    </tr>
    <?php }}?>
    <?php foreach($mdata as $k=>$v){?>
        <tr class="parent selected" id="row_<?php echo $k;?>" >
            <td colspan="5"><?php echo $k;?></td>
        </tr>
        <?php foreach($v as $k1=>$v1){ ?>
            <tr  class="child_row_<?php echo $k;?>" style="display:none">
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