<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?
	if($arGroup["ID"]==-1)die('sfdgdzfg');
	$postsCounter = CIBlockElement::GetList(Array(), Array("IBLOCK_ID" => 3, "ACTIVE" => "Y", "PROPERTY_SOCIAL_GROUP_ID"=>$arGroup["ID"]), Array());
?>

	<div class="flex-between" id="block-wrapper" data-count="<?=$postsCounter?>"><? include("ajax_contest.php");?> </div>
	<div class="clear"></div>
	<!--a href="#" id="addposts" style="text-align:center; display:block;">ЕЩЁ СОБЫТИЯ</a-->