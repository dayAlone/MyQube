<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");?>
<?
	CModule::IncludeModule("iblock");
	$id 	  = intval($_GET["id"]);
	$UID 	  = $USER->GetID();

	$ELEMENT_ID = 	$id;	
	CIBlockElement::Delete($ELEMENT_ID);
	
	echo "all ok ".$id;

?>