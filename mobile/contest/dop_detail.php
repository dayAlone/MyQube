<link rel="stylesheet" href="/css/competition-photo-preview.css">
<style>
	#TEXT {
		color: #898989;
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
	/*	$("#accept-exit").click(function(){alert("123");
			$(this).hide();
			$("#accept-enter").show();
		});*/
	});
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
	$_SESSION["BackFromDetail"]["group_6"]["nPageSize"] = $_GET["page"];
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
			<a class="gallery_back" href="/group/<?=$arGroup["ID"]?>/contest/"></a>
		</div>
		<div class="main-text"><?=$arEvent["NAME"]?></div>
	</div>
	<div style="position: relative; text-align: left;">
<div class="left-block">
			<!-- Три иконки справа -->
			<div class="like-menu">
					<a class="likes <?=($res_like>0)?"active":""?>"></a>
					<div class="comments-wrap">
								<div class="comments-icon"></div>
								<div class="comments-number"><?=intval($arEvent["PROPERTIES"]["COMMENTS_COUNT"]["VALUE"])?> комментариев</div>
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
					</div>
				</div>
				<div class="info-block">
					<div class="info-block-head">Описание конкурса:</div>
					<div class="info-block-text"><?=$arEvent["PREVIEW_TEXT"]?></div>
				</div>
				<div class="info-block">
					<div class="info-block-head">Призы организаторов</div>
					<div class="info-block-text">
						I место - IMAC 25<br>
						II место - IPhone 6Plus<br>
						III место - Блок сигарет Kent<br>
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
		<div class="right-block">
		<? /*echo "<xmp>"; print_r($arEvent); echo "</xmp>";*/?>
		<img src="<?=CFile::GetPath($arEvent["PREVIEW_PICTURE"])?>" width="540">
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
		</div>
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