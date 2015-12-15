<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
/** @var array $arParams */
/** @var array $arResult */
/** @global CMain $APPLICATION */
/** @global CUser $USER */
/** @global CDatabase $DB */
/** @var CBitrixComponentTemplate $this */
/** @var string $templateName */
/** @var string $templateFile */
/** @var string $templateFolder */
/** @var string $componentPath */
/** @var CBitrixComponent $component */
?>
	<script>
		function AjaxFormRequest_mess(){
					if($('#TEXT').val()!="")
					{
						$.ajax({url: '<?=SITE_TEMPLATE_PATH?>/components/bitrix/news.list/correspondence/ajax.php',
						type:     "POST",
						dataType: "html",
						data: jQuery("#new_comment_form").serialize(),
						success: function(data){
									if(data){
										$('#comment_block_nw').append(data);
										$("#new_comment_form textarea").val('');
									}
								}
							});
					}
				}
		$(function(){
			$('#comment_block_nw .frend-comment .comment.unread').hover(function() { 
						if($(this).hasClass("unread"))
						{
							$(this).removeClass("unread");
							$.get('<?=SITE_TEMPLATE_PATH?>/components/bitrix/news.list/correspondence/ajax_read.php',{id: $(this).attr('id')},
								function(data){
									$.ajax({
										url: host_url+"/communication/ajax/count.php",
										method: 'GET',
									}).done(function(data){
										var n_new_m=parseInt(data);
										if(n_new_m>0){
											$("#new_messages_count").html(n_new_m);
											$("#new_messages_count").show();
										}
										else {
											$("#new_messages_count").hide();
										}
									});	
								}
							);
						}
			});
		});		
	</script>
<?
	$this->setFrameMode(true);
	$friend_in = intval($_GET['friend_in']);
	$CurentUser = CUser::GetByID($USER->GetID())->Fetch();
	$username = ($CurentUser['NAME']!="")?($CurentUser['NAME'].' '.$CurentUser['LAST_NAME']):$CurentUser['LOGIN'];
	
	if($CurentUser['PERSONAL_PHOTO']!="")
			$file_user_current = CFile::ResizeImageGet($CurentUser['PERSONAL_PHOTO'], array('width'=>50, 'height'=>50), BX_RESIZE_IMAGE_EXACT, true);
		else $file_user_current["src"]="/images/user_photo.png";
	
	//if(empty($CurentUser["UF_FRIENDS"]))$CurentUser["UF_FRIENDS"]=Array(1,2,3,4,5);
	$implode_users = implode('|', $CurentUser["UF_FRIENDS"]);
	$rsUsers = CUser::GetList($order, $tmp, Array("ID"=>$implode_users));
	$users_ar=Array();
	while($user = $rsUsers->Fetch()) {
			$users_ar[$user['ID']]=$user;
	}
	$rsMessages = CIBlockElement::GetList(Array("TIMESTAMP_X"=>"DESC"),
										  Array("IBLOCK_ID"=>15,
											  Array(
											  "LOGIC" => "OR",
											  Array("CREATED_BY"=>$USER->GetID()),
											  Array("PROPERTY_USER_IN"=>$USER->GetID()))
											  ),
											false,false,
										  Array("PREVIEW_TEXT","PROPERTY_READ","PROPERTY_IN_OUT")
										  );
	$rsUsers = CUser::GetList($order, $tmp, Array("ID"=>$implode_users));
if($friend_in>0) {
	$FriendUser = CUser::GetByID($friend_in)->Fetch();
	$friend_username = ($FriendUser['NAME']!="")?($FriendUser['NAME'].' '.$FriendUser['LAST_NAME']):$FriendUser['LOGIN'];
	if($FriendUser['PERSONAL_PHOTO']!="")
			$file_user_friend = CFile::ResizeImageGet($FriendUser['PERSONAL_PHOTO'], array('width'=>50, 'height'=>50), BX_RESIZE_IMAGE_EXACT, true);
		else $file_user_friend["src"]="/images/user_photo.png";
}
?>
<div class="left-block messages">

	<hr class="left-block-messages-hr">		
	<?while($rsMess = $rsMessages->Fetch()) {
		$id_s = str_replace($USER->GetID()."_","",$rsMess["PROPERTY_IN_OUT_VALUE"]);
		$id_s = str_replace("_".$USER->GetID(),"",$id_s);
		$id_s = intval($id_s);

		if(isset($users_ar[$id_s]))
			$arUser = $users_ar[$id_s];
		else
		{
			$arUser = CUser::GetByID($id_s)->Fetch();
		}
		$username_tmp = ($arUser['NAME']!="")?($arUser['NAME'].' '.$arUser['LAST_NAME']):$arUser['LOGIN'];
		if($arUser['PERSONAL_PHOTO']!="")
			$file = CFile::ResizeImageGet($arUser['PERSONAL_PHOTO'], array('width'=>50, 'height'=>50), BX_RESIZE_IMAGE_EXACT, true);
		else $file["src"]="/images/user_photo.png";
		?>
		<div class="comment-wrap">
			<!-- Блок камента -->
			<a class="comment comment_left" href="/communication/<?=$arUser["ID"]?>/" id="comment_<?=$arUser["ID"]?>">
			<!-- Блок аватара -->
				<div class="avatar">
					<div class="user-photo" style="background:url('<?=$file["src"]?>');">
					<!-- Внешняя окружность статуса -->
						<div class="opcircl">
						<!-- Кружок статуса. Цвет прописывается классом -->
							<div class="colorcrcl  red-satus"></div>
						</div>
					</div>
					<div class="status"></div>
				</div>
				<!-- Блок текста(Имя + текст камента) -->
				<div class="right-text">
				<!-- Имя автора камента -->
					<div class="user-name"><span class="user-name-text <?=($friend_in==$arUser["ID"])?"active":""?>"><?=$username_tmp?></span></div>
				<!-- Текст камента -->
					<div class="comment-text <?=($friend_in==$arUser["ID"])?"active":""?>"><?=mb_substr($rsMess['PREVIEW_TEXT'],0,20)?>...</div>
				</div>
			</a>	
		</div>
		<?
			unset($users_ar[$id_s]);
		}
		foreach ($users_ar as $arUser)
		{
			$username_tmp = ($arUser['NAME']!="")?($arUser['NAME'].' '.$arUser['LAST_NAME']):$arUser['LOGIN'];
			if($arUser['PERSONAL_PHOTO']!="")
				$file = CFile::ResizeImageGet($arUser['PERSONAL_PHOTO'], array('width'=>50, 'height'=>50), BX_RESIZE_IMAGE_EXACT, true);
			else $file["src"]="/images/user_photo.png";
			?>
			<div class="comment-wrap">
				<!-- Блок камента -->
				<a class="comment comment_left" href="/communication/<?=$arUser["ID"]?>/" id="comment_<?=$arUser["ID"]?>">
				<!-- Блок аватара -->
					<div class="avatar">
						<div class="user-photo" style="background:url('<?=$file["src"]?>');">
						<!-- Внешняя окружность статуса -->
							<div class="opcircl">
							<!-- Кружок статуса. Цвет прописывается классом -->
								<div class="colorcrcl  red-satus"></div>
							</div>
						</div>
						<div class="status"></div>
					</div>
					<!-- Блок текста(Имя + текст камента) -->
					<div class="right-text">
					<!-- Имя автора камента -->
						<div class="user-name"><span class="user-name-text <?=($friend_in==$arUser["ID"])?"active":""?>"><?=$username_tmp?></span></div>
					<!-- Текст камента -->
						<div class="comment-text <?=($friend_in==$arUser["ID"])?"active":""?>"></div>
					</div>
				</a>	
			</div>
		<?
		}
		?>

	</div>
	<!-- Правый блок с текстом и каментами -->
	<div class="right-block  messages-right">
	<!-- Заголовок каментов-->
		<div class="comments">

<?if($arParams["DISPLAY_TOP_PAGER"]):?>
	<?=$arResult["NAV_STRING"]?><br />
<?endif;?>
<div id="comment_block_nw">
<?foreach($arResult["ITEMS"] as $arItem):
	$my=($arItem['CREATED_BY']==$USER->GetID())?1:0;
?>
	<!-- Блок каментов -->
	<div class="comment-wrap <?=($my)?"my-comment":"frend-comment"?>">
		<!-- Блок камента -->
		<div class="comment <?=($arItem['PROPERTY_READ']==0)?"unread":""?>" id="friend_comment_<?=$arItem['ID']?>">
		<!-- Блок аватара -->
			<div class="avatar">
				<div class="user-photo" style="background:url('<?=($my)?$file_user_current["src"]:$file_user_friend["src"]?>')">
				<!-- Внешняя окружность статуса -->
					<div class="opcircl">
					<!-- Кружок статуса. Цвет прописывается классом -->
						<div class="colorcrcl  red-satus"></div>
					</div>
				</div>
				<div class="status"></div>
			</div>
			<!-- Блок текста(Имя + текст камента) -->
			<div class="right-text">
			<!-- Имя автора камента -->
				<div class="user-name"><span class="user-name-text"><?=($my)?$username:$friend_username?></span></div>
			<!-- Текст камента -->
				<div class="comment-text"><?=$arItem["PREVIEW_TEXT"]?></div>
			</div>
		</div>
		<div class="comment-date"><?=date("d.m.y - H:i",strtotime($arItem["DATE_CREATE"]));?></div>
	</div>	
<?endforeach;?>
<?if($arParams["DISPLAY_BOTTOM_PAGER"]):?>
	<br /><?=$arResult["NAV_STRING"]?>
<?endif;?>
</div>
		<?if($friend_in>0) {?>
			<div class="head-form-comment">
				<form method="post"enctype="multipart/form-data" onsubmit="return false;"  action="#" id="new_comment_form">
					<fieldset style="border: none;"> 
						<textarea name="TEXT" id="TEXT" placeholder="Написать"></textarea> 
						<input type="hidden" name="to_id" value="<?=$friend_in?>" />
						<div class="comment_submit_button">
							<input class="formcom comments-button" type="image" src="<?=SITE_TEMPLATE_PATH?>/images/enter.png" value="Отправить" onclick="AjaxFormRequest_mess();" />
						</div>
					</fieldset> 
				</form>
			</div>
		<?}?>
			</div>
		</div>
