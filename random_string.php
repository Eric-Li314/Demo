<?php
//生成多位数字字母形成的不重复的随机字符串
function buildRandomString($length){
    $chars = join('',array_merge(range('a','z'),range('A',"Z"),range(0,9)));
    $chars = str_shuffle($chars);//对字符串随机排列
    //生成不重复的多位随机字符
    return substr($chars,0,$length);
}

echo '<h1>'.buildRandomString(4).'</h1>';