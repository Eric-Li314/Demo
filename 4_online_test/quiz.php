<?php
include_once("connect.php");

$sql = "select * from quiz order by id asc";
$query = mysql_query($sql);
while($row=mysql_fetch_array($query)){
	$answers = explode('###',$row['answer']);
	$arr[] = array(
		'question' => $row['id'].'、'.$row['question'],
		'answers' => $answers
	);
}
$json = json_encode($arr);
?>

<!DOCTYPE HTML>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
<title>演示：如何使用jQuery+PHP+MySQL来实现一个在线测试项目</title>
<meta name="keywords" content="jquery,php,mysql" />
<meta name="description" content="Helloweba文章结合实例演示HTML5、CSS3、jquery、PHP等WEB技术应用。" />
<link rel="stylesheet" type="text/css" href="../css/main.css" />
<link rel="stylesheet" type="text/css" href="styles.css" />
<style type="text/css">
.demo{width:760px; margin:60px auto 10px auto}
</style>
<script type="text/javascript" src="http://libs.useso.com/js/jquery/1.7.2/jquery.min.js"></script>
<script src="quizs.js"></script>
<script>
$(function(){
	$('#quiz-container').jquizzy({
        questions: <?php echo $json;?>,
		sendResultsURL: 'data.php'
    });
});
</script>
</head>

<body>
	
<div id="header">
   <div id="logo"><h1><a href="http://www.helloweba.com" title="返回helloweba首页">helloweba</a></h1></div>
   <div class="demo_topad"><script src="/js/ad_js/demo_topad.js" type="text/javascript"></script></div>
</div>

<div id="main">
   <h2 class="top_title"><a href="http://www.helloweba.com/view-blog-297.html">如何使用jQuery+PHP+MySQL来实现一个在线测试项目</a></h2>
	<div class="demo">
		<div id='quiz-container'></div>
	</div>
	<div class="ad_76090"><script src="/js/ad_js/bd_76090.js" type="text/javascript"></script></div><br/>
</div>

<div id="footer">
    <p>Powered by helloweba.com  允许转载、修改和使用本站的DEMO，但请注明出处：<a href="http://www.helloweba.com">www.helloweba.com</a></p>
</div>

<p id="stat"><script type="text/javascript" src="/js/tongji.js"></script></p>
</body>
</html>
