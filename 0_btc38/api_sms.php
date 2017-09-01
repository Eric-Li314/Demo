<?php
set_time_limit(0);
header("Content-Type: text/html; charset=utf-8");

$config['sms'] = array(
    'sign' => '【比特时代】',
    'gwUrl' => 'http://hprpt2.eucp.b2m.cn:8080/sdk/SDKService?wsdl',
    'serialNumber' => '8SDK-EMY-6699-RFZTT',//序列号,请通过亿美销售人员获取
    'password' => '374777',
    'sessionKey' => '123456',
);
/**
 * 定义程序绝对路径
 */

define('SCRIPT_ROOT', dirname(__FILE__) . '/sms/');
require_once SCRIPT_ROOT . 'include/Client.php';
/**
 * 网关地址
 */
$gwUrl = 'http://hprpt2.eucp.b2m.cn:8080/sdk/SDKService?wsdl';

/**
 * 序列号,请通过亿美销售人员获取
 */
$serialNumber = '8SDK-EMY-6699-RFZTT';

/**
 * 密码,请通过亿美销售人员获取
 */
$password = '374777';

/**
 * 登录后所持有的SESSION KEY，即可通过login方法时创建
 */
$sessionKey = '123456';

/**
 * 连接超时时间，单位为秒
 */
$connectTimeOut = 2;

/**
 * 远程信息读取超时时间，单位为秒
 */
$readTimeOut = 10;

/**
$proxyhost		可选，代理服务器地址，默认为 false ,则不使用代理服务器
$proxyport		可选，代理服务器端口，默认为 false
$proxyusername	可选，代理服务器用户名，默认为 false
$proxypassword	可选，代理服务器密码，默认为 false
 */
$proxyhost = false;
$proxyport = false;
$proxyusername = false;
$proxypassword = false;
$client = new Client($gwUrl,$serialNumber,$password,$sessionKey,$proxyhost,$proxyport,$proxyusername,$proxypassword,$connectTimeOut,$readTimeOut);
/**
 * 发送向服务端的编码，如果本页面的编码为GBK，请使用GBK
 */
$client->setOutgoingEncoding("UTF-8");

function sendSMS($phones,$msg)
{
    global $client;
    $statusCode = $client->sendSMS(array(0=>$phones),'【比特时代】'.$msg);
    echo "处理状态码:".$statusCode;
    //chkError();
}
/**
 * 接口调用错误查看 用例
 */
function chkError()
{
    global $client;

    $err = $client->getError();
    if ($err)
    {
        /**
         * 调用出错，可能是网络原因，接口版本原因 等非业务上错误的问题导致的错误
         * 可在每个方法调用后查看，用于开发人员调试
         */

        echo $err;
    }

}

$phone = $_REQUEST['phone'];
$msg = $_REQUEST['msg'];

sendSMS($phone,$msg);