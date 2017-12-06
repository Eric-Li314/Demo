<?php
/*
 * 用于延迟数据的获取，通过周期执行系统命令ping得到具体数据,然后写入数据库
 * */


//你是cli模式还是cgi模式？cli模式不用设默认就是无时间限制，cgi默认是有30秒超时限制。
set_time_limit(0);//针对cgi模式有效
date_default_timezone_set('PRC');

include_once('../common/db.class.php');
$db = new DB();
$domain = "www.baidu.com";
echo iconv("UTF-8", "GB2312//IGNORE", "正在测试域名：{$domain}\n") ;//cmd下中文是gbk编码
echo "start testing {$domain}\n";
do{
    $info = exec("ping {$domain}");
    // 最短 = 43ms，最长 = 49ms，平均 = 47ms
    $pattern = "/\S+\s+=\s+(\d+)ms\S+\s+=\s+(\d+)ms\S+\s+=\s+(\d+)ms/im";//匹配上面注释中的3个数据，括号是子组匹配
    preg_match($pattern,$info,$match);
    if(count($match) != 4){ //匹配异常
        echo date("Y-m-d H:i:s").": ".$info;
        echo "\n";
        continue;
    }
    $min = $match[1];
    $max = $match[2];
    $avg = $match[3];
    $res = $db->add('monitor',array("domain"=>$domain,"min"=>$min,"max"=>$max,"avg"=>$avg,"time"=>date("Y-m-d H:i:s")));
    //发起http请求通知workerman
    if($res){

        //获取最新数据
        $data = $db ->getAll("monitor","time,avg","","id desc","20"); //查询结果 　　
        foreach($data as $k=>$v){
            $data[$k]['name'] = $v['time'];//构建返回数据格式
            $data[$k]['value'] = array($v['time'],$v['avg']);
        }
        $data = array_reverse($data);//数组反转或者排序，数据id大的在前面
        $data = array_values($data); //key重排
        $data = json_encode($data);


        //模拟发送http-post请求
        $push_api_url = "http://127.0.0.1:2121/";
        $post_data = array(
            "type" => "publish",
            "content" => $data,
        );
        $ch = curl_init ();
        curl_setopt ( $ch, CURLOPT_URL, $push_api_url );
        curl_setopt ( $ch, CURLOPT_POST, 1 );
        curl_setopt ( $ch, CURLOPT_HEADER, 0 );
        curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, 1 );
        curl_setopt ( $ch, CURLOPT_POSTFIELDS, $post_data );
        curl_setopt ($ch, CURLOPT_HTTPHEADER, array("Expect:"));
        $return = curl_exec ( $ch );
        curl_close ( $ch );
        //var_export($return);
    }
    sleep(5);//固定间隔执行一次
}while(1);

