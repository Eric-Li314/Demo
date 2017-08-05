<?php
/*
 * 语音合成接口
 *
 * */
$text = $_REQUEST['text'];

// 引入Speech SDK
require_once 'baidu_voice_sdk/AipSpeech.php';
// 定义常量
const APP_ID = '9920607';
const API_KEY = '5zb1I7p4FZGDl2o5RFrBtWIG';
const SECRET_KEY = 'c78499aa7b45d20428cbe5e08ea1f679';
// 初始化AipSpeech对象
$aipSpeech = new AipSpeech(APP_ID, API_KEY, SECRET_KEY);

$result = $aipSpeech->synthesis($text, 'zh', 1, array(
    'vol' => 5,
    'spd' => 4,
));
// 识别正确返回语音二进制 错误则返回json 参照下面错误码
if(!is_array($result)){
    file_put_contents('coins_price.mp3', $result);
    echo 'ok';
}