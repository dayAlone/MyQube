<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?
	$postsCounter = CIBlockElement::GetList(Array(), Array("IBLOCK_ID" => 8, "ACTIVE" => "Y", "PROPERTY_SOCIAL_GROUP_ID"=>$arGroup["ID"]), Array());
?>

	<div class="flex-between" id="block-wrapper" data-count="<?=$postsCounter?>"><? include("ajax_video.php");?> </div>
	<div class="clear"></div>
	<!--a href="#" id="addposts" style="text-align:center; display:block;">ЕЩЁ НОВОСТИ</a-->
