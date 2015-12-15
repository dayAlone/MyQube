<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");?>
<?
CModule::IncludeModule("iblock");
$id=intval(str_replace("friend_comment_","",$_GET["dis"]));
$arFilter = array("IBLOCK_ID" => 12, ">ID" => $id, "CREATED_BY" => $_GET["created_by"], ">DATE_CREATE" => ConvertTimeStamp(time()-5, "FULL"));
$res = CIBlockElement::GetList(array(), $arFilter, false, Array());
while($arItemObj = $res->GetNextElement(true, false)) {
	$arItem = $arItemObj->GetFields();
	$arItem["PROPERTIES"] = $arItemObj->GetProperties();
?>
	<!-- Блок каментов -->
	<div class="comment-wrap <?=($my)?"my-comment":"frend-comment"?>" <?if($friend_in==0&&!$my){?> onclick="javascript:window.location='/communication/<?=$arItem['CREATED_BY']?>/'" <?}?> <?if($friend_in==0&&$my==1){?> onclick="javascript:window.location='/communication/<?=$arItem['PROPERTIES']['USER_IN']['VALUE']?>/'" <?}?>>
		<!-- Блок камента -->
		<div class="comment <?=($arItem['PROPERTY_READ']==0)?"unread":""?>" id="friend_comment_<?=$arItem['ID']?>">
		<!-- Блок аватара -->
			<div class="avatar">
				<div class="user-photo" style="background:url('<?=$file_user_current["src"]?>')">
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
<?}?>