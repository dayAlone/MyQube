<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");
CModule::IncludeModule("iblock");//"><PROPERTY_DATE_FROM" => array(date("Y-m-d H", strtotime("+5 hour")).":20:00", date("Y-m-d H", strtotime("+6 hour")).":20:00")
$res = CIBlockElement::GetList(array(), array("IBLOCK_ID" => 21, "ACTIVE" => "Y", "ID" => 9326));
while($ob = $res->GetNextElement()) {
	$arFields = $ob->GetFields();
	$arProps = $ob->GetProperties();
	echo $arFields["ID"]."<br>";
	if($arFields["ID"] > 0) {
		$STRING_CODE = "";
		$res = CIBlockElement::GetList(array(), array("IBLOCK_ID" => 20, "PROPERTY_PERFORMANCE" => $arFields["ID"]));
		while($ob = $res->GetNextElement()) {
			$arFieldsCode = $ob->GetFields();
			$arPropsCode = $ob->GetProperties();
			$user = $USER->GetByID($arPropsCode["USER"]["VALUE"])->Fetch();
			$STRING_CODE = $STRING_CODE."<tr>
					<td style='border-bottom: 1px solid; padding: 5px;'>".$arFieldsCode['NAME']."</td>
					<td style='border-bottom: 1px solid; padding: 5px;'>".$user['NAME']." ".$user['LAST_NAME']."</td>
				</tr>";
		}
		$eventFields = array(
			"EMAIL" => $arProps["EMAIL"]["VALUE"],
			"NAME_PERFORMANCE" => $arFields["NAME"],
			"DATE_FROM" => date("d.m.Y H:i", strtotime($arProps["DATE_FROM"]["VALUE"])),
			"STRING_CODE" => $STRING_CODE
		);
		$eventFields_al = array(
			"EMAIL" => "al@liskovas.com",
			"NAME_PERFORMANCE" => $arFields["NAME"],
			"DATE_FROM" => date("d.m.Y H:i", strtotime($arProps["DATE_FROM"]["VALUE"])),
			"STRING_CODE" => $STRING_CODE
		);
		//CEvent::SendImmediate("DEADLINE_PERFORMANCE", "s1", $eventFields, $Duplicate = "N", $message_id="35");
		//CEvent::SendImmediate("DEADLINE_PERFORMANCE", "s1", $eventFields_al, $Duplicate = "N", $message_id="35");
		echo "send";
	} else {
		echo "no send";
	}
}
?>