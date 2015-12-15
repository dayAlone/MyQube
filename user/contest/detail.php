<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");?>
<?
$page_name="contest_detail";

	include($_SERVER["DOCUMENT_ROOT"]."/user/header.php");
			$APPLICATION->IncludeComponent(
			"bitrix:main.include",
			"",
			Array(
				"COMPONENT_TEMPLATE" => ".default",
				"AREA_FILE_SHOW" => "file",
				"AREA_FILE_SUFFIX" => "inc",
				"EDIT_TEMPLATE" => "",
				"PATH" => "/chat/index.php"
			)
		);
	$only_my = 1;
	include($_SERVER["DOCUMENT_ROOT"]."/group/contest/dop_detail.php");
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");
?>