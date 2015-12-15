<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");?>
<style>
	.likes-wrap {
		width:60px !important;
	}
	a.likes {
		margin-top:1px !important;
	}
</style>
<?
function fetch_vimeo_id($url) {
	$headers = get_headers($url);
	# Reverse loop because we want the last matching header,
	# as Vimeo does multiple redirects with your `https` URL
	for($i = count($headers) - 1; $i >= 0; $i--) {
		$header = $headers[$i];
		//echo $header."#<br>";
		if(strpos($header, "Location: /") === 0) {
			return substr($header, strlen("Location: /"));
		}
	}
	# Could not find id
	return null;
}
$page_name="video";

	include($_SERVER["DOCUMENT_ROOT"]."/user/header.php");
			$APPLICATION->IncludeComponent(
			"bitrix:main.include",
			"",
			Array(
				"COMPONENT_TEMPLATE" => ".default",
				"AREA_FILE_SHOW" => "file",
				"AREA_FILE_SUFFIX" => "inc",
				"EDIT_TEMPLATE" => "",
				"PATH" => "/chat/index.php"
			)
		);
	$only_my = 1;
	$only_for = $CurentUser["ID"];
	include($_SERVER["DOCUMENT_ROOT"]."/group/video/ajax_video.php");
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");
?>
<?/*
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$page_name="video";

include($_SERVER["DOCUMENT_ROOT"]."/user/header.php");
?><link rel="stylesheet" href="/css/video.css">
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
	
	$arFilter = array("IBLOCK_ID" => $iblock_id, "PROPERTY_ANC_ID" => $CurentUser["ID"], "PROPERTY_ANC_TYPE" => 19);
	/*if($_GET["events"] == "archiv")
		$arFilter["<=PROPERTY_DATE_EVENT"] = ConvertDateTime(date("d.m.Y", time()), "YYYY-MM-DD")." 00:00:00";
	else
		$arFilter[">=PROPERTY_DATE_EVENT"] = ConvertDateTime(date("d.m.Y", time()), "YYYY-MM-DD")." 00:00:00";
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
		$link = $arPost["ID"].'/';
		$user = CUser::GetByID($arPost["CREATED_BY"])->Fetch();
		$parsed_url = parse_url($arPost["PROPERTIES"]["VIDEO"]["VALUE"]);
		parse_str($parsed_url['query'], $parsed_query);
		?>
		<div class="video-block" id="video-<?=$arPost["ID"]?>">
			<a href="<?=$link?>"><div class="video-img" style="background: url('http://img.youtube.com/vi/<?=$parsed_query['v']?>/0.jpg'); background-size: cover;">
				<div class="play-img"></div>
			</div></a>
			<div class="video-name"><a href="<?=$link?>"><?=$arPost["NAME"]?></a></div>
			<div class="video-socbutton">
				<!-- класс video-like-gray - серый video-like-red - красный лайк -->
				<?
						$res_like = CIBlockElement::GetList(array(), array("IBLOCK_ID" => 6, "PROPERTY_LIKE" => $arPost['ID'], "PROPERTY_USER" => $USER->GetID() ),array());	
				?>
				<a class="likes <?=($res_like>0)?"active":""?>" id="video_item_<?=$arPost["ID"]?>"></a>
				<a class="comments-wrap" href="/group/<?=$group_id?>/video/<?=$arPost['ID']?>/#comment_form_<?=$arPost['ID']?>">
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
							"PAGE_URL" => $APPLICATION->GetCurPage(),
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
		</div>
	<?	$APPLICATION->IncludeComponent(
			"bitrix:main.include",
			"",
			Array(
				"COMPONENT_TEMPLATE" => ".default",
				"AREA_FILE_SHOW" => "file",
				"AREA_FILE_SUFFIX" => "inc",
				"EDIT_TEMPLATE" => "",
				"PATH" => "/chat/index.php"
			)
		);
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");
*/?>