<?php
//生成多位数字字母形成的不重复的随机字符串
function buildRandomString($length){
    $chars = join('',array_merge(range('a','z'),range('A',"Z"),range(0,9)));
    $chars = str_shuffle($chars);//对字符串随机排列
    //生成不重复的多位随机字符
    return substr($chars,0,$length);
}

function randomStr($type = 3,$length = 4){
    $str1 = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $str2 = '0123456789';
    $str3 = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';//定义的字符串库
    switch($type){
        case 1;$chars = str_shuffle($str1);break;
        case 2;$chars = str_shuffle($str2);break;
        case 3;$chars = str_shuffle($str3);break;
    }
    $randstr = str_shuffle($chars);
    return substr($randstr,0,$length);

}
echo '<h1>'.buildRandomString(4).'</h1>';
echo '<h1>'.randomStr(2,5).'</h1>';