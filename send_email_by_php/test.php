<?php
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
$mail->FromName = "yb";
$to = "619280492@qq.com";//收件人邮箱地址
$mail->AddAddress($to);
$mail->Subject = "testphp";//主题
$mail->Body = "11111111112222222";//正文
$mail->WordWrap = 80;
//$mail->AddAttachment("f:/test.png"); //可以添加附件
$mail->IsHTML(true);
$mail->Send();