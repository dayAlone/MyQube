<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Новости");
?>Текст....<?/*$APPLICATION->IncludeComponent(
	"bitrix:catalog.smart.filter",
	"",
	Array(
	)
);*/?><?$APPLICATION->IncludeComponent(
	"bitrix:forum.user.list",
	"",
	Array(
	)
);?><?$APPLICATION->IncludeComponent(
	"bitrix:forum.pm.search",
	"",
	Array(
	)
);?><?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>