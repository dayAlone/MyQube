
/*
require($_SERVER['DOCUMENT_ROOT'] . '/includes/helpers.php');
$exist = false;
$templates = array();
$raw = CSite::GetTemplateList("s1");
while($tmp = $raw->Fetch()) {
    if ($tmp['TEMPLATE'] === 'myqube') $exist = true;
    $templates[] = $tmp;
}
if (!$exist) {
    $templates[] = array(
        'TEMPLATE' => 'myqube',
        'CONDITION' => "CSite::InDir('/signup/')"
    );
    $templates[] = array(
        'TEMPLATE' => 'myqube',
        'CONDITION' => '$_SERVER['SCRIPT_NAME'] === "/index.php"'
    );
    $templates[] = array(
        'TEMPLATE' => 'myqube',
        'CONDITION' => '(!$USER->IsAuthorized() && preg_match("/\/group\/\d\/post\//", $APPLICATION->GetCurPage()) > 0) || ($USER->IsAuthorized() && in_array($_GET["message"], array("checking_user_fields", "you_are_under_18", "birthday")))'
    );
    $templates[] = array(
        'TEMPLATE' => 'myqube',
        'CONDITION' => '(!$USER->IsAuthorized() && preg_match("/\/group\/\d\//", $APPLICATION->GetCurPage()) > 0)'
    );

    $obSite = new CSite;
    $obSite->Update("s1",
        array(
            'TEMPLATE' => $templates
        )
    );
}

$raw = CUserTypeEntity::GetList( array($by=>$order), array('FIELD_NAME' => 'UF_AUTH_TOKEN') )->Fetch();
if (!$raw) {
    $ob = new CUserTypeEntity();
    $arFields = array(
        'ENTITY_ID'     => 'USER',
        'FIELD_NAME'    => 'UF_AUTH_TOKEN',
        'USER_TYPE_ID'  => 'string',
        'XML_ID'        => '',
        'SORT'          => 100,
        'MULTIPLE'      => 'N',
        'MANDATORY'     => 'N',
        'SHOW_FILTER'   => 'N',
        'SHOW_IN_LIST'  => 'Y',
        'EDIT_IN_LIST'  => 'Y',
        'IS_SEARCHABLE' => 'N'
    );
    $FIELD_ID = $ob->Add($arFields);

}

addValueToList('UF_STATUS', 'USER', array(
    "VALUE"  => "Конверсивный завершенный",
    "XML_ID" => 6
));



$raw = CUserTypeEntity::GetList( array($by=>$order), array('ENTITY_ID' => 'HLBLOCK_1','FIELD_NAME' => 'UF_TIME') )->Fetch();
if (!$raw) {
    $ob = new CUserTypeEntity();
    $arFields = array(
        'ENTITY_ID'     => 'HLBLOCK_1',
        'FIELD_NAME'    => 'UF_TIME',
        'USER_TYPE_ID'  => 'string',
        'XML_ID'        => '',
        'SORT'          => 100,
        'MULTIPLE'      => 'N',
        'MANDATORY'     => 'Y',
        'SHOW_FILTER'   => 'N',
        'SHOW_IN_LIST'  => 'Y',
        'EDIT_IN_LIST'  => 'Y',
        'IS_SEARCHABLE' => 'N'
    );
    $FIELD_ID = $ob->Add($arFields);

}
*/
