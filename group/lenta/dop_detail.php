<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");?>
	<?
	global $USER;
	$_SESSION["BackFromDetail"]["group_6"]["nPageSize"] = $_GET["page"];
	$arr_t=array("nPageSize" => 1, "nElementID" => $_GET["POST_ID"]);
	$arr_p=array("IBLOCK_ID" => 1, "ACTIVE" => "Y", "PROPERTY_SOCIAL_GROUP_ID" => $_GET["GROUP_ID"]);
	if($_SESSION["BackFromDetail"]["brand"]==1)
	{	$arr_p["PROPERTY_ABOUT_VALUE"]=1;
	}
	$res = CIBlockElement::GetList(array("ACTIVE_FROM"=>"DESC"), $arr_p,false, $arr_t, array("ID", "*"));
	$in = 0;
	while($arRes = $res->GetNextElement()){
		$arItem = $arRes->GetFields();
		$arItem["PROPERTIES"] = $arRes->GetProperties();
		$arPost[] = $arItem;
		if($_GET["POST_ID"] == $arItem["ID"]) $in = 1;
	}
	if($in==0)
	{
		$arPost = Array();
		$arr_p_1=array("IBLOCK_ID" => 1, "ACTIVE" => "Y", "PROPERTY_SOCIAL_GROUP_ID" => $_GET["GROUP_ID"]);
		$res = CIBlockElement::GetList(array("ACTIVE_FROM"=>"DESC"), $arr_p_1,false, $arr_t, array("ID", "*"));
		while($arRes = $res->GetNextElement()){
			$arItem = $arRes->GetFields();
			$arItem["PROPERTIES"] = $arRes->GetProperties();
			$arPost[] = $arItem;
		}
	}
	if((count($arPost) == 2) && ($_GET["POST_ID"] == $arPost[0]["ID"])) {
		$this_post = 0;
		$close_url = '<a onclick="goBack_1(\''.'/group/'.$_GET["GROUP_ID"].(($_SESSION["BackFromDetail"]["brand"]==1)?"/about":"").'/#lenta_item_'.$arPost[$this_post]["ID"].'\');" href="#"><span class="icon_close"></span><b>Закрыть статью</b><div class="clear"></div></a>';
		$prev_url = '';
		$next_url = '<a  href="'.str_replace("#group_id#", $_GET["GROUP_ID"], $arPost[1]["DETAIL_PAGE_URL"]).'/"><span class="icon_next"></span><b>Следующая статья</b><div class="clear"></div></a>';
	} elseif((count($arPost) == 2) && ($_GET["POST_ID"] == $arPost[1]["ID"])) {
		$this_post = 1;
		$close_url = '<a onclick="goBack_1(\''.'/group/'.$_GET["GROUP_ID"].(($_SESSION["BackFromDetail"]["brand"]==1)?"/about":"").'/#lenta_item_'.$arPost[$this_post]["ID"].'\');" href="#"><span class="icon_close"></span><b>Закрыть статью</b><div class="clear"></div></a>';
		$prev_url = '<a href="'.str_replace("#group_id#", $_GET["GROUP_ID"], $arPost[0]["DETAIL_PAGE_URL"]).'/"><span class="icon_prev"></span><b>Предыдущая статья</b><div class="clear"></div></a>';
		$next_url = '';
	} else {
		$this_post = 1;/*href="/group/'.$_GET["GROUP_ID"].'/#lenta_item_'.$arPost[$this_post]["ID"].'"*/
		$close_url = '<a onclick="goBack_1(\''.'/group/'.$_GET["GROUP_ID"].(($_SESSION["BackFromDetail"]["brand"]==1)?"/about":"").'/#lenta_item_'.$arPost[$this_post]["ID"].'\');" href="#"><span class="icon_close"></span><b>Закрыть статью</b><div class="clear"></div></a>';
		$prev_url = '<a href="'.str_replace("#group_id#", $_GET["GROUP_ID"], $arPost[0]["DETAIL_PAGE_URL"]).'/"><span class="icon_prev"></span><b>Предыдущая статья</b><div class="clear"></div></a>';
		$next_url = '<a href="'.str_replace("#group_id#", $_GET["GROUP_ID"], $arPost[2]["DETAIL_PAGE_URL"]).'/"><span class="icon_next"></span><b>Следующая статья</b><div class="clear"></div></a>';
	}
	if($_SESSION["BackFromDetail"]["u_concept"] == 1) {
		$close_url = '<a href="/group/'.$_GET["GROUP_ID"].'/u_concept/"><span class="icon_close"></span><b>Закрыть статью</b><div class="clear"></div></a>';
	}
	$ogImage = CFile::ResizeImageGet($arPost[$this_post]["PROPERTIES"]["OG_IMAGE"]["VALUE"], array('width'=>200, 'height'=>200), BX_RESIZE_IMAGE_PROPORTIONAL, true);
	$APPLICATION->SetPageProperty("title", $arPost[$this_post]["NAME"]);
	$APPLICATION->SetPageProperty("description", $arPost[$this_post]["PROPERTIES"]["OG_DESCRIPTION"]["VALUE"]["TEXT"]);
	$APPLICATION->SetPageProperty("og:title", $arPost[$this_post]["NAME"]);
	$APPLICATION->SetPageProperty("og:description", $arPost[$this_post]["PROPERTIES"]["OG_DESCRIPTION"]["VALUE"]["TEXT"]);
	$APPLICATION->SetPageProperty("og:image", "http://myqube.ru".$ogImage["src"]);
	if($USER->IsAuthorized() /*&& CustomUser::UserYouHave18() && CustomUser::UserCheckFields()*/)
	{
		?>
		<script>
			$(document).ready(function() {
				var topSnoska = $(".detail_page_content .snoska").offset().top;
				var heightSnoska = $(".detail_page_content .snoska").height();
				if($(".detail_page_content img:first").offset() !== undefined) {
					var topFirstImg = $(".detail_page_content img:first").offset().top;
					var newTopFirstImg = (heightSnoska+topSnoska)+50-topFirstImg;
					if(newTopFirstImg > 0)
						$(".detail_page_content img:first").css({"margin-top":newTopFirstImg+"px"});
				}
				if($(".detail_page_content iframe:first").offset() !== undefined) {
					var topFirstIframe = $(".detail_page_content iframe:first").offset().top;
					var newTopFirstIframe = (heightSnoska+topSnoska)+50-topFirstIframe;
					if(newTopFirstIframe > 0)
						$(".detail_page_content iframe:first").css({"margin-top":newTopFirstIframe+"px"});
				}

				$('body').on("click", ".up_page", function() {
					$('html, body').animate({scrollTop: 0},500);
				});
				/*$(".detail_page_content").find('img').each(function(i) {
					var thisImg = $(this).offset().top+$(this).height();
					if($(".detail_page_content img").eq(i+1).offset() !== undefined) {
						var nextImg = $(".detail_page_content img").eq(i+1).offset().top;
					} else {
						var nextImg = $(".comments").offset().top;
					}
					var pos = (nextImg - thisImg) / 2 - 30;
					if(+pos > 10)
						$(this).after("<div class='up_page' style='margin-top: "+pos.toFixed()+"px;'>В начало статьи</div>");
				});
				$(".detail_page_content").find('iframe').each(function(i) {
					var thisIframe = $(this).offset().top+$(this).height();
					if($(".detail_page_content iframe").eq(i+1).offset() !== undefined) {
						var nextIframe = $(".detail_page_content iframe").eq(i+1).offset().top;
					} else {
						var nextIframe = $(".comments").offset().top;
					}
					var pos = (nextIframe - thisIframe) / 2 - 30;
					if(+pos > 10)
						$(this).after("<div class='up_page' style='margin-top: "+pos.toFixed()+"px;'>В начало статьи</div>");
				});*/
			});
			$(function(){
				$("a.photo_list_like" ).click(function() {
							$( this ).toggleClass( "like_active" );
							var path = host_url+"/group/lenta/like_post.php";
							$.get(path, {post_id: $(this).attr('id'),like: Number($( this ).hasClass( "like_active" ))}, function(data){
							});
						});
			});
		</script>
		<div class="detail_page" style="background-image: url('<?=CFile::GetPath($arPost[$this_post]["DETAIL_PICTURE"])?>');">
			<div class="detail_page_content">
                <style>
                @media screen and (max-device-width: 640px){
                    #nav_left_open{
                        left: -165px !important;
                    }

                    .detail_page h1{
                        background-image: url('<?=CFile::GetPath($arPost[$this_post]["DETAIL_PICTURE"])?>');
                    }

                    h1 span{
                        position: relative;
                    }
                }
                </style>
                <!-- <div class="mobile-block mobile-post-top-block"> -->

                <!-- </div> -->
				<h1>
                    <div class="mobile-arrow-back mobile-block"><?
					echo $close_url?></div>
                    <div class="mobile-block post-h1-gradient"></div>

                    <span class="color_blue"><?=$arPost[$this_post]["NAME"]?></span><br><span><?=$arPost[$this_post]["PROPERTIES"]["NAME_2"]["VALUE"]?></span>


                </h1>
				<p class="snoska p"><?=$arPost[$this_post]["PREVIEW_TEXT"]?></p>
				<div class="detail_text p"><?=$arPost[$this_post]["DETAIL_TEXT"]?></div>
				<nav class="detail_page_nav">
					<?
					echo $close_url;
					echo $next_url;
					echo $prev_url;
					?>
					<?if($arPost[$this_post]["PROPERTIES"]["SHARE"]["VALUE"] == "Y"){?>
						<?$APPLICATION->IncludeComponent(
							"bitrix:main.share",
							"myqube",
							Array(
								"COMPONENT_TEMPLATE" => ".default",
								"HIDE" => "N",
								"HANDLERS" => array("vk","facebook", "google"),
								"PAGE_URL" => $APPLICATION->GetCurPage(),
								"PAGE_TITLE" => $arPost[$this_post]["NAME"],
								"PAGE_IMAGE" => "http://myqube.ru".$ogImage["src"],
								"SHORTEN_URL_LOGIN" => "",
								"SHORTEN_URL_KEY" => ""
							)
						);?>
					<?}?>
					<?
					$res_like = CIBlockElement::GetList(array(), array("IBLOCK_ID" => 6, "PROPERTY_LIKE" => $arPost[$this_post]["ID"], "PROPERTY_USER" => $USER->GetID() ),array());
					?>
					<a class="photo_list_like <?=($res_like>0)?"like_active":""?>" id="like_post_<?=$arPost[$this_post]["ID"]?>"></a>
				</nav>
				<div style="both: clear;" class="clear"></div>
				<?$APPLICATION->IncludeComponent("smsmedia:comments", "myqube_lenta", Array(
					"OBJECT_ID" => $arPost[$this_post]["ID"],	// ID объекта комментирования
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
						"COMPONENT_TEMPLATE" => "myqube_event"
					),
					false
				);?>
			</div>
		</div>
		<?
	} elseif($arPost[$this_post]["PROPERTIES"]["SHARE"]["VALUE"] == "Y") {
	} else {
		if($USER->IsAuthorized()) {
			if(!CustomUser::UserYouHave18())
				LocalRedirect("/?message=you_are_under_18");
			if(!CustomUser::UserCheckFields())
				LocalRedirect("/checking_user_fields.php?backurl=".$_SERVER["REQUEST_URI"]);
		} else
			LocalRedirect("/auth/?backurl=".$_SERVER["REQUEST_URI"]);
	}
?><?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");
?>
