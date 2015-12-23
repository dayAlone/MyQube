<? $geiop = CAltasibGeoBase::GetAddres();?>
<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?if($arParams["group_id"] && $arParams["show_logo"] == "Y"){?>
<style>
#nav_1 .nav-inner{
	margin:0 auto;
}
</style>
<?}?>
<nav id="nav_1">
	<div class="nav-inner">
		<?if (!empty($arResult)):
		$arr_1 = explode("/",$_SERVER['REQUEST_URI']);
		?>
		<?if($arParams["search"] == "y" && $arParams["search_pos"] == "l") {?>
			<?$APPLICATION->IncludeComponent(
				"bitrix:search.form",
				"myqube_search_group",
				array(
					"COMPONENT_TEMPLATE" => "myqube_search_group",
					"PAGE" => $APPLICATION->GetCurPage(),
					"USE_SUGGEST" => "Y"
				),
				false
			);?>
		<?}?>
		<?if($_GET["user"]) $user = $_GET["user"]; else $user = CUser::GetID();?>
		<?if($arParams["group_id"] && $arParams["show_logo"] == "Y") {?>
			<div class="item nomobile" style="float:left;margin-right:120px;margin-left:24px"><img src="<?=SITE_TEMPLATE_PATH?>/images/KENT LAB.png" style="vertical-align: middle; height: 20px;"></div>
		<?}?>
		<?foreach($arResult as $arItem):?>
			<?
			//echo $arItem["LINK"]."!!!";
			$link = str_replace("#group_id#", $arParams["group_id"], $arItem["LINK"]);
			$link = str_replace("#user#", $user, $link);
			$section_1 = str_replace("/","#",$arItem["LINK"]);
			if($arParams["group_id"])
				$section = preg_replace("/^#group##group_id##?(\w*)#?$/","$1",$section_1);
			else
				$section = preg_replace("/^#user##user##?(\w*)#?$/","$1",$section_1);
			if(!$USER->IsAdmin() && $geiop['CITY_NAME'] != CITY_NAME && $section=="contest") continue;
			//echo $section."!!!";
			if(!$arItem["SELECTED"]&&$section=="#personal#contest#"&&!$arParams["group_id"])continue;
			//echo $section;
			if($section!==""&&in_array($section,$arr_1)||$section==""&&$arr_1[3]=="")$arItem["SELECTED"]=1;
			/*if(strpos($arItem["LINK"],"profile"))$arItem["SELECTED"]=1;*/
			?>
			<?if($arItem["SELECTED"]):?>
				<div class="item"><a class="selected" href="<?=$link?>"><?=mb_strtoupper($arItem["TEXT"]);?></a></div>
			<?else:?>
				<div class="item"><a href="<?=$link?>"><?=mb_strtoupper($arItem["TEXT"])?></a></div>
			<?endif?>
		<?endforeach?>
		<?endif?>
		<?if($arParams["LAST_LINK"]) {?>
			<div class="item"><a href="<?=$arParams["LAST_LINK"]["LINK"]?>" <?=$arParams["LAST_LINK"]["STYLE"]?>><?=$arParams["LAST_LINK"]["NAME"]?></a></div>
		<?}?>
		<?if($arParams["search"] == "y" && $arParams["search_pos"] == "r") {?>
			<?$APPLICATION->IncludeComponent(
				"bitrix:search.form",
				"myqube_search_group",
				array(
					"COMPONENT_TEMPLATE" => "myqube_search_group",
					"PAGE" => $APPLICATION->GetCurPage(),
					"USE_SUGGEST" => "Y"
				),
				false
			);?>
		<?}?>
	</div>
</nav>
<?/*echo "<xmp>";print_r($arResult); echo "</xmp>";*/?>
