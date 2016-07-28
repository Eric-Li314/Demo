// JavaScript Document
$(function(){
	$('#saytxt').bind("blur focus keydown keypress keyup", function(){
		recount();
	});
    $("#myform").submit(function(){
		//var submitData = $(this).serialize();
		var saytxt = $("#saytxt").val();
		var ip = $("#ip").val();
		var location = $("#location").val();
		if(saytxt==""){
			$("#msg").show().html("你总得说点什么吧.").fadeOut(1200);;
			return false;
		}
		$('.counter').html('<img style="padding:8px 12px" src="images/load.gif" alt="正在处理..." />');
		$.ajax({
		   type: "POST",
		   url: "submit.php",
		   //data: submitData,
		   data:"saytxt="+saytxt+"&ip="+ip+'&location='+location,
		   dataType: "html",
		   success: function(msg){
			  if(parseInt(msg)!=0){
				 $('#saywrap').prepend(msg);
				 $('#saytxt').val('');
				 recount();
			  }
		  }
	    });
		return false;
	});
});

function recount(){
	var maxlen=140;
	var current = maxlen-$('#saytxt').val().length;
	$('.counter').html(current);

	if(current<0 || current>maxlen){
		$('.counter').css('color','#D40D12').html("超过最大字数限制！");
		$('input.sub_btn').attr('disabled','disabled').attr('src',"file/btn1.jpg");
	}
	else
		$('input.sub_btn').removeAttr('disabled').attr('src',"file/btn.gif");

	if(current<10)
		$('.counter').css('color','#D40D12');

	else if(current<20)
		$('.counter').css('color','#5C0002');

	else
		$('.counter').css('color','#cccccc');

}
