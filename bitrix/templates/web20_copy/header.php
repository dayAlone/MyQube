<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?
/*$dir = $APPLICATION->GetCurDir(); 
if (!$USER->IsAuthorized() && $dir != "/"){
	header("Location: /");
	die();
	}*/
 ?>
<!doctype html>
	<html>
		<head>
			<?$APPLICATION->ShowHead()?>
			<title><?$APPLICATION->ShowTitle()?></title>
            <meta name="viewport" content="width=device-width, initial-scale=0.5, maximum-scale=0.5, user-scalable=no">
			<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.8.1/jquery.min.js"></script>
			<script type="text/javascript" src="<?=SITE_TEMPLATE_PATH?>/main.js"></script>
			<script type="text/javascript">
				$(function(){
						$(".show_full_nav").toggle(function() {
							$(".nav_text").show();
							$("#nav_left_open").animate({width: '170'});
							$(".show_full_nav").addClass("show_full_nav_full");
						}, function() {
							$(".nav_text").hide();
							$("#nav_left_open").animate({width: '53'});
							$(".show_full_nav").removeClass("show_full_nav_full");
						})
					})
			</script>
		</head>
		<body>
			<?$APPLICATION->ShowPanel();?>
			<div class="body">		
	
			<?
			/*	if($USER->IsAuthorized())
				{
					$APPLICATION->IncludeComponent("bitrix:menu", "main_menu", Array(
						"ROOT_MENU_TYPE" => "top",	// Тип меню для первого уровня
							"MAX_LEVEL" => "1",	// Уровень вложенности меню
							"USE_EXT" => "N",	// Подключать файлы с именами вида .тип_меню.menu_ext.php
							"MENU_CACHE_TYPE" => "A",	// Тип кеширования
							"MENU_CACHE_TIME" => "3600",	// Время кеширования (сек.)
							"MENU_CACHE_USE_GROUPS" => "N",	// Учитывать права доступа
							"MENU_CACHE_GET_VARS" => "",	// Значимые переменные запроса
							"COMPONENT_TEMPLATE" => "vertical_multilevel1",
							"CHILD_MENU_TYPE" => "left",	// Тип меню для остальных уровней
							"DELAY" => "N",	// Откладывать выполнение шаблона меню
							"ALLOW_MULTI_SELECT" => "N",	// Разрешить несколько активных пунктов одновременно
						),
						false
					);
				}*/
				?>  
				<div class="main"<?if(!$USER->IsAuthorized()) echo ' ';?>>
					<section>