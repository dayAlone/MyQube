<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");
/*global $USER;
if(CModule::IncludeModule("iblock")){
	if(!empty($_POST["Latitude"]) && !empty($_POST["Longitude"]) && $USER->GetID() > 0){
		$NewElement = new CIBlockElement;
		$NewElement->Add(
			array(
				"IBLOCK_ID" => 21,
				"NAME" => $USER->GetLogin(),
				"ACTIVE" => "Y", 
				"PROPERTY_VALUES" => array(
					"80" => $USER->GetID(),
					"81" => $_POST["Latitude"],
					"82" => $_POST["Longitude"],
				)
			)
		);
	}
}*/
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/epilog_after.php");
?>