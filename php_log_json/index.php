<?php 
require_once('Log.class.php');

$filename = "logs/log_".date("Ymd",time()).".txt";
$msg = array(
	'ip' => $_SERVER["REMOTE_ADDR"],
	'user' =>  getBrowser()
);
$Log = new Log();
$Log->writeLog($filename,$msg);
$loglist = $Log->readLog($filename);

//获取浏览器类型
function getBrowser() { 
    $user_OSagent = $_SERVER['HTTP_USER_AGENT']; 
    if (strpos($user_OSagent, "Maxthon") && strpos($user_OSagent, "MSIE")) { 
        $visitor_browser = "Maxthon(Microsoft IE)"; 
    } elseif (strpos($user_OSagent, "Maxthon 2.0")) { 
        $visitor_browser = "Maxthon 2.0"; 
    } elseif (strpos($user_OSagent, "Maxthon")) { 
        $visitor_browser = "Maxthon"; 
    } elseif (strpos($user_OSagent, "Edge")) { 
        $visitor_browser = "Edge"; 
    } elseif (strpos($user_OSagent, "Trident")) { 
        $visitor_browser = "IE"; 
    } elseif (strpos($user_OSagent, "MSIE")) { 
        $visitor_browser = "IE";  
    } elseif (strpos($user_OSagent, "MSIE")) { 
        $visitor_browser = "MSIE 较高版本"; 
    } elseif (strpos($user_OSagent, "NetCaptor")) { 
        $visitor_browser = "NetCaptor"; 
    } elseif (strpos($user_OSagent, "Netscape")) { 
        $visitor_browser = "Netscape"; 
    } elseif (strpos($user_OSagent, "Chrome")) { 
        $visitor_browser = "Chrome"; 
    } elseif (strpos($user_OSagent, "Lynx")) { 
        $visitor_browser = "Lynx"; 
    } elseif (strpos($user_OSagent, "Opera")) { 
        $visitor_browser = "Opera"; 
    } elseif (strpos($user_OSagent, "MicroMessenger")) { 
        $visitor_browser = "微信浏览器"; 
    } elseif (strpos($user_OSagent, "Konqueror")) { 
        $visitor_browser = "Konqueror"; 
    } elseif (strpos($user_OSagent, "Mozilla/5.0")) { 
        $visitor_browser = "Mozilla"; 
    } elseif (strpos($user_OSagent, "Firefox")) { 
        $visitor_browser = "Firefox"; 
    } elseif (strpos($user_OSagent, "U")) { 
        $visitor_browser = "Firefox"; 
    } else { 
        $visitor_browser = "其它"; 
    } 
    return $visitor_browser; 
}
 ?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>PHP记录和读取JSON格式日志文件</title>
<link rel="stylesheet" href="//cdn.bootcss.com/bootstrap/3.3.5/css/bootstrap.min.css">
<link rel="stylesheet" type="text/css" href="http://www.helloweba.com/demo/css/demo.css" />
</head>
<body>
<div class="container">
	<header>
		<div class="row">
			<div class="col-md-3 col-xs-12"><h1 class="logo"><a href="http://www.helloweba.com" title="返回helloweba首页">helloweba</a></h1></div>
			<div class="col-md-9 text-right"></div>
		</div>
	</header>
	<div class="row main">
		<h2 class="top_title"><span class="glyphicon glyphicon-menu-left" aria-hidden="true"></span><a href="http://www.helloweba.com/view-blog-373.html">PHP记录和读取JSON格式日志文件</a></h2>
		<div class="col-md-12">
			<table class="table table-hover">
		      <thead>
		        <tr>
		          <th>#</th>
		          <th>时间</th>
		          <th>IP</th>
		          <th>浏览器</th>
		        </tr>
		      </thead>
		      <tbody>
		      	<?php 
		      	$i = 1;
		      	 foreach($loglist as & $val){
		      	 ?>
		        <tr>
		          <th scope="row"><?php echo $i; ?></th>
		          <td><?php echo $val['logtime']; ?></td>
		          <td><?php echo $val['msg']['ip']; ?></td>
		          <td><?php echo $val['msg']['user']; ?></td>
		        </tr>
		        <?php  $i++; } ?>
		      </tbody>
		    </table>
		</div>

	</div>
	<footer>
		<p>Powered by helloweba.com  允许转载、修改和使用本站的DEMO，但请注明出处：<a href="http://www.helloweba.com">www.helloweba.com</a></p>
	</footer>
</div>
</body>
</html>