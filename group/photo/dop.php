<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?
	$postsCounter = CIBlockElement::GetList(Array(), Array("IBLOCK_ID" => 7, "ACTIVE_DATE" => "Y", "PROPERTY_ANC_ID" => $arGroup["ID"], "PROPERTY_ANC_TYPE" => 18), Array());
?>

	<div class="flex-between" id="block-wrapper" data-count="<?=$postsCounter?>"><? include("ajax_photo.php");?> </div>
	<div class="clear"></div>
	<!--a href="#" id="addposts" style="text-align:center; display:block;">ЕЩЁ НОВОСТИ</a-->
