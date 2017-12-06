//var http = require("http");            //提供web服务
//var url = require("url");            //解析GET请求
//var query = require("querystring");    //解析POST请求
var EventEmitter = require('events').EventEmitter; //事件触发器
var event = new EventEmitter();

var express = require('express'); //web应用框架express
var app = express();

var WebSocketServer = require('ws').Server; //引入websocket
var wss = new WebSocketServer({ port: 8181 });

var io = require('socket.io').listen(9999);//socket.io



var mysql = require('mysql'); //加载mysql模块
var conn = mysql.createConnection({ //初始化连接参数
    host: 'localhost',
    user: 'root',
    password: 'mysql',
    database: 'yb',
    port: 3306
});
conn.connect();  //连接数据库
var selectSQL = ' select id,time,avg from monitor order by id desc limit 200 ';
// conn.query("sql..",function(err,res){}); //nodejs操作数据库的执行方法




//时间格式转换
function timetostr(d){
    var y = d.getFullYear();
    var m = d.getMonth() + 1;
    m = m < 10 ? "0" + m : m;
    var day = d.getDate();
    day = day < 10 ? "0" + day : day;
    var h = d.getHours();
    var i = d.getMinutes();
    i = i < 10 ? "0" + i : i;
    var s = d.getSeconds();
    s = s < 10 ? "0" + s : s;

    return y+"-"+m+"-"+day+" "+h+":"+i+":"+s;
}



//响应http-get请求
app.get('/', function (req, res) {
    res.send('Hello World');
    console.log("http -- 收到"+req.ip+"请求,lastid="+req.query.lastid);
    console.log("event -- 触发websocket事件");
    event.emit('websocket',{id:req.query.lastid,random:Math.random()});//触发websocket事件，并携带参数

});

//监听http请求（ip+port）
var server = app.listen(8080, function () {
    var host = server.address().address;
    var port = server.address().port;
    console.log("http -- 访问地址为 http://%s:%s", host, port);
});


//方式1 --- websocket
/*wss.on('connection', function (ws) {
    console.log("websocket -- 已建立与客户端的连接");
    var sendData = function (ws) {
        if (ws.readyState == 1) { //1 -- websocket连接正常
            event.on('websocket', function(data) {
                console.log('event -- 监听到websocket事件');
                //从数据库获取最新数据并返回websocket客户端
                conn.query(selectSQL, function (err2, rows) {
                    if (err2) {console.log("db -- 数据获取失败："+err2);return false;}
                    var ret = [];
                    for (var i in rows) {
                        //转换时间
                        var d = new Date(rows[i]['time']);
                        var time = timetostr(d);//转换为 y-m-d H:i:s 格式
                        ret[i] = {name:time,value:[time,rows[i]['avg']]};//构建数据返回格式
                        //console.log(ret[i]);
                    }
                    ret.reverse();//反转数组，让id小的排前面

                    //发送数据到客户端
                    ws.send(JSON.stringify(ret));//json对象转成字符串
                    console.log("websocket -- s->c：data has been sent");
                });
            });
        }
    };
    sendData(ws);

    //接收客户端消息
    ws.on('message', function (message) {
        //var stockRequest = JSON.parse(message);//json字符串转json对象
        console.log("websocket -- c->s："+message);
    });
});*/

//方式2 -- socket.io
io.sockets.on('connection', function(socket) {
    console.log('socket.io -- 已建立与客户端的连接');
    event.on('websocket', function(data) {
        console.log('event -- 监听到websocket事件');
        //从数据库获取最新数据并返回websocket客户端
        conn.query(selectSQL, function (err2, rows) {
            if (err2) {console.log("db -- 数据获取失败："+err2);return false;}
            var ret = [];
            for (var i in rows) {
                //转换时间
                var d = new Date(rows[i]['time']);
                var time = timetostr(d);//转换为 y-m-d H:i:s 格式
                ret[i] = {name:time,value:[time,rows[i]['avg']]};//构建数据返回格式
                //console.log(ret[i]);
            }
            ret.reverse();//反转数组，让id小的排前面

            //发送数据到客户端，触发data事件
            socket.emit('new_data',JSON.stringify(ret));//json对象转成字符串
            console.log("socket.io -- s->c：data has been sent");
        });
    });

});
