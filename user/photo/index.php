<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");?>
<style>
	a.likes {
		margin-top:1px !important;
	}
	.likes-wrap {
		width: 60px !important;
	}
</style>
<?
$page_name="photo";

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
	include($_SERVER["DOCUMENT_ROOT"]."/group/photo/ajax_photo.php");
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");
?>
<?/*
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");

$page_name="photo";

include($_SERVER["DOCUMENT_ROOT"]."/user/header.php");
?>
	<link type="text/css" rel="stylesheet" href="/css/events_detail.css">
	<script>
		$("a.likes" ).click(function() {
			$( this ).toggleClass( "active" );
			var path = host_url+"/group/photo/like_post.php";
			$.get(path, {post_id: $(this).attr('id'),like: Number($( this ).hasClass( "active" ))}, function(data){
			});
		});
	</script>
				<?
			CModule::IncludeModule("iblock");
			$iblock_id = 7;
			$arPosts = array();
			
			// Постраничная пагинация / Сессия прописывается в init.php
			if(($nPageSize = $_SESSION["BackFromDetail"]["group_6"]["nPageSize"]) && !$_GET["PAGEN_1"])
				$nPageSizePhoto = $_SESSION["BackFromDetail"]["group_6"]["nPageSize"]*9;
			else
				$nPageSizePhoto = 9;
			
			$arFilter = array("IBLOCK_ID" => $iblock_id, "PROPERTY_ANC_ID" => $CurentUser["ID"], "PROPERTY_ANC_TYPE" => 17);
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
			?>
			<div class="photo_list">
				<?
				foreach($arPosts as $arPost)
				{
					if($elementNum == 9) {
						++$page;
						$elementNum = 0;
					}
					++$elementNum;
					$link = $arPost["DETAIL_PAGE_URL"].'/?page='.$page;
					$user = CUser::GetByID($arPost["CREATED_BY"])->Fetch();
					?>
					<div class="photo_list_item" style="background: url('<?=CFile::GetPath($arPost["PREVIEW_PICTURE"])?>');">
						<img class="photo_list_gradient" src="<?=SITE_TEMPLATE_PATH?>/images/gradient.png">
						<a href="<?=$arPost["ID"]?>/" style="position: absolute; width: 280px; height: 250px;"></a>
						<div class="photo_list_user">
							<!--div class="photo_list_avatar" style="background: url('<?=CFile::GetPath($user["PERSONAL_PHOTO"])?>'); background-size: 80px;">
							</div>
							<div class="photo_list_name"><?=$user["NAME"]?></div-->
							<div class="photo_list_header"><?=$arPost["NAME"]?></div>							
						</div>
						<div class="photo_list_info">
							<?
								$res_like = CIBlockElement::GetList(array(), array("IBLOCK_ID" => 6, "PROPERTY_LIKE" => $arPost['ID'], "PROPERTY_USER" => $USER->GetID() ),array());	
							?>
							<a class="likes <?=($res_like>0)?"active":""?>" id="photo_item_<?=$arPost["ID"]?>"></a>
							<a class="comments-wrap" href="<?=$arPost["ID"]?>/#">
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
							<div class="photo_list_date">
								<?=FormatDate(array(
									"tommorow" => "tommorow",
									"today" => "today",
									"yesterday" => "yesterday",
									"d" => 'j F',
									 "" => 'j F Y',
									), MakeTimeStamp($arPost["DATE_CREATE"]))?>
							</div>		
						</div>
					</div>
					<?
					//echo '<pre>'; print_r($arPost); echo '</pre>';		
				}
				?>
			</div>
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