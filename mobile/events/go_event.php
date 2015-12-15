<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");?>
<?
	CModule::IncludeModule("iblock");
	$id = intval($_GET["event_id"]);
	$go		  = intval($_GET["go"]);
	$UID 	  = $USER->GetID();
	$ib_id = 2;
	
	$resObj = CIBlockElement::GetByID($id);
	$item = $resObj->GetNextElement(true, false);
	
	$propItems = $item->GetProperty("ANC_ID");
	if($go)
	{
		$prop = $propItems["VALUE"];
		$prop[] = $UID;
		$prop = array_unique($prop);
	}
	else
	{
		unset($prop[array_search($UID, $prop)]);
	}
	$ok = CIBlockElement::SetPropertyValues($id, $ib_id, $prop, "ANC_ID");	
	if($go)
	{
		echo "Я иду";
	}
	else
	{
		echo "Я пойду";
	}
?>