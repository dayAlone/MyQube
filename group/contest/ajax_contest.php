<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");?>
<?
if($_GET["scroll"])
	$_SESSION["MQ_GROUP_LAST_POINT_SCROLL"] = $_GET["scroll"];
if($_GET["count"])
	$_SESSION["MQ_GROUP_LAST_POINT_COUNT_POSTS"] = $_GET["count"];
?>
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
	$only_my = ($_GET["filter"] == "my")?1:0;

	// Постраничная пагинация / Сессия прописывается в init.php
	if(($nPageSize = $_GET["page"]) && !$_GET["PAGEN_1"])
		$nPageSizePhoto = $nPageSize*9;
	else
		$nPageSizePhoto = 9;
	
	$arFilter = array("IBLOCK_ID" => $iblock_id, "ACTIVE" => "Y", "PROPERTY_SOCIAL_GROUP_ID" => $group_id);
	if(isset($only_my)&&$only_my==1)
	
		$arFilter['PROPERTY_ANC_ID']=$USER->GetID();
		//echo date("Y.m.d H:i:s");
	if($_GET["filter"] == "archive")
	{
		$arFilter['<=PROPERTY_END_DATE']=date("Y-m-d H:i:s");	
	}
	else
	{
		$arFilter['>=PROPERTY_END_DATE']=date("Y-m-d H:i:s");	
	}
	if($_GET["q"])
		$arFilter["%NAME"] = $_GET["q"];
	$res = CIBlockElement::GetList(array("ACTIVE_FROM" => "DESC"), $arFilter, false, Array("nPageSize" => $nPageSizePhoto));
	while($arItemObj = $res->GetNextElement(true, false))
	{
		$arItem = $arItemObj->GetFields();
		$arItem["PROPERTIES"] = $arItemObj->GetProperties();
		$arItem["in"]=in_array($USER->GetID(),$arItem["PROPERTIES"]["ANC_ID"]["VALUE"]);
		$arPosts[$arItem["ID"]] = $arItem;
	}
	if($_GET["filter"] == "archive")
	{
		function cmp($a,$b)
		{
			if ($a["in"] == $b["in"]) {
				return 0;
			}
			return ($a["in"] < $b["in"]) ? -1 : 1;
		}
		usort($arPosts,"cmp");
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
		$link = "/group/1/contest/".$arPost["ID"].'/?filter='.$_GET["filter"].'&page='.$page;
		$file = CFile::ResizeImageGet($arPost["PREVIEW_PICTURE"], array('width'=>280, 'height'=>240), BX_RESIZE_IMAGE_EXACT, true);
		?>
		<div class="event search-item" id="event-<?=$arPost["ID"]?>" style="background: url('<?=CFile::GetPath($arPost["PREVIEW_PICTURE"])?>');">
			<div class="shadow-wrap">
				<div class="upper-card-block">
					<div class="event-header"><a href="<?=$link?>" class="search-item-name"><?=$arPost["NAME"]?></a></div>
					<div class="event-date" style="font-size: 16px;">
					<a href="<?=$link?>"><?if(FormatDate(array("d" => 'F'), MakeTimeStamp($arPost["PROPERTIES"]["START_DATE"]["VALUE"], "DD.MM.YYYY HH:MI:SS")) ==
						FormatDate(array("d" => 'F'), MakeTimeStamp($arPost["PROPERTIES"]["END_DATE"]["VALUE"], "DD.MM.YYYY HH:MI:SS")))
							echo FormatDate(array("d" => 'j - '), MakeTimeStamp($arPost["PROPERTIES"]["START_DATE"]["VALUE"], "DD.MM.YYYY HH:MI:SS"));
						else
							echo FormatDate(array("d" => 'j F - '), MakeTimeStamp($arPost["PROPERTIES"]["START_DATE"]["VALUE"], "DD.MM.YYYY HH:MI:SS"));
						echo FormatDate(array("d" => 'j F'), MakeTimeStamp($arPost["PROPERTIES"]["END_DATE"]["VALUE"], "DD.MM.YYYY HH:MI:SS"));
						echo "<br>".date('Y', MakeTimeStamp($arPost["PROPERTIES"]["END_DATE"]["VALUE"], "DD.MM.YYYY HH:MI:SS"));	
							?></a>	
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
					<div class="likes-wrap" style="float:left;">
						<div id="<?=$GLOBALS['gl_like_id']?>" href="#" class="likes_tiser"></div>
						<div class="likes-number-tiser" style="padding-left:0;"><?=intval($arPost["PROPERTIES"]["LIKES"]["VALUE"])?></div>
					</div>
					<div class="users-wrap">
						<div class="users-icon"></div>
						<div class="users-number"><?if($arPost["PROPERTIES"]["ANC_ID"]["VALUE"]) echo count($arPost["PROPERTIES"]["ANC_ID"]["VALUE"]); else echo 0;?></div>
					</div>
					<!-- Обертка для соцкнопок и кнопки репоста -->
					<? if($arPost["PROPERTIES"]["SHARE"]["VALUE"]=='Y'):?>
						<div class="socwrap">
							<!-- Кнопка репоста -->
							<div class="social-buttons"></div>
							 <span link="<?=urlencode("http://".SITE_SERVER_NAME."/group/1/photo/".$arPost["ID"].'/')?>" class= "fb_share_count"></span> <span>поделились</span>
						</div>
					<?endif;?>
				</div>
			</div>	
		</div>
		<?
	}
?>