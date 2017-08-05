/**
 * Created by USER on 2016/9/23.
 */

$(document).ready(function(){

    //转换为 2018-01-05 18:11:25 格式
    function timetostr(timestamp){
        var d = new Date(timestamp * 1000);
        var y = d.getFullYear();
        var m = d.getMonth() + 1;
        m = m < 10 ? "0" + m : m;
        var day = d.getDate();
        day = day < 10 ? "0" + day : day;
        var h = d.getHours();
        h = h < 10 ? "0" + h : h;
        var i = d.getMinutes();
        i = i < 10 ? "0" + i : i;
        var s = d.getSeconds();
        s = s < 10 ? "0" + s : s;

        return y+"-"+m+"-"+day+" "+h+":"+i+":"+s;
    }


    $('#input').show();
    $('#mask').show();

    //添加昵称，ajax存库
    $('#addNickname').click(function(){
        nickname = $('input[name=nickname]').val();
        if(!nickname){
            alert("请输入昵称！！！");
            return false;
        }

        $('#addNickname').html("提交中...").prop("disabled",true);
        $('input[name=nickname]').prop("disabled",true);

        $.post(
            "save.php",
            {
                "action":"addnickname",
                "nickname":nickname,
                "type":"提示",
                "content":"joined the chat room!",
            },
            function(data){
                if(data=="repeat"){
                    alert("该昵称已被使用！");
                    $('#addNickname').html("提交").prop("disabled",false);
                    $('input[name=nickname]').prop("disabled",false).val('');
                    return false;
                }
                if(jQuery.parseJSON(data).status == "ok"){
                    $('#mask').hide();
                    $('#input').hide();
                    var info = "<p style='color:blue'>"+nickname+" joined the chat room!</p>";
                    $('#list').append(info);
                    $('#header').html(nickname);
                    $('#lastid').html($.parseJSON(data).lastid);

                }else{
                    alert("昵称提交失败！");
                    $('#addNickname').html("提交").prop("disabled",false);
                    $('input[name=nickname]').prop("disabled",false).val('');
                }

                $('#list').scrollTop(9999);//滚动条自动到底部

                //ajax短轮询获取消息
                /*setInterval(function(){
                    $.ajax({
                        type: "POST",
                        url: "get.php",
                        data: {"nickname":nickname,"lastid":$('#lastid').html()},
                        dataType: "json", //以json格式接收直接转为json对象
                        success: function (json) {
                            if(json){
                                $.each(json.data,function(i,e){

                                    var time = timetostr(e.time);
                                    if(e.type == "提示"){
                                        var info = "<p style='color:blue'>"+ e.nickname+"("+time+") "+ e.content+"</p>";
                                    }else{
                                        var info = "<p><span style='color:blue;'>"+ e.nickname +"</span>("+ time +")： "+ e.content +"</p>"
                                    }

                                    $('#list').append(info);

                                });
                                $('#lastid').html(json.lastid);//存lastid
                                $('#list').scrollTop(99999);//滚动条自动到底部
                            }

                            //$('#list').scrollTop(999999);//滚动条自动到底部

                        },
                        error: function () {

                        },
                    });
                },1000);*/

                //ajax 长连接方式获取消息
                (function longPolling() {
                    $.ajax({
                        url: "get.php",
                        data: {"nickname":nickname,"lastid":$('#lastid').html()},
                        type: "post",
                        dataType: "json", //以json格式接收直接转为json对象
                        timeout: 30000, //请求超时时间，如果服务器响应时间超过了这个时间或者这段时间内无返回值，则进入 ERROR （错误处理）
                        error: function (XMLHttpRequest, textStatus, errorThrown) {
                            $("#state").append("<p style='color:blue;'>[state: " + textStatus + ", error: " + errorThrown + " ]</p>");
                            if (textStatus == "timeout") { // 请求超时
                                longPolling(); // 递归调用
                                // 其他错误，如网络错误等
                            } else {
                                longPolling();
                            }
                        },
                        success: function (json,textStatus) {

                            if(json){
                                $.each(json.data,function(i,e){

                                    var time = timetostr(e.time);
                                    if(e.type == "提示"){
                                        var info = "<p style='color:blue'>"+ e.nickname+"("+time+") "+ e.content+"</p>";
                                    }else{
                                        var info = "<p><span style='color:blue;'>"+ e.nickname +"</span>("+ time +")： "+ e.content +"</p>"
                                    }

                                    $('#list').append(info);

                                });
                                $('#lastid').html(json.lastid);//存lastid
                                $('#list').scrollTop(99999);//滚动条自动到底部
                            }

                            if (textStatus == "success") { // 请求成功
                                longPolling();
                            }
                        }
                    });
                })();

                //ajax轮询更新用户在线状态同时检查离线用户--10s一次
                setInterval(function(){
                    $.ajax({
                        type: "POST",
                        url: "update_status.php",
                        data: {"nickname":nickname},
                        dataType: "json", //以json格式接收直接转为json对象
                        success: function () {},
                        error: function () {},
                    });
                },10000);
            }
        );



    });

    //保存发言内容
    $('#send').click(function(){
        var content = $('#content').val();
        if(!content){alert("请输入内容！");return false;}
        $.post(
            "save.php",
            {
                "action":"send",
                "nickname":nickname,
                "type":"内容",
                "content":content,
            },
            function(data){
                if(jQuery.parseJSON(data).status == "ok"){
                    var info = "<p><span style='color:blue;'>"+ nickname +"</span>("+ jQuery.parseJSON(data).time +")： "+content+"</p>";
                    $('#list').append(info);
                    $('#content').val("");
                }else{
                    alert("发送失败！！！");
                }

                $('#list').scrollTop(9999);//滚动条自动到底部
                //$("#list").scrollTop=$("#list").scrollHeight;
            }
        );

    });



});
