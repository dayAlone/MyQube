<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?
	if($arGroup["ID"]==-1)die('sfdgdzfg');
	$arFilter = Array("IBLOCK_ID" => 3, "ACTIVE" => "Y", "PROPERTY_SOCIAL_GROUP_ID"=>$arGroup["ID"]);
	if(isset($only_my)&&$only_my==1)
		$arFilter['PROPERTY_ANC_ID']=$USER->GetID();
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
	$postsCounter = CIBlockElement::GetList(Array(), $arFilter, Array());
?>
	<?
		$geiop = CAltasibGeoBase::GetAddres();
		if (($geiop['CITY_NAME'] == CITY_NAME || $USER->IsAdmin()) && strtotime('14.02.2016') > time()) {?>
			<a href="/group/1/contest/u_creative/" style='margin-top: 5px;display: inline-block;z-index: 1;position:relative;padding: 0 20px;'><img src="/group/u_creative/images/big-banner.jpg" alt="" style="border-radius: 8px;" width='100%'/></a>
		<?}
	?>
	<div class="flex-between" id="block-wrapper" data-count="<?=$postsCounter?>"><? include("ajax_contest.php");?> </div>
	<div class="clear"></div>
	<!--a href="#" id="addposts" style="text-align:center; display:block;">ЕЩЁ СОБЫТИЯ</a-->
