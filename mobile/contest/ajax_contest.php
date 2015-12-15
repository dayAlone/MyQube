<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");?>
<link type="text/css" rel="stylesheet" href="/css/competitions-all.css">
<script>
	$(document).ready(function() {
		$('body').on('click', '.accept_event', function() {
			var id = $(this).parent().attr("data-id");
			BX.ajax.get(
				"/group/contest/ajax.php?go="+id,
				function (res){
					$("#event-"+id).find(".event_me").html(res);
				}
			);
		});
		$('body').on('click', '.unaccept_event', function() {
			var id = $(this).parent().attr("data-id");
			BX.ajax.get(
				"/group/contest/ajax.php?leave="+id,
				function (res){
					$("#event-"+id).find(".event_me").html(res);
				}
			);
		});
	});
</script>
<?
	CModule::IncludeModule("iblock");
	$group_id = (isset($arGroup["id"]))?$arGroup["id"]:$_GET["GROUP_ID"];
	$iblock_id = 3;
	$arPosts = array();

	// Постраничная пагинация / Сессия прописывается в init.php
	if(($nPageSize = $_SESSION["BackFromDetail"]["group_6"]["nPageSize"]) && !$_GET["PAGEN_1"])
		$nPageSizePhoto = $_SESSION["BackFromDetail"]["group_6"]["nPageSize"]*9;
	else
		$nPageSizePhoto = 9;
	
	$arFilter = array("IBLOCK_ID" => $iblock_id, "ACTIVE" => "Y", "PROPERTY_SOCIAL_GROUP_ID" => $group_id);
	if(isset($only_my)&&$only_my==1)
		$arFilter['PROPERTY_ANC_ID']=$USER->GetID();
	
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
		if($elementNum == 9) {
			++$page;
			$elementNum = 0;
		}
		
		++$elementNum;
		$link = str_replace("#group_id#",$group_id,$arPost["DETAIL_PAGE_URL"]).'/?page='.$page;
		$file = CFile::ResizeImageGet($arPost["PREVIEW_PICTURE"], array('width'=>280, 'height'=>240), BX_RESIZE_IMAGE_EXACT, true);
		?>
		<div class="event" id="event-<?=$arPost["ID"]?>" style="background: url('<?=CFile::GetPath($arPost["PREVIEW_PICTURE"])?>');">
			<div class="shadow-wrap">
				<div class="upper-card-block">
					<div class="event-header"><a href="<?=$arPost["ID"]?>/"><?=$arPost["NAME"]?></a></div>
					<div class="event-date" style="font-size: 16px;">
						<?if(FormatDate(array("d" => 'F'), MakeTimeStamp($arPost["PROPERTIES"]["START_DATE"]["VALUE"], "DD.MM.YYYY HH:MI:SS")) ==
						FormatDate(array("d" => 'F'), MakeTimeStamp($arPost["PROPERTIES"]["END_DATE"]["VALUE"], "DD.MM.YYYY HH:MI:SS")))
							echo FormatDate(array("d" => 'j - '), MakeTimeStamp($arPost["PROPERTIES"]["START_DATE"]["VALUE"], "DD.MM.YYYY HH:MI:SS"));
						else
							echo FormatDate(array("d" => 'j F - '), MakeTimeStamp($arPost["PROPERTIES"]["START_DATE"]["VALUE"], "DD.MM.YYYY HH:MI:SS"));
						echo FormatDate(array("d" => 'j F'), MakeTimeStamp($arPost["PROPERTIES"]["END_DATE"]["VALUE"], "DD.MM.YYYY HH:MI:SS"))?>
					</div>
					<div class="event_me" data-id="<?=$arPost["ID"]?>">
						<?if($DB->CompareDates($arPost["PROPERTIES"]["END_DATE"]["VALUE"], date("d.m.Y H:i", time())) == 1){?>
							<?if(in_array($USER->GetID(), $arPost["PROPERTIES"]["ANC_ID"]["VALUE"])) {?>
								<div class="accept-event"></div>
								<div class="accept-text">
									Вы уже участвуете в конкурсе
								</div>
								<div class="unaccept-event unaccept_event">
									Отменить участие
								</div>
							<?} else {?>
								<div class="accept accept_event"><button>Принять участие</button></div>
							<?}?>
						<?} else {?>
							<div class="end-event"></div>
							<div class="end-event-text">
								Конкурс окончен
							</div>
						<?}?>
					</div>
				</div>
				<div class="bottom-small-menu">
					<!-- Блок пользователей -->
					<div class="users-wrap" style="margin-right: 21px;">
						<div class="users-icon"></div>
						<div class="users-number"><?if($arPost["PROPERTIES"]["ANC_ID"]["VALUE"]) echo count($arPost["PROPERTIES"]["ANC_ID"]["VALUE"]); else echo 0;?> участника</div>
					</div>
					<!-- Кнопка каментов -->
					<a class="comments-wrap" href="<?=$arPost["ID"]?>/">
								<div class="comments-icon"></div>
								<div class="comments-number"><?=intval($arPost["PROPERTIES"]["COMMENTS_COUNT"]["VALUE"])?> комментариев</div>
					</a>
					<!-- Обертка для соцкнопок и кнопки репоста -->
					<div style="float:left;">
					<? if($arPost["PROPERTIES"]["SHARE"]["VALUE"]=='Y'):?>
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
					<?endif;?>
					</div>
				</div>
			</div>	
		</div>
		<?
	}
?>