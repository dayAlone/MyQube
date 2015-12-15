<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php"); $APPLICATION->SetTitle("Новости");?>
<?
      CJSCore::Init(array("jquery"));
 ?><script>
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
		if($(this).hasClass("add"))
			alert("Ваша заявка отправлена");
	});
	
	$(".id_add_photo").click(function(){
		$("#add_post_page").show();	
		$("#new_post_page").hide();
		$("#new_photo_page").show();
		$("#new_album_page").hide();
	});
	
	$('.search-form input[name="q"]').keyup(function() { 
		$(".grid-item").each(function(){
			if($('.search-form input[name="q"]').val()=='' || $(this).find(".name-news").html().toLowerCase().indexOf($('.search-form input[name="q"]').val().toLowerCase())>=0)
				$(this).css({"display":"inline-block","position":"initial"});
			else
				$(this).css({"display":"none","position":"initial"});
		});
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
	}else{
	var i = str.lastIndexOf('/')+1;
	}						
	var filename = "("+str.slice(i)+")";			
	var uploaded = document.getElementById("fileformlabel");
	$(obj).parent().find(".selectbutton").html(filename+" <span></span>");
}
</script>
<link rel="stylesheet" href="/css/cabinet.css">
<style>
	.lenta_item {
		width:180px;
		height:190px;
		display:block;
		margin:20px 0 0 20px;
	}
	.lenta_item_hover {
		position:absolute;
		width:180px;
		height:190px;
		opacity:0.6;
		background:#000;
		top:0;
		z-index:-1;
	}
	.event-header span {
		position:relative;
		z-index:1;
		font-size: 15px;
	}
</style>
<?
if(!empty($_GET["user"])) {
	$userID = $_GET["user"];
	$myProfile = CUser::GetByID($USER->GetID())->Fetch();
	$friends = false;
	if(in_array($userID, $myProfile["UF_FRIENDS"]))
		$friends = true;
} else
	$userID = $USER->GetID();
$CurentUser = CUser::GetByID($userID)->Fetch();
?>
	<div style="width: 100%; float: left;">
	<div class="shadow-profile-edit-popup" id="shadow-friends-edit-popup" style="display:none; z-index: 9;">
		<div id="shadow-new-friens-popup" class="shadow-new-friens-popup"></div>
	</div>
	<!-- Верхний блок -->
		<div class="profile-head">
        <div class="mobile-block mobile-menu-ico" id="menu-button"></div>
        <style>
        .mobile-menu-ico {
            background: url(/images/menuicon.png );
            width: 40px;
            height: 40px;
            margin-left: 20px;
           
        }
        
        .profile-head{
            padding-top: 10px;
        }
        </style>
        <script>
        
        $(function(){
                     $("#menu-button").click(function(){
                        if($("#nav_left_open").css('left') == '-170px'){
                           $("#nav_left_open").animate({ left: '0' }, 400);
                            $("div.main").animate({ left: '165' }, 400);                   
                        };
                        if($("#nav_left_open").css('left') == '0px'){
                            $("#nav_left_open").animate({ left: '-170' }, 400);
                            $("div.main").animate({ left: '0' }, 400);
                        };
                    })
        })
        </script>
        
		<div class="left-profile-head">
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
					if(!$friends)
						echo '<button class="add-or-del-friend" data-id="'.$CurentUser["ID"].'">Добавить в друзья</button>';
					else						
						echo '<button class="add-or-del-friend" data-id="'.$CurentUser["ID"].'">Удалить из друзей</button>
							<button onclick="window.location.href=\'/communication/'.$CurentUser['ID'].'/\'">Отправить сообщение</button>';
				} else
					echo '<button id="add_post">Опубликовать</button><button id="add_photo">Загрузить фото</button>';
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
							width: 500px; font-size: 13px; padding-left: 10px; padding-top: 15px; height: 120px; border-radius: 8px; border: 3px solid #fff; background: #ebebeb; color: #969696; font-weight: bold; font-family: GothaProReg, sans-serif; resize: none; display: block; margin: 0 auto;
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
						<div id="new_post_page">
							<textarea name="post_text" placeholder="Напишите что-нибудь"></textarea>
						</div>
						<div id="new_photo_page" style="display:none;">
							<input name="video" type="text" placeholder="Место для ссылки с youtube"><br><br>
							<div class="fileform" style="margin-left: 20px;">
								<a class="selectbutton">Загрузить фото <span></span></a>
								<input id="upload" type="file" name="photo" size="20" onchange="getName(this.value);" />
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
				if(count($arPhoto) >= 5)
					break;			
			}
			$arPhoto = call_user_func_array('array_merge', $arPhoto);
			if(count($arPhoto) < 5)
				$background_photo = '<img src="/images/unknown_profile_images.png" style="position:absolute; height:100%; width:100%;">';
			echo $background_photo;
			for($i = 0; $i <= 4; $i++)
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
				<div class="all-img-prof" style="float:right;">
					<?
					if($background_photo) echo '<a href="#" class="id_add_photo" style="width:auto;">Загрузить фото</a>';
					else echo '<a href="/user/photo/" style="width:auto;">Все фото</a>';
					?>
				</div>
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
					),
					"search" => "y",
					"search_pos" => "l"
					)
				);?>
			</div>
		<div class="posts-block">
			<link type="text/css" rel="stylesheet" href="/css/events_detail.css">
			<script>
				$("a.likes" ).click(function() {
					$( this ).toggleClass( "active" );
					var path = host_url+"/group/photo/like_post.php";
					$.get(path, {post_id: $(this).attr('id'),like: Number($( this ).hasClass( "active" ))}, function(data){
					});
				});
			</script>
				
	<!-- Редактирование профиля. общий попап блок -->
	<div class="shadow-profile-edit-popup" id="shadow-profile-edit-popup">
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
			
			newPostPage.style.display = "none";
			newPhotoPage.style.display = "block";
			newAlbumPage.style.display = "none";
		})
		newPost.addEventListener('click', function(){
			newPostPage.style.display = "block";
			newPhotoPage.style.display = "none";
			newAlbumPage.style.display = "none";
		})
		newPhoto.addEventListener('click', function(){
			newPostPage.style.display = "none";
			newPhotoPage.style.display = "block";
			newAlbumPage.style.display = "none";
		})
		newAlbum.addEventListener('click', function(){
			newPostPage.style.display = "none";
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
	<link rel="stylesheet" href="/css/news.css">
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.isotope/2.2.1/isotope.pkgd.min.js"></script>
	<script>
		$(document).ready( function() {
			$('.posts-block').isotope({
				itemSelector: '.grid-item',
				layoutMode: 'masonry',
				masonry: {
					columnWidth: 100
				}
			});
		});
	</script>	
	<?
	CModule::IncludeModule("iblock");
	$arSelect = Array("ID", "IBLOCK_ID", "*");
	$property_enums = CIBlockPropertyEnum::GetList(Array("SORT"=>"ASC"), Array("IBLOCK_ID"=>array(1, 2, 3, 7, 8), "XML_ID"=>"FOR_GROUPS") );
	while($enum_fields = $property_enums->GetNext())
		$enums_id[] = $enum_fields["ID"];
	$arFilter = Array("IBLOCK_ID"=>array(1, 2, 3, 7, 8), "ACTIVE_DATE"=>"Y", "ACTIVE"=>"Y");
	if($CurentUser["UF_USER_SUB"])
		$CREATED_BY = $CurentUser["UF_USER_SUB"];
	else			
		$CREATED_BY = 0;
	if($CurentUser["UF_GROUPS"])
		$PROPERTY_ANC_ID = $CurentUser["UF_GROUPS"];
	else			
		$PROPERTY_ANC_ID = 0;
	if($_GET["filter"] == "groups") {
		$arFilter["PROPERTY_ANC_TYPE"] = $enums_id;
		$arFilter["PROPERTY_ANC_ID"] = $PROPERTY_ANC_ID;
	} elseif($_GET["filter"] == "friends") {
		$arFilter["CREATED_BY"] = $CREATED_BY;
	} else {
		$arFilter[] = array("LOGIC"=>"OR", array("PROPERTY_ANC_ID"=>$PROPERTY_ANC_ID, "PROPERTY_ANC_TYPE"=>$enums_id),array("CREATED_BY" => $CREATED_BY));
	}
	if($_GET["q"])
		$arFilter = array(array(
				"LOGIC"=>"OR", 
				array("%NAME" => $_GET["q"]), 
				array("%PREVIEW_TEXT" => $_GET["q"])
			));
	$res = CIBlockElement::GetList(Array("DATE_CREATE" => "DESC"), $arFilter, false, false, $arSelect);
	$used = Array();
	while($ob = $res->GetNextElement()) {
		$arFields = $ob->GetFields();
		$arProps = $ob->GetProperties();
		if(in_array($arFields["ID"],$used))
			continue;
		else 
			array_push($used, $arFields["ID"]);
		if($arFields["IBLOCK_ID"] == 8) {
			if(!$arFields["PREVIEW_PICTURE"]) {
				$parsed_url = parse_url($arProps["VIDEO"]["VALUE"]);
				parse_str($parsed_url['query'], $parsed_query);
				$pic = "http://img.youtube.com/vi/".$parsed_query['v']."/0.jpg";
			} else
				$pic = CFile::GetPath($arFields["PREVIEW_PICTURE"]);
			$link = str_replace("#user_id#", $arFields["CREATED_BY"], $arFields["LIST_PAGE_URL"]).$arFields["ID"].'/';
			?>
			<div class="video-block grid-item" style="background-image: url('<?=CFile::GetPath($arFields["PREVIEW_PICTURE"])?>');">
				<a href="<?=$link?>">
					<div class="video-img" style="background-image: url('<?=$pic?>');">
						<div class="play-img"></div>
					</div>
				</a>
				<a href="<?=$link?>">
					<div class="video-name name-news"><?=$arFields["NAME"]?></div>
				</a>
				<!--div class="video-socbutton">
					<!-- класс video-like-gray - серый video-like-red - красный лайк ->
					<div class="video-like video-like-gray" id="video1-like"></div>
					<div class="video-comment"></div>
					<div class="video-repost"></div>
				</div-->
			</div>
			<?
		} elseif($arFields["IBLOCK_ID"] == 7) {
			$CreatedBy = CUser::GetByID($arFields["CREATED_BY"])->Fetch();
			if($CreatedBy['PERSONAL_PHOTO'] != "")
				$file = CFile::ResizeImageGet($CreatedBy['PERSONAL_PHOTO'], array('width'=>50, 'height'=>50), BX_RESIZE_IMAGE_EXACT, true);
			else $file["src"]="/images/user_photo.png";
			$link = str_replace("#user_id#", $arFields["CREATED_BY"], $arFields["LIST_PAGE_URL"]).$arFields["ID"].'/';
			?>
			<div class="event-post grid-item" style="background-image: url('<?=CFile::GetPath($arFields["PREVIEW_PICTURE"])?>');">
				<div class="shadow-wrap">
					<div class="upper-card-block">
						<div class="upper-card-block-avatar">
							<div class="upper-card-block-avatar-img" style="background-image: url('<?=$file["src"]?>');"></div>
							<div class="upper-card-block-name"><?=$CreatedBy['NAME']?></div>
						</div>
						<a href="<?=$link?>">
							<div class="event-header name-news"><?=$arFields["NAME"]?></div>
						</a>
					</div>
					<div class="bottom-small-menu">
						<!--div class="video-like video-like-gray" id="video1-like"></div>
						<div class="comments"></div>
						<div class="socwrap">
							<div class="social-buttons"></div>
							<div class="socblock">
								<div class="facebook-icon"></div>
								<div class="blogger-icon"></div>
								<div class="google-icon"></div>
							</div>
							</div-->
						<div class="bottom-small-menu-date">
							<?=FormatDate(
								array(
									"i" => "idiff",
									"H" => "Hdiff",
									"tommorow" => "tommorow",
									"today" => "today",
									"yesterday" => "yesterday",
									"d" => 'j F',
									 "" => 'j F Y',
								), 
								MakeTimeStamp($arFields["DATE_CREATE"])
							)?>
						</div>
					</div>
				</div>	
			</div>
			<?
		} elseif($arFields["IBLOCK_ID"] == 3) {
			if(FormatDate(array("d" => 'F'), MakeTimeStamp($arProps["START_DATE"]["VALUE"], "DD.MM.YYYY HH:MI:SS")) == FormatDate(array("d" => 'F'), MakeTimeStamp($arProps["END_DATE"]["VALUE"], "DD.MM.YYYY HH:MI:SS"))) {
				$time = FormatDate(array("d" => 'j - '), MakeTimeStamp($arProps["START_DATE"]["VALUE"], "DD.MM.YYYY HH:MI:SS"));
			} else {
				$time = FormatDate(array("d" => 'j F - '), MakeTimeStamp($arProps["START_DATE"]["VALUE"], "DD.MM.YYYY HH:MI:SS"));
			}
			$time.= ' - '.FormatDate(array("d" => 'j F'), MakeTimeStamp($arProps["END_DATE"]["VALUE"], "DD.MM.YYYY HH:MI:SS"));
			$link = str_replace("#user_id#", $arFields["CREATED_BY"], $arFields["LIST_PAGE_URL"]).$arFields["ID"].'/';
			?>
			<div class="event grid-item" onclick="javascript:window.location='<?=$link?>';" style="background-image: url('<?=CFile::GetPath($arFields["PREVIEW_PICTURE"])?>');">
				<div class="shadow-wrap">
					<div class="upper-card-block">
						<div class="event-header name-news"><?=$arFields["NAME"]?></div>
						<div class="event-date"><?=$time?></div>
						<div class="accept"><button>Принять участие</button></div>
					</div>
					<div class="bottom-small-menu">
						<div class="users-wrap">
							<div class="users-icon"></div>
							<div class="users-number"><?if($arProps["ANC_ID"]["VALUE"]) echo count($arProps["ANC_ID"]["VALUE"]); else echo 0;?> участника</div>
						</div>
						<!--div class="comments"></div>
						<div class="socwrap">
							<div class="social-buttons"></div>
							<div class="socblock">
								<div class="facebook-icon"></div>
								<div class="blogger-icon"></div>
								<div class="google-icon"></div>
							</div>
						</div-->
					</div>
				</div>	
			</div>
			<?
		} elseif($arFields["IBLOCK_ID"] == 2) {
			$link = str_replace("#user_id#", $arFields["CREATED_BY"], $arFields["LIST_PAGE_URL"]).$arFields["ID"].'/';
			?>
			<a class="lenta_item grid-item" href="<?=$link?>" style="background-image:url('<?=CFile::GetPath($arFields["PREVIEW_PICTURE"])?>');">
				<div class="cover_text">
					<div class="event-header">
						<span class="name-news"><?=$arFields["NAME"]?></span>
					</div>
				</div>
				<div class="lenta_item_hover" style="opacity: 0.5;"></div>
			</a>
			<?
		} elseif($arFields["IBLOCK_ID"] == 1) {
			$CreatedBy = CUser::GetByID($arFields["CREATED_BY"])->Fetch();
			if($CreatedBy['PERSONAL_PHOTO'] != "")
				$file = CFile::ResizeImageGet($CreatedBy['PERSONAL_PHOTO'], array('width'=>50, 'height'=>50), BX_RESIZE_IMAGE_EXACT, true);
			else $file["src"]="/images/user_photo.png";
			$link = str_replace("#user_id#", $arFields["CREATED_BY"], $arFields["LIST_PAGE_URL"]);			
			$name = $arFields["PREVIEW_TEXT"];
			if($_GET["filter"] == "groups")
				$link = str_replace("#group_id#", 1, $arFields["DETAIL_PAGE_URL"]).'/';
			if($_GET["filter"] == "groups")
				$name = $arFields["NAME"];
			?>
			<div class="event-post grid-item" style="background-image: url('<?=CFile::GetPath($arFields["PREVIEW_PICTURE"])?>');">
				<div class="shadow-wrap">
					<div class="upper-card-block">
							<div class="upper-card-block-avatar">
							<div class="upper-card-block-avatar-img" style="background-image: url('<?=$file["src"]?>');"></div>
							<div class="upper-card-block-name"><?=$CreatedBy['NAME']?></div>
						</div>				
					</div>
					<div class="event-post-down">
						<a href="<?=$link?>">
							<div class="event-post-down-text name-news"><?=$name?></div>
						</a>
						<div class="bottom-small-menu">
							<!--div class="video-like video-like-gray" id="video1-like"></div>
							<div class="comments"></div>
							<div class="socwrap">
								<div class="social-buttons"></div>
								<div class="socblock">
									<div class="facebook-icon"></div>
									<div class="blogger-icon"></div>
									<div class="google-icon"></div>
								</div>
							</div-->
							<div class="bottom-small-menu-date">
								<?=FormatDate(
									array(
										"i" => "idiff",
										"H" => "Hdiff",
										"tommorow" => "tommorow",
										"today" => "today",
										"yesterday" => "yesterday",
										"d" => 'j F',
										 "" => 'j F Y',
									), 
									MakeTimeStamp($arFields["DATE_CREATE"])
								)?>
							</div>
						</div>
					</div>
				</div>	
			</div>
			<?
		}
	}?>
</div>
<?$APPLICATION->IncludeComponent(
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
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>