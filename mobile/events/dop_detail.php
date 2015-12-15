<link type="text/css" rel="stylesheet" href="/css/events_detail.css">
<? 
	CModule::IncludeModule("iblock");
	$_SESSION["BackFromDetail"]["group_6"]["nPageSize"] = $_GET["page"];
	$event_id = $_GET["POST_ID"];
	$res = CIBlockElement::GetList(array(), array("IBLOCK_ID" => 2, "ID" => $event_id));
	while($arRes = $res->GetNextElement()){
		$arItem = $arRes->GetFields();
		$arItem["PROPERTIES"] = $arRes->GetProperties();
		$arEvent = $arItem;
	}
	$APPLICATION->SetPageProperty("title", $arEvent["NAME"]);
	$APPLICATION->SetPageProperty("description", $arEvent["PROPERTIES"]["OG_DESCRIPTION"]["VALUE"]["TEXT"]);
	$APPLICATION->SetPageProperty("og:title", $arEvent["NAME"]);
	$APPLICATION->SetPageProperty("og:description", $arEvent["PROPERTIES"]["OG_DESCRIPTION"]["VALUE"]["TEXT"]);
	$APPLICATION->SetPageProperty("og:image", CFile::GetPath($arEvent["PROPERTIES"]["OG_IMAGE"]["VALUE"]));
	
	//echo $arEvent["NAME"];
	
	//echo "<xmp>";print_r($arEvent);echo"</xmp>";
?>
		<script>
			$(function(){
				$( ".acccept button" ).click(function() {
				  $( this ).toggleClass( "active" );
					var path = host_url+"/group/events/go_event.php";
					$.get(path, {event_id: <?=$arEvent['ID']?>,go: Number($( this ).hasClass( "active" ))}, function(data){
						$( ".acccept button" ).html(data);
					});
				});
				$("a.likes" ).click(function() {
					$( this ).toggleClass( "active" );
					var path = host_url+"/group/events/like_event.php";
					$.get(path, {event_id: <?=$arEvent['ID']?>,like: Number($( this ).hasClass( "active" ))}, function(data){
					});
				});
			});
		</script>
		<div class="main-head">
			<div class="main-menu"><a href="/group/<?=$arGroup["ID"]?>/events/" class="back-link"></a></div>
			<div class="main-text"> <?=$arEvent["NAME"]?></div>
		</div>
		<div class="content">
			<div class="left-block">
				<!-- Три иконки справа -->
				<div class="like-menu">
						<!--<div class="like-ico"><img src="<?=SITE_TEMPLATE_PATH?>/images/like1.png" alt="pic"></div>
						<div class="comment-ico"><img src="<?=SITE_TEMPLATE_PATH?>/images/comment.png" alt="pic"></div>
						<div class="repost-ico"><img src="<?=SITE_TEMPLATE_PATH?>/images/repost.png" alt="pic"></div>-->
						<div class="bottom-small-menu">
							<!-- Кнопка лайков -->
							<?
								$res_like = CIBlockElement::GetList(array(), array("IBLOCK_ID" => 6, "PROPERTY_LIKE" => $arEvent['ID'], "PROPERTY_USER" => $USER->GetID() ),array());	
							?>
							<a class="likes <?=($res_like>0)?"active":""?>"></a>
							<!-- Блок комментариев -->
							<a class="comments-wrap" href="#comment_form_<?=$arEvent['ID']?>">
								<div class="comments-icon"></div>
								<div class="comments-number"><?=intval($arEvent["PROPERTIES"]["COMMENTS_COUNT"]["VALUE"])?> комментариев</div>
							</a>
							<!-- Обертка для соцкнопок и кнопки репоста -->
							<? if($arEvent["PROPERTIES"]["SHARE"]["VALUE"]=='Y'):?>
								<div style="float:left;">
									<?$APPLICATION->IncludeComponent(
										"bitrix:main.share", 
										"myqube_best", 
										array(
											"COMPONENT_TEMPLATE" => "myqube_best",
											"HIDE" => "N",
											"HANDLERS" => array(
												0 => "facebook",
												1 => "vk",
												2 => "Google",
											),
											"PAGE_URL" => $APPLICATION->GetCurPage(),
											"PAGE_TITLE" => $arEvent["NAME"],
											"SHORTEN_URL_LOGIN" => "",
											"SHORTEN_URL_KEY" => ""
										),
										false
									);?>
								</div>
								<!--<div class="socwrap">
									<div class="social-buttons"></div>
									<div class="socblock">
										<div class="facebook-icon"></div>
										<div class="blogger-icon"></div>
										<div class="google-icon"></div>
									</div>
								</div>-->
							<?endif;?>
						</div>
				</div>
				<div class="acccept">
					
					<?if(in_array($USER->GetID(), $arEvent["PROPERTIES"]["ANC_ID"]["VALUE"])) {?>
						<button class="active">Я иду</button>
					<?}else {
						?><button>Я пойду</button><?
					}?>
				</div>
				<div class="info-block">
					<div class="info-block-head">Название заведения:</div>
					<div class="info-block-text"><?=$arEvent["PROPERTIES"]["CLUB_NAME"]["VALUE"]?></div>
				</div>
				<div class="info-block">
					<div class="info-block-head">Выступают:</div>
					<div class="info-block-text"><?=$arEvent["PROPERTIES"]["ON_STAGE"]["VALUE"]["TEXT"]?></div>
				</div>
				<div class="info-block">
					<div class="info-block-head">Информация от организатора</div>
					<div class="info-block-text"><?=FormatDate(array("d" => 'j F H:i' ), strtotime($arEvent["PROPERTIES"]["START_DATE"]["VALUE"]))?></div>
				</div>
				<div class="info-block">
					<div class="info-block-head">Место</div>
					<div class="info-block-text"><?=$arEvent["PROPERTIES"]["PLACE_EVENT"]["VALUE"]?></div>
				</div>
			</div>
			<div class="right-block">
				<div class="main-img">
					<img src="<?=CFile::GetPath($arEvent["DETAIL_PICTURE"])?>" alt="main-img">
				</div>
				<div class="shadow-text">
				<div class="competition-text">
					<?=$arEvent["DETAIL_TEXT"]?>
				</div>
				<?$APPLICATION->IncludeComponent("smsmedia:comments", "myqube_event", Array(
					"OBJECT_ID" => $arEvent["ID"],	// ID объекта комментирования
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
				);?>				
			</div>
		</div>