<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");?>
<?
	$APPLICATION->IncludeComponent("smsmedia:comments", "myqube_event", Array(
			"OBJECT_ID" => $_GET["post_id"],	// ID объекта комментирования
			"OBJECT_ID_W" => $_GET["post_id_w"],
			"IBLOCK_TYPE" => "comments",	// Тип инфоблока
			"COMMENTS_IBLOCK_ID" => "5",	// ID инфоблока, в котором хранятся комментарии
			"LEFT_MARGIN" => "",	// Отступ для дочерних комментариев
			"SHOW_USERPIC" => "Y",	// Показывать аватар
			"SHOW_DATE" => "Y",	// Показывать дату комментария
			"SHOW_COUNT" => "Y",	// Показывать количество комментариев
			"CACHE_TYPE" => "A",	// Тип кеширования
			"CACHE_TIME" => "3600",	// Время кеширования (сек.)
			"NO_FOLLOW" => "Y",	// Добавить атрибут rel="nofollow" к ссылкам в комментариях
			"NO_INDEX" => "Y",	// Не индексировать комментрии
			"NON_AUTHORIZED_USER_CAN_COMMENT" => "N",	// Разрешить неавторизованным пользователям добавлять комменарии
			"USE_CAPTCHA" => "N",	// Показывать капчу для неавторизованных пользователей
			"AUTH_PATH" => "/auth/",	// Путь до страницы авторизации
			"COMPONENT_TEMPLATE" => "myqube"
		),
		false
	);
?>