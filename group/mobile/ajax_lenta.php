<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");?>
<?
	CModule::IncludeModule("iblock");
	$group_id = (isset($arGroup["id"]))?$arGroup["id"]:$_GET["GROUP_ID"];
	$iblock_id = 1;
	$arPosts = array();

	// Постраничная пагинация / Сессия прописывается в init.php
	if(($nPageSize = $_SESSION["BackFromDetail"]["group_6"]["nPageSize"]) && !$_GET["PAGEN_1"])
		$nPageSize = $_SESSION["BackFromDetail"]["group_6"]["nPageSize"]*9;
	else
		$nPageSize = 9;

	$arFilter = array("IBLOCK_ID" => $iblock_id, "ACTIVE" => "Y", "PROPERTY_SOCIAL_GROUP_ID" => $group_id);
	$res = CIBlockElement::GetList(array("ACTIVE_FROM" => "DESC"), $arFilter, false, Array("nPageSize" => $nPageSize));
	while($arItemObj = $res->GetNextElement(true, false))
	{
		$arItem = $arItemObj->GetFields();
		$arItem["PROPERTIES"] = $arItemObj->GetProperties();
		$arPosts[$arItem["ID"]] = $arItem;
	}
	$page = $res->NavPageNomer;
	$elementNum = 0;
	$bottom_block = "";
					
	foreach($arPosts as $arPost)
	{
		//echo "<xmp>";print_r($arPost);echo "</xmp>";
		if($elementNum == 9) {
			++$page;
			$elementNum = 0;
		}
		
		++$elementNum;
		$link = str_replace("#group_id#",$group_id,$arPost["DETAIL_PAGE_URL"]).'/'; //?page='.$page

		$file = CFile::ResizeImageGet($arPost["PREVIEW_PICTURE"], array('width'=>280, 'height'=>240), BX_RESIZE_IMAGE_EXACT, true);
		echo "<a class=\"lenta_item\" id=\"lenta_item_".$arPost["ID"]."\" href=\"".$link."\" style=\"background-image:url('".$file["src"]."');\"><div class=\"cover_text\">";
		if($arPost["NAME"]!=" ")
			echo "<span>".mb_strtoupper($arPost["NAME"])."</span>";
		echo "</div><div class=\"lenta_item_hover\"></div></a>";
		?>
<div class="cover_bottom_info" id="bottom_lenta_item_<?=$arPost["ID"]?>">
	<div class="cover_bottom_info_inside">
		<div class="group_info_slogan"><!--Необычные док-станции <span class="slogan_color">IXOOST</span>--><?=$arPost["PROPERTIES"]["NAME_2"]["VALUE"]?></div>
		<?
			$res_like = 0;//CIBlockElement::GetList(array(), array("IBLOCK_ID" => 6, "PROPERTY_LIKE" => $arPost['ID'], "PROPERTY_USER" => $USER->GetID() ),array());	
			$res_like_star = CIBlockElement::GetList(array(), array("IBLOCK_ID" => 10, "PROPERTY_LIKE" => $arPost['ID'], "PROPERTY_USER" => $USER->GetID() ),array());	
		?>
		<div class="group_info_details">
			<!--img src="<?=SITE_TEMPLATE_PATH?>/images/date_icon.png" width="" height="" alt="">
			<span><?=FormatDate(array("d" => 'l, j F'), $arPost["DATE_CREATE_UNIX"]);?></span>
			<img src="<?=SITE_TEMPLATE_PATH?>/images/date_watch.png" width="" height="" alt="">
			<span>В <?=date("H:i", $arPost["DATE_CREATE_UNIX"])?></span-->
			<img src="<?=SITE_TEMPLATE_PATH?>/images/date_comments.png" width="" height="" alt="">
			<?
			$tmp_comm_count = $arPost["PROPERTIES"]["COMMENTS_COUNT"]["VALUE"];
			?>
			<span><?=intval($tmp_comm_count)?> КОММЕНТАРИЕВ</span>
			<img src="<?=SITE_TEMPLATE_PATH?>/images/arrow.png" width="" height="" alt=""> <span link="<?=urlencode("http://".SITE_SERVER_NAME.$link)?>" class= "fb_share_count" style="vertical-align: baseline; color:#fff;"></span>
			<img src="<?=SITE_TEMPLATE_PATH?>/images/like80.png" width="" height="" alt=""> <span style="vertical-align: baseline; color:#fff;"><?=intval($arPost["PROPERTIES"]["LIKES"]["VALUE"])?></span>
		</div>
	</div>
	<?/*?><div class="cover_bottom_info_actions">
			<div class="cover_bottom_info_a1">
				<span>В избранное</span><br>
				
			</div>
			<?if($arPost["PROPERTIES"]["SHARE"]["VALUE"] == "Y"||true){?>
				<div class="cover_bottom_info_a2">
					<!--span>Поделитесь</span--><br>
					<!--<img src="<?=SITE_TEMPLATE_PATH?>/images/bottom_hover_fb.png" width="" height="" alt=""><span link="<?=urlencode("http://".SITE_SERVER_NAME.$link)?>" class= "fb_share_count" style="vertical-align: baseline;"></span>
					<img src="<?=SITE_TEMPLATE_PATH?>/images/bottom_hover_vk.png" width="" height="" alt=""><span class= "vk_share_count" style="vertical-align: baseline;"></span>
					<img src="<?=SITE_TEMPLATE_PATH?>/images/bottom_hover_g.png" width="" height="" alt=""><span class= "g_share_count" style="vertical-align: baseline;"></span>-->
				</div>
			<?}?>
	</div><?*/?>
</div>
		<?
	}
?>