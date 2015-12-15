<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?
	$arr_t = Array("IBLOCK_ID" => 1, "ACTIVE_DATE" => "Y", "ACTIVE" => "Y", "PROPERTY_SOCIAL_GROUP_ID"=>$arGroup["ID"]);
	if(isset($_GET["about"])&&$_GET["about"]==1)$arr_t["PROPERTY_ABOUT_VALUE"]=1;
	$postsCounter = CIBlockElement::GetList(Array(), $arr_t, Array());
?>
	<div class="flex-between" id="block-wrapper" data-count="<?=$postsCounter?>"><?include("ajax_lenta.php");?></div>
	<div class="clear"></div>
	<?/*if($postsCounter > 6) {?>
		<a href="#" id="addposts" style="text-align:center; display:block;">ЕЩЁ НОВОСТИ</a>
	<?}*/?>
