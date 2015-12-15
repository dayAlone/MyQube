<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");
	
	CModule::IncludeModule("iblock");
	//$arSelect = array("ID", "NAME", "DETAIL_TEXT", "PROPERTY_OTVET_NA", "PROPERTY_LIKE", "PROPERTY_FILE", "PROPERTY_AUTHOR", "DATE_CREATE", "PREVIEW_PICTURE");
	$arFilter = array("IBLOCK_ID"=>6, "ACTIVE"=>"Y", "PROPERTY_LIKE" => $_GET["post_id"]);
	$res = CIBlockElement::GetList(array("ID" => "ASC"), $arFilter, false, array());
	$arFilter["PROPERTY_USER"] = $USER->GetID();
	$res1 = CIBlockElement::GetList(array("ID" => "ASC"), $arFilter, false, array());
	$options=array(
		"count"=>$res->SelectedRowsCount(),
		"active"=>$res1->SelectedRowsCount()
	 );
	echo json_encode($options);
?>