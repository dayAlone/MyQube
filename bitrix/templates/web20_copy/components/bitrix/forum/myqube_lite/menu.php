<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
/********************************************************************
				Input params
********************************************************************/
/***************** URL *********************************************/
	$arParams["SHOW_AUTH_FORM"] = ($arParams["SHOW_AUTH_FORM"] == "N" ? "N" : "Y");
/***************** ADDITIONAL **************************************/
/***************** STANDART ****************************************/
	if ($arParams["CACHE_TYPE"] == "Y" || ($arParams["CACHE_TYPE"] == "A" && COption::GetOptionString("main", "component_cache_on", "Y") == "Y"))
		$arParams["CACHE_TIME"] = intval($arParams["CACHE_TIME"]);
	else
		$arParams["CACHE_TIME"] = 0;
/********************************************************************
				/Input params
********************************************************************/
?>
<div class="forum-info-box forum-menu-box">
	<div class="forum-info-box-inner">
<?
if ($GLOBALS["USER"]->IsAuthorized())
{
	if (intval(COption::GetOptionString("forum", "UsePMVersion", "2")) > 0)
	{
		$pm = "";
		$arUserPM = array();
		$cache = new CPHPCache();
		$cache_path_main = str_replace(array(":", "//"), "/", "/".SITE_ID."/".$this->__component->__name."/");
		$cache_id = "forum_user_pm_".$GLOBALS["USER"]->GetId();
		$cache_path = $cache_path_main."user".$GLOBALS["USER"]->GetId();
		if ($arParams["CACHE_TIME"] > 0 && $cache->InitCache($arParams["CACHE_TIME"], $cache_id, $cache_path))
		{
			$val = $cache->GetVars();
			if (is_array($val["arUserPM"]))
				$arUserPM = $val["arUserPM"];
		}
		if (!is_array($arUserPM) || empty($arUserPM))
		{
			CModule::IncludeModule("forum");
			$arUserPM = CForumPrivateMessage::GetNewPM();
			if ($arParams["CACHE_TIME"] > 0):
				$cache->StartDataCache($arParams["CACHE_TIME"], $cache_id, $cache_path);
				$cache->EndDataCache(array("arUserPM"=>$arUserPM));
			endif;
		}
		if (intVal($arUserPM["UNREAD_PM"]) > 0)
		{
			$pm = " (".intVal($arUserPM["UNREAD_PM"]).")";
		}
		?>
		<span class="forum-menu-item forum-menu-messages"><a href="<?=$arResult["URL_TEMPLATES"]["MESSAGES"]?>"><span><?=GetMessage("F_MESSAGES")?><?=$pm?></span></a>&nbsp;</span>
		<?
	}
}
if (IsModuleInstalled("search")):
?>
		<span class="forum-menu-item <?
			?><?=($GLOBALS["USER"]->IsAuthorized() ? "" : "forum-menu-item-first")?><?
			?> forum-menu-search"><noindex><a href="<?=$arResult["URL_TEMPLATES"]["SEARCH"]?>" rel="nofollow"><span><?=GetMessage("F_SEARCH")?></span></a></noindex>&nbsp;</span>
<?	
endif;
?>
<? if ($arParams['SHOW_FORUM_USERS'] === 'Y')
{ ?>
		<span class="forum-menu-item <?
			?><?=($GLOBALS["USER"]->IsAuthorized() || IsModuleInstalled("search") ? "" : "forum-menu-item-first")?><?
			?> forum-menu-users"><a href="<?=$arResult["URL_TEMPLATES"]["USERS"]?>"><span><?=GetMessage("F_USERS")?></span></a>&nbsp;</span>
<?
}
?>
		<span class="forum-menu-item <?
			?><?=($arParams["SHOW_AUTH_FORM"] == "Y" ? "" : "forum-menu-item-last")?><?
			?> forum-menu-rules"><a href="<?=$arResult["URL_TEMPLATES"]["RULES"]?>"><span><?=GetMessage("F_RULES")?></span></a>&nbsp;</span>
<?
if ($arParams["SHOW_AUTH_FORM"] == "Y"):
?>
		<span class="forum-menu-item forum-menu-item-last forum-menu-authorize">
		<?$GLOBALS["APPLICATION"]->IncludeComponent("bitrix:system.auth.form", "", Array(), $component, array("HIDE_ICONS" => "Y"));?>&nbsp;</span>
<?
endif;
?>
	</div>
</div>
<?
if ($arParams["SHOW_NAVIGATION"] != "N" && $arParams["SET_NAVIGATION"] != "N" && ($arResult["PAGE_NAME"] != "index" || $arResult["GID"] > 0)):
// text from main
	if($GLOBALS["APPLICATION"]->GetProperty("NOT_SHOW_NAV_CHAIN")=="Y")
		return false;
	CMain::InitPathVars($site, $path);
	$DOC_ROOT = CSite::GetSiteDocRoot($site);

	$path = $GLOBALS["APPLICATION"]->GetCurDir();
	$arChain = Array();
	
	while(true)
	{
		$path = rtrim($path, "/");

		$chain_file_name = $DOC_ROOT.$path."/.section.php";
		if(file_exists($chain_file_name))
		{
			$sSectionName = "";
			include($chain_file_name);
			if(strlen($sSectionName)>0)
				$arChain[] = Array("TITLE"=>$sSectionName, "LINK"=>$path."/");
		}

		if($path.'/' == SITE_DIR)
			break;

		if(strlen($path)<=0)
			break;
		$pos = bxstrrpos($path, "/");
		if($pos===false)
			break;
		$path = substr($path, 0, $pos+1);
	}
	if ($arResult["PAGE_NAME"] == "read")
	{
		$GLOBALS["FORUM_HIDE_LAST_BREADCRUMB"] = true;
	}
	$GLOBALS["APPLICATION"]->IncludeComponent(
	"bitrix:breadcrumb", ".default",
	Array(
		"START_FROM" => count($arChain) - 1, 
		"PATH" => "", 
		"SITE_ID" => "",  
	), $component, 
	array("HIDE_ICONS" => "Y")
);
endif;
?>