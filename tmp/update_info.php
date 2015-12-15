<?	
	require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");
	echo "Success test 1";
	/*CModule::IncludeModule("iblock");
	$arPosts = array();
	$iblock_id = 7;
	$group_id = 1;
	$arFilter = array("IBLOCK_ID" => $iblock_id);
	
	$res = CIBlockElement::GetList(array("active_from" => "DESC"), $arFilter, false);
	while($arItemObj = $res->GetNextElement(true, false)){
		$arItem = $arItemObj->GetFields();
		$arItem["PROPERTIES"] = $arItemObj->GetProperties();
		$count = 0;
		foreach($arItem["PROPERTIES"]["PHOTO"]["VALUE"] as $key => $picture) 
		{
			$arFilter1 = array("IBLOCK_ID"=>6, "ACTIVE"=>"Y", "PROPERTY_LIKE" => $picture);
			$res_1 = CIBlockElement::GetList(array("ID" => "ASC"), $arFilter1, false, array());
			$count = $res_1->SelectedRowsCount() + $count;
		}
		CIBlockElement::SetPropertyValuesEx($arItem['ID'], false, array('LIKES' => $count));
		echo $arItem['ID']." ".$count."<br>";
	}*/
	/*$arPosts = array();
	$iblock_id = 7;
	$group_id = 1;
	$arFilter = array("IBLOCK_ID" => $iblock_id);
	
	$res = CIBlockElement::GetList(array("active_from" => "DESC"), $arFilter, false);
	while($arItemObj = $res->GetNextElement(true, false)){
		$arItem = $arItemObj->GetFields();
		$arItem["PROPERTIES"] = $arItemObj->GetProperties();
		$count = 0;
		foreach($arItem["PROPERTIES"]["PHOTO"]["VALUE"] as $key => $picture) 
		{
			$arFilter1 = array("IBLOCK_ID"=>5, "ACTIVE"=>"Y", "PROPERTY_OBJECT_ID" => $picture);
			$res_1 = CIBlockElement::GetList(array("ID" => "ASC"), $arFilter1, false, array());
			$count = $res_1->SelectedRowsCount() + $count;
		}
		CIBlockElement::SetPropertyValuesEx($arItem['ID'], false, array('COMMENTS_COUNT' => $count));
		echo $arItem['ID']." ".$count."<br>";
	}*/
?>