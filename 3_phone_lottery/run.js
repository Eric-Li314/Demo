/**
 * Created by USER on 2016/7/15.
 */
$(document).ready(function(){
    var _gogo;
    var start_btn = $("#start");
    var stop_btn = $("#stop");

    start_btn.click(function(){
        //ajax 获取未抽中的手机号码数据
        $.post('data.php','',function(json){
            if(json){
                var obj = eval(json);//将JSON字符串转化为对象
                var len = obj.length;
                _gogo = setInterval(function(){
                    var num = Math.floor(Math.random()*len);//获取随机数
                    var id = obj[num]['id']; //随机id
                    var v = obj[num]['mobile']; //对应的随机号码
                    $("#roll").html(v);
                    $("#mid").val(id);
                },100); //每隔100ms执行一次
                stop_btn.show();
                start_btn.hide();
            }else{
                $("#roll").html('系统找不到数据源，请先导入数据。');
            }
        });
    });

    stop_btn.click(function(){
        clearInterval(_gogo);
        var mid = $("#mid").val();
        //将抽中的手机号码对应的id传给后台，如果该id是未抽中的则显示出来
        $.post("data.php?action=ok",{id:mid},function(msg){
            if(msg==1){
                var mobile = $("#roll").html();
                $("#result").append("<p>"+mobile+"</p>");
            }
            stop_btn.hide();
            start_btn.show();
        });
    });
});