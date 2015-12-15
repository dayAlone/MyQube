<script type="text/javascript" src="/js/main.js"></script>
<!--[if lt IE 9]>
	<script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
<![endif]-->
<link href="/css/main.css" type="text/css"  rel="stylesheet" />
<link type="text/css" rel="stylesheet" href="/css/events_detail.css">
<script>
$(function(){
	$("a.likes" ).click(function() {
					$( this ).toggleClass( "active" );
					var path = host_url+"/group/photo/like_post.php";
					$.get(path, {post_id: $(this).attr('id'),like: Number($( this ).hasClass( "active" ))}, function(data){
					});
				});
});
</script>
<style>
	.comments {
		display:none;
	}
	.gallery_comm_item_info {
		width:550px;
	}
</style>
<?
	CModule::IncludeModule("iblock");
	$_SESSION["BackFromDetail"]["group_6"]["nPageSize"] = $_GET["page"];
	$event_id = $_GET["POST_ID"];
	$res = CIBlockElement::GetList(array(), array("IBLOCK_ID" => 7, "ID" => $event_id));
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
		<div class="gallery">
			<h1>
				<a class="gallery_back" href="/group/<?=$arGroup["ID"]?>/photo/"></a>
				<?=$arEvent["NAME"]?>
				
				<?
					$res_like = CIBlockElement::GetList(array(), array("IBLOCK_ID" => 6, "PROPERTY_LIKE" => $arEvent['ID'], "PROPERTY_USER" => $USER->GetID() ),array());	
				?>
				<div style="float:right; width:250px;">
					<a id="photo_item_<?=$arEvent["ID"]?>" class="likes <?=($res_like>0)?"active":""?>"></a>
					<!-- Блок комментариев -->
					<div class="comments-wrap gallery_comments">
						<div class="comments-icon"></div>
						<div class="comments-number"><?=intval($arEvent["PROPERTIES"]["COMMENTS_COUNT"]["VALUE"])?> комментариев</div>
					</div>
					
					<?if($arEvent["PROPERTIES"]["SHARE"]["VALUE"] == "Y"){?>
						<div>
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
					<?}?>
				</div>
			</h1>
			<div class="gallery_leftcol">
				<div class="gallery_text">
					<?=$arEvent["DETAIL_TEXT"]?>
				</div>
				<div class="gallery_preview">
					<div class="gallery_open"></div>
					<div class="gallery_preview_cont">
							<div class="gallery_arrow_up"></div>
						<div class="gallery_preview_cont_cont">
							<div class="gallery_preview_cont_cont_cont">
								<?foreach($arEvent["PROPERTIES"]["PHOTO"]["VALUE"] as $key => $picture) {
									$image_small = CFile::ResizeImageGet($picture, array("width" => 125, "height" => 84));?>
									<a href="<?=CFile::GetPath($picture)?>" style="background: url('<?=$image_small["src"]?>') center center;"></a>
								<?}?>
							</div>
						</div>
						<div class="clear"></div>
						<div class="gallery_arrow_down"></div>
					</div>
				</div>
			</div>
			<div class="gallery_rightcol">
				<div class="gallery_photo_cont">
					<img src="<?=CFile::GetPath($arEvent["PROPERTIES"]["PHOTO"]["VALUE"][0])?>" id="gallery_photo">
					<div class="gallery_photo_gradient"></div>
				</div>
				<?
				$APPLICATION->IncludeComponent("smsmedia:comments", "myqube_event", Array(
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
		<script>
			$( ".gallery_open" ).click(function() {
				$( ".gallery_preview_cont" ).slideToggle( "slow", function() {
					if($( ".gallery_preview_cont" ).css("display")=="none"){
						$(".gallery_open").css("background-image", "url('/images/gallery_close.png')");
					}else{
						$(".gallery_open").css("background-image", "url('/images/gallery_open.png')");
					}
				});
			});

			var pos=(Math.ceil(($(".gallery_preview_cont_cont_cont").find("a").length)/3)-3)*100;
			//var scroll=$(".gallery_preview_cont_cont_cont").height()-$(".gallery_preview_cont_cont").height();
			//alert(scroll);

			$(".gallery_arrow_down").click(function() {
				$(".gallery_preview_cont_cont_cont").animate({
					top: "-=100"
				}, 500, function() {
					if($(".gallery_preview_cont_cont_cont").css("top")=="-100px"){
						$(".gallery_arrow_up").show();
					}
					if($(".gallery_preview_cont_cont_cont").css("top")=="0px"){
						$(".gallery_arrow_up").hide();
					}
					if($(".gallery_preview_cont_cont_cont").css("top")=="-"+pos+"px"){
						$(".gallery_arrow_down").hide();
					}
					if($(".gallery_preview_cont_cont_cont").css("top")=="-"+(pos-1)+"px"){
						$(".gallery_arrow_down").show();
					}		
					//alert($(".gallery_preview_cont_cont_cont").css("top"));
					//alert("-"+pos+"px");
				});
			});

			$(".gallery_arrow_up").click(function() {
				$(".gallery_preview_cont_cont_cont").animate({
					top: "+=100"
				}, 500, function() {
					if($(".gallery_preview_cont_cont_cont").css("top")=="-100px"){
						$(".gallery_arrow_up").show();
					}
					if($(".gallery_preview_cont_cont_cont").css("top")=="0px"){
						$(".gallery_arrow_up").hide();
					}
					if($(".gallery_preview_cont_cont_cont").css("top")=="-"+pos+"px"){
						$(".gallery_arrow_down").show();
					}
					if($(".gallery_preview_cont_cont_cont").css("top")=="-"+(pos-1)+"px"){
						$(".gallery_arrow_down").show();
					}			
				});
			});
			//$(".gallery_comments").hover(function() {
				//$( ".gallery_comments" ).find("span").show("slide", { direction: "right" }, 500);
			//});

			$(".gallery_comments").click(function(event) {
				event.preventDefault();
				if($( ".comments" ).css("display")=="none"){
					$(".gallery_comments").addClass("gallery_comments_active");
				}else{
					$(".gallery_comments").removeClass("gallery_comments_active");
				}
				$( ".comments" ).slideToggle(500, function(){});

				
				if ($( ".gallery_photo_cont" ).css("height")=="150px"){
					$( ".gallery_photo_cont" ).animate({
						height: $( "#gallery_photo" ).css("height")
					}, 500, function() {
						// Animation complete.
					});
				}else{
					$( ".gallery_photo_cont" ).animate({
						height: "150"
					}, 500, function() {
						// Animation complete.
					});
				}

				
				
			});
			$(".gallery_preview_cont_cont_cont").find("a").click(function(event) {
				event.preventDefault();
				$("#gallery_photo").attr("src", $(this).attr("href"));
			});
		</script>