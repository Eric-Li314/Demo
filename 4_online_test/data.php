<?php
include_once("connect.php");

$data = $_REQUEST['an'];

$answers = explode('|',$data);
$an_len = count($answers)-1; //题目数

$sql = "select correct from quiz order by id asc";

$query = mysql_query($sql);
$i = 0;
$score = 0; //初始得分
$q_right = 0; //答对的题数
while($row=mysql_fetch_array($query)){
	if($answers[$i]==$row['correct']){
		$arr['res'][] = 1;
		$q_right += 1;
	}else{
		$arr['res'][] = 0;
	}
	$i++;
}
$arr['score'] = round(($q_right/$an_len)*100); //总得分
echo json_encode($arr);
?>
