<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");
CModule::IncludeModule("iblock");
$arLoadProductArray = Array("READ"=>1);
$m=intval(str_replace("friend_comment_","",$_GET["id"]));
CIBlockElement::SetPropertyValuesEx($m,12, $arLoadProductArray);
	
?>