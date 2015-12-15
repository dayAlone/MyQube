<?
	require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");
	CModule::IncludeModule("iblock");
	//error_reporting(E_ALL);
	$arPosts = array();
	$iblock_id = 20;
	//$group_id = 1;
	$arFilter = array("IBLOCK_ID" => $iblock_id);
	include_once("phpqrcode/qrlib.php");

	
	$res = CIBlockElement::GetList(array("active_from" => "DESC"), $arFilter, false);
	while($arItemObj = $res->GetNextElement(true, false)){
		$arItem = $arItemObj->GetFields();
		//echo "<xmp>"; print_r($arItem); echo "</xmp>";
		//$arItem["NAME"];
		QRcode::png("http://myqube.ru/QR/".$arItem["NAME"]."/", $_SERVER["DOCUMENT_ROOT"]."/upload/qr/qr_".$arItem["NAME"].".png", "L", 7, 7);
		
		$arLoadProductArray = Array(
		  "PREVIEW_PICTURE" => CFile::MakeFileArray($_SERVER["DOCUMENT_ROOT"]."/upload/qr/qr_".$arItem["NAME"].".png")
		  );
		$el = new CIBlockElement;
		$PRODUCT_ID = $arItem["ID"];  // изменяем элемент с кодом (ID) 2
		$res_1 = $el->Update($PRODUCT_ID, $arLoadProductArray);
		echo "<br>super<br>";
		//$arItem["PROPERTIES"] = $arItemObj->GetProperties();
		//$count = 0;
		//foreach($arItem["PROPERTIES"]["PHOTO"]["VALUE"] as $key => $picture) 
		//{
			/*$arFilter1 = array("IBLOCK_ID"=>5, "ACTIVE"=>"Y", "PROPERTY_OBJECT_ID" => $picture);
			$res_1 = CIBlockElement::GetList(array("ID" => "ASC"), $arFilter1, false, array());
			$count = $res_1->SelectedRowsCount() + $count;*/
		//}
		/*CIBlockElement::SetPropertyValuesEx($arItem['ID'], false, array('COMMENTS_COUNT' => $count));
		echo $arItem['ID']." ".$count."<br>";*/
		//die("!!!");
	}
	echo "all ok";
	?>