<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?
	$arFilter = array("IBLOCK_ID" => 2, "ACTIVE_DATE" => "Y", "PROPERTY_SOCIAL_GROUP_ID" => $arGroup["ID"], "PROPERTY_ANC_TYPE" => 26);
	if($_GET["filter"] == "next" || empty($_GET["filter"]))
		$arFilter[">=PROPERTY_START_DATE"] = trim(CDatabase::CharToDateFunction(ConvertTimeStamp(time(),'FULL')),"\'");	
	if($_GET["filter"] == "prev")
		$arFilter["<=PROPERTY_END_DATE"] = trim(CDatabase::CharToDateFunction(ConvertTimeStamp(time(),'FULL')),"\'");
	if($_GET["filter"] == "my")
		$arFilter["PROPERTY_ANC_ID"] = $USER->GetID();
	$postsCounter = CIBlockElement::GetList(Array(), $arFilter, Array());
?>

	<div class="flex-between" id="block-wrapper" data-count="<?=$postsCounter?>"><? include("ajax_events.php");?> </div>
	<div class="clear"></div>
	<!--a href="#" id="addposts" style="text-align:center; display:block;">ЕЩЁ СОБЫТИЯ</a-->
