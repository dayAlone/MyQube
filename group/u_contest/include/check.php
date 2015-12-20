<?
define('IBLOCK_ID', 28);
function checkExist($user) {
    CModule::IncludeModule("iblock");
    $arSelect = Array("ID");
    $arFilter = Array("IBLOCK_ID" => IBLOCK_ID, 'PROPERTY_USER' => $user);
    $res = CIBlockElement::GetList(Array(), $arFilter, false, false, $arSelect);
    return $res->Fetch();
}
?>
