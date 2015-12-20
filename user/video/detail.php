<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$page_name="video_detail";

include($_SERVER["DOCUMENT_ROOT"]."/user/header.php");
?><link type="text/css" rel="stylesheet" href="/css/video-preview.css">
<script>/*
$(function(){
	$("a.likes" ).click(function() {
					$( this ).toggleClass( "active" );
					var path = host_url+"/group/video/like_post.php";
					$.get(path, {post_id: $(this).attr('id'),like: Number($( this ).hasClass( "active" ))}, function(data){
					});
				});
});*/
</script>
<? 
	CModule::IncludeModule("iblock");
	$_SESSION["BackFromDetail"]["group_6"]["nPageSize"] = $_GET["page"];
	$event_id = $_GET["POST_ID"];
	$res = CIBlockElement::GetList(array(), array("IBLOCK_ID" => 8, "ID" => $event_id));
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
	$CurentUser = CUser::GetByID($arEvent["CREATED_BY"])->Fetch();
?>
		<!-- Блок с верхинми иконками -->
			<div class="icon-menu">
			<!-- Блок возврата на уровень выше -->
				<div class="main-menu">
					<a class="gallery_back" href="/user/video/"></a>
				</div>
				<div class="main-text"><?=$arEvent["NAME"]?></div>
				<!-- Три иконки справа -->
				<div class="right-menu">
					<?
						$res_like = CIBlockElement::GetList(array(), array("IBLOCK_ID" => 6, "PROPERTY_LIKE" => $arEvent['ID'], "PROPERTY_USER" => $USER->GetID() ),array());	
					?>
					<!--<a id="video_item_<?=$arEvent['ID']?>" class="likes <?=($res_like>0)?"active":""?>"></a>-->
					
					<!--<a class="comments-wrap" href="#comment_form_<?=$arEvent['ID']?>">
								<div class="comments-icon"></div>
								<div class="comments-number"><?=intval($arEvent["PROPERTIES"]["COMMENTS_COUNT"]["VALUE"])?> комментариев</div>
					</a>-->
				</div>
			</div>

		<!-- Блок фото -->
		<div class="right-block mobile-block" style="width:540px;">
		<div class="right-block-text">
			<?=$arEvent["PREVIEW_TEXT"]?>
		</div>
				<? //echo "<xmp>"; print_r($arEvent); echo "</xmp>";?>
				<?
				if(!empty($arEvent["PROPERTIES"]["VIDEO_FILE"]["VALUE"]))
				{
					?>
					<div style="width:<?=$arEvent["PROPERTIES"]["VIDEO_FILE"]["VALUE"]["width"]?>; height:<?=$arEvent["PROPERTIES"]["VIDEO_FILE"]["VALUE"]["height"]?>;">
					<?
					$APPLICATION->IncludeComponent(
						"bitrix:player",
						"",
						Array(
							"PATH" => $arEvent["PROPERTIES"]["VIDEO_FILE"]["VALUE"]["path"],
							"WIDTH" => 780/*$arEvent["PROPERTIES"]["VIDEO_FILE"]["VALUE"]["width"]*/,
							"HEIGHT" => 780*$arEvent["PROPERTIES"]["VIDEO_FILE"]["VALUE"]["height"]/$arEvent["PROPERTIES"]["VIDEO_FILE"]["VALUE"]["width"],
							"PREVIEW" => CFile::GetPath($arEvent["PREVIEW_PICTURE"]))
					);	
				}
				else
				{
					?>
					<div class="photo" style="width:540px;">
						<?
						if(strpos($arEvent["PROPERTIES"]["VIDEO"]["VALUE"],"vimeo.com"))
						{
							$vimeo_video_id = preg_replace('/^.*vimeo.com\/(.*)$/i','$1',$arEvent["PROPERTIES"]["VIDEO"]["VALUE"]);
						?>
							<iframe src="https://player.vimeo.com/video/<?=$vimeo_video_id?>?badge=0" width="100%" height="100%" frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>
						<?
						}
						else 
						{
							$parsed_url = parse_url($arEvent["PROPERTIES"]["VIDEO"]["VALUE"]);
							parse_str($parsed_url['query'], $parsed_query);
							echo '<iframe src="http://www.youtube.com/embed/'.$parsed_query['v'].'" allowfullscreen="" width="100%" height="100%" frameborder="0"></iframe>';	
						}
				}
				?>
					</div>	
                    
                    <div class="right-menu" style="margin-right:0px;">
			<?
				$res_like = CIBlockElement::GetList(array(), array("IBLOCK_ID" => 6, "PROPERTY_LIKE" => $arEvent['ID'], "PROPERTY_USER" => $USER->GetID() ),array());
				/*global $gl_active, $gl_like_id;*/
				$GLOBALS['gl_active'] = $res_like;
				$GLOBALS['gl_like_id'] = "video_item_".$arEvent['ID'];
				$GLOBALS['gl_like_numm'] = intval($arEvent["PROPERTIES"]["LIKES"]["VALUE"]);
				$GLOBALS['gl_like_param'] = "post_id";
				$GLOBALS['gl_like_js'] = 1;
				$GLOBALS['gl_like_url'] = "/group/video/like_post.php";
				$APPLICATION->IncludeComponent("bitrix:main.include","",Array(
					"AREA_FILE_SHOW" => "file", 
					"PATH" => "/like.php"
					)
				);
			?>
			<a class="comments-wrap" href="#comment_form_<?=$arEvent['ID']?>">
				<div class="comments-icon"></div>
				<div class="comments-number"><?=intval($arEvent["PROPERTIES"]["COMMENTS_COUNT"]["VALUE"])?></div>
			</a>
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



	<!-- Левый блок с каментами -->
		<div class="left-block">

			<!-- Блок с картинкой и именем автора поста -->
			<!--div class="author-id">
				<div class="author-photo user-photo" id="user-1" style="background-image:url('<?=CFile::GetPath($CurentUser["PERSONAL_PHOTO"]);?>');"></div>
				<div class="author-name user-name"><?=$CurentUser["NAME"].' '.$CurentUser["LAST_NAME"];?></div>
			</div-->
			<?$APPLICATION->IncludeComponent("smsmedia:comments", "myqube_video", Array(
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
		<!-- Блок фото -->
		<div class="right-block nomobile" style="width:540px;">
		<div class="right-block-text">
			<?=$arEvent["PREVIEW_TEXT"]?>
		</div>
				<? //echo "<xmp>"; print_r($arEvent); echo "</xmp>";?>
				<?
				if(!empty($arEvent["PROPERTIES"]["VIDEO_FILE"]["VALUE"]))
				{
					?>
					<div style="width:<?=$arEvent["PROPERTIES"]["VIDEO_FILE"]["VALUE"]["width"]?>; height:<?=$arEvent["PROPERTIES"]["VIDEO_FILE"]["VALUE"]["height"]?>;">
					<?
					$APPLICATION->IncludeComponent(
						"bitrix:player",
						"",
						Array(
							"PATH" => $arEvent["PROPERTIES"]["VIDEO_FILE"]["VALUE"]["path"],
							"WIDTH" => 780/*$arEvent["PROPERTIES"]["VIDEO_FILE"]["VALUE"]["width"]*/,
							"HEIGHT" => 780*$arEvent["PROPERTIES"]["VIDEO_FILE"]["VALUE"]["height"]/$arEvent["PROPERTIES"]["VIDEO_FILE"]["VALUE"]["width"],
							"PREVIEW" => CFile::GetPath($arEvent["PREVIEW_PICTURE"]))
					);	
				}
				else
				{
					function fetch_vimeo_id($url) {
						$headers = get_headers($url);
						# Reverse loop because we want the last matching header,
						# as Vimeo does multiple redirects with your `https` URL
						for($i = count($headers) - 1; $i >= 0; $i--) {
							$header = $headers[$i];
							//echo $header."#<br>";
							if(strpos($header, "Location: /") === 0) {
								return substr($header, strlen("Location: /"));
							}
						}
						# Could not find id
						return null;
					}
					?>
					<div class="photo" style="width:540px;">
					<?
					if(strpos($arEvent["PROPERTIES"]["VIDEO"]["VALUE"],"vimeo.com"))
					{
						$vimeo_video_id = intval(preg_replace('/^.*vimeo.com\/(.*)$/i','$1',$arEvent["PROPERTIES"]["VIDEO"]["VALUE"]));
						if(!($vimeo_video_id>0))
							$vimeo_video_id = fetch_vimeo_id($arEvent["PROPERTIES"]["VIDEO"]["VALUE"]);
						//echo $vimeo_video_id."!!!";
					?>
						<iframe src="https://player.vimeo.com/video/<?=$vimeo_video_id?>?badge=0" width="100%" height="100%" frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>
					<?
					}
					else 
					{
						$parsed_url = parse_url($arEvent["PROPERTIES"]["VIDEO"]["VALUE"]);
						parse_str($parsed_url['query'], $parsed_query);
						echo '<iframe src="http://www.youtube.com/embed/'.$parsed_query['v'].'" allowfullscreen="" width="100%" height="100%" frameborder="0"></iframe>';	
					}
				}
				?>
			</div>
			<div class="right-menu" style="margin-right:0px;">
			<?
				$res_like = CIBlockElement::GetList(array(), array("IBLOCK_ID" => 6, "PROPERTY_LIKE" => $arEvent['ID'], "PROPERTY_USER" => $USER->GetID() ),array());
				/*global $gl_active, $gl_like_id;*/
				$GLOBALS['gl_active'] = $res_like;
				$GLOBALS['gl_like_id'] = "video_item_".$arEvent['ID'];
				$GLOBALS['gl_like_numm'] = intval($arEvent["PROPERTIES"]["LIKES"]["VALUE"]);
				$GLOBALS['gl_like_param'] = "post_id";
				$GLOBALS['gl_like_js'] = 0;
				$GLOBALS['gl_like_url'] = "/group/video/like_post.php";
				$APPLICATION->IncludeComponent("bitrix:main.include","",Array(
					"AREA_FILE_SHOW" => "file", 
					"PATH" => "/like.php"
					)
				);
			?>
			<a class="comments-wrap" href="#comment_form_<?=$arEvent['ID']?>">
				<div class="comments-icon"></div>
				<div class="comments-number"><?=intval($arEvent["PROPERTIES"]["COMMENTS_COUNT"]["VALUE"])?></div>
			</a>
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
		</div>
	<?	$APPLICATION->IncludeComponent(
			"bitrix:main.include",
			"",
			Array(
				"COMPONENT_TEMPLATE" => ".default",
				"AREA_FILE_SHOW" => "file",
				"AREA_FILE_SUFFIX" => "inc",
				"EDIT_TEMPLATE" => "",
				"PATH" => "/chat/index.php"
			)
		);
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");
?>