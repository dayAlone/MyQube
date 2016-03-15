<?
    require_once($_SERVER['DOCUMENT_ROOT'].'/bitrix/modules/main/include/prolog_before.php');
    use Bitrix\Highloadblock as HL;
	use Bitrix\Main\Entity;
    CModule::IncludeModule("main");
    CModule::IncludeModule("iblock");


	/*
    require($_SERVER['DOCUMENT_ROOT'] . '/includes/helpers.php');

    // Создание шаблонов

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

    // Создание свойства пользователя

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

    // Создание доп полей

    addValueToList('UF_STATUS', 'USER', array(
        "VALUE"  => "Конверсивный завершенный",
        "XML_ID" => 6
    ));
    addValueToList('UF_TYPE', 'HLBLOCK_2', array(
        "VALUE"  => "Конверсивный завершенный",
        "XML_ID" => 6
    ));
    addValueToList('UF_TYPE_2', 'HLBLOCK_2', array(
        "VALUE"  => "Конверсивный завершенный",
        "XML_ID" => 6
    ));


    // Приготовления к лайкам

    $raw = CUserTypeEntity::GetList( array($by=>$order), array('ENTITY_ID' => 'HLBLOCK_1','FIELD_NAME' => 'UF_TIME') )->Fetch();
    if (!$raw) {
        $ob = new CUserTypeEntity();
        $arFields = array(
            'ENTITY_ID'     => 'HLBLOCK_1',
            'FIELD_NAME'    => 'UF_TIME',
            'USER_TYPE_ID'  => 'datetime',
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

    $raw = CUserTypeEntity::GetList( array($by=>$order), array('ENTITY_ID' => 'HLBLOCK_1','FIELD_NAME' => 'UF_LIKE') )->Fetch();
    $ob = new CUserTypeEntity();
    $res = $ob->Delete($raw['ID']);

    $raw = CUserTypeEntity::GetList( array($by=>$order), array('ENTITY_ID' => 'HLBLOCK_1','FIELD_NAME' => 'UF_ELEMENT_ID') )->Fetch();
    $ob = new CUserTypeEntity();
    $res = $ob->Delete($raw['ID']);

    $ob = new CUserTypeEntity();
    $arFields = array(
        'ENTITY_ID'     => 'HLBLOCK_1',
        'FIELD_NAME'    => 'UF_ELEMENT_ID',
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

    $files = array();
    $rs = CIBlockElement::GetList (
		Array("ID" => "ASC"),
		Array("IBLOCK_ID" => 7),
		false,
		false,
		array('ID', 'NAME', 'PROPERTY_PHOTO')
	);
    while ($item = $rs->Fetch()) {
        $files[] = $item['PROPERTY_PHOTO_VALUE'];
    }

    $rs = CIBlockElement::GetList (
		Array("ID" => "ASC"),
		Array("IBLOCK_ID" => 6),
		false,
		false,
		array('ID', 'NAME', 'PROPERTY_LIKE', 'PROPERTY_USER', 'DATE_CREATE')
	);

	$hbLike     = HL\HighloadBlockTable::getById(1)->fetch();
	$entityLike = HL\HighloadBlockTable::compileEntity($hbLike);
	$logLike    = $entityLike->getDataClass();

	while ($item = $rs->Fetch()) {
        if (intval($item['PROPERTY_USER_VALUE']) > 0 && strlen($item['PROPERTY_LIKE_VALUE']) > 0) {
    		$res = $logLike::add(
    				array(
    					'UF_USER_ID'    => $item['PROPERTY_USER_VALUE'],
    					'UF_TIME'       => $item['DATE_CREATE'],
    					'UF_ELEMENT_ID' => (in_array($item['PROPERTY_LIKE_VALUE'], $files) ? 'photo_' : '') .$item['PROPERTY_LIKE_VALUE'],
    				)
    			);
        }
	}

    */
?>
