<?
	require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
	$APPLICATION->SetPageProperty("title", "Социальная сеть MYQUBE.RU");
	$APPLICATION->SetTitle("Социальная сеть MYQUBE.RU");

	if (!$USER->IsAuthorized()) {

		// Страница с формой авторизации

		$APPLICATION->SetPageProperty("page_class", "login");

		$APPLICATION->IncludeComponent(
			"bitrix:system.auth.form",
			"login",
			array(
				"FORGOT_PASSWORD_URL" => "",
				"SHOW_ERRORS" => "N"
			),
			false
		);

	} else {
		$APPLICATION->SetPageProperty("page_class", "welcome");
	}
	$APPLICATION->IncludeComponent("bitrix:news.list", "groups",
    	array(
		    "IBLOCK_ID"           => 4,
		    "NEWS_COUNT"          => "99999",
		    "SORT_BY1"            => "ID",
		    "SORT_ORDER1"         => "ASC",
		    "FIELD_CODE"          => "",
		    "PROPERTY_CODE"       => array('USERS', 'LIST_PICT'),
		    "DETAIL_URL"          => "/group/#SECTION_ID#/".$_GET['backurl'] ? "?backurl=" . $_GET['backurl'] : "",
		    "CACHE_TYPE"          => "A",
		    "DISPLAY_PANEL"       => "N",
		    "SET_TITLE"           => "N"
       ),
       false
    );
?>


<?/*
	<script src="//code.jquery.com/jquery-1.8.3.js"></script>
	<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
	<script src="/js/jquery.ui.touch-punch.min.js"></script>
	<script type="text/javascript" src="/js/plugins/jquery.slimscroll/jquery.slimscroll.min.js"></script>
	<script type="text/javascript" src="/js/web20/script.js"></script>
	<link type="text/css" rel="stylesheet" href="/css/group.css">
	<div class="enter_page">
		<style>
		@media screen and (max-device-width: 640px){
			body {
				overflow-y: hidden;
			}

			div.main {
				height: 100% !important;
				z-index: 100;
			}
		}
		</style>
		<script>
			$(function(){



				if ($( 'body' ).css('overflow-y')=='hidden'){
					var nua = navigator.userAgent;
					var chromeStart = nua.indexOf('Chrome/');
					var chrome = nua.slice(chromeStart+7,chromeStart+9);
					var is_android = (nua.indexOf('Android ') > -1 || nua.indexOf('Linux') > -1)&&(nua.indexOf('Mozilla/5.0') > -1);
					var old_mobile = (nua.indexOf('Version/4.0') > -1);

					if (is_android){

						if((chrome<20&&chrome>1)||old_mobile){
							function customScaleThisScreen(){
							var contentWidth = document.body.scrollWidth,
								windowWidth = window.innerWidth,
								newScale = windowWidth / contentWidth;
							document.body.style.zoom = newScale/2;
							};
							customScaleThisScreen();
						}
					};
				}
			  $(".enter_page_rightcol_img").click(function(){
				$(".enter_page_leftcol").animate({"left":"0"}, 1000);
				$("body").css('overflow-y','hidden');
			  });
			  $(".header-reg-mobile-up-left").click(function(){
				$(".enter_page_leftcol").animate({"left":"-100%"}, 1000);
				$("body").css('overflow','auto');
			  });
			});
		</script>

		<div id="window_invite_group">
			<div class="header_invite">Для вступления в эту группу необходимо подать заявку</div>
			<div class="button_invite"><span>Введите ваш email.</span>
				<input type="text" style="padding: 5px 10px; width: 70%; margin: 10px 0 25px; text-align:center;" placeholder="E-mail">
				<button class="closed_group_button" style="padding: 5px 10px 5px 10px; background-color: #fff; color: #052b4b; font-size: 15px; text-transform: uppercase; border: none; font-weight: bold;">Отправить</button>
			</div>
		</div>
		<div class="enter_page_rightcol">
	        <div class="enter_page_rightcol_img mobile-block">
	            <img src="<?=SITE_TEMPLATE_PATH?>/images/group-reg-small.jpg" alt="pic">
	        </div>
			<div id="scroll">
				<?
				CModule::IncludeModule("iblock");
				$arSelect = Array("ID", "IBLOCK_ID", "*");
				$arFilter = Array("IBLOCK_ID"=>4, "ACTIVE_DATE"=>"Y", "ACTIVE"=>"Y");
				$res = CIBlockElement::GetList(Array(), $arFilter, false, false, $arSelect);
				while($ob = $res->GetNextElement())
				{
					$arFields = $ob->GetFields();
					$arProps = $ob->GetProperties();
					$arGroups[$arFields["ID"]] = $arFields;
					$arGroups[$arFields["ID"]]["PROPERTIES"] = $arProps;
					if(!empty($_GET["backurl"]))
						$backurl = '?backurl='.$_GET["backurl"];
					else
						$backurl = '';
					?>
					<a href="/group/<?=$arFields["ID"]?>/<?=$backurl;?>" class="enter_page_group_item <?=($arFields["ID"]==1)?"":"closed_group";?>" style="background-image: url('<?=CFile::GetPath($arProps["LIST_PICT"]["VALUE"])?>');">
						<h1><?=$arFields["NAME"]?><br><?=$arProps["NAME_2"]["VALUE"]?></h1>
						<div class="enter_page_members"><img src="<?=SITE_TEMPLATE_PATH?>/images/members_icon.png"><?if($arProps["USERS"]["VALUE"]) echo $arProps["USERS"]["VALUE"]; else echo 0;?> Участников</div>
						<div class="enter_page_group_lock"><img src="<?=SITE_TEMPLATE_PATH?>/images/lock_group_icon.png"><br>Это закрытая группа</div>
					</a>
					<?
				}
				?>
			</div>
		<script>
		$('#scroll').slimScroll({
			color: '#00d6ff',
			size: '10px',
			width: '720px',
			height: '100%',
			distance: '10px',
			alwaysVisible: true
		});
		</script>
		</div>
		<style>
			.enter_page_user_name {font-size: 37px; color: #464646; text-align: center; line-height: 1.5;}
			.enter_page_user_links {margin: 5px 0; color: #7d7d7d;}
			.enter_page_user_links a {color: #7d7d7d;}
			.enter_page_user_links a:link, .enter_page_user_links a:hover {display: inline-block; width: 250px; height: 50px; margin-bottom: 15px; padding: 0 20px; border: 2px solid #d8d8d8; border-radius: 8px; background: #fff; color: #7d7d7d; font-family: GothamProBold; font-size: 12px; line-height: 25px; text-transform: uppercase; text-align: left; text-decoration: none;}
			.enter_page_user_links a:link img {vertical-align: middle;}
			.enter_page_user_links a:link img.arrow {display: none; padding-left: 20px;}
			.enter_page_user_links a:hover {border-color: #00d6ff;}
			.enter_page_user_links a:hover img.arrow {display: inline-block;}
			.enter_page_user_links_name {float: left; padding-top: 12px;}
			.enter_page_user_links_value {float: right; padding-top: 12px;}
		</style>
		<div class="enter_page_leftcol">
			<div class="enter_page_leftcol_cont">
				<?if($USER->IsAuthorized() && $USER->GetID() > 0)
				{
					$rsUser = $USER->GetByID($USER->GetID());
					$arUser = $rsUser->Fetch();
					//echo '<pre>'; print_r($arUser); echo '</pre>';
					?>
	                <style>
	                    .mobile-menu-ico{
	                        float: none;
	                    }
	                </style>

	                <div class="mobile-block mobile-menu-ico" id="menu-button" style="display: block;"></div>
	                <script>

	                   $("#menu-button").click(function(){
	                          if($("#nav_left_open").css('left') == '-165px'){
	                                                $("#nav_left_open").animate({ left: '0' }, 1200);
	                                                $("div.main").animate({ left: '165' }, 1200);
	                                             };
	                                             if($("#nav_left_open").css('left') == '0px'){
	                                                 $("#nav_left_open").animate({ left: '-165' }, 1200);
	                                                 $("div.main").animate({ left: '0' }, 1200);
	                                             };
	                    })
	                </script>
	                <img src="<?=CFile::GetPath($arUser["PERSONAL_PHOTO"])?>" style="border-radius: 50%; background-image: -moz-linear-gradient( 90deg, rgba(0,0,0,0) 0%, rgb(0,0,0) 100%); background-image: -webkit-linear-gradient( 90deg, rgba(0,0,0,0) 0%, rgb(0,0,0) 100%); background-image: -ms-linear-gradient( 90deg, rgba(0,0,0,0) 0%, rgb(0,0,0) 100%); box-shadow: 0px 2px 0px 0px rgba(255, 255, 255, 0.4), inset 0px 0px 10px 0px rgba(0, 0, 0, 0.4); width: 94px; height: 94px; margin-top: 30px;">
					<h1 class="enter_page_user_name"><?=$arUser["NAME"]." ".$arUser["LAST_NAME"]?></h1>
					<?if($arUser["PERSONAL_BIRTHDAY"]){?>
						<span><?=FormatDate(array("d" => 'j F'), MakeTimeStamp($arUser["PERSONAL_BIRTHDAY"]), time());?></span><br>
					<?}?>
					<?if($arUser["PERSONAL_CITY"]) {?>
						<span>Живет в <?=$arUser["PERSONAL_CITY"].", ".GetCountryByID($arUser["PERSONAL_COUNTRY"], "ru")?></span>
					<?}?>
					<div class="enter_page_user_links">
						<a href="/user/profile/">
							<div class="enter_page_user_links_name">Мой профиль</div>
							<div class="enter_page_user_links_value"><img src="<?=SITE_TEMPLATE_PATH?>/images/edition.png"> <img class="arrow" src="<?=SITE_TEMPLATE_PATH?>/images/link_arrow.png"></div>
						</a><br>
						<a href="/communication/">
							<div class="enter_page_user_links_name">Друзья</div>
							<div class="enter_page_user_links_value"><?=count($arUser["UF_FRIENDS"])?> <img class="arrow" src="<?=SITE_TEMPLATE_PATH?>/images/link_arrow.png"></div>
						</a><br>
						<a href="/user/groups/">
							<div class="enter_page_user_links_name">Группы</div>
							<div class="enter_page_user_links_value"><?if($arUser["UF_GROUPS"]) echo count($arUser["UF_GROUPS"]); else echo 0;?> <img class="arrow" src="<?=SITE_TEMPLATE_PATH?>/images/link_arrow.png"></div>
						</a><br>
						<!--a href="/user/contest/">
							<div class="enter_page_user_links_name">Конкурсы</div>
							<div class="enter_page_user_links_value">0 <img class="arrow" src="<?=SITE_TEMPLATE_PATH?>/images/link_arrow.png"></div>
						</a><br-->
					</div>
					<div style="display:inline-block;width:328px; margin: 10px 0;">
						<div style="">
							<div style="width: 50%;float: left;"><a href="/user/profile/?edit=y" style="text-decoration: none; color:#7d7d7d;"><img src="<?=SITE_TEMPLATE_PATH?>/images/settings.png" style="vertical-align: middle; padding-right: 10px;"> Настройки</a></div>
							<div style="width: 50%; float: left;"><a href="?logout=yes" style="text-decoration: none; color:#7d7d7d;"><img src="<?=SITE_TEMPLATE_PATH?>/images/exit.png" style="vertical-align: middle; padding-right: 10px;"> Выйти</a></div>
						</div>
					</div>
					<?
				} else {
					?>
					<!--<img class="q_back" src="/bitrix/templates/web20/images/myqube_bg_enterpage.png">-->
					<div class="container" style="display:none;">
						<div class="background-container"></div>
						<?include("group/ajax/1/manifest.php");?>
					</div>

	                     <link rel="stylesheet" href="/css/index-reg.css">
	                      <div class="mobile-block header-reg-mobile">
	                        <div class="header-reg-mobile-up">
	                            <a><div class="header-reg-mobile-up-left"></div></a>
	                            <div class="header-reg-mobile-up-logo"></div>
	                        </div>

	                    </div>
					<?
					$APPLICATION->IncludeComponent(
						"bitrix:system.auth.form",
						"myqube",
						array(
							"REGISTER_URL" => "/club/group/search/",
							"PROFILE_URL" => "/user/profile/",
							"FORGOT_PASSWORD_URL" => "",
							"SHOW_ERRORS" => "Y"
						),
						false
					);
				}?>
				<div class="enter_page_rights" id="enter_page_rights">
					© 2015 MyQube. Все права защищены.<br>
					Социальная сеть предназначена для лиц старше 18 лет
				</div>
			</div>
		</div>
	</div>
*/?>
<?
	require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");
?>
