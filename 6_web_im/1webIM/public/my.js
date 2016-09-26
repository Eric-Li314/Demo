/**
 * Created by USER on 2016/9/23.
 */

$(document).ready(function(){

    //转换为 2018-11-15 18:11:25 格式
    function timetostr(timestamp){
        var d = new Date(timestamp * 1000);
        var y = d.getFullYear();
        var m = d.getMonth() + 1;
        var day = d.getDate();
        var h = d.getHours();

        if(d.getMinutes()<10){
            var i = "0"+ d.getMinutes();
        }else{
            var i = d.getMinutes();
        }

        if(d.getSeconds()<10){
            var s = "0"+ d.getSeconds();
        }else{
            var s = d.getSeconds();
        }

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

                }else{
                    alert("昵称提交失败！");
                    $('#addNickname').html("提交").prop("disabled",false);
                    $('input[name=nickname]').prop("disabled",false).val('');
                }

                $('#list').scrollTop(9999);//滚动条自动到底部

                //ajax短轮询获取消息
                setInterval(function(){
                    $.ajax({
                        type: "POST",
                        url: "get.php",
                        data: {"nickname":nickname},
                        dataType: "json", //以json格式接收直接转为json对象
                        success: function (json) {
                            if(json){
                                $.each(json,function(i,e){

                                    var time = timetostr(e.time);
                                    if(e.type == "提示"){
                                        var info = "<p style='color:blue'>"+ e.nickname+"("+time+") "+ e.content+"</p>";
                                    }else{
                                        var info = "<p><span style='color:blue;'>"+ e.nickname +"</span>("+ time +")： "+ e.content +"</p>"
                                    }

                                    $('#list').append(info);

                                });
                                $('#list').scrollTop(99999);//滚动条自动到底部


                            }else{

                            }

                            //$('#list').scrollTop(999999);//滚动条自动到底部

                        },
                        error: function () {

                        },
                    });
                },1000);

                //ajax轮询更新用户在线状态--10s一次
                setInterval(function(){
                    $.ajax({
                        type: "POST",
                        url: "update_status.php",
                        data: {"nickname":nickname},
                        dataType: "json", //以json格式接收直接转为json对象
                        success: function (data) {
                            if(data){
                                //data为下线用户提示消息
                                $('#list').append(data);
                                $('#list').scrollTop(99999);//滚动条自动到底部

                            }else{}

                            //$('#list').scrollTop(999999);//滚动条自动到底部

                        },
                        error: function () {

                        },
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
