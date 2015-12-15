<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");?>
<link rel="stylesheet" href="/css/video.css">
<?
	CModule::IncludeModule("iblock");
	$group_id = (isset($arGroup["id"]))?$arGroup["id"]:$_GET["GROUP_ID"];
	$iblock_id = 8;
	$arPosts = array();
	
	// Постраничная пагинация / Сессия прописывается в init.php
	if(($nPageSize = $_SESSION["BackFromDetail"]["group_6"]["nPageSize"]) && !$_GET["PAGEN_1"])
		$nPageSizePhoto = $_SESSION["BackFromDetail"]["group_6"]["nPageSize"]*9;
	else
		$nPageSizePhoto = 9;
	
	$arFilter = array("IBLOCK_ID" => $iblock_id, "PROPERTY_ANC_ID" => $group_id, "PROPERTY_ANC_TYPE" => 20);
	if(isset($only_my)&&$only_my==1) {
		$arFilter['PROPERTY_ANC_ID']=$only_for;
		$arFilter['PROPERTY_ANC_TYPE']=19;
	}
	/*if($_GET["events"] == "archiv")
		$arFilter["<=PROPERTY_DATE_EVENT"] = ConvertDateTime(date("d.m.Y", time()), "YYYY-MM-DD")." 00:00:00";
	else
		$arFilter[">=PROPERTY_DATE_EVENT"] = ConvertDateTime(date("d.m.Y", time()), "YYYY-MM-DD")." 00:00:00";*/
	$res = CIBlockElement::GetList(array("ACTIVE_FROM" => "DESC"), $arFilter, false, Array("nPageSize" => $nPageSizePhoto));
	while($arItemObj = $res->GetNextElement(true, false)){
		$arItem = $arItemObj->GetFields();
		$arItem["PROPERTIES"] = $arItemObj->GetProperties();
		$arPosts[$arItem["ID"]] = $arItem;
	}
	$page = $res->NavPageNomer;
	$elementNum = 0;
	foreach($arPosts as $arPost)
	{
		if($elementNum == 9) {
			++$page;
			$elementNum = 0;
		}
		++$elementNum;
		$link = str_replace("#group_id#",$group_id,$arPost["DETAIL_PAGE_URL"]).'?page='.$page;;
		$user = CUser::GetByID($arPost["CREATED_BY"])->Fetch();
		if(empty($arPost["PREVIEW_PICTURE"])) {
			$parsed_url = parse_url($arPost["PROPERTIES"]["VIDEO"]["VALUE"]);
			parse_str($parsed_url['query'], $parsed_query);
			$pic = "http://img.youtube.com/vi/".$parsed_query['v']."/0.jpg";
		} else {
			$pic = CFile::GetPath($arPost["PREVIEW_PICTURE"]);
		}
		?>
		<div class="video-block" id="video-<?=$arPost["ID"]?>">
			<a href="<?=$arPost["ID"]?>/"><div class="video-img" style="background: url('<?=$pic?>'); background-size: cover;">
				<div class="play-img"></div>
			</div></a>
			<div class="video-name"><a href="<?=$arPost["ID"]?>/"><?=$arPost["NAME"]?></a></div>
			<div class="video-socbutton">
				<!-- класс video-like-gray - серый video-like-red - красный лайк -->
				<?
						$res_like = CIBlockElement::GetList(array(), array("IBLOCK_ID" => 6, "PROPERTY_LIKE" => $arPost['ID'], "PROPERTY_USER" => $USER->GetID() ),array());	
				?>
				<a class="likes <?=($res_like>0)?"active":""?>" id="like_post_<?=$arPost["ID"]?>"></a>
				<a class="comments-wrap" href="<?=$arPost['ID']?>/#comment_form_<?=$arPost['ID']?>">
							<div class="comments-icon"></div>
							<div class="comments-number"><?=intval($arPost["PROPERTIES"]["COMMENTS_COUNT"]["VALUE"])?> комментариев</div>
				</a>
				<?if($arPost["PROPERTIES"]["SHARE"]["VALUE"] == "Y"){?>
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
							"PAGE_URL" => $APPLICATION->GetCurPage().$arPost["ID"].'/',
							"PAGE_TITLE" => $arPost["NAME"],
							"SHORTEN_URL_LOGIN" => "",
							"SHORTEN_URL_KEY" => ""
						),
						false
					);?>
				<?}?>
			</div>
		</div>
		<?
		//echo '<pre>'; print_r($arPost); echo '</pre>';		
	}
	?>