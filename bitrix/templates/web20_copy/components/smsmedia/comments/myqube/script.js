$(document).ready(function() 
{
	$('#new_comment_form').submit(function() {
		if($('#TEXT').val() == '')
		{
			alert('Вы не ввели комментарий');	
			return false;
		}
		else
		{
			$(this).find("button[type=submit]").attr("disabled","disabled");
			return true;
		}
	});
});

function scrollToComment(comment_id)
	{
		var comment_id = '#comment_' + comment_id;
//		alert(comment_id);
		$('html,body').animate({scrollTop: $(comment_id).offset().top}, 1000); 
	}

function ReplyToComment(id, username, depth_level) 
{
	 $("input[name=PARENT_ID]").val(id);
	 $("#TEXT").val(username);
	 $("#TEXT").focus();
}

