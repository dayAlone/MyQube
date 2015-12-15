<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");?>
<script>
$(document).ready(function(){
$(".lenta_item").mouseover(function(){
      $(this).find(".lenta_item_hover").css({"opacity":"0"});
    }).mouseout(function(){
      $(this).find(".lenta_item_hover").css({"opacity":"0.3"});
});});
</script>
<?
if($_GET["scroll"])
	$_SESSION["MQ_GROUP_LAST_POINT_SCROLL"] = $_GET["scroll"];
if($_GET["count"])
	$_SESSION["MQ_GROUP_LAST_POINT_COUNT_POSTS"] = $_GET["count"];
?>
<?
	CModule::IncludeModule("iblock");
	$group_id = (isset($arGroup["id"]))?$arGroup["id"]:$_GET["GROUP_ID"];
	$iblock_id = 2;
	$arPosts = array();

	// Постраничная пагинация / Сессия прописывается в init.php
	if(($nPageSize = $_GET["page"]) && !$_GET["PAGEN_1"])
		$nPageSizePhoto = $nPageSize*9;
	else
		$nPageSizePhoto = 9;

	$arFilter = array("IBLOCK_ID" => $iblock_id, "ACTIVE_DATE" => "Y", "PROPERTY_SOCIAL_GROUP_ID" => $group_id, "PROPERTY_ANC_TYPE" => 26, "PROPERTY_CREATED_USER_ID"=>false);	
	if($_GET["filter"] == "next" || empty($_GET["filter"]))
		$arFilter[">=PROPERTY_START_DATE"] = trim(CDatabase::CharToDateFunction(ConvertTimeStamp(time(),'FULL')),"\'");	
	if($_GET["filter"] == "prev")
		$arFilter["<PROPERTY_END_DATE"] = trim(CDatabase::CharToDateFunction(ConvertTimeStamp(time(),'FULL')),"\'");
	if($_GET["filter"] == "my")
		$arFilter["PROPERTY_ANC_ID"] = $USER->GetID();
	
	if($_GET["q"])
		$arFilter["%NAME"] = $_GET["q"];
	$res = CIBlockElement::GetList(array("ACTIVE_FROM" => "DESC"), $arFilter, false, Array("nPageSize" => $nPageSizePhoto));
	while($arItemObj = $res->GetNextElement())
	{
		$arItem = $arItemObj->GetFields();
		$arItem["PROPERTIES"] = $arItemObj->GetProperties();
		$arPosts[$arItem["ID"]] = $arItem;
		/*if($USER->GetID() == 2) {
		echo '<pre>'; print_r($arItem["PROPERTIES"]["START_DATE"]["VALUE"].' '.trim(CDatabase::CharToDateFunction(ConvertTimeStamp(time(),'FULL')),"\'")); echo '<pre>';
		}*/
	}
	$page = $res->NavPageNomer;
	$elementNum = 0;
	foreach($arPosts as $arPost)
	{
	//for($i=1;$i<=6;$i++)
	//{
		if($elementNum == 9) {
			++$page;
			$elementNum = 0;
		}
		
		++$elementNum;
		$link = str_replace("#group_id#",$group_id,$arPost["DETAIL_PAGE_URL"]).'/?filter='.$_GET["filter"].'&page='.$page;
		//echo "<xmp>";print_r($arPost); echo "</xmp>";
		$file = CFile::ResizeImageGet($arPost["PREVIEW_PICTURE"], array('width'=>280, 'height'=>240), BX_RESIZE_IMAGE_EXACT, true);
		echo "<a class=\"lenta_item search-item\" id=\"lenta_item_".$arPost["ID"]."\" href=\"".$link."\" style=\"background-image:url('".$file["src"]."');\"><div class=\"cover_text\"><span class=\"search-item-name\">".mb_strtoupper($arPost["NAME"])."</span></div><div class=\"lenta_item_hover\"></div></a>";
		?>
<div class="cover_bottom_info search-item-cover" id="bottom_lenta_item_<?=$arPost["ID"]?>">
    <div class="nomobile">
	<div class="cover_bottom_info_inside">
		<div class="group_info_slogan"><?=$arPost["PROPERTIES"]["NAME_2"]["VALUE"]?></div>
		<div class="group_info_details" style="width:800px;">
			<!--<img src="<?=SITE_TEMPLATE_PATH?>/images/date_icon.png" width="" height="" alt="">
			<span><?=FormatDate(array("d" => 'l, j F'), $arPost["DATE_CREATE_UNIX"]);?></span>
			<img src="<?=SITE_TEMPLATE_PATH?>/images/date_watch.png" width="" height="" alt="">
			<span>В <?=date("H:i", $arPost["DATE_CREATE_UNIX"])?></span>-->
			<img src="<?=SITE_TEMPLATE_PATH?>/images/members_icon.png" width="" height="" alt="">
			<?
			$tmp_comm_count = $arPost["PROPERTIES"]["COMMENTS_COUNT"]["VALUE"];
			?>
			<!--span><?=intval($tmp_comm_count)?> <?=getNumEnding(intval($tmp_comm_count), Array("КОММЕНТАРИЙ", "КОММЕНТАРИЯ", "КОММЕНТАРИЕВ"))?></span-->
			<span><?=count($arPost["PROPERTIES"]["ANC_ID"]["VALUE"])?> <?=getNumEnding(count($arPost["PROPERTIES"]["ANC_ID"]["VALUE"]), Array("УЧАСТНИК", "УЧАСТНИКА", "УЧАСТНИКОВ"))?></span>
			<?if($arPost["PROPERTIES"]["SHARE"]["VALUE"] == "Y"){
				$link_2 = str_replace("#group_id#",$group_id,$arPost["DETAIL_PAGE_URL"]);?>
			<img src="<?=SITE_TEMPLATE_PATH?>/images/arrow.png" width="" height="" alt=""> <span link="<?=urlencode("http://".SITE_SERVER_NAME.$link_2.'/')?>" class= "fb_share_count" style="vertical-align: baseline; color:#fff;"></span><span style="margin-left:-20px;">ПОДЕЛИЛИСЬ</span>
			<?}?>
			<img src="<?=SITE_TEMPLATE_PATH?>/images/like80.png" width="" height="" alt=""> <span style="vertical-align: baseline; color:#fff;"><?=intval($arPost["PROPERTIES"]["LIKES"]["VALUE"])?></span>
		</div>
	</div>
    </div>
    
</div>

     

		<?
		//echo ('<a class="lenta_item" href="'.$link.'">'.$arPost["NAME"].'</a>');
	//}
	}
?>