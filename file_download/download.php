<?php
header('content-type:text/html;charset=utf-8');

function download($file){
    if(is_file($file)) {
        header("Content-Type: application/force-download");
        header("Content-Disposition: attachment; filename=".basename($file));
        readfile($file);
        exit;
    }else{
        echo "<script>alert('文件不存在！');</script>";
        exit;
    }
}

if(isset($_REQUEST) && @$_REQUEST['dl']){
    $file="file/".$_REQUEST['filename'];
    download($file);
    die;
}

if(isset($_REQUEST) && @$_REQUEST['see']){
    $link="file/".$_REQUEST['filename'];
    if (isset($link))
    {
        header('content-type:text/html;charset=utf-8');
        Header("HTTP/1.1 303 See Other");
        Header("Location: $link");
        exit;
    }
}

echo "非法连接！";