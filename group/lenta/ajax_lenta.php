<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");?>
<?
if($_GET["scroll"])
	$_SESSION["MQ_GROUP_LAST_POINT_SCROLL"] = $_GET["scroll"];
if($_GET["count"])
	$_SESSION["MQ_GROUP_LAST_POINT_COUNT_POSTS"] = $_GET["count"];
?>
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

	$arFilter = array("IBLOCK_ID" => $iblock_id, "ACTIVE_DATE" => "Y", "ACTIVE" => "Y", "PROPERTY_SOCIAL_GROUP_ID" => $group_id);
	if(isset($_GET["about"])&&$_GET["about"]==1)
		$arFilter["PROPERTY_ABOUT_VALUE"]=1;
	if($_GET["q"])
		$arFilter["%NAME"] = $_GET["q"];
	$res = CIBlockElement::GetList(array("PROPERTY_K_INSPIRATION" => "DESC", "ACTIVE_FROM" => "DESC"), $arFilter, false, Array("nPageSize" => $nPageSize));
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
		$link = str_replace("#group_id#",$group_id,$arPost["DETAIL_PAGE_URL"]).'/?page='.$page; //?page='.$page - при закрытии деталки осуществляем возврат в ленту с фокусом на закрытом посте
		$link_share = str_replace("#group_id#",$group_id,$arPost["DETAIL_PAGE_URL"])."/";

		$file = CFile::ResizeImageGet($arPost["PREVIEW_PICTURE"], array('width'=>280, 'height'=>240), BX_RESIZE_IMAGE_EXACT, true);
		echo "<a class=\"lenta_item search-item\" id=\"lenta_item_".$arPost["ID"]."\" href=\"".$link."\" style=\"background-image:url('".$file["src"]."');\"><div class=\"cover_text\">";
		if($arPost["NAME"]!=" ")
			echo "<span class=\"search-item-name\">".mb_strtoupper($arPost["NAME"])."</span>";
		echo "</div><div class=\"lenta_item_hover\" id=\"lenta_item_".$arPost["ID"]."\"></div></a>";
		?>
<a class="cover_bottom_info search-item-cover" id="bottom_lenta_item_<?=$arPost["ID"]?>" href="<?=$link?>">
	<div class="cover_bottom_info_inside">
		<div class="group_info_slogan"><!--Необычные док-станции <span class="slogan_color">IXOOST</span>--><?=$arPost["PROPERTIES"]["NAME_2"]["VALUE"]?></div>
		<?
			$res_like = 0;//CIBlockElement::GetList(array(), array("IBLOCK_ID" => 6, "PROPERTY_LIKE" => $arPost['ID'], "PROPERTY_USER" => $USER->GetID() ),array());	
			$res_like_star = CIBlockElement::GetList(array(), array("IBLOCK_ID" => 10, "PROPERTY_LIKE" => $arPost['ID'], "PROPERTY_USER" => $USER->GetID() ),array());	
		?>
		<div class="group_info_details">
			<img src="<?=SITE_TEMPLATE_PATH?>/images/date_comments.png" width="" height="" alt="">
			<?
			$tmp_comm_count = $arPost["PROPERTIES"]["COMMENTS_COUNT"]["VALUE"];
			?>
			<span><?=intval($tmp_comm_count)?> <?=getNumEnding(intval($tmp_comm_count), Array("КОММЕНТАРИЙ", "КОММЕНТАРИЯ", "КОММЕНТАРИЕВ"))?></span>
			<?if($arPost["PROPERTIES"]["SHARE"]["VALUE"] == "Y"){?>
			<img src="<?=SITE_TEMPLATE_PATH?>/images/arrow.png" width="" height="" alt=""> <span link="<?=urlencode("http://".SITE_SERVER_NAME.$link_share)?>" class= "fb_share_count" style="vertical-align: baseline; color:#fff;"></span><span style="margin-left:-20px;">ПОДЕЛИЛИСЬ</span>
			<?}?>
			<img src="<?=SITE_TEMPLATE_PATH?>/images/like80.png" width="" height="" alt=""> <span style="vertical-align: baseline; color:#fff;"><?=intval($arPost["PROPERTIES"]["LIKES"]["VALUE"])?></span>
		</div>
        <div class="mobile-block group_info_mobile-block">
               <!-- <div><span>ДЕЙСТВИЯ</span><span>ПОДЕЛИТЕСЬ</span></div> -->
                <div>
                    <div class="group_info_mobile-block_like"></div><span class="mobile-like-number" style="vertical-align: baseline; color:#fff;"><?=intval($arPost["PROPERTIES"]["LIKES"]["VALUE"])?></span>
                    <div class="group_info_mobile-block_star"></div>
                    <div class="group_info_mobile-block_fb"></div>                    
                    <div class="group_info_mobile-block_vk"></div>                    
                    <div class="group_info_mobile-block_gplus"></div>                    
                </div>
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
</a>
		<?
	}
?>