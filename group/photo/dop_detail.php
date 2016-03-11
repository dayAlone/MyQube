<script type="text/javascript" src="/js/main.js"></script>
<script type="text/javascript" src="/js/image_loader.js"></script>
<!--[if lt IE 9]>
	<script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
<![endif]-->
<link href="/css/main.css" type="text/css"  rel="stylesheet" />
<link type="text/css" rel="stylesheet" href="/css/events_detail.css">
<link type="text/css" rel="stylesheet" href="/bitrix/templates/web20/components/smsmedia/comments/myqube_lenta/style.css">
<script type="text/javascript" src="/bitrix/templates/web20/components/smsmedia/comments/myqube_lenta/script.js"></script>
<style>
	.detail_picture_view {
		display: none;
		position: absolute;
		width: 100%;
		left: 0;
	}
	.popup_background {
		position:fixed;
		top:0;
		bottom:0;
		right:0;
		left:0;
		background:rgba(0,0,0,.7);
	}
	.popup_detail_picture_wrapper {
		/*width: 800px;*/
		margin: 0 auto;
	}
	.popup_detail_picture_wrapper img {
		position: absolute;
		max-width: 1000px;
		z-index: 99;
		left: 0;
		right: 0;
		top: 325px;
		bottom: 0;
		margin: auto;
	}
	#loaderImage {
		position:absolute;
		top:40%;
		left:48%;
		display:none;
	}
	/*.comments {
		display:none;
	}*/
	.gallery_comm_item_info {
		width:550px !important;
	}
	.comments {
		padding-left:40px;
	}
	.head-form-comment {
		width:90%;
		padding:0 auto;
	}
	.gallery_preview_cont .slimScrollBar {
		z-index:1 !important;
	}
	.slimScrollDiv {
		margin-top:0px !important;
		margin-bottom:-60px !important;
	}
	#comments_block {
		margin-top:70px;
		display:none;
	}
	a.likes {
		margin-top: 1px !important;
	}
	#like_box {
		width:60px;
		float: left;
	}

    @media screen and (max-device-width: 640px){
    .detail_picture_view{
        top: 240px !important;
    }
    .popup_detail_picture_wrapper img{
        top: 940px;
    }

    .gallery_nw_prev{
        left: 0px !important;
    }

    .gallery_nw_prev, .gallery_nw_next{
        background-position: center !important;
        width: 110px !important;
        height: 270px !important;
        top:18% !important;
        right: 0px !important;
    }

    .comments{
        margin: auto !important;
        padding: 0 !important;
    }


    }
    .comments_count {
		display:none;
	}
</style>
<script>
			$("body").on("click", "#gallery_photo", function(){
				$(".detail_picture_view").fadeIn();
				var src = $(this).attr("src");
				$("#popup_detail_picture").attr({"src":src});
			});
			$("body").on("click", ".detail_picture_view", function(){
				$(".detail_picture_view").fadeOut();
				$("#popup_detail_picture").attr({"src":""});
			});
$(function(){
	$('.gallery_preview_cont_cont').slimScroll({
		color: '#00d6ff',
		size: '10px',
		width: '307px',
		height: '370px',
		distance: '3px',
		alwaysVisible: true
	});
});
</script>
<?
	CModule::IncludeModule("iblock");
	if($_GET["page"])
		$page = $_GET["page"];
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
				<a class="gallery_back" href="/group/<?=$arGroup["ID"]?>/photo/?page=<?=$page?>#photo_list_item_<?=substr($event_id, 0, strripos($event_id, "?"))?>"></a>
				<?=$arEvent["NAME"]?>

				<?
					//$res_like = CIBlockElement::GetList(array(), array("IBLOCK_ID" => 6, "PROPERTY_LIKE" => $arEvent['ID'], "PROPERTY_USER" => $USER->GetID() ),array());
				?>
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
								<?$first_picture_id=0;
								$arEvent["PROPERTIES"]["PHOTO"]["VALUE"]=array_reverse($arEvent["PROPERTIES"]["PHOTO"]["VALUE"]);
								?>
								<?foreach($arEvent["PROPERTIES"]["PHOTO"]["VALUE"] as $key => $picture) {
									if($first_picture_id==0)$first_picture_id=$picture;
									/*echo "<xmp>"; print_r($picture);echo "</xmp>";*/
									$image_small = CFile::ResizeImageGet($picture, array("width" => 125, "height" => 84));?>
									<a id="photo_<?=$picture?>" href="<?=CFile::GetPath($picture)?>" style="background: url('<?=$image_small["src"]?>') center center;"></a>
								<?}?>
							</div>
						</div>
						<div class="clear"></div>
						<div class="gallery_arrow_down"></div>
					</div>
				</div>
			</div>
			<div class="gallery_rightcol_sk"><div class="gallery_rightcol">
				<div class="gallery_photo_cont">
					<img src="<?=CFile::GetPath($arEvent["PROPERTIES"]["PHOTO"]["VALUE"][0])?>" id="gallery_photo">
					<div class="gallery_photo_gradient"></div>
					<div class="gallery_nw_prev"></div>
					<div class="gallery_nw_next"></div>
					<div id="loaderImage"></div>
				</div>

				<div style="float:right; margin-top: 15px;">
					<div id="like_box">

					<?
						$APPLICATION->IncludeComponent("radia:likes","",Array(
							"ELEMENT" => 'photo_'.$arEvent["PROPERTIES"]["PHOTO"]["VALUE"][0]
						));
					?>
					</div>
					<!-- Блок комментариев -->
					<div class="comments-wrap gallery_comments">
						<div class="comments-icon"></div>
						<div class="comments-number" style="width:30px;"></div>
					</div>

					<?if($arEvent["PROPERTIES"]["SHARE"]["VALUE"] == "Y"){?>
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
					<?}?>
				</div>
				<div id="comments_block">
				<?/*$APPLICATION->IncludeComponent("smsmedia:comments", "myqube_event", Array(
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
				);*/?>
				</div>
			</div>
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

			var pos=(Math.ceil(($(".gallery_preview_cont_cont_cont").find("a").length)/3)-4)*96;
			//var scroll=$(".gallery_preview_cont_cont_cont").height()-$(".gallery_preview_cont_cont").height();
			//alert(scroll);
			$(function(){
				if (pos<400)
				{
					$(".gallery_arrow_up").hide();
					$(".gallery_arrow_down").hide();
				}
			});
			var scrollBarDown = $(".gallery_preview_cont_cont_cont").height()/100;
			$(".gallery_arrow_down").click(function(event) {
				 event.stopPropagation();
				event.preventDefault();
				$(".gallery_preview_cont_cont").animate({
					scrollTop: $(".gallery_preview_cont_cont").scrollTop()+100
				}, 500, function() {
					$(".gallery_preview_cont .slimScrollBar").css({"top" : $(".gallery_preview_cont .slimScrollBar").position().top+scrollBarDown+"px"});
					if($(".gallery_preview_cont_cont").scrollTop()>=100){
						$(".gallery_arrow_up").show();
					}
					if($(".gallery_preview_cont_cont").scrollTop()==0){
						$(".gallery_arrow_up").hide();
					}
					if($(".gallery_preview_cont_cont").scrollTop()>=pos){
						$(".gallery_arrow_down").hide();
					}
					if($(".gallery_preview_cont_cont").scrollTop()<=pos-1){
						$(".gallery_arrow_down").show();
					}
					//alert($(".gallery_preview_cont_cont_cont").css("top"));
					//alert("-"+pos+"px");
				});
			});

			$(".gallery_arrow_up").click(function(event) {
				event.stopPropagation();
				event.preventDefault();
				$(".gallery_preview_cont_cont").animate({
					scrollTop: $(".gallery_preview_cont_cont").scrollTop()-100
				}, 500, function() {
					$(".gallery_preview_cont .slimScrollBar").css({"top" : $(".gallery_preview_cont .slimScrollBar").position().top-scrollBarDown+"px"});
					if($(".gallery_preview_cont_cont").scrollTop()>=100){
						$(".gallery_arrow_up").show();
					}
					if($(".gallery_preview_cont_cont").scrollTop()==0){
						$(".gallery_arrow_up").hide();
					}
					if($(".gallery_preview_cont_cont").scrollTop()>=pos){
						$(".gallery_arrow_down").hide();
					}
					if($(".gallery_preview_cont_cont").scrollTop()<=pos-1){
						$(".gallery_arrow_down").show();
					}
				});
			});
			//$(".gallery_comments").hover(function() {
				//$( ".gallery_comments" ).find("span").show("slide", { direction: "right" }, 500);
			//});
			var	current_photo = $(".gallery_preview_cont_cont_cont a").first();

			var path = host_url+"/group/photo/comments_count.php";
			$.get(path, {post_id: $(current_photo).attr("id").replace("photo_", "")}, function(data){
				$(data).appendTo(".comments-number");
				$("#comments_count_" + $(current_photo).attr("id").replace("photo_", "")).first().css("display","block");
			});


			$(".gallery_comments").click(function(event) {
				event.preventDefault();
				if($("#comment_form_" + $(current_photo).attr("id").replace("photo_", "")).length == 0)
				{
					var path = host_url+"/group/photo/comments.php";
					$.get(path, {post_id: $(current_photo).attr("id").replace("photo_", ""),post_id_w:<?=$arEvent["ID"]?>}, function(data){
						$(data).appendTo("#comments_block");
						$( "#comments_block" ).slideToggle(500, function(){});
					});
				}
				else
				{
					$( "#comments_block" ).slideToggle(500, function(){});
				}
				$('html,body').animate({
					scrollTop: $("#comments_block").offset().top},
					'slow');
				$("#comment_form_"+$(current_photo).attr("id").replace("photo_", "")).show();
				/*if($( ".comments" ).css("display")=="none"){
					$(".gallery_comments").addClass("gallery_comments_active");
				}else{
					$(".gallery_comments").removeClass("gallery_comments_active");
				}*/


				/*if ($( ".gallery_photo_cont" ).css("height")=="150px"){
					$( ".gallery_photo_cont" ).animate({
						height: $( "#gallery_photo" ).css("height")
					}, 500, function() {
						// Animation complete.
					});
				}else{*/
				/*$( ".gallery_photo_cont" ).animate({
					height: $( "#gallery_photo" ).css("height")
				}, 500, function() {
					// Animation complete.
				});*/
				/*}	*/
			});
			$(".gallery_preview_cont_cont_cont").find("a").click(function(event) {
				event.preventDefault();
				current_photo = this;
				startAnimation()
				$( "#comments_block" ).hide();
				$("#loaderImage").show();
				$('<img/>').attr('src', $(current_photo).attr("href")).load(function () {
					$('#gallery_photo').fadeOut(500, function() {
						$('#gallery_photo').attr("src",$(current_photo).attr("href"));
					});
				});

			});
			$(function(){
				$( "#gallery_photo" ).load(function() {
					$("#loaderImage").hide();
					$('#gallery_photo').fadeIn(500);
					$(".comments").hide();
					$( "#comments_block" ).hide();
					$(".comments_count").css("display","none");
					if($("#comments_count_" + $(current_photo).attr("id").replace("photo_", "")).length == 0)
					{
						var path = host_url+"/group/photo/comments_count.php";
						$.get(path, {post_id: $(current_photo).attr("id").replace("photo_", "")}, function(data){
							$(data).appendTo(".comments-number");
							$("#comments_count_" + $(current_photo).attr("id").replace("photo_", "")).first().css("display","block");
						});
					}
					else
					{
						$("#comments_count_" + $(current_photo).attr("id").replace("photo_", "")).css("display","block");
					}
					stopAnimation();
					path = host_url+"/group/photo/likes_count.php";
					$.get(path, {post_id: $(current_photo).attr("id").replace("photo_", "")}, function(data){
						$('#like_box').html(data)
						window.initLikes()
					});
				});
				$(".gallery_nw_next").click(function() {
					var current_photo_1 = $( current_photo ).next( ".gallery_preview_cont_cont_cont a" );
					if(!current_photo_1.attr("href")) return;
					current_photo = current_photo_1;
					startAnimation()
					$("#loaderImage").show();
					$( "#comments_block" ).hide();
					$('<img/>').attr('src', $(current_photo).attr("href")).load(function () {
						$('#gallery_photo').fadeOut(500, function() {
							$('#gallery_photo').attr("src",$(current_photo).attr("href"));
						});
					});
				});
				$(".gallery_nw_prev").click(function() {
					var current_photo_1 = $( current_photo ).prev( ".gallery_preview_cont_cont_cont a" );
					if(!current_photo_1.attr("href")) return;
					current_photo = current_photo_1;
					startAnimation()
					$("#loaderImage").show();
					$( "#comments_block" ).hide();
					$('<img/>').attr('src', $(current_photo).attr("href")).load(function () {
						$('#gallery_photo').fadeOut(500, function() {
							$('#gallery_photo').attr("src",$(current_photo).attr("href"));
						});
					});
				});
			});
		</script>
		<style>
			.gallery_nw_prev,.gallery_nw_next {
				position:absolute;
				top:45%;
				width:28px;
				height:40px;
				cursor:pointer;
				background-repeat:no-repeat;
			}
			.gallery_nw_prev {
				left:10px;
				background-image:url('/images/gallery_arrow_up_min.png');
			}
			.gallery_nw_next {
				right:10px;
				background-image:url('/images/gallery_arrow_down_min.png');
			}
		</style>

		<div class="detail_picture_view">
			<div class="popup_background"></div>
			<div class="popup_detail_picture_wrapper">
				<img src="" id="popup_detail_picture">
			</div>
		</div>
