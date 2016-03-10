<?
function page_class()
{
    global $APPLICATION;
    if($APPLICATION->GetPageProperty('page_class')) {
        return $APPLICATION->GetPageProperty('page_class');
    }
}
function svg($value='')
{
    $path = $_SERVER["DOCUMENT_ROOT"]."/layout/images/svg/".$value.".svg";
    return file_get_contents($path);
}
function pluralize($num, $arEnds) {

    if (strlen($num)>1 && substr($num, strlen($num)-2, 1)=="1")
    {
        return $arEnds[0];
    }
    else
    {
        $c = IntVal(substr($num, strlen($num)-1, 1));
        if ($c==0 || ($c>=5 && $c<=9))
            return $arEnds[1];
        elseif ($c==1)
            return $arEnds[2];
        else
            return $arEnds[3];
    }
}
function getValuesList($field, $entity) {
    CModule::IncludeModule("main");
    $fields = array();
    $raw = CUserTypeEntity::GetList( array($by=>$order), array('FIELD_NAME' => $field, 'ENTITY_ID' => $entity) )->Fetch();
    $enum = CUserFieldEnum::GetList(array(), array("USER_FIELD_ID" => $raw['ID']));
    while($el = $enum->GetNext()) $fields[$el['XML_ID']] = $el;
    return $fields;
}

function addValueToList($field, $entity, $props) {
    $raw = CUserTypeEntity::GetList( array($by=>$order), array('FIELD_NAME' => $field, 'ENTITY_ID' => $entity) )->Fetch();
    $fields = array();
    $enum = CUserFieldEnum::GetList(array(), array("USER_FIELD_ID" => $raw['ID']));
    while($el = $enum->GetNext()) $fields[$el['XML_ID']] = $el;

    if (!isset($fields[$props['XML_ID']])) {
        $obEnum = new CUserFieldEnum;
        $obEnum->SetEnumValues($raw['ID'], array(
            "n0" => $props
        ));
    }
}


?>
