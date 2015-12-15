<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");?>
<style>
	.slimScrollDiv {
		float:left;
		padding-bottom:90px;
	}
	.shadow-new-friens-popup .comment {
		margin-left:15px;
		margin-top: 20px;
		display: table;
		width: 100%;
	}
	.shadow-new-friens-popup .right-icons {
		margin-right:35px;
	}
	.shadow-new-friens-popup .popup-comments {
		/*height:55px;*/
	}
</style>
<script type="text/javascript" src="<?=SITE_TEMPLATE_PATH?>/jquery.slimscroll.min.js"></script>
<script type="text/javascript">
$(function(){
		$('#popup-friends-clean').click(function() { 
			$("#friends-subs-page").hide();
			$("#friends-requests-page").hide();
			$("#friends-search-page").show();
			if($('#TEXT').val()!="")
			{
				$.ajax({url: '/user/profile/ajax/find_friends.php',
				type:     "POST",
				dataType: "html",
				data: $("form#search_friend_form").serialize(),
				success: function(data){
							if(data){
								$('#friends-search-page').html(data);
							}
						}
					});
			}
		});
		$('#scroll_search').slimScroll({
			color: '#00d6ff',
			size: '10px',
			width: '309px',
			height: '338',
			distance: '10px',
			alwaysVisible: true
		});
	});
	
	
	$("#friends-requests").click(function(){
		var path = host_url+"/user/profile/ajax/friends.php";
		$.get(path, {}, function(data){
			$("#shadow-new-friens-popup").html(data);
			$("#friends-requests-page").show();
			$("#friends-subs-page").hide();		
			$("#friends-search-page").hide();
			$(".black-menu-select a").removeClass("selected");
			$("#friends-requests").addClass("selected");
		});
	});
	
	$("#friends-subs").click(function(){
		var path = host_url+"/user/profile/ajax/friends.php";
		$.get(path, {}, function(data){
			$("#shadow-new-friens-popup").html(data);			
			$("#friends-subs-page").show();
			$("#friends-requests-page").hide();
			$("#friends-search-page").hide();
			$(".black-menu-select a").removeClass("selected");
			$("#friends-subs").addClass("selected");
		});
	});
	
	$(".del_sub").click(function(){
		var userID = $(this).data("id");
		var path = host_url+"/user/profile/ajax/friends_res.php";
		var parent = $(this).parent();
		$.get(path, {userID:userID, del_sub:1}, function(data){
			$(parent).parent().remove();
		});
	});
</script>
<div class="profile-edit-popup" style="width:519px;">
	<div class="new-post-popup-menu">
		<div class="profile-edit-popup-menu">
			<div class="black-menu">
				<div class="black-menu-wrap">
					<div class="black-menu-select"><a id="friends-requests" class="selected">Заявки в друзья</a></div>
					<div class="black-menu-select"><a id="friends-subs">Ваши подписки</a></div>
				</div>
			</div>
		</div>
	<div class="frends-filter" style="display:table;">
		<div class="friends-left-block" id="scroll_search">
		<?
		$CurentUser = CUser::GetByID($USER->GetID())->Fetch();
		$arraySubs = array_merge($CurentUser["UF_FRIENDS_SUB_IN"], $CurentUser["UF_FRIENDS_SUB"]);
		asort($arraySubs);
		?>
		<div class="popup-comments" id="friends-requests-page">
			<?foreach($arraySubs as $key => $value) {
				if(in_array($value, $CurentUser["UF_FRIENDS"])) break;
				$user = CUser::GetByID($value)->Fetch();
				if(!$user){continue;}
				if($user['PERSONAL_PHOTO']!="")
					$file = CFile::ResizeImageGet($user['PERSONAL_PHOTO'], array('width'=>50, 'height'=>50), BX_RESIZE_IMAGE_EXACT, true);
				else $file["src"]="/images/user_photo.png";
				$username = ($user["NAME"]!="")?($user["NAME"].' '.$user["LAST_NAME"]):$user["LOGIN"];		?>
				<div class="comment" id="user-<?=$user["ID"]?>">
					<div class="avatar">
						<a href="/user/<?=$value?>/profile/">
							<div class="user-photo" style="background-image: url('<?=$file["src"];?>');">
								<div class="opcircl">
									<div class="colorcrcl"></div>
								</div>
							</div>
						</a>
						<div class="status"></div>
					</div>
					<a href="/user/<?=$value?>/profile/">
						<div class="right-text">
							<div class="user-name"><?=$username?></div>
						</div>
					</a>
					<div class="right-icons popup_subs">
						<?if(!in_array($user["ID"], $CurentUser["UF_FRIENDS_SUB"])) {?>
							<div class="add-right-icons add-or-del-friend" data-id="<?=$user["ID"]?>">
								<div class="add-right-icons-icon"></div>
								<div class="add-right-icons-text"></div>
							</div>
						<?}?>
						<div class="add-right-icons-delet add-or-del-friend" data-id="<?=$user["ID"]?>" data-subin="delete"><div class="add-right-icons-delet-text"></div></div>
					</div>
				</div>
			<?}?>
		</div>
		<div class="popup-comments" id="friends-subs-page" style="display:none;">
			<?
			foreach($CurentUser["UF_USER_SUB"] as $key => $value) {
				$user = CUser::GetByID($value)->Fetch();
				if(!$user)continue;
				if($user['PERSONAL_PHOTO']!="")
					$file = CFile::ResizeImageGet($user['PERSONAL_PHOTO'], array('width'=>50, 'height'=>50), BX_RESIZE_IMAGE_EXACT, true);
				else $file["src"]="/images/user_photo.png";
				$username = ($user["NAME"]!="")?($user["NAME"].' '.$user["LAST_NAME"]):$user["LOGIN"];		?>
				<div class="comment" id="user-<?=$user["ID"]?>">
					<div class="avatar">
						<div class="user-photo" style="background-image: url('<?=$file["src"];?>');">
							<div class="opcircl">
								<div class="colorcrcl"></div>
							</div>
						</div>
						<div class="status"></div>
					</div>
					<div class="right-text">
						<div class="user-name"><?=$username?></div>
					</div>
					<div class="right-icons popup_subs">
						<div class="add-right-icons-delet del_sub" data-id="<?=$user["ID"]?>">
							<div class="add-right-icons-delet-text"></div>
						</div>
					</div>
				</div>
			<?}?>
		</div>
		<div class="popup-comments" id="friends-search-page" style="display:none;">
			
		</div>
		<div class="new-post-popup-button">
			<button class="popup-friends-cancel" id="popup-friends-cancel">Закрыть</button>
		</div>

	</div>
		<div class="friends-right-block" style="margin-top: -15px;">
			<div class="friends-right-block-head">Фильтр поиска</div>
			<form id="search_friend_form" method="post"enctype="multipart/form-data" onsubmit="return false;">
			<fieldset style="border: none;"> 
			<div style="height: 65px;">
				<input id="popup-frend-search" name="s_name" type="text" placeholder="ИМЯ ДРУГА">
				<label for="popup-frend-search"><span></span></label>
			</div>

			<!-- Разделитель -->
			<div><hr></div>

			<!-- Radiobutton с выбором пола -->
			<div>
				<div class="profile-edit-popup-right-input">
					<input type="radio" name="sex-frend" id='male-frend' value="male-frend">
					<label for="male-frend"><span></span>Мужчина</label>
					<br><br>
					<input type="radio" name="sex-frend" id='female-frend' value="female-frend">
					<label for="female-frend"><span></span>Женщина</label>
				</div>
			</div>

			<div><hr></div>

			<!-- Сложный символ -->
			<div class="frend-age">
				<div>
					Возраст
				</div>
				<div>
					<span class="frend-age-black">C</span> <input name="s_age_from" type="text">
				</div>
				<div><span class="frend-age-black">До</span> <input name="s_age_to" type="text"></div>

			</div>

			<div><hr></div>


			<div>
			<!-- Город -->
			<div>
				<input name="s_friend_city" id="popup-frend-sity" type="text" placeholder="ГОРОД">
				<label for="popup-frend-sity"><span></span></label>
			</div>
			</div>
				<button class="popup-cancel" id="popup-friends-clean">Поиск</button>
			</fieldset>
			</form>
		</div>

	</div>
	</div>
</div>