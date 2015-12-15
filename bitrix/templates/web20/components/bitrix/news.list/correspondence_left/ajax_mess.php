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
	$this->setFrameMode(true);
	$friend_in = intval(str_replace("comment_","",$_GET['friend_in']));
	$CurentUser = CUser::GetByID($USER->GetID())->Fetch();
	$username = ($CurentUser['NAME']!="")?($CurentUser['NAME'].' '.$CurentUser['LAST_NAME']):$CurentUser['LOGIN'];
	
	if($CurentUser['PERSONAL_PHOTO']!="")
			$file_user_current = CFile::ResizeImageGet($CurentUser['PERSONAL_PHOTO'], array('width'=>50, 'height'=>50), BX_RESIZE_IMAGE_EXACT, true);
		else $file_user_current["src"]="/images/user_photo.png";
	
if($friend_in>0) {
	$FriendUser = CUser::GetByID($friend_in)->Fetch();
	$friend_username = ($FriendUser['NAME']!="")?($FriendUser['NAME'].' '.$FriendUser['LAST_NAME']):$FriendUser['LOGIN'];
	if($FriendUser['PERSONAL_PHOTO']!="")
			$file_user_friend = CFile::ResizeImageGet($FriendUser['PERSONAL_PHOTO'], array('width'=>50, 'height'=>50), BX_RESIZE_IMAGE_EXACT, true);
		else $file_user_friend["src"]="/images/user_photo.png";
}

	$res = CIBlockElement::GetList(array(), $arFilter, false, Array());
	while($arItemObj = $res->GetNextElement(true, false))
	{
		$arItem = $arItemObj->GetFields();
		$arItem["PROPERTIES"] = $arItemObj->GetProperties();
		$arPosts[$arItem["ID"]] = $arItem;
	}

foreach($arResult["ITEMS"] as $arItem):
	$my=($arItem['CREATED_BY']==$USER->GetID())?1:0;
?>
	<!-- Блок каментов -->
	<div class="comment-wrap <?=($my)?"my-comment":"frend-comment"?>">
		<!-- Блок камента -->
		<div class="comment" id="comment_<?=$arItem['CREATED_BY']?>">
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

