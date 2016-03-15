<?
use Bitrix\Highloadblock as HL;
use Bitrix\Main\Entity;

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
function getValuesList($field, $entity, $prop = false) {
    CModule::IncludeModule("main");
    $fields = array();
    $raw = CUserTypeEntity::GetList( array($by=>$order), array('FIELD_NAME' => $field, 'ENTITY_ID' => $entity) )->Fetch();
    $enum = CUserFieldEnum::GetList(array(), array("USER_FIELD_ID" => $raw['ID']));
    while($el = $enum->GetNext()) {
        $fields[$el['XML_ID']] = !$prop ? $el : $el[$prop];
    }
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


function changeUserStatus($ID, $PARENT, $CURRENT, $NEW, $text) {

    CModule::IncludeModule("iblock");
	CModule::IncludeModule("highloadblock");
	global $APPLICATION;

    $fields = getValuesList('UF_STATUS', 'USER', 'ID');
    $flipFields = array_flip($fields);
    $types = array(getValuesList('UF_TYPE', 'HLBLOCK_2', 'ID'), getValuesList('UF_TYPE_2', 'HLBLOCK_2', 'ID'));

    $raw = new CUser;
    $raw->Update($ID, array('UF_INVITE_STATUS' => 1, 'UF_STATUS' => $fields[$NEW]));

    $hbKPI     = HL\HighloadBlockTable::getById(2)->fetch();
    $entityKPI = HL\HighloadBlockTable::compileEntity($hbKPI);
    $logKPI    = $entityKPI->getDataClass();

    $logKPI::add(
            array(
                'UF_USER'        => intval($ID),
                'UF_AMPLIFIER'   => intval($PARENT),
                'UF_EVENT'       => 0,
                'UF_DATE_TIME'   => date("Y-m-d H:i:s"),
                'UF_ACTION_CODE' => 103,
                'UF_ACTION_TEXT' => "change_status",
                'UF_TYPE'        => $CURRENT ? $types[0][$flipFields[$CURRENT]] : 1,
                'UF_TYPE_2'      => $types[1][$NEW]
            )
        );

    $hbLOG = HL\HighloadBlockTable::getById(4)->fetch();
    $entityLOG = HL\HighloadBlockTable::compileEntity($hbLOG);
    $logLOG = $entityLOG->getDataClass();
    $res = $logLOG::add(
        array(
            'UF_USER'        => intval($ID),
            'UF_AMPLIFIER'   => intval($PARENT),
            'UF_EVENT'       => 0,
            'UF_DATE_TIME'   => date("d.m.Y H:i:s", time()),
            "UF_ACTION_CODE" => 104,
            "UF_ACTION_TEXT" => $text,
            "UF_TYPE"        => $CURRENT ? $flipFields[$CURRENT] : 1,
            "UF_TYPE_2"      => $NEW
        )
    );
}

?>
