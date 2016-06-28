/**
 * Created by USER on 2016/6/28.
 */
$(document).ready(function(){
    $('#name').blur(function(){
        $(this).val().length<5 ? $('#info').css('color','red').html('长度应该至少5个字符') : $('#info').css('color','green').html('ok');

    });
});
