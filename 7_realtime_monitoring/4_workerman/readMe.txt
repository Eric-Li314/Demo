WEB消息推送框架
web-msg-sender是一款web长连接推送框架，采用PHPSocket.IO开发，
基于WebSocket长连接通讯，如果浏览器不支持WebSocket则自动转用comet推送。
通过后台推送消息，消息可以即时推送到客户端，非轮询，实时性非常好，性能很高。

特点：
多浏览器支持
支持针对单个用户推送消息
支持向所有用户推送消息
长连接推送（websocket或者comet），消息即时到达
支持在线用户数实时统计展示
支持在线页面数实时统计展示
支持跨域推送

本例用了workerman web消息发送框架 用的socket.io

在探针程序中(monitor_probe.php)中需要设置一个http触发，
当新数据成功写入数据库就会模拟发送一个http请求，该请求会携带参数type=publish，content=xxx，由于内容比较多，采用post方式
workerman接收该请求并触发后续流程