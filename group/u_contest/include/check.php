<?
define('IBLOCK_ID', 28);
function checkExist($user, $email) {
    CModule::IncludeModule("iblock");
    $arSelect = Array("ID");
    $arFilter = Array("IBLOCK_ID" => IBLOCK_ID, array(
        "LOGIC" => "OR",
            array("PROPERTY_USER" => $user),
            array("PROPERTY_EMAIL" => $email),
        )
    );
    $res = CIBlockElement::GetList(Array(), $arFilter, false, false, $arSelect);
    return $res->Fetch();
}
?>
