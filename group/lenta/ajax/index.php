<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");?>
<?
	CModule::IncludeModule("iblock");
	$group_id = (isset($arGroup["id"]))?$arGroup["id"]:$_GET["GROUP_ID"];
	$iblock_id = 1;
	$arPosts = array();

	// Постраничная пагинация / Сессия прописывается в init.php
	if(($nPageSize = $_SESSION["BackFromDetail"]["group_6"]["nPageSize"]) && !$_GET["PAGEN_1"])
		$nPageSizePhoto = $_SESSION["BackFromDetail"]["group_6"]["nPageSize"]*8;
	else
		$nPageSizePhoto = 8;

	$arFilter = array("IBLOCK_ID" => $iblock_id, "ACTIVE" => "Y", "PROPERTY_SOCIAL_GROUP_ID" => $group_id);
	$res = CIBlockElement::GetList(array("ACTIVE_FROM" => "DESC"), $arFilter, false, Array("nPageSize" => $nPageSizePhoto));
	while($arItemObj = $res->GetNextElement(true, false))
	{
		$arItem = $arItemObj->GetFields();
		$arItem["PROPERTIES"] = $arItemObj->GetProperties();
		$arPosts[$arItem["ID"]] = $arItem;
	}
	$page = $res->NavPageNomer;
	$elementNum = 0;
	foreach($arPosts as $arPost)
	{
	for($i=1;$i<=6;$i++)
	{
		if($elementNum == 8) {
			++$page;
			$elementNum = 0;
		}
		++$elementNum;
		$link = $arPost["DETAIL_PAGE_URL"].'/?page='.$page;
		//echo "<xmp>";print_r($arPost); echo "</xmp>";
		$file = CFile::ResizeImageGet($arPost["PREVIEW_PICTURE"], array('width'=>280, 'height'=>240), BX_RESIZE_IMAGE_EXACT, true);
		echo "<a class=\"lenta_item\" href=\"".$link."\" style=\"background-image:url('".$file["src"]."');\"><div class=\"cover_text\"><span>".mb_strtoupper($arPost["NAME"])."</span></div><div class=\"cover_bottom_info\">";
		?>
	<div class="cover_bottom_info_inside">
		<div class="group_info_slogan">Необычные док-станции <span class="slogan_color">IXOOST</span></div>
		<div class="group_info_details">
			<img src="<?=SITE_TEMPLATE_PATH?>/images/date_icon.png" width="" height="" alt="">
			<span><?=FormatDate(array("d" => 'l, j F'), MakeTimeStamp(date('d.m.Y', time())), time());?></span>
			<img src="<?=SITE_TEMPLATE_PATH?>/images/date_watch.png" width="" height="" alt="">
			<span>В <?=date("H:i", time())?></span>
			<img src="<?=SITE_TEMPLATE_PATH?>/images/date_comments.png" width="" height="" alt="">
			<span>5 КОММЕНТАРИЕВ</span>
		</div>
	</div>
	<div class="cover_bottom_info_actions">
			<div class="cover_bottom_info_a1">
				<span>Действия</span><br>
				<img src="<?=SITE_TEMPLATE_PATH?>/images/like_heart.png" width="" height="" alt="">
				<img src="<?=SITE_TEMPLATE_PATH?>/images/like_star.png" width="" height="" alt="">
			</div>
			<div class="cover_bottom_info_a2">
				<span>Поделитесь</span><br>
				<img src="<?=SITE_TEMPLATE_PATH?>/images/bottom_hover_fb.png" width="" height="" alt="">
				<img src="<?=SITE_TEMPLATE_PATH?>/images/bottom_hover_vk.png" width="" height="" alt="">
				<img src="<?=SITE_TEMPLATE_PATH?>/images/bottom_hover_g.png" width="" height="" alt="">
			</div>
	</div>
		<?
		echo"</div><div class=\"lenta_item_hover\"></div></a>";
		//echo ('<a class="lenta_item" href="'.$link.'">'.$arPost["NAME"].'</a>');
	}
	}
?>