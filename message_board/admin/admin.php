<?php
header("Content-type: text/html; charset=utf-8");
session_start();
if(@!$_SESSION['username'] && @!$_COOKIE['username']){
    header('location:login.php');
    die;
}

//引入
require_once 'page_class/page.class.php';
require_once 'pdo_class/db.class.php';

$db = new DB();//实例化数据库类
$pagesize = 5;//分页显示条数

//处理查询结果
if(isset($_REQUEST['query']) || isset($_REQUEST['from']) || isset($_REQUEST['to'])){
    if(!$_REQUEST['query'] && !$_REQUEST['from'] && !$_REQUEST['to']){
        header('location:admin.php');//都没有数据则重新刷新管理页面
    }else{
        $keyword = $_REQUEST['query'];
        $from = $_REQUEST['from'];
        $to = $_REQUEST['to'];
        $from = strtotime($from);
        $to = strtotime($to);
        $where = '';
        $flag = 1;//高亮字处理标记
        if($keyword){//存在关键字
            $where .= "(contact like '%{$_REQUEST['query']}%' or message like '%{$_REQUEST['query']}%') ";
            if($from && $to && $from != $to){//存在日期 from to 都存在且不等
                $from1 = min($from,$to);
                $to1 = max($from,$to) + 86400;
                $where .= " and (time between $from1 and $to1) ";
            }elseif(!$from && !$to){//form to 都是空
                $where .= '';
            }else{
                $from = $from? $from : $to;
                $to = $from + 86400;
                $where .= " and (time between $from and $to) ";
            }

        }else{
            if($from && $to && $from != $to){
                $from1 = min($from,$to);
                $to1 = max($from,$to) + 86400;
                $where .= " (time between $from1 and $to1) ";
            }else{
                $from = $from? $from : $to;
                $to = $from + 86400;
                $where .= " (time between $from and $to) ";
            }
        }

        $total = $db->execSql("select count(*) num from message where $where");
        $total = $total[0]['num'];//获取查询结果的总记录数
        $pg = new Page($total,$pagesize);//分页类
        $start = $pg->getStart();//获取开始位置
    }
}else{//非查询得到的所有结果
    $total = $db->getRowCount('message');//表的总记录数
    $pg = new Page($total,$pagesize);
    $start = $pg->getStart();
    $where = false; //查询条件为空
}

$data = $db -> getAll('message','*',$where,"time DESC","$start,$pagesize");//获取数据
$pagestr = $data ? $pg->showpage() : '没有数据！！！';

//高亮关键字，针对查询内容
if(isset($flag) && $keyword){
    foreach($data as $k=>$v){
        $replacement = '<span style="background:greenyellow">'.$keyword.'</span>';
        $data[$k]['contact'] = preg_replace("/$keyword/",$replacement,$v['contact']);
        $data[$k]['message'] = preg_replace("/$keyword/",$replacement,$v['message']);
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>留言管理</title>
    <link href="page_class/page.css" rel="stylesheet" type="text/css" />
    <script src="jquery-easyui-1.4.5/jquery.min.js" type="text/javascript"></script>
    <script src="jquery-easyui-1.4.5/jquery.easyui.min.js" type="text/javascript"></script>
    <link href="jquery-easyui-1.4.5/themes/default/easyui.css" rel="stylesheet" type="text/css" />

    <style>
        #check{
            color:darkblue;
            text-decoration: none;
        }
        #check:hover{
            text-decoration: underline;
            color:darkred;
            font-weight:bold;
        }
    </style>
</head>
<body>
<div style="text-align:center;color:green;"><h2>留言后台管理</h2></div>
<span>当前管理员:[<?php if(@$_SESSION['username']){echo $_SESSION['username'];}else{echo $_COOKIE['username'];}?>]</span>
<span style="margin-left:86%"><a href="logout.php?logout=1">注销</a></span>
<hr/>
<a href="../index.php">返回留言板</a>&nbsp;&nbsp;<br/>
<form action="">
    <input name="query" placeholder="关键字" value="<?php echo isset($_REQUEST['query'])?$_REQUEST['query']:'';?>"/>&nbsp;&nbsp;
    <input class="easyui-datebox" style="width:100px" name="from" value="<?php echo isset($_REQUEST['from'])?$_REQUEST['from']:'';?>"/> --
    <input class="easyui-datebox" style="width:100px" name="to" value="<?php echo isset($_REQUEST['to'])?$_REQUEST['to']:'';?>"/>
    &nbsp;&nbsp;&nbsp;&nbsp;
    <input type="submit">
</form>
<table border="1" style="border:1px solid green;border-collapse: collapse;font-size:14px">
    <tr>
        <th width="40">序号</th>
        <th width="80">留言者IP</th>
        <th width="80">联系方式</th>
        <th width="220">留言内容</th>
        <th width="80">留言时间</th>
        <th width="60">审核</th>
        <th>操作</th>
    </tr>
    <?php foreach($data as $k=>$v){?>
        <tr>
            <td><?php echo $k+1;?></td>
            <td><?php echo $v['ip'];?></td>
            <td><?php echo $v['contact'];?></td>
            <td><?php echo $v['message'];?></td>
            <td><?php echo date('Y-m-d H:i:s',$v['time']);?></td>
            <td>
                <?php if($v['checked']==0){?>
                <a id="check" href="action.php?action=check&id=<?php echo $v['id'];?>">审核</a>
                <?php }else{?><span style="color:green">已审核</span><?php }?>
            </td>
            <td>
                <a href="update.php?action=update&id=<?php echo $v['id'];?>">修改</a>
                <a href="action.php?action=delete&id=<?php echo $v['id'];?>">删除</a>
            </td>
        </tr>
    <?php }?>
    <tr>
        <td colspan="7">
            <div id="page">
                <?php echo $pagestr;?>
            </div>
        </td>
    </tr>
</table>

</body>
</html>
