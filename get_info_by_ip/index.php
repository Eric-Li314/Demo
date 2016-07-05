<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>search</title>
    <style>
        .search {
            height: 40px;
            width:371px;
            margin: 0 auto;

        }
        .search .search_input {
            height: 29px;
            width: 220px;
            float: left;
            margin: 0;
            border: 1px solid #7b9ebe;
            padding: 1px 0px 1px 5px;
            font-family:微软雅黑;
            font-size:16px;
        }

        .search .search_btn {
            width: 64px;
            height: 33px;
            float: left;
            border: 0;
            margin: 0;
            cursor: pointer;
            background-image: url("./search.png");
        }

    </style>
    <script>
        function commit(){ //js提交表单数据
            var form = document.getElementById('form');
            var url = 'index.php';
            var content = document.getElementById('search_input').value;
            form.action= url;
            form.method='post';
            form.submit();
            //alert('你搜索的内容"'+content+'"已经提交到'+url);
        }
    </script>
</head>
<body>
<form id="form">
    <div class="search">
        <input class="search_input" id="search_input" name="search" placeholder="请输入IP地址" type="text">
        <input class="search_btn" id="search_btn" type="button" onclick="javascript:commit()">
    </div>
</form>
</body>
</html>
<?php
if(isset($_REQUEST) && $_REQUEST){
    $ip = $_REQUEST['search'];
    $ip = trim($ip);
    if(!preg_match("/^[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}$/", $ip)) {
        die('IP Address Format Error');
    }
    function getInfoByIp($ip)
    {
        //利用淘宝接口
        $url = "http://ip.taobao.com/service/getIpInfo.php?ip=" . $ip;
        $ip = json_decode(file_get_contents($url));//将json格式的数据转换为对象
        $data = (array)$ip->data;//获得data下的数据并转换为数组
        return $data;//返回一个关联数组
    }

    var_dump(getInfoByIp($ip));
}

?>