<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");?>
<?
$PRODUCT_IDS=Array();
if($_POST["video"]) {
	CModule::IncludeModule("iblock");
	$arFields = array(
	   "IBLOCK_ID" => 8,
	   "NAME" => date("Y-m-d H:i", time()),
	   "PREVIEW_PICTURE" => $_FILES["photo"],
	   "PROPERTY_VALUES" => array("VIDEO" => $_POST["video"], "ANC_ID" => CUser::GetID(), "ANC_TYPE" => 19)
	);
	$oElement = new CIBlockElement();
	$idElement = $oElement->Add($arFields, false, false, true); 
	$PRODUCT_IDS[]=$idElement;
} elseif(empty($_FILES["photo"]['error'])) {
	CModule::IncludeModule("iblock");
	$arFields = array(
	   "IBLOCK_ID" => 7,
	   "NAME" => date("Y-m-d H:i", time()),
	   "PREVIEW_PICTURE" => $_FILES["photo"],
	   "PROPERTY_VALUES" => array("PHOTO" => $_FILES["photo"], "ANC_ID" => CUser::GetID(), "ANC_TYPE" => 17)
	);
	$oElement = new CIBlockElement();
	$idElement = $oElement->Add($arFields, false, false, true); 
	$PRODUCT_IDS[]=$idElement;
} elseif(empty($_FILES["photo_ar"]["error"])) {
	/*$fr = fopen($_SERVER['DOCUMENT_ROOT']."/logg.txt", 'a');
	fputs($fr, "___".var_export($_FILES["photo_ar"], true));
	fclose($fr);**/
	CModule::IncludeModule("iblock");
	if(!$_POST['head'])
		$head = date("Y-m-d H:i", time());
	$arFiles = array();
	for($i = 0; $i < count($_FILES["photo_ar"]['name']); $i++)
	{
		$file = Array
                (
                    'name' => $_FILES["photo_ar"]['name'][$i],
                    'size' => $_FILES["photo_ar"]['size'][$i],
                    'tmp_name' => $_FILES["photo_ar"]['tmp_name'][$i],
                    'type' => $_FILES["photo_ar"]['type'][$i]
                );
		if($_FILES["photo_ar"]['tmp_name'][$i])
			$arFiles[] = array('VALUE' => $file, 'DESCRIPTION' => '');
	}
	$arFields = array(
	   "IBLOCK_ID" => 7,
	   "NAME" => $head,
	   "PREVIEW_PICTURE" => $arFiles[0]["VALUE"],
	   "PROPERTY_VALUES" => array("PHOTO" => $arFiles, "ANC_ID" => CUser::GetID(), "ANC_TYPE" => 17)
	);
	$oElement = new CIBlockElement();
	$idElement = $oElement->Add($arFields, false, false, true); 
	$PRODUCT_IDS[]=$idElement;
}

if($_POST["post_text"]) {
	/*$fr = fopen($_SERVER['DOCUMENT_ROOT']."/logg.txt", 'a');
	fputs($fr, "???".var_export($_FILES["photo"], true)."!!!".var_export($PRODUCT_IDS, true));
	fclose($fr);*/
	CModule::IncludeModule("iblock");
	$arFields = array(
	   "IBLOCK_ID" => 1,
	   "NAME" => date("Y-m-d H:i", time()),
	   "PREVIEW_TEXT" => $_POST["post_text"],
	   "PROPERTY_VALUES" => array(
									"ANC_ID" => CUser::GetID(), 
									"ANC_TYPE" => 21,
									"CONTENT" => $PRODUCT_IDS
								)
	);
	$oElement = new CIBlockElement();
	$idElement = $oElement->Add($arFields, false, false, true); 
} 

LocalRedirect("/user/profile/");
?>