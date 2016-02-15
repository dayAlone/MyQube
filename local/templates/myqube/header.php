<? if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die(); ?>
<!DOCTYPE html><html lang='ru'>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1, maximum-scale=1">
  <meta name="apple-mobile-web-app-capable" content="yes">
  <meta name="mobile-web-app-capable" content="yes">
  <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
  <title>MyQube</title>
  <?
	$APPLICATION->SetAdditionalCSS("/layout/css/frontend.css", true);
	$APPLICATION->AddHeadScript('/layout/js/frontend.js');
	$APPLICATION->ShowHead();
	$APPLICATION->ShowViewContent('header');
  ?>
  <title><?$APPLICATION->ShowTitle()?></title>
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->
</head>
<body class='page page--<?=$APPLICATION->AddBufferContent("page_class");?>'>
	<div id="panel"><?$APPLICATION->ShowPanel();?></div>
    <?
        if($USER->IsAuthorized())
        {
            $APPLICATION->IncludeComponent(
            "bitrix:menu",
            "sidebar",
            array(
                "ROOT_MENU_TYPE"        => "top",
                "MAX_LEVEL"             => "1",
                "USE_EXT"               => "N",
                "MENU_CACHE_TYPE"       => "A",
                "MENU_CACHE_TIME"       => "3600",
                "MENU_CACHE_NOTES"      => $USER->GetID(),
                "MENU_CACHE_USE_GROUPS" => "N",
                "MENU_CACHE_GET_VARS"   => array(),
                "COMPONENT_TEMPLATE"    => "main_menu",
                "CHILD_MENU_TYPE"       => "left",
                "DELAY"                 => "N",
                "ALLOW_MULTI_SELECT"    => "N"
            ),
            false
            );
        }
    ?>
	<div class="wrap">
