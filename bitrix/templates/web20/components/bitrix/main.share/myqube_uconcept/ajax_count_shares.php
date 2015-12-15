<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");

CModule::IncludeModule("iblock");
$sharesInGroup = CIBlockElement::GetProperty(4, 1, array("sort" => "asc"), Array("CODE"=>"SHARES"))->Fetch();
$sharesInGroup["VALUE"]++;
CIBlockElement::SetPropertyValues(1, 4, $sharesInGroup["VALUE"], "SHARES");
echo $sharesInGroup;
?>