<?
	require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
	//require_once($_SERVER['DOCUMENT_ROOT'].'/bitrix/modules/main/include/prolog_before.php');
	$APPLICATION->SetPageProperty("title", "Социальная сеть MYQUBE.RU");
	$APPLICATION->SetTitle("Социальная сеть MYQUBE.RU");
	/*
	CModule::IncludeModule("iblock");
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
		$logLike::add(
				array(
					'UF_USER'        => intval($user["ID"]),
					'UF_AMPLIFIER'   => intval($user['UF_USER_PARENT']),
					'UF_EVENT'       => 0,
					'UF_DATE_TIME'   => date("Y-m-d H:i:s"),
					'UF_ACTION_CODE' => 103,
					'UF_ACTION_TEXT' => "change_status",
					'UF_TYPE'        => $user['UF_STATUS'] ? $types[0][$flipFields[$user['UF_STATUS']]] : 1,
					'UF_TYPE_2'      => $types[1][$newStatus]
				)
			);
	}

	$APPLICATION->IncludeComponent("radia:likes","",Array(
        "ELEMENT" => "1",
    ));
	die();
	*/
	if (!$USER->IsAuthorized()) {

		// Страница с формой авторизации

		$APPLICATION->SetPageProperty("page_class", "page--login");

		$APPLICATION->IncludeComponent(
			"bitrix:system.auth.form",
			"login",
			array(
				"FORGOT_PASSWORD_URL" => "",
				"SHOW_ERRORS" => "Y"
			),
			false
		);

	} else if ($USER->IsAuthorized() && $USER->GetID() > 0) {

		// Страница с профилем

		$APPLICATION->SetPageProperty("page_class", "page--welcome");
		$APPLICATION->IncludeComponent("bitrix:main.profile",
			"welcome",
			Array(
		        "USER_PROPERTY_NAME" => "",
		        "USER_PROPERTY" => Array('UF_FRIENDS'),
		        "SEND_INFO" => "Y",
		        "CHECK_RIGHTS" => "N",
	    	)
		);
	}
	$APPLICATION->IncludeComponent("bitrix:news.list", "groups",
    	array(
		    "IBLOCK_ID"           => 4,
		    "NEWS_COUNT"          => "99999",
		    "SORT_BY1"            => "ID",
		    "SORT_ORDER1"         => "ASC",
		    "FIELD_CODE"          => "",
		    "PROPERTY_CODE"       => array('USERS', 'LIST_PICT'),
		    "DETAIL_URL"          => "/group/#ELEMENT_ID#/",
		    "CACHE_TYPE"          => "N",
			"CACHE_NOTES"         => $USER->IsAuthorized(),
		    "DISPLAY_PANEL"       => "N",
		    "SET_TITLE"           => "N"
       ),
       false
    );

	require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");
?>
