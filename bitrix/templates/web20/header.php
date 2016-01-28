<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?

global $USER;

if($USER->GetID() == 3){
	$APPLICATION->ShowPanel = false;
}


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
			<?$Dir = explode("/",$_SERVER["REQUEST_URI"]);
			if($Dir[3] !== "explore" && $Dir[4] !== "u_creative")
				echo '<meta name="viewport" content="width=device-width, initial-scale=0.5, maximum-scale=0.5, user-scalable=no">';
			else
				echo '<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">';	?>
			<link rel="shortcut icon" href="/images/q.png" type="image/png">
        	<!--<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.8.1/jquery.min.js"></script>-->
            <script src="//code.jquery.com/jquery-1.11.3.min.js"></script>
			<!--<script src="<?=SITE_TEMPLATE_PATH?>/js/jquery.ui.touch-punch.min.js"></script>-->
            <script type="text/javascript" src="<?=SITE_TEMPLATE_PATH?>/main.js"></script>
			<script type="text/javascript">
				$(function(){
					(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
					(i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
					m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
					})(window,document,'script','//www.google-analytics.com/analytics.js','ga');

					ga('create', 'UA-61330528-1', 'auto');
					ga('send', 'pageview');

					$(".share-click").click(function(){
						var url = $(this).data("share");
						var nw = $(this).data("nw");
						var title = $(this).data("title");
						var image = $(this).data("image");

						$.get("/bitrix/templates/web20/components/bitrix/main.share/myqube/ajax_count_shares.php", {group_id: <?=strripos($_GET["GROUP_ID"], "?") ? intval(substr($_GET["GROUP_ID"], 0, strripos($_GET["GROUP_ID"], "?"))) :intval( $_GET["GROUP_ID"])?>}, function(data){});
						$.get(host_url+"/bitrix/templates/web20/components/bitrix/main.share/myqube_uconcept_pics/add_share.php?user=<?=$USER->GetID()?>&link="+url+"&social_network="+nw, function( data ) {});

						if(nw == "Google Plus") {
							window.open('https://plus.google.com/share?url='+encodeURIComponent(url),'sharer','toolbar=0,status=0,width=626,height=436');
						} else if(nw == "VK") {
							window.open('http://vkontakte.ru/share.php?url='+encodeURIComponent(url)+'&title='+encodeURIComponent(title)+'&image='+encodeURIComponent(image),'sharer','toolbar=0,status=0,width=626,height=436');
						} else if(nw == "Facebook") {
							window.open('http://www.facebook.com/share.php?u='+encodeURIComponent(url)+'&t='+encodeURIComponent(title),'sharer','toolbar=0,status=0,width=626,height=436');
						}
					});
					$(".show_full_nav").click(function() {
							if(!$(".show_full_nav").hasClass("show_full_nav_full"))
							{
								$(".nav_text").css("display","inline");
								$("#nav_left_open").animate({width: '170'});
								$(".show_full_nav").addClass("show_full_nav_full");
								$("#nav_left_open .nav_item").css("text-align","left");
								$("#nav_left_open .nav_item").css("padding-left","10px");
							}
							else{
								$(".nav_text").hide();
								$("#nav_left_open").animate({width: '53'});
								$(".show_full_nav").removeClass("show_full_nav_full");
								$("#nav_left_open .nav_item").css("text-align","center");
								$("#nav_left_open .nav_item").css("padding-left","0px");
							}
						});


            var nua = navigator.userAgent;
            var chromeStart = nua.indexOf('Chrome/');
            var chrome = nua.slice(chromeStart+7,chromeStart+9);
            var is_android = (nua.indexOf('Android ') > -1 || nua.indexOf('Linux') > -1)&&(nua.indexOf('Mozilla/5.0') > -1);
            var old_mobile = (nua.indexOf('Version/4.0') > -1);

            if (navigator.userAgent.match(/IEMobile\/10\.0/)) {
                var msViewportStyle = document.createElement("style");
                msViewportStyle.appendChild(
                    document.createTextNode(
                        "@-ms-viewport{width:auto!important}"
                    )
                );
                document.getElementsByTagName("head")[0].
                    appendChild(msViewportStyle);
            }


            if (is_android){

                if((chrome<20&&chrome>1)||old_mobile||navigator.userAgent.match(/IEMobile\/10\.0/)){
                    function customScaleThisScreen(){
                    var contentWidth = document.body.scrollWidth,
                        windowWidth = window.innerWidth,
                        newScale = windowWidth / contentWidth;
                    document.body.style.zoom = newScale/2;
                    };
                    customScaleThisScreen();
                }
            };

					})
			</script>
			<!-- Yandex.Metrika counter -->
			<script type="text/javascript">
			    (function (d, w, c) {
			        (w[c] = w[c] || []).push(function() {
			            try {
			                w.yaCounter31164396 = new Ya.Metrika({
			                    id:31164396,
			                    clickmap:true,
			                    trackLinks:true,
			                    accurateTrackBounce:true,
			                    webvisor:true,
			                    trackHash:true
			                });
			            } catch(e) { }
			        });

			        var n = d.getElementsByTagName("script")[0],
			            s = d.createElement("script"),
			            f = function () { n.parentNode.insertBefore(s, n); };
			        s.type = "text/javascript";
			        s.async = true;
			        s.src = "https://mc.yandex.ru/metrika/watch.js";

			        if (w.opera == "[object Opera]") {
			            d.addEventListener("DOMContentLoaded", f, false);
			        } else { f(); }
			    })(document, window, "yandex_metrika_callbacks");
			</script>
            <style>
         @media screen and (max-width:640px) {
            @-ms-viewport{
                width:640px;
            }
        }
            </style>

			<!-- /Yandex.Metrika counter -->
		</head>
		<body onselectstart="return false">
			<?$APPLICATION->ShowPanel();?>
			<div class="body">
				<?
				if($USER->IsAuthorized())
				{
					$APPLICATION->IncludeComponent(
	"bitrix:menu",
	"main_menu",
	array(
		"ROOT_MENU_TYPE" => "top",
		"MAX_LEVEL" => "1",
		"USE_EXT" => "N",
		"MENU_CACHE_TYPE" => "N",
		"MENU_CACHE_TIME" => "3600",
		"MENU_CACHE_USE_GROUPS" => "N",
		"MENU_CACHE_GET_VARS" => array(
		),
		"COMPONENT_TEMPLATE" => "main_menu",
		"CHILD_MENU_TYPE" => "left",
		"DELAY" => "N",
		"ALLOW_MULTI_SELECT" => "N"
	),
	false
);
				}
				?>
				<div class="main"<?if(!$USER->IsAuthorized()) echo ' style="padding-left: 0px;"';?>>
					<section>
