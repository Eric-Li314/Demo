<?php
include_once("connect.php");

$data = $_REQUEST['an'];

$answers = explode('|',$data);
$an_len = count($answers)-1; //��Ŀ��

$sql = "select correct from quiz order by id asc";

$query = mysql_query($sql);
$i = 0;
$score = 0; //��ʼ�÷�
$q_right = 0; //��Ե�����
while($row=mysql_fetch_array($query)){
	if($answers[$i]==$row['correct']){
		$arr['res'][] = 1;
		$q_right += 1;
	}else{
		$arr['res'][] = 0;
	}
	$i++;
}
$arr['score'] = round(($q_right/$an_len)*100); //�ܵ÷�
echo json_encode($arr);
?>
