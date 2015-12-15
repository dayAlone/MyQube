<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Общение");
?>
<!-- <script type="text/javascript">
		$(function(){			
			$(".nav_text").show();
			$("#nav_left_open").css("width","170");
			$(".show_full_nav").addClass("show_full_nav_full");	
			})
	</script> -->
	 <link rel="stylesheet" href="../../css/communication-mobile.css">
	 <script type="text/javascript" src="<?=SITE_TEMPLATE_PATH?>/js/communication.js"></script>
	 <link rel="stylesheet" href="/css/cabinet.css">
	 <div class="shadow-profile-edit-popup" id="shadow-friends-edit-popup" style="display:none; z-index: 101;">
		<div id="shadow-new-friens-popup" class="shadow-new-friens-popup"></div>
	</div>

<?
/*$APPLICATION->IncludeComponent("bitrix:menu", "top_line", Array(
	"ROOT_MENU_TYPE"	=>	"left",
	"MAX_LEVEL"	=>	"1",
	"CHILD_MENU_TYPE"	=>	"left",
	"USE_EXT"	=>	"Y",
	"MENU_CACHE_TYPE" => "A",
	"MENU_CACHE_TIME" => "3600",
	"MENU_CACHE_USE_GROUPS" => "Y",
	"MENU_CACHE_GET_VARS" => array(
		0 => "SECTION_ID",
		1 => "page",
	),
	"LAST_LINK" => array(
		"NAME" => "НАПИСАТЬ",
		"STYLE" => "style='color:red;'",
		"LINK" => "/communication/new"
	)
	)
);*/
$friend_in = intval($_GET['friend_in']);

$APPLICATION->IncludeComponent("bitrix:menu", "top_line_communication", Array(
	"ROOT_MENU_TYPE" => "left",	// Тип меню для первого уровня
		"MAX_LEVEL" => "1",	// Уровень вложенности меню
		"CHILD_MENU_TYPE" => "left",	// Тип меню для остальных уровней
		"USE_EXT" => "Y",	// Подключать файлы с именами вида .тип_меню.menu_ext.php
		"MENU_CACHE_TYPE" => "A",	// Тип кеширования
		"MENU_CACHE_TIME" => "3600",	// Время кеширования (сек.)
		"MENU_CACHE_USE_GROUPS" => "Y",	// Учитывать права доступа
		"MENU_CACHE_GET_VARS" => array(	// Значимые переменные запроса
			0 => "SECTION_ID",
			1 => "page",
		),
		"search" => "y"
	),
	false
);

if($friend_in>0)
	$AR_FILTER = Array("PROPERTY_USER_IN"=>Array($USER->GetID(),$friend_in),"CREATED_BY"=>Array($USER->GetID(),$friend_in));
else
	$AR_FILTER = Array("CREATED_BY"=>$USER->GetID());
//	$AR_FILTER = Array("PROPERTY_USER_IN"=>Array(-1),"CREATED_BY"=>Array(-1));
	
	$APPLICATION->IncludeComponent("bitrix:news.list", "correspondence", Array(
	"COMPONENT_TEMPLATE" => "correspondence",
		"IBLOCK_TYPE" => "comments",	// Тип информационного блока (используется только для проверки)
		"IBLOCK_ID" => "12",	// Код информационного блока
		"NEWS_COUNT" => "100",	// Количество новостей на странице
		"SORT_BY1" => "ID",	// Поле для первой сортировки новостей
		"SORT_ORDER1" => "ASC",	// Направление для первой сортировки новостей
		"SORT_BY2" => "SORT",	// Поле для второй сортировки новостей
		"SORT_ORDER2" => "ASC",	// Направление для второй сортировки новостей
		"FILTER_NAME" => "AR_FILTER",	// Фильтр
		"FIELD_CODE" => array(	// Поля
			0 => "PREVIEW_TEXT",
			1 => "DATE_CREATE",
			2 => "CREATED_BY",
			3 => "CREATED_USER_NAME",
		),
		"PROPERTY_CODE" => array(	// Свойства
			0 => "USER_IN",
		)
	),
	false
);
?>
<?
			$APPLICATION->IncludeComponent(
			"bitrix:main.include",
			"",
			Array(
				"COMPONENT_TEMPLATE" => ".default",
				"AREA_FILE_SHOW" => "file",
				"AREA_FILE_SUFFIX" => "inc",
				"EDIT_TEMPLATE" => "",
				"PATH" => "/chat/index.php"
			)
		);?>
<br><?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>