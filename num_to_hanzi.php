<?php
header('content-type:text/html;charset=utf-8');
//将数字转换为大写汉字
//3675.35   叁仟陆佰柒拾五圆叁角五分  30070.35

$charNum=array('零','壹','贰','叁','肆','伍','陆','柒','捌','玖');
$danwei=array(1=>'圆',2=>'拾','佰','仟','万','拾万','佰万','仟万','亿');

$num=70.35;//待转换的数字

$numArr=explode(".",$num);
$number=(string)$numArr[0];
$xiaoshu=(string)$numArr[1];
//操作整数位
$wei=0;
$numberStr="";
$lingNum=0;
for($i=strlen($number)-1;$i>=0;$i--){
	$wei++;
	$curNum=$number[$i];
	if($curNum!=0){
		$char=$danwei[$wei];
		if(preg_match("/万/",$numberStr)){
			$char=str_replace("万",'',$char);
		}
		$numberStr=$charNum[$curNum].$char.$numberStr;
	}else{
		$numberStr='零'.$numberStr;
	}
}
//替换处理
$numberStr=preg_replace("/[零]{1,}/",'零',$numberStr);
$numberStr=preg_replace("/零$/",'圆',$numberStr);
$xiaoStr="";
for($j=0;$j<strlen($xiaoshu);$j++){
	$xiaoChar=$charNum[$xiaoshu[$j]];
	if($j==0){
		$xiaoChar.="角";
	}else{
		$xiaoChar.="分";
	}
	$xiaoStr.=$xiaoChar;
}
echo $numberStr.$xiaoStr;
