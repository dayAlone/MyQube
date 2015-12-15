<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Конкурсы");
?><?$APPLICATION->IncludeComponent("bitrix:main.profile", "", Array(
	"SET_TITLE" => "Y",	// Устанавливать заголовок страницы
	),
	false
);?>
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>