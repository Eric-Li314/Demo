<?php
//session_start();
file_put_contents('./debug-tttttt.log', date('Y-m-d H:i:s ').'1111111111'. "\r\n", FILE_APPEND);
function captcha($len=4){
	#创建画布
	$width=80;
	$height=30;
	$image = imagecreatetruecolor($width, $height);
	#创建画布背景颜色
	$grey = imagecolorallocate($image, 200, 200, 200);
	imagefill($image, 0, 0, $grey);

	#添加干扰元素
	#添加随机像素点
	for ($i = 0; $i < 200; $i++) {
		$randcolor = imagecolorallocate($image, rand(200,255), rand(200,255), rand(200,255));
		imagesetpixel($image, rand(0,80), rand(0,30), $randcolor);
	}
	#添加随机直线
	for ($i = 0; $i < 20; $i++) {
		$randcolor = imagecolorallocate($image, rand(200,255), rand(200,255), rand(200,255));
		imageline($image, rand(0,80), rand(0,30), rand(0,80), rand(0,30), $randcolor);
	}

	#生成随机验证码,要求不重复
	$str = "abcdefghijkmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ23456789";
	$num = $len;
	$code = '';
	for ($a = 0;; $a++) {
		$single = substr($str, rand(0,strlen($str)-1),1);
		if(strpos(strtolower($code),strtolower($single)) === false){
			$code .= $single;
		}
		if(strlen($code) == $len){break;}
	}

	#将生成的验证码保存在session中
	//$_SESSION['vcode'] = $code;

	#将验证码放到画布中
	for ($j = 0; $j < $num; $j++) {
		$randcolor = imagecolorallocate($image, rand(0,150), rand(0,150), rand(0,150));
		$size = rand(12,16);
		$angle = rand(-10,10);
		$fontfile = "C:/Windows/Fonts/msyh.ttc";
		$x = ($j*80/$num)+rand(2,4);
		$y = rand(18,22);
		$text = substr($code, $j,1);

		imagettftext($image, $size, $angle, $x, $y, $randcolor,$fontfile, $text);
	}

	file_put_contents('./debug-tttttt.log', date('Y-m-d H:i:s ') .'--'.$code. "\r\n", FILE_APPEND);
	#输出验证码
	header("content-type: image/gif");
	imagegif($image);

	#销毁画布回收内存资源
	imagedestroy($image);
}

captcha(5);