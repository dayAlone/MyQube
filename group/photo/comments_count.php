<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");
	
	CModule::IncludeModule("iblock");
	//$arSelect = array("ID", "NAME", "DETAIL_TEXT", "PROPERTY_OTVET_NA", "PROPERTY_LIKE", "PROPERTY_FILE", "PROPERTY_AUTHOR", "DATE_CREATE", "PREVIEW_PICTURE");
	$arFilter = array("IBLOCK_ID"=>5, "ACTIVE"=>"Y", "PROPERTY_OBJECT_ID" => $_GET["post_id"]);
	$res = CIBlockElement::GetList(array("ID" => "ASC"), $arFilter, false, array());
	echo "<div class=\"comments_count\" id=\"comments_count_".$_GET["post_id"]."\">".$res->SelectedRowsCount().""."</div>";
?>