<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();
if (!$this->__component->__parent || empty($this->__component->__parent->__name)):
	$GLOBALS['APPLICATION']->SetAdditionalCSS('/bitrix/components/bitrix/forum/templates/.default/style.css');
	$GLOBALS['APPLICATION']->SetAdditionalCSS('/bitrix/components/bitrix/forum/templates/.default/themes/blue/style.css');
	$GLOBALS['APPLICATION']->SetAdditionalCSS('/bitrix/components/bitrix/forum/templates/.default/styles/additional.css');
endif;
IncludeAJAX();
/********************************************************************
				Input params
********************************************************************/
/***************** BASE ********************************************/
$arParams["WORD_WRAP_CUT"] = intVal($arParams["WORD_WRAP_CUT"]);
$arParams["SHOW_RSS"] = /*($arParams["SHOW_RSS"] == */"N" /*? "N" : "Y")*/;
$arParams["SHOW_RSS"] = ($arParams["SHOW_RSS"] == "Y" && !empty($arResult["FORUMS_FOR_GUEST"]) ? "Y" : "N");
if ($arParams["SHOW_RSS"] == "Y"):
	$APPLICATION->AddHeadString('<link rel="alternate" type="application/rss+xml" href="'.$arResult["URL"]["RSS_DEFAULT"].'" />');
endif;
$arResult["USER"]["HIDDEN_GROUPS"] = explode("/", $_COOKIE[COption::GetOptionString("main", "cookie_name", "BITRIX_SM")."_FORUM_GROUP"]);
$arParams["TMPLT_SHOW_ADDITIONAL_MARKER"] = trim($arParams["TMPLT_SHOW_ADDITIONAL_MARKER"]);
/********************************************************************
				/Input params
********************************************************************/
if (!empty($arResult["NAV_STRING"]) && $arResult["NAV_RESULT"]->NavPageCount > 1):
?>
<div class="forum-navigation-box forum-navigation-top">
	<div class="forum-page-navigation">
		<?=$arResult["NAV_STRING"]?>
	</div>
	<div class="forum-clear-float"></div>
</div>
<?
endif;
?>

