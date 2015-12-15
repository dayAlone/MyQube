<?
if(!$USER->IsAuthorized()) {
	LocalRedirect("/?backurl=".$_SERVER["REQUEST_URI"]);
}
if($USER->IsAuthorized()) {?><?
      CJSCore::Init(array("jquery"));
 ?>
 <script type="text/javascript" src="/js/jquery.Jcrop.js"></script>
 <script type="text/javascript" src="/js/jquery.color.js"></script>
 <link rel="stylesheet" href="/css/jquery.Jcrop.css">
 <script>
$(document).ready(function(){
	
	$("#new-friends-number,.chat-head").click(function(){		
		$("#shadow-new-friens-popup").show();
		$("#shadow-friends-edit-popup").show();	
		var path = host_url+"/user/profile/ajax/friends.php";
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
		var path = host_url+"/user/profile/ajax/friends_res.php";
		var parent = $(this).parent();
		$.get(path, {userID:userID, subin:subin}, function(data){
			if($(parent).hasClass("popup_subs")) {
				$(parent).parent().remove();
			} else {
				$(parent).find('.del').hide();
				$(parent).find('.add').hide();
				$(parent).find('.'+data).show();
			}
		});
		if($(this).hasClass("add")) {
			$( "#window_invite_group" ).show();
			$('#window_invite_group').delay(1000).fadeOut()
		}
	});
	
	$(".id_add_photo").click(function(){
		$("#add_post_page").show();	
		/*$("#new_post_page").hide();*/
		$("#new_photo_page").show();
		$("#new_album_page").hide();
	});
	/*$('#upload_avatar').bind('click', function (e) {
	  e.preventDefault();
	  cropperImg();
	});*/
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
function updateCoords(c)
{
	console.log("update cords");
	$('#x').val(c.x);
	$('#y').val(c.y);
	$('#w').val(c.w);
	$('#h').val(c.h);
}
function cropperImg (str){
	var preview = document.getElementById('profile-avatar-img-popup');
	var file    = document.getElementById('upload_avatar').files[0];
	var reader  = new FileReader();
	$("#ava_popup").show();
	reader.onloadend = function () {
		/*$("#profile-avatar-img-popup").css("background-image", "url('"+reader.result+"')");*/		
		console.log("inside image upload 1 " + reader.result);
		$("#ava_popup_inner").html("<img id='preview_cropper' src='"+reader.result+"'/>");
		$('#preview_cropper').Jcrop({bgColor:     'black',bgOpacity:   .4, onSelect: updateCoords,aspectRatio:1},function(){

        jcrop_api = this;
        jcrop_api.animateTo([0,0,100,100]);
        // Setup and dipslay the interface for "enabled"
        /*$('#can_click,#can_move,#can_size').attr('checked','checked');
        $('#ar_lock,#size_lock,#bg_swap').attr('checked',false);
        $('.requiresjcrop').show();*/

      });
	}
	if (file) {
		reader.readAsDataURL(file);
	} else {
		preview.src = "";
	}
}
function send_ava() {
	//console.log("send ava");
	//$("#ava_popup").hide();
	$.post( "/user/ajax/crop.php", { x: $('#x').val(), y: $('#y').val(), w:$('#w').val(), h:$('#h').val() ,img:$('#preview_cropper').attr('src')})
		.done(function( data ) {
			location.reload();
	  });
	return false;
}
function getName2 (obj, str){
	if (str.lastIndexOf('\\')){
		var i = str.lastIndexOf('\\')+1;
	}else{
	var i = str.lastIndexOf('/')+1;
	}						
	var filename = "("+str.slice(i)+")";			
	var uploaded = document.getElementById("fileformlabel");
	$(obj).parent().find(".selectbutton").html(filename+" <span></span>");
}
</script>
<style>

#window_invite_group {
	display:none;
	position:fixed;
	left:32%;
	top:25%;
	width:350px;
  	background-color: #FFF;
	z-index:10;
	-webkit-box-shadow: 11px 11px 5px 0px rgba(50, 50, 50, 0.76);
	-moz-box-shadow:    11px 11px 5px 0px rgba(50, 50, 50, 0.76);
	box-shadow:         11px 11px 5px 0px rgba(50, 50, 50, 0.76);
}
.header_invite {
	background: #FFF;
	color: #001d44;
	font-size: 16px;
	padding: 10px 20px;
	line-height: 20px;
	text-align: center;
}
.button_invite {
	height: 60px;
	background-color: #001d44;
	line-height: 50px;
	font-size: 16px;
	padding: 20px;
	text-align: center;
}
#new_photo_page {
	padding-left: 20px;
    padding-bottom: 10px;
}
</style>
	<div id="window_invite_group">
		<div class="header_invite"></div>
		<div class="button_invite">
			<span>Ваша заявка отправлена</span>
		</div>
	</div>
<link rel="stylesheet" href="/css/cabinet.css">
<?
if(!empty($_GET["user"])) {
	$userID = $_GET["user"];
	$myProfile = CUser::GetByID($USER->GetID())->Fetch();
	$friends = false;	
	$outSub = false;
	if(in_array($userID, $myProfile["UF_FRIENDS"]))
		$friends = true;
	elseif(in_array($userID, $myProfile["UF_FRIENDS_SUB"]))
		$outSub = true;
} else
	$userID = $USER->GetID();
$CurentUser = CUser::GetByID($userID)->Fetch();

if($CurentUser["ID"] !== $USER->GetID()) {
	if($CurentUser["UF_PRIVATE_MYPAGE"] == 4) {
		echo "Страница закрыта настройками приватности.";
		die();
	}
	if($CurentUser["UF_PRIVATE_MYPAGE"] == 3) {
		$friendsFriends = array();
		foreach($CurentUser["UF_FRIENDS"] as $key => $value) {
			$friendsFriends = array_merge($friendsFriends, CUser::GetByID($value)->Fetch()["UF_FRIENDS"]);
		}
		if(!in_array($USER->GetID(), $CurentUser["UF_FRIENDS"]) && !in_array($USER->GetID(), $friendsFriends)) {
			echo "Страница закрыта настройками приватности.";
			die();
		}
	}
	if($CurentUser["UF_PRIVATE_MYPAGE"] == 2 && !in_array($USER->GetID(), $CurentUser["UF_FRIENDS"])) {
		echo "Страница закрыта настройками приватности.";
		die();
	}
}
?>
	<div style="width: 100%; float: left;">
	<div class="shadow-profile-edit-popup" id="shadow-friends-edit-popup" style="display:none; z-index: 9;">
		<div id="shadow-new-friens-popup" class="shadow-new-friens-popup"></div>
	</div>
	<!-- Верхний блок -->
      <link href="<?$_SERVER["DOCUMENT_ROOT"]?>/mobile/profile.css" rel="stylesheet">
		<div class="profile-head">
		<div class="left-profile-head">
            <div class="mobile-block mobile-profile-icons">
                <div class="mobile-menu-ico" id="menu-button"></div>
                <div class="mobile-frend-ico" id="menu-button-chat"></div>                
            </div>
            
            <script>
            $(function(){

             if( navigator.userAgent.match(/Android/i) ||
            	navigator.userAgent.match(/webOS/i) ||
            	navigator.userAgent.match(/iPhone/i) ||
            	navigator.userAgent.match(/iPod/i) ||
				navigator.userAgent.match(/Windows Phone/i) ||
				navigator.userAgent.match(/iemobile/i)
            	){
                    $("#menu-button").click(function(){
                
                        if($("#nav_left_open").css('left') == '-165px'){
                            $("html").css('overflow', 'hidden')
                            $("#nav_left_open").animate({ left: '0' }, 400);
                            $("div.main").animate({ left: '165' }, 400);                     
                        };
                        if($("#nav_left_open").css('left') == '0px'){
                            $("html").css('overflow', 'auto')
                            $("#nav_left_open").animate({ left: '-165' }, 400);
                            $("div.main").animate({ left: '0' }, 400);
                        };
                    })           
                    $("#menu-button-chat").click(function(){
                
                        if($(".chat").css('right') == '-210px'){
                            $("html").css('overflow', 'hidden')
                            $(".chat").animate({ right: '0' }, 400);
                            $("div.main").animate({ left: '-210' }, 400);                     
                        };
                        if($(".chat").css('right') == '0px'){
                            $("html").css('overflow', 'auto')
                            $(".chat").animate({ right: '-210' }, 400);
                            $("div.main").animate({ left: '0' }, 400);
                        };
                    })                    
                }
                            
                
                
                
            })
 
            </script>
            
            
			<div class="up-left-profile-head">
				<div class="profile-avatar">
					<div class="profile-avatar-img" style="background-image:url('<?=CFile::GetPath($CurentUser["PERSONAL_PHOTO"]);?>');">
						<?if($CurentUser["ID"] == $USER->GetID()) {?>
						<div class="profile-avatar-img-round" id="profile-avatar-img-round">
							<div class="profile-avatar-img-round-img"></div>
						</div>
						<?}?>
					</div>
				</div>
				<div class="profile-info">
					<div class="profile-user-name">
						<?=$CurentUser["NAME"].' '.$CurentUser["LAST_NAME"]?>
					</div>
					<div class="profile-date">
					<?if($CurentUser["PERSONAL_BIRTHDAY"]){?>
						<?=FormatDate(array("d" => 'j F'), MakeTimeStamp($CurentUser["PERSONAL_BIRTHDAY"]), time());?>
					<?}?>
					</div>
					<div class="profile-city">
						<?if($CurentUser["PERSONAL_CITY"]) {?>
							Живет в <?=$CurentUser["PERSONAL_CITY"].", ".GetCountryByID($CurentUser["PERSONAL_COUNTRY"], "ru")?>
						<?}?>
					</div>
				</div>
				<?if($CurentUser["ID"] == $USER->GetID()){?>
					<div class="new-friends-number" id="new-friends-number" <?if(!$CurentUser["UF_FRIENDS_SUB_IN"] && !$CurentUser["UF_FRIENDS_SUB"]) echo ' style="display: none;"';?>>
						<div class="new-friends-number-circle">
							<?=count(array_merge($CurentUser["UF_FRIENDS_SUB"], $CurentUser["UF_FRIENDS_SUB_IN"]))?>
						</div>
					</div>
				<?}?>
				<div class="profile-soc">
					<div class="profile-soc-infoblock">
						<div class="profile-soc-infoblock-head"><?if($CurentUser["ID"] == $USER->GetID()) echo 'Ваши';?> друзья</div>
						<div class="profile-soc-infoblock-bottom"><?if($CurentUser["UF_FRIENDS"]) echo count($CurentUser["UF_FRIENDS"]); else echo 0;?> <?=getNumEnding(count($CurentUser["UF_FRIENDS"]), Array("человек", "человека", "человек"))?></div>
					</div>
					<div class="profile-soc-infoblock">
						<div class="profile-soc-infoblock-head"><?if($CurentUser["ID"] == $USER->GetID()) echo 'Ваc';?> читают</div>
						<div class="profile-soc-infoblock-bottom"><?if($CurentUser["UF_USER_SUB_IN"]) echo count($CurentUser["UF_USER_SUB_IN"]); else echo 0;?> <?=getNumEnding(count($CurentUser["UF_USER_SUB_IN"]), Array("человек", "человека", "человек"))?></div>
					</div>
					<div class="profile-soc-infoblock">
						<div class="profile-soc-infoblock-head"><?if($CurentUser["ID"] == $USER->GetID()) echo 'Вы состоите в'; else echo 'состоит в';?></div>
						<div class="profile-soc-infoblock-bottom"><?if($CurentUser["UF_GROUPS"]) echo count($CurentUser["UF_GROUPS"]); else echo 0;?> <?=getNumEnding(count($CurentUser["UF_GROUPS"]), Array("группе", "группах", "группах"))?></div>
					</div>



				</div>
				
			</div>
			<div class="down-left-profile-head">
				<?if($CurentUser["ID"] !== $USER->GetID()){
					if(!$friends) {
						if(!$outSub) {
							$add = "";
							$del = " style='display: none;'";
						} else {							
							$del = "";
							$add = " style='display: none;'";
						}
						echo '<button class="add-or-del-friend add" data-id="'.$CurentUser["ID"].'"'.$add.'>Добавить в друзья</button>';
						echo '<button class="add-or-del-friend del" data-id="'.$CurentUser["ID"].'"'.$del.'>Отменить заявку</button>';
					}
					else {						
						echo '<button class="add-or-del-friend add" data-id="'.$CurentUser["ID"].'" style="display: none;">Добавить в друзья</button>';
						echo '<button class="add-or-del-friend del" data-id="'.$CurentUser["ID"].'">Удалить из друзей</button>
							<button onclick="window.location.href=\'/communication/'.$CurentUser['ID'].'/\'">Отправить сообщение</button>';
					}
				} else
					echo '<button id="add_post">Опубликовать</button><button id="add_photo">Загрузить</button>';
				?>
			</div>
			<div class="shadow-profile-edit-popup" id="add_post_page" style="display:none; z-index:9;">
				<div class="profile-edit-popup">
					<div class="black-menu" style="background: none;">
						<div class="black-menu-wrap">
							<div class="black-menu-select"><a id="new_post" style="color:#8d9298">Новый пост</a></div>
							<div class="black-menu-select"><a id="new_photo" style="color:#8d9298">Добавить фото/видео</a></div>
							<div class="black-menu-select"><a id="new_album" style="color:#8d9298">Создать альбом</a></div>
						</div>
					</div>
					<style>
						#add_post_page input[type="text"] {
							margin-top: 10px; width: 320px; margin-left: 20px; height: 40px; border-radius: 8px; border: 3px solid #fff;background: #ebebeb; padding-left: 20px; font-weight: bold; color: #969696; text-transform: uppercase;
						}
						#add_post_page textarea {
							width: 500px; font-size: 13px; padding-left: 10px; padding-top: 15px; height: 120px; border-radius: 8px; border: 3px solid #fff; background: #ebebeb; color: #969696; font-weight: bold; font-family: GothaProReg, sans-serif; resize: none; margin-left: 40px;
						}
						#add_post_page .popup-buttons {
							margin: 15px auto; width: 330px;
						}
						#add_post_page .fileform {
							width: 250px;
						}
						#add_post_page .selectbutton {
							border-radius: 8px; border: 3px solid #fff; background: #ebebeb; padding: 15px 20px; font-weight: bold; color: #969696; text-transform: uppercase; display: block;
						}
						#add_post_page .selectbutton span {
							background: url(/images/plus.png); width: 14px; height: 15px; display: block; position: absolute; right: 20px; top: 16px;
						}
						#add_post_page table {
							margin: 0 auto;
						}
						#add_post_page td {
							padding: 5px;
						}
					</style>
					<form method="post" action="/user/lenta/ajax.php" enctype="multipart/form-data">
						<div id="new_photo_page" style="display:none;">
							<input name="video" type="text" placeholder="Место для ссылки с youtube"><br><br>
							<div class="fileform" style="margin-left: 20px;">
								<a class="selectbutton">Загрузить фото <span></span></a>
								<input id="upload" type="file" name="photo" size="20" onchange="getName2(this, this.value);" />
								<div id="fileformlabel"></div>
							</div>
						</div>
						<div id="new_album_page" style="display:none;">
							<div class="new-post-popup-albom-head">
								<div class="new-post-popup-albom-head-icon"></div>
								<div class="new-post-popup-albom-head-text" style="position: relative; top: -24px;"><input type="text" name="head" placeholder="Название альбома"></div>
								<div class="new-post-popup-albom-head-edit">РЕДАКТИРОВАТЬ</div>
							</div>
							<table>
								<tr>
									<td>
										<div class="fileform">
											<a class="selectbutton">Загрузить фото <span></span></a>
											<input id="upload" type="file" name="photo_ar[]" size="20" onchange="getName2(this, this.value);" />
											<div id="fileformlabel"></div>
										</div>
									</td>
									<td>
										<div class="fileform">
											<a class="selectbutton">Загрузить фото <span></span></a>
											<input id="upload" type="file" name="photo_ar[]" size="20" onchange="getName2(this, this.value);" />
											<div id="fileformlabel"></div>
										</div>
									</td>
								</tr>
								<tr>
									<td>
										<div class="fileform">
											<a class="selectbutton">Загрузить фото <span></span></a>
											<input id="upload" type="file" name="photo_ar[]" size="20" onchange="getName2(this, this.value);" />
											<div id="fileformlabel"></div>
										</div>
									</td>
									<td>
										<div class="fileform">
											<a class="selectbutton">Загрузить фото <span></span></a>
											<input id="upload" type="file" name="photo_ar[]" size="20" onchange="getName2(this, this.value);" />
											<div id="fileformlabel"></div>
										</div>
									</td>
								</tr>
								<tr>
									<td>
										<div class="fileform">
											<a class="selectbutton">Загрузить фото <span></span></a>
											<input id="upload" type="file" name="photo_ar[]" size="20" onchange="getName2(this, this.value);" />
											<div id="fileformlabel"></div>
										</div>
									</td>
									<td>
										<div class="fileform">
											<a class="selectbutton">Загрузить фото <span></span></a>
											<input id="upload" type="file" name="photo_ar[]" size="20" onchange="getName2(this, this.value);" />
											<div id="fileformlabel"></div>
										</div>
									</td>
								</tr>
							</table>
						</div>
						<div id="new_post_page">
							<textarea name="post_text" placeholder="Напишите что-нибудь"></textarea>
						</div>
						<div class="popup-buttons">
							<input type="submit" class="popup-save" name="save" value="Опубликовать">
							<button class="popup-cancel" id="popup-cancel-add-post" onclick="return false;">Отмена</button>
						</div>
					</form>
				</div>
			</div>

		</div>
		<!-- Блок с картинками -->
		<div class="right-profile-head" style="position:relative;">
			<?
			$arPhoto = array();
			CModule::IncludeModule("iblock");
			$arSelect = Array("ID", "IBLOCK_ID", "*");
			$arFilter = Array("IBLOCK_ID"=>7, "ACTIVE_DATE"=>"Y", "ACTIVE"=>"Y", "PROPERTY_ANC_ID" => $CurentUser["ID"], "PROPERTY_ANC_TYPE" => 17);
			$res = CIBlockElement::GetList(Array("DATE_CREATE" => "DESC"), $arFilter, false, false, $arSelect);
			while($ob = $res->GetNextElement())
			{
				$arFields = $ob->GetFields();
				$arProps = $ob->GetProperties();
				$arPhoto[] = $arProps["PHOTO"]["VALUE"];
				if(count($arPhoto) >= 6)
					break;			
			}
			$arPhoto = call_user_func_array('array_merge', $arPhoto);
			if(count($arPhoto) < 6)
				$background_photo = '<img src="/images/unknown_profile_images'.(($CurentUser["ID"] != $USER->GetID())?"_6":"").'.png" style="position:absolute; height:100%; width:100%;">';
			echo $background_photo;
			for($i = 0; $i <= 6; $i++)
				$image_small[$i] = CFile::ResizeImageGet($arPhoto[$i], array("width" => 115, "height" => 125), BX_RESIZE_IMAGE_EXACT)
			?>
			<div class="img-container" style="position:absolute; top:0;">
				<div class="img-prof" style="background-image:url('<?=$image_small[0]["src"]?>'); background-size:100%;"></div>
				<div class="img-prof" style="background-image:url('<?=$image_small[1]["src"]?>'); background-size:100%;"></div>
				<div class="img-prof" style="background-image:url('<?=$image_small[2]["src"]?>'); background-size:100%;"></div>
			</div>
			<div class="img-container" style="position:absolute; bottom:0;">
				<div class="img-prof" style="background-image:url('<?=$image_small[3]["src"]?>'); background-size:100%;"></div>
				<div class="img-prof" style="background-image:url('<?=$image_small[4]["src"]?>'); background-size:100%;"></div>
				<?if($CurentUser["ID"] == $USER->GetID()) {?>
					<div class="all-img-prof" style="float:right;">
						<?
						if($background_photo) echo '<a href="#" class="id_add_photo" style="width:auto;">Загрузить фото</a>';
						else echo '<a href="/user/photo/" style="width:auto;">Все фото</a>';
						?>
					</div>
				<?} else {?>
					<div class="img-prof" style="background-image:url('<?=$image_small[5]["src"]?>'); background-size:100%;"></div>
				<?}?>
			</div>
		</div>			

		</div>
		<!-- Центральное меню -->
			<div class="center-menu">
				<?$APPLICATION->IncludeComponent("bitrix:menu", "top_line", Array(
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
					)
					)
				);?>
			</div>
		<div class="posts-block">
			<link type="text/css" rel="stylesheet" href="/css/events_detail.css">
			<script>/*
				$("a.likes" ).click(function() {
					$( this ).toggleClass( "active" );
					var path = host_url+"/group/photo/like_post.php";
					$.get(path, {post_id: $(this).attr('id'),like: Number($( this ).hasClass( "active" ))}, function(data){
					});
				});*/
			</script>
			
<!-- Редактирование профиля. общий попап блок -->
<div class="shadow-profile-edit-popup" id="shadow-profile-edit-popup"<?if($_GET["edit"] == "y") echo ' style="display:block;"';?>>
	<?$APPLICATION->IncludeComponent(
	"bitrix:main.profile", 
	"myqube", 
	array(
		"SET_TITLE" => "Y",
		"COMPONENT_TEMPLATE" => "myqube",
		"AJAX_MODE" => "N",
		"AJAX_OPTION_JUMP" => "N",
		"AJAX_OPTION_STYLE" => "Y",
		"AJAX_OPTION_HISTORY" => "N",
		"AJAX_OPTION_ADDITIONAL" => "undefined",
		"USER_PROPERTY" => array(
			0 => "UF_PRIVATE_MYPAGE",
			1 => "UF_PRIVATE_MYFRIENDS",
			2 => "UF_PRIVATE_MYGROUPS",
			3 => "UF_VK_PROFILE",
			4 => "UF_FB_PROFILE",
			5 => "UF_GP_PROFILE",
		),
		"SEND_INFO" => "N",
		"CHECK_RIGHTS" => "N",
		"USER_PROPERTY_NAME" => ""
	),
	false
);?>
</div>	
<script type="text/javascript">
	var profile = document.getElementById('profile-link');
	var inform = document.getElementById('inform-link');
	var privacy = document.getElementById('privacy-link');	
	var addPost = document.getElementById('add_post');
	var addPhoto = document.getElementById('add_photo');
	var newPost = document.getElementById('new_post');
	var newPhoto = document.getElementById('new_photo');
	var newAlbum = document.getElementById('new_album');

	var addPostPage= document.getElementById('add_post_page');
	var newPostPage= document.getElementById('new_post_page');
	var newPhotoPage= document.getElementById('new_photo_page');
	var newAlbumPage= document.getElementById('new_album_page');	
	var profilePage= document.getElementById('profile-edit-popup-right-profile');
	var informPage= document.getElementById('profile-edit-popup-right-info');
	var privacyPage= document.getElementById('profile-edit-popup-right-privacy');

	var cancel= document.getElementById('popup-cancel');
	var cancelAddPost= document.getElementById('popup-cancel-add-post');
	var profilePopup= document.getElementById('profile-avatar-img-round');

	var popupPage= document.getElementById('shadow-profile-edit-popup');

	$(document).ready(function(){
		$("body").click(function(e) {
			if($("#shadow-profile-edit-popup").is(e.target))	
				popupPage.style.display = "none";
		});
	});
	
	cancelAddPost.addEventListener('click', function(){
		addPostPage.style.display = "none";
	})
	
	cancel.addEventListener('click', function(){
		popupPage.style.display = "none";
	})

	profilePopup.addEventListener('click', function(){
		popupPage.style.display = "block";
	})

	addPost.addEventListener('click', function(){
		addPostPage.style.display = "block";
	})
	addPhoto.addEventListener('click', function(){
		addPostPage.style.display = "block";
		
		/*newPostPage.style.display = "none";*/
		newPhotoPage.style.display = "block";
		newAlbumPage.style.display = "none";
	})
	newPost.addEventListener('click', function(){
		/*newPostPagenewPostPage.style.display = "block";*/
		newPhotoPage.style.display = "none";
		newAlbumPage.style.display = "none";
	})
	newPhoto.addEventListener('click', function(){
		/*newPostPage.style.display = "none";*/
		newPhotoPage.style.display = "block";
		newAlbumPage.style.display = "none";
	})
	newAlbum.addEventListener('click', function(){
		/*newPostPage.style.display = "none";*/
		newPhotoPage.style.display = "none";
		newAlbumPage.style.display = "block";
	})

	profile.addEventListener('click', function(){
		profilePage.style.display = "block";
		informPage.style.display = "none";
		privacyPage.style.display = "none";
		
	})

	inform.addEventListener('click', function(){
		profilePage.style.display = "none";
		informPage.style.display = "block";
		privacyPage.style.display = "none";
	})

	privacy.addEventListener('click', function(){
		profilePage.style.display = "none";
		informPage.style.display = "none";
		privacyPage.style.display = "block";
	})
</script>
<?} elseif($_POST["ID"]) {?>
	<link type="text/css" rel="stylesheet" href="/css/teaser.css">
	<script type="text/javascript" src="/js/plugins/jquery-ui/jquery-ui.min.js"></script>
	<script type="text/javascript" src="/js/plugins/jquery.slimscroll/jquery.slimscroll.min.js"></script>
	<script type="text/javascript" src="/js/plugins/jquery.fancybox/jquery.fancybox.js"></script>
	<link type="text/css" rel="stylesheet" href="/js/plugins/jquery.fancybox/jquery.fancybox.css">
	<script type="text/javascript" src="/js/web20/script.js"></script>
	<style>
		.main { width:100%; }
		.black-menu { width:100%; }
		.content { padding: 0px; }
		.black-menu-select a { text-decoration: none; }
	</style>
	<div class="black-menu">
		<div class="black-menu-wrap">
			<div class="black-menu-select"><a>У меня уже есть аккаунт</a></div>
			<div class="black-menu-select"><a>Присоединиться к проекту</a></div>
		</div>
	</div>
	<?
	$res = CIBlockElement::GetList(array(), array("ID" => $_GET["POST_ID"]));
	while($arRes = $res->GetNextElement()){
		$arItem = $arRes->GetFields();
		$arItem["PROPERTIES"] = $arRes->GetProperties();
		$arPost = $arItem;
	}
	if($arPost["PROPERTIES"]["SHARE"]["VALUE"] !== "Y")
		LocalRedirect("/");
	/*if(empty($arPost["PREVIEW_PICTURE"]) && !empty($arPost["PROPERTIES"]["VIDEO"]["VALUE"])) {
		$parsed_url = parse_url($arPost["PROPERTIES"]["VIDEO"]["VALUE"]);
		parse_str($parsed_url['query'], $parsed_query);
		$pic = "http://img.youtube.com/vi/".$parsed_query['v']."/0.jpg";
	} else {
		$pic = CFile::GetPath($arPost["PREVIEW_PICTURE"]);
	}*/
	$ogImage = CFile::ResizeImageGet($arPost["PROPERTIES"]["OG_IMAGE"]["VALUE"], array('width'=>200, 'height'=>200), BX_RESIZE_IMAGE_PROPORTIONAL, true);
	$APPLICATION->SetPageProperty("title", $arPost["NAME"]);
	$APPLICATION->SetPageProperty("description", $arPost["PROPERTIES"]["OG_DESCRIPTION"]["VALUE"]["TEXT"]);
	$APPLICATION->SetPageProperty("og:title", $arPost["NAME"]);
	$APPLICATION->SetPageProperty("og:description", $arPost["PROPERTIES"]["OG_DESCRIPTION"]["VALUE"]["TEXT"]);
	$APPLICATION->SetPageProperty("og:image", "http://myqube.ru".$ogImage["src"]);
	//echo '<pre>'; print_r($arPost); echo '</pre>';
	?>
	<div class="main">

	<div class="main-head">
		<div class="main-text"><?=$arPost["NAME"]?></div>
	</div>
	<div class="content">
		<div class="left-block">
			<!-- Три иконки справа -->
			<div class="like-menu">
					<div class="like-ico"><img src="/images/like.png" alt="pic"></div>
					<div class="comment-ico"><img src="/images/comment.png" alt="pic"></div>
					<?$APPLICATION->IncludeComponent(
							"bitrix:main.share", 
							"myqube_best", 
							array(
								"COMPONENT_TEMPLATE" => "myqube_best",
								"HIDE" => "N",
								"HANDLERS" => array(
									0 => "facebook",
									1 => "vk",
									2 => "Google",
								),
								"PAGE_URL" => $APPLICATION->GetCurPage(),
								"PAGE_TITLE" => $arPost["NAME"],
								"SHORTEN_URL_LOGIN" => "",
								"SHORTEN_URL_KEY" => ""
							),
							false
						);?>
			</div>
			<div class="info-block">
				<div class="info-block-head">Дата публикации:</div>
				<div class="info-block-text"><?=FormatDate(array("d" => 'j F Y, H:i'), MakeTimeStamp($arPost["ACTIVE_FROM"], "DD.MM.YYYY HH:MI:SS"))?></div>
			</div>
			<div class="info-info-block">
			<div class="info-block">
				<div class="info-block-head">Описание:</div>
				<div class="info-block-text"><?=$arPost["PREVIEW_TEXT"]?></div>
			</div>
			</div>
			<!--div class="acccept">
				<button>Послушать подкасты</button>
			</div-->

		</div>

		<div class="right-block">
			<div class="main-img"style="height: auto; background:none;">
				<img src="<?=CFile::GetPath($arPost["PREVIEW_PICTURE"])?>" width="780">
			</div>

			
		</div>
	</div>
	</div>
<?}?>