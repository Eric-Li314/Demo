初次运行请确认数据库已经配置好
monitor（table）：字段如下
id（int11） 
domain（varchar50）
max min avg int（11）
time datetime

monitor_probe 是周期获取监控数据，然后存入数据库中

短连接和长连接都是轮询方式从服务器获取数据，都要携带lastid参数，服务器通过这个判断是否有新数据入库
短连接：轮询服务器获取结果，不一定每次请求都有数据返回
长连接：轮询服务器，每次都有结果返回

websocket 技术可以让服务器主动推动数据到客户端
socket.io