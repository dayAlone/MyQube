<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");
CModule::IncludeModule("iblock");
$arPosts = array();
$iblock_id = 21;
if(!empty($_POST["performance"])) {	
	$ActUsers = CIBlockElement::GetList(array(), array("IBLOCK_ID" => 20, "PROPERTY_USER" => $USER->GetID()));
	while($obActUsers = $ActUsers->GetNextElement()) {
		$arActUsers = $obActUsers->GetFields();
	}
	if($arActUsers["ID"] > 0) {
		echo 2;
	} else {
		$performance = CIBlockElement::GetList(array(), array("IBLOCK_ID" => $iblock_id, "ID" => $_POST["performance"]));
		while($ob = $performance->GetNextElement()) {
			$arPerformance = $ob->GetFields();
			$arPerformance["PROPS"] = $ob->GetProperties();
		}
		if($DB->CompareDates($arPerformance["PROPERTIES"]["DATE_FROM"]["VALUE"], date("d.m.Y H:i:s", strtotime("+4 hours"))) != 1) {
			$countUsers = $arPerformance["PROPS"]["SEATS"];
			if($arPerformance["PROPS"]["SEATS"]["VALUE"] != 0) {
				$res = CIBlockElement::GetList(array(), array("IBLOCK_ID" => 20, "NAME" => $_POST["code"]));
				while($ob = $res->GetNextElement()) {
					$arFields = $ob->GetFields();
					$arProps = $ob->GetProperties();
				}
				if($arFields["ID"] > 0 && empty($arProps["USER"]["VALUE"])) {
					$el = new CIBlockElement;
					$PROP = array();
					$PROP[141] = $_POST["performance"];
					$PROP[142] = $USER->GetID();
					$PROP[145] = $arProps["AMBASSADOR"]["VALUE"];
					$PROP[160] = $_POST["phone"];
					$arLoadProductArray = Array(
						"PROPERTY_VALUES"=> $PROP
					);
					$res = $el->Update($arFields["ID"], $arLoadProductArray);	
					$countUsers["VALUE"]--;
					CIBlockElement::SetPropertyValues($_POST["performance"], $iblock_id, $countUsers["VALUE"], "SEATS");
					$arUser = $USER->GetByID($USER->GetID())->Fetch();
					$eventFields = array(
						"EMAIL" => $_POST["email"],
						"NAME" => $arUser["NAME"],
						"DATE" => date("H:i d.m.Y", strtotime($arPerformance["PROPS"]["DATE_FROM"]["VALUE"])),
						"QR_GIF" => "http://myqube.ru".CFile::GetPath($arFields["PREVIEW_PICTURE"])
					);
					CEvent::SendImmediate("PERFORMANCE", "s1", $eventFields, $Duplicate = "N", $message_id="33");
					echo 1;
				} else {
					echo 0;	//"Регистрация не удалась. Данный код уже был использован.";
				}
			} else {
				echo 0; //"Регистрация не удалась. Места закончились.";
			}
		} else {
			echo 3;
		}
	}
} else {
	echo 0;
}?>