<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Общение");
?>

 <script>
$(document).ready(function(){
	/*$(".likes").click(function(){
		$( this ).toggleClass( "active" );
		var path = host_url+"/group/lenta/like_post.php";
		$.get(path, {post_id: $(this).attr('id'),like: Number($( this ).hasClass( "active" ))}, function(data){
		});
	});*/
	$("#new-friends-number,.chat-head").click(function(){
		
		$("#shadow-new-friens-popup").show();
		$("#shadow-friends-edit-popup").show();	
		//if($("#shadow-new-friens-popup").html()=="")
		//{
			var path = host_url+"/user/profile/ajax/friends.php";
			$.get(path, {}, function(data){
				$("#shadow-new-friens-popup").html(data);
			});
		//}
	});
	$("body").on("click", "#popup-friends-cancel", function(){
		$("#shadow-new-friens-popup").hide();
		$("#shadow-friends-edit-popup").hide();
	});
	$("body").on("click", ".add-or-del-friend", function(){
		var userID = $(this).data("id");
		var subin = $(this).data("subin");
		var path = host_url+"/user/profile/ajax/friends_res.php";
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
	/*$("body").on("click", ".del-request-friend", function(){
		var userID = $(this).data("id");
		var path = host_url+"/user/profile/ajax/friends_res.php";
		$.get(path, {userID:userID, del_request:"Y"}, function(data){
			$("#user-"+userID).find(".right-icons").html(data);
		});
	});
	$("body").on("click", ".res-sub-friend", function(){
		var userID = $(this).data("id");
		var path = host_url+"/user/profile/ajax/friends_res.php";
		$.get(path, {userID:userID, sub:"Y"}, function(data){
			$("#user-"+userID).find(".right-icons").html(data);
		});
	});*/
	
	$("body").on("click", "#friends-requests", function(){
		var path = host_url+"/user/profile/ajax/friends.php";
		$.get(path, {}, function(data){
			$("#shadow-new-friens-popup").html(data);
			$("#friends-requests-page").show();
			$("#friends-subs-page").hide();		
			$("#friends-search-page").hide();
		});
	});
	
	$("body").on("click", "#friends-subs", function(){
		var path = host_url+"/user/profile/ajax/friends.php";
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
</script>
	
<link rel="stylesheet" href="/css/cabinet.css">
	<div class="shadow-profile-edit-popup" id="shadow-friends-edit-popup" style="display:none; z-index: 101;">
		<div id="shadow-new-friens-popup" class="shadow-new-friens-popup"></div>
	</div>
	<style>
		.right-text {
			top: 4px !important;
			font-size: 10px !important;
			color: #fff !important;
		}
		.comment-date {
			margin-right: 0px;
			color: #555c63;
			
		}
        

	</style>


<script type="text/javascript">
		/*$(function(){			
			$(".nav_text").show();
			$("#nav_left_open").css("width","170");
			$(".show_full_nav").addClass("show_full_nav_full");	
			})*/
	</script>
         <link rel="stylesheet" href="../../css/communication-mobile.css">

<?
/*$APPLICATION->IncludeComponent("bitrix:menu", "top_line", Array(
	"ROOT_MENU_TYPE"	=>	"left",
	"MAX_LEVEL"	=>	"1",
	"CHILD_MENU_TYPE"	=>	"left",
	"USE_EXT"	=>	"Y",
	"MENU_CACHE_TYPE" => "A",
	"MENU_CACHE_TIME" => "3600",
	"MENU_CACHE_USE_GROUPS" => "Y",
	"MENU_CACHE_GET_VARS" => array(
		0 => "SECTION_ID",
		1 => "page",
	),
	"LAST_LINK" => array(
		"NAME" => "НАПИСАТЬ",
		"STYLE" => "style='color:red;'",
		"LINK" => "/communication/new"
	)
	)
);*/
$friend_in = intval($_GET['friend_in']);

/*if($friend_in==0)
{
	$rsMess = CIBlockElement::GetList(Array(),Array("IBLOCK_ID"=>15,"IN_OUT"=>min($USER->GetID(),$PROPS['USER_IN'])."_".max($USER->GetID(),$PROPS['USER_IN'])),Array("ID"),false);
	$Mess   = $rsMess->Fetch();
}*/

$APPLICATION->IncludeComponent("bitrix:menu", "top_line_communication", Array(
	"ROOT_MENU_TYPE" => "left",	// Тип меню для первого уровня
		"MAX_LEVEL" => "1",	// Уровень вложенности меню
		"CHILD_MENU_TYPE" => "left",	// Тип меню для остальных уровней
		"USE_EXT" => "Y",	// Подключать файлы с именами вида .тип_меню.menu_ext.php
		"MENU_CACHE_TYPE" => "A",	// Тип кеширования
		"MENU_CACHE_TIME" => "3600",	// Время кеширования (сек.)
		"MENU_CACHE_USE_GROUPS" => "Y",	// Учитывать права доступа
		"MENU_CACHE_GET_VARS" => array(	// Значимые переменные запроса
			0 => "SECTION_ID",
			1 => "page",
		),
		"search" => "y"
	),
	false
);

if($friend_in>0)
	$AR_FILTER = Array("PROPERTY_USER_IN"=>Array($USER->GetID(),$friend_in),"CREATED_BY"=>Array($USER->GetID(),$friend_in));
else
	$AR_FILTER = Array("PROPERTY_USER_IN"=>$USER->GetID());
//	$AR_FILTER = Array("PROPERTY_USER_IN"=>Array(-1),"CREATED_BY"=>Array(-1));
	
	$APPLICATION->IncludeComponent("bitrix:news.list", "correspondence", Array(
	"COMPONENT_TEMPLATE" => "correspondence",
		"IBLOCK_TYPE" => "comments",	// Тип информационного блока (используется только для проверки)
		"IBLOCK_ID" => "12",	// Код информационного блока
		"NEWS_COUNT" => "100",	// Количество новостей на странице
		"SORT_BY1" => "ID",	// Поле для первой сортировки новостей
		"SORT_ORDER1" => "ASC",	// Направление для первой сортировки новостей
		"SORT_BY2" => "SORT",	// Поле для второй сортировки новостей
		"SORT_ORDER2" => "ASC",	// Направление для второй сортировки новостей
		"FILTER_NAME" => "AR_FILTER",	// Фильтр
		"FIELD_CODE" => array(	// Поля
			0 => "PREVIEW_TEXT",
			1 => "DATE_CREATE",
			2 => "CREATED_BY",
			3 => "CREATED_USER_NAME",
		),
		"PROPERTY_CODE" => array(	// Свойства
			0 => "USER_IN",
		)
	),
	false
);
?>
<?
			$APPLICATION->IncludeComponent(
			"bitrix:main.include",
			"",
			Array(
				"COMPONENT_TEMPLATE" => ".default",
				"AREA_FILE_SHOW" => "file",
				"AREA_FILE_SUFFIX" => "inc",
				"EDIT_TEMPLATE" => "",
				"PATH" => "/chat/index.php"
			)
		);?>
<br><?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>