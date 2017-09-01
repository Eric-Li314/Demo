<?php

$to_email  = '13629795255@139.com';
$to_title  = '价格浮动通知';
$to_content = $_REQUEST['to_content']."(".date('H:i:s').")";
if(isset($_REQUEST['title'])){
    $to_title = $_REQUEST['title'];
}

//以我的163邮箱为发送账号
require 'PHPMailer/class.smtp.php';
require 'PHPMailer/class.phpmailer.php';
$mail = new PHPMailer(true);
$mail->IsSMTP();
$mail->CharSet='UTF-8';
$mail->SMTPAuth = true;
$mail->Port = 25;
$mail->Host = "smtp.163.com";//邮箱smtp地址，此处以163为例
$mail->Username = "boyyb87@163.com";//你的邮箱账号
$mail->Password = "yb19870210";//你的邮箱密码
$mail->From = "boyyb87@163.com";//你的邮箱账号
$mail->FromName = "比特时代";//发件人的名称
$to = $to_email;//收件人邮箱地址
$mail->AddAddress($to);
$mail->Subject = $to_title;//主题
$mail->Body = $to_content;//正文
$mail->WordWrap = 80;
//$mail->AddAttachment("f:/test.png"); //可以添加附件
$mail->IsHTML(true);
$res = $mail->Send();
if($res){echo '邮件发送成功！内容：';}
echo $to_content;