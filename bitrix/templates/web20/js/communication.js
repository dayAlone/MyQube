$(document).ready(function(){
	$("#new-friends-number,.chat-head").click(function(){
		
		$("#shadow-new-friens-popup").show();
		$("#shadow-friends-edit-popup").show();	
			var path = host_url+"/personal/profile/ajax/friends.php";
			$.get(path, {}, function(data){
				$("#shadow-new-friens-popup").html(data);
			});
	});
	$("body").on("click", "#popup-friends-cancel", function(){
		$("#shadow-new-friens-popup").hide();
		$("#shadow-friends-edit-popup").hide();
	});
	$("body").on("click", ".add-or-del-friend", function(){
		var userID = $(this).data("id");
		var subin = $(this).data("subin");
		var path = host_url+"/personal/profile/ajax/friends_res.php";
		var parent = $(this).parent();
		$.get(path, {userID:userID, subin:subin}, function(data){
			if($(parent).hasClass("popup_subs"))
				$(parent).parent().remove();
			else {
				$(parent).find('.del').hide();
				$(parent).find('.add').hide();
				$(parent).find('.'+data).show();
			}
		});
		if($(this).hasClass("add"))
			alert("Ваша заявка отправлена");
	});
	
	$("body").on("click", "#friends-requests", function(){
		var path = host_url+"/personal/profile/ajax/friends.php";
		$.get(path, {}, function(data){
			$("#shadow-new-friens-popup").html(data);
			$("#friends-requests-page").show();
			$("#friends-subs-page").hide();		
			$("#friends-search-page").hide();
		});
	});
	
	$("body").on("click", "#friends-subs", function(){
		var path = host_url+"/personal/profile/ajax/friends.php";
		$.get(path, {}, function(data){
			$("#shadow-new-friens-popup").html(data);			
			$("#friends-subs-page").show();
			$("#friends-requests-page").hide();
			$("#friends-search-page").hide();
		});
	});
	$(".id_add_photo").click(function(){
		$("#add_post_page").show();
	
		$("#new_post_page").hide();
		$("#new_photo_page").show();
		$("#new_album_page").hide();
	});
});
function getName (str){
  var preview = document.getElementById('profile-avatar-img-popup');
  var file    = document.getElementById('upload_avatar').files[0];
  var reader  = new FileReader();

  reader.onloadend = function () {
    $("#profile-avatar-img-popup").css("background-image", "url('"+reader.result+"')");
  }

  if (file) {
    reader.readAsDataURL(file);
  } else {
    preview.src = "";
  }
}
function getName2 (obj, str){
    if (str.lastIndexOf('\\')){
        var i = str.lastIndexOf('\\')+1;
    }
    else{
        var i = str.lastIndexOf('/')+1;
    }						
    var filename = "("+str.slice(i)+")";			
    var uploaded = document.getElementById("fileformlabel");
    $(obj).parent().find(".selectbutton").html(filename+" <span></span>");
}