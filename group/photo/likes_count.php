<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");
	$APPLICATION->IncludeComponent("radia:likes","",Array(
		"ELEMENT" => 'photo_'.$_GET["post_id"]
	));
?>
