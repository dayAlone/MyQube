<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");

CModule::IncludeModule("iblock");
$el = new CIBlockElement;
$PROP = array();
$PROP["URL"] = $_GET["link"];
$PROP["USER_ID"] = $_GET["user"];
$PROP["SOCIAL_NETWORK"] = $_GET["social_network"];
$arLoadProductArray = Array(
	"IBLOCK_ID"      => 27,
	"PROPERTY_VALUES"=> $PROP,
	"NAME"           => "Share"
);
$el->Add($arLoadProductArray);
?>