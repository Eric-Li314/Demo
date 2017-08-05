/**
 * Created by USER on 2016/6/28.
 */
$(document).ready(function(){
    $('#name').blur(function(){
        if(!$(this).val()){
            $('#error_name').css('color','red').html('用户名不能为空');
            return;
        }
        if($(this).val() && $(this).val().length<=3){
            $('#error_name').css('color','red').html('长度至少4个位');
            return;
        }
        $.post(
            'data_check.php',
            {"name":$('#name').val()},
            function(data){
                var data = $.parseJSON(data);
                data.ret == 'ok' ? $('#error_name').css('color','red').html('用户名已存在'):
                    $('#error_name').css('color','green').html('ok');
            }

        );

    });

    $('#pwd').blur(function(){
        if(!$(this).val()){
            $('#error_pwd').css('color','red').html('密码不能为空');
            return;
        }
        if($(this).val() && $(this).val().length<6){
            $('#error_pwd').css('color','red').html('长度至少6位');
            return;
        }else{
            $('#error_pwd').css('color','green').html('ok');
        }
    });

    $('#email').blur(function(){
        if($(this).val()){
            var reg = /\w+@\w+[.]\w+/;
            if (!reg.test($("#email").val())) {
                $('#error_email').css('color','red').html('邮箱格式错误');
            }else{
                $('#error_email').css('color','green').html('ok');
            }
            return;
        }
        $('#error_email').html('');
    });

    $('#phone').blur(function(){
        if($(this).val() && $(this).val().length != 11){
            if(isNaN($(this).val())){
                $('#error_phone').css('color','red').html('数据格式为纯数字');
                $(this).val('');
                return;
            }
            $('#error_phone').css('color','red').html('长度为11位');
            return;
        }
        if($(this).val() && !isNaN($(this).val()) && $(this).val().length == 11){
            $('#error_phone').css('color','green').html('ok');
            return;
        }
        $('#error_phone').html('');
    });

    $('#name,#pwd,#email,#phone').focus(function(){
        $(this).css('border','');
    });

    $('#btn').click(function(){
        if($('#error_name').html() == "ok" && $('#error_pwd').html() == 'ok'){
            if( $('#email').val() && $('#error_email').html() != 'ok'){
                $('#email').css('border','2px solid red');
                alert("请检查数据");
            }
            else if( $('#phone').val() && $('#error_phone').html() != 'ok'){
                $('#phone').css('border','2px solid red');
                alert("请检查数据");
            }else{
                alert("数据通过");
                $('form').submit();

            }
        }else{
            if($('#error_name').html()!='ok') $('#name').css('border','2px solid red');
            if($('#error_pwd').html()!='ok') $('#pwd').css('border','2px solid red');
            alert("请检查数据");
        }
    });
});
