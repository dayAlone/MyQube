<?
	require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
	$APPLICATION->SetPageProperty("title", "Социальная сеть MYQUBE.RU");
	$APPLICATION->SetTitle("Социальная сеть MYQUBE.RU");

	if (!$USER->IsAuthorized()) {

		// Страница с формой авторизации

		$APPLICATION->SetPageProperty("page_class", "page--login");

		$APPLICATION->IncludeComponent(
			"bitrix:system.auth.form",
			"login",
			array(
				"FORGOT_PASSWORD_URL" => "",
				"SHOW_ERRORS" => "N"
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
		        "CHECK_RIGHTS" => "Y",
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
