<?php
/**
 * 使用代理方式、跨域
 *
 */
if(empty($_POST)) die("缺少POST参数");

//接口配置参数
$stamp = time();
$public_key = 'f03f2df42aea1245ff3dc52c641cb26c';
$private_key = '1475cb9452dfa32cb73a4224b9a72f67ecdf38b913c3b5dbd4b4d785fa19f5dc';
$user_id = 279642;
$mdt = "{$public_key}_{$user_id}_{$private_key}_".$stamp;
$mdt = md5($mdt);

//分功能调用
$type = $_POST['type'];
switch($type){
    case 'get_my_balance': //账户余额
        $data = array(
            "key" => "f03f2df42aea1245ff3dc52c641cb26c",
            "time" => $stamp,
            "md5" => $mdt,
        );
        $url = 'http://api.btc38.com/v1/getMyBalance.php';
        break;
    case 'get_order_list': //获取某个币挂单
        $data = array(
            "key" => "f03f2df42aea1245ff3dc52c641cb26c",
            "time" => $stamp,
            "md5" => $mdt,
            'mk_type' => 'cny',
            'coinname' => $_POST['coinname']
        );
        $url = 'http://api.btc38.com/v1/getOrderList.php';
        break;
    case 'make_order': //挂单
        $data = array(
            "key" => "f03f2df42aea1245ff3dc52c641cb26c",
            "time" => $stamp,
            "md5" => $mdt,
            'mk_type' => 'cny',
            'coinname' => $_POST['coinname'],
            'type'=> 2,//卖单  1是买单
            'amount'=>$_POST['amount'],
            'price'=>$_POST['price']
        );
        $url = 'http://api.btc38.com/v1/submitOrder.php';
        break;
    case 'get_ticker': //某个币的交易行情
        $data = array();
        $url = 'http://api.btc38.com/v1/ticker.php?c='.$_POST['coinname'].'&mk_type=cny';
        break;
    case 'get_ticker_all': //所有币交易行情
        $data = array();
        $url = 'http://api.btc38.com/v1/ticker.php?c=all';
        break;
}


$ch = curl_init ();
curl_setopt ( $ch, CURLOPT_URL, $url );
curl_setopt ( $ch, CURLOPT_POST, 1 );
curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_HEADER, 0);
curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/4.0 (compatible; btc38 PHP bot; ' . php_uname('a') . '; PHP/' . phpversion() . ')');

$result = curl_exec($ch);
echo $result;

