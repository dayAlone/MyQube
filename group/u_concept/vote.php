<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");
CModule::IncludeModule("iblock");
//$id = intval(str_replace("project_","",$_POST["id"]));
$res = CIBlockElement::GetList(array(), array("IBLOCK_ID" => 22, "PROPERTY_USER" => $USER->GetID()));
while($ob = $res->GetNextElement()) {
	$arFields = $ob->GetFields();
}
if($arFields["ID"] > 0) {
	echo 1;
} else {
	echo 0;
}
?>