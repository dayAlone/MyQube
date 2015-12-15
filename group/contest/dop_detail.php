<link rel="stylesheet" href="/css/competition-photo-preview.css">
<style>
	#TEXT {
		color: #898989;
	}
	.like-menu {
		float:right;
	}
	a.likes {
		margin-top:1px !important;
	}
	.comments-wrap {
		margin-left:10px;
	}
	.right-block-inner {
		width:540px; 
		margin:0 auto;
	}
	.right-block {
		width:740px !important;
	}
</style>
<script>
	$(document).ready(function() {
		$('body').on('click', '.accept_event', function() {
			var id = $(this).parent().attr("data-id");
			BX.ajax.get(
				"/group/contest/ajax.php?go="+id,
				function (res){
					$("#accept-enter").hide();
					$("#accept-exit").show();
				}
			);
		});
		$('body').on('click', '#accept-exit', function() {
			var id = $(this).parent().attr("data-id");
			BX.ajax.get(
				"/group/contest/ajax.php?leave="+id,
				function (res){
					$("#accept-enter").show();
					$("#accept-exit").hide();
				}
			);
		});
		
		$("#accept-exit").mouseover(function(){
			$(this).html("Выйти из участия в конкурсе");
			$(this).addClass( "accept-exit" );
		});
		$("#accept-exit").mouseout(function(){
			$(this).html("Вы уже участвуете в конкурсе");
			$(this).removeClass( "accept-exit" );
		});
		$('.contest_info .close').click(function(){
					$('.contest_info').fadeOut();
				});
	/*	$("#accept-exit").click(function(){alert("123");
			$(this).hide();
			$("#accept-enter").show();
		});*/
	});
	function openPopup_page(x){
		$("."+x).fadeIn();
			} 
	/*(function () {
		var enter = document.getElementById("accept-enter");
		var exit = document.getElementById("accept-exit"); 
		enter.addEventListener('click', function(){
			enter.style.display = 'none';
			exit.style.display = 'block';
		});
		exit.addEventListener('click', function(){
			exit.style.display = 'none';
			enter.style.display = 'inline-block';
		});


	})()*/
</script>
<? 
	CModule::IncludeModule("iblock");
	if($_GET["page"])
		$page = $_GET["page"];
	if($_GET["filter"])
		$filter = $_GET["filter"];
	$event_id = $_GET["POST_ID"];
	$res = CIBlockElement::GetList(array(), array("IBLOCK_ID" => 3, "ID" => $event_id));
	while($arRes = $res->GetNextElement()){
		$arItem = $arRes->GetFields();
		$arItem["PROPERTIES"] = $arRes->GetProperties();
		$arEvent = $arItem;
	}
	$APPLICATION->SetPageProperty("title", $arEvent["NAME"]);
	$APPLICATION->SetPageProperty("description", $arEvent["PROPERTIES"]["OG_DESCRIPTION"]["VALUE"]["TEXT"]);
	$APPLICATION->SetPageProperty("og:title", $arEvent["NAME"]);
	$APPLICATION->SetPageProperty("og:description", $arEvent["PROPERTIES"]["OG_DESCRIPTION"]["VALUE"]["TEXT"]);
	$APPLICATION->SetPageProperty("og:image", "http://myqube.ru".CFile::GetPath($arEvent["PROPERTIES"]["OG_IMAGE"]["VALUE"]));
?>

	<div class="main-head">
		<div class="main-menu">
			<a class="gallery_back" href="/group/<?=$arGroup["ID"]?>/contest/??filter=<?=$filter?>&page=<?=$page?>#event-<?=substr($event_id, 0, strripos($event_id, "?"))?>"></a>
		</div>
		<div class="main-text"><?=$arEvent["NAME"]?></div>
	</div>
	<div style="position: relative; text-align: left;">
<div class="left-block">
			<!-- Три иконки справа -->
			<?if($DB->CompareDates($arEvent["PROPERTIES"]["END_DATE"]["VALUE"], date("d.m.Y H:i", time())) == 1){?>
			
				<div class="people-number">В конкурсе участвует <span class="text-blue">
					<?if(!empty($arEvent["PROPERTIES"]["ANC_ID"]["VALUE"])) echo count($arEvent["PROPERTIES"]["ANC_ID"]["VALUE"]); else echo 0;?> человек
				</span></div>
				<div class="accept" data-id="<?=$arEvent["ID"]?>">
					<button id="accept-enter" class="accept_event"<?if(in_array($USER->GetID(), $arEvent["PROPERTIES"]["ANC_ID"]["VALUE"])) echo ' style="display:none;"'; else echo ' style="display:block;"';?>>Участвовать</button>
					<button id="accept-exit"<?if(in_array($USER->GetID(), $arEvent["PROPERTIES"]["ANC_ID"]["VALUE"])) echo ' style="display:block;"'; else echo ' style="display:none;"';?>>Вы уже участвуете в конкурсе</button>
				</div>
				<div class="clear"></div>
				<div class="info-block">
					<div class="info-block-head">Даты проведения</div>
					<div class="info-block-text">
						<?if(FormatDate(array("d" => 'F'), MakeTimeStamp($arEvent["PROPERTIES"]["START_DATE"]["VALUE"], "DD.MM.YYYY HH:MI:SS")) ==
						FormatDate(array("d" => 'F'), MakeTimeStamp($arEvent["PROPERTIES"]["END_DATE"]["VALUE"], "DD.MM.YYYY HH:MI:SS")))
							echo FormatDate(array("d" => 'j - '), MakeTimeStamp($arEvent["PROPERTIES"]["START_DATE"]["VALUE"], "DD.MM.YYYY HH:MI:SS"));
						else
							echo FormatDate(array("d" => 'j F - '), MakeTimeStamp($arEvent["PROPERTIES"]["START_DATE"]["VALUE"], "DD.MM.YYYY HH:MI:SS"));
						echo FormatDate(array("d" => 'j F'), MakeTimeStamp($arEvent["PROPERTIES"]["END_DATE"]["VALUE"], "DD.MM.YYYY HH:MI:SS"))?>
						<? echo " ".date('Y', MakeTimeStamp($arEvent["PROPERTIES"]["END_DATE"]["VALUE"], "DD.MM.YYYY HH:MI:SS"));?>	
					</div>
				</div>
				<div class="info-block">
					<div class="info-block-head">Описание конкурса:</div>
					<div class="info-block-text"><?=$arEvent["PREVIEW_TEXT"]?>
						<br>
						*подробнее об условиях участия в конкурсе читайте <a title="Подробно о конкурсе" href="#" onclick="openPopup_page('contest_info')">здесь</a>
						<div class="privacy-window contest_info" style="display:none;">
							<div class="wrap-privacy">
								<div class="privacy-text">
									<?=$arEvent["PROPERTIES"]["CONTEST_INFO"]["~VALUE"]["TEXT"] ?>
								</div>
							</div>
							<div class="privacy-shadow"></div>
							<div class="privacy-button"><button class="close">ЗАКРЫТЬ</button></div>
						</div>
					</div>
				</div>
				<div class="info-block">
					<div class="info-block-head">Призы организаторов</div>
					<div class="info-block-text">
						<?=$arEvent["PROPERTIES"]["PRIZES"]["~VALUE"]["TEXT"] ?>
					</div>
				</div>
				<div class="info-block">
					<div class="info-block-text">
					</div>
				</div>

			<?} else {?>
				<div class="competition-end">Конкурс окончен</div>

				<div class="info-block">
						<div class="info-block-head">Победители конкурса</div>
						<div class="info-block-text">
							I место - IMAC25
						</div>
						<div class="info-block-avatar">
							<div class="user-photo" id="user-3"></div>
							<div class="right-text">
								<div class="user-name">Дима</div>
							</div>
							<div class="avatar-info">
									<div class="users-icon"></div>
									<div class="comments-icon2"></div>
							</div>
						</div>
					</div>

					<div class="info-block">
						<div class="info-block-text">
							II место - IMAC25
						</div>
						<div class="info-block-avatar">
							<div class="user-photo" id="user-4"></div>
							<div class="right-text">
								<div class="user-name">Антон</div>
							</div>
							<div class="avatar-info">
									<div class="users-icon"></div>
									<div class="comments-icon2"></div>
							</div>
						</div>
					</div>

					<div class="info-block">
						<div class="info-block-text">
							III место - IMAC25
						</div>
						<div class="info-block-avatar">
							<div class="user-photo" id="user-2"></div>
							<div class="right-text">
								<div class="user-name">Артур</div>
							</div>
							<div class="avatar-info">
									<div class="users-icon"></div>
									<div class="comments-icon2"></div>
							</div>
						</div>
					</div>
					<div class="info-block">
						<div class="info-block-head">Описание конкурса</div>
						<div class="info-block-text"><?=$arEvent["PREVIEW_TEXT"]?></div>
					</div>
			<?}?>
		</div>
		<!-- Правый блок с текстом и каментами -->
		<div class="right-block"><div class="right-block-inner">
		<? /*echo "<xmp>"; print_r($arEvent); echo "</xmp>";*/?>
		<img src="<?=CFile::GetPath($arEvent["DETAIL_PICTURE"])?>" width="540">
			<div class="like-menu">
					<?
							$res_like = CIBlockElement::GetList(array(), array("IBLOCK_ID" => 6, "PROPERTY_LIKE" => $arEvent['ID'], "PROPERTY_USER" => $USER->GetID() ),array());	
							$GLOBALS['gl_active'] = $res_like;
							$GLOBALS['gl_like_id'] = "like_post_".$arEvent["ID"];
							$GLOBALS['gl_like_numm'] = intval($arEvent["PROPERTIES"]["LIKES"]["VALUE"]);
							$GLOBALS['gl_like_param'] = "event_id";
							$GLOBALS['gl_like_js'] = ($GLOBALS['gl_like_js']==1)?0:1;
							$GLOBALS['gl_like_url'] = "/group/events/like_event.php";
							$APPLICATION->IncludeComponent("bitrix:main.include","",Array(
								"AREA_FILE_SHOW" => "file", 
								"PATH" => "/like.php"
								)
							);
						?>
					<div class="comments-wrap">
								<div class="comments-icon"></div>
								<div class="comments-number"><?=intval($arEvent["PROPERTIES"]["COMMENTS_COUNT"]["VALUE"])?></div>
							</div>
					<? if($arEvent["PROPERTIES"]["SHARE"]["VALUE"]=='Y'):?>
								<div style="display:inline-block;">
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
							<?endif;?>
			</div>
		<!-- Заголовок каментов--><?$APPLICATION->IncludeComponent("smsmedia:comments", "myqube_event", Array(
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
		</div></div>
</div>

	<!--script type="text/javascript">
	// Меняем кнопку события
	(function () {
		var enter = document.getElementById("accept-enter");
		var exit = document.getElementById("accept-exit"); 
		enter.addEventListener('click', function(){
			enter.style.display = 'none';
			exit.style.display = 'block';
		});
		exit.addEventListener('click', function(){
			exit.style.display = 'none';
			enter.style.display = 'inline-block';
		});


	})()

	</script-->