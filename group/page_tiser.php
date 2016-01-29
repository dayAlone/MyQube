<?
if(strripos($_SERVER["HTTP_REFERER"], "vk.com"))
	$soc_network = "vk";
if(strripos($_SERVER["HTTP_REFERER"], "facebook"))
	$soc_network = "facebook";
if(strripos($_SERVER["HTTP_REFERER"], "google"))
	$soc_network = "google";
if($strripos = strripos($_SERVER["REQUEST_URI"], "?")) {
	$backurl = "/?backurl=".substr($_SERVER["REQUEST_URI"], 0, $strripos);
} else {
	$backurl = "/?backurl=".$_SERVER["REQUEST_URI"];
}
$obCache = new CPHPCache();
$cacheLifetime = 86400*7;
$cacheID = 'TeaserItems'.$_GET["POST_ID"];
$cachePath = '/'.$cacheID;

if($obCache->InitCache($cacheLifetime, $cacheID, $cachePath) )
{
   $vars = $obCache->GetVars();
   $arPost = $vars['arPost'];
}
elseif( $obCache->StartDataCache()  )
{
   $res = CIBlockElement::GetList(array(), array("ID" => $_GET["POST_ID"]));
   while($arRes = $res->GetNextElement()){
	   	$arItem = $arRes->GetFields();
	   	$arItem["PROPERTIES"] = $arRes->GetProperties();
	   	$arPost = $arItem;
   }
   $obCache->EndDataCache(array('arPost' => $arPost));
}

$ogImage = CFile::ResizeImageGet($arPost["PROPERTIES"]["OG_IMAGE"]["VALUE"], array('width'=>600, 'height'=>600), BX_RESIZE_IMAGE_PROPORTIONAL, true);?>
<?
$APPLICATION->SetPageProperty("title", $arPost["NAME"]);
$APPLICATION->SetPageProperty("description", $arPost["PROPERTIES"]["OG_DESCRIPTION"]["VALUE"]["TEXT"]);
$APPLICATION->SetPageProperty("og:title", $arPost["NAME"]);
$APPLICATION->SetPageProperty("og:description", $arPost["PROPERTIES"]["OG_DESCRIPTION"]["VALUE"]["TEXT"]);
$APPLICATION->SetPageProperty("og:image", "http://myqube.ru".str_replace(' ','%20',$ogImage["src"]));
$APPLICATION->SetPageProperty("og:url", "http://myqube.ru".$_SERVER["REQUEST_URI"]);

if($arPost["IBLOCK_ID"] == 1 || $arPost["IBLOCK_ID"] == 7) {?>
	<script>
		$(document).ready(function(){$.get("http://myqube.ru<?=$_SERVER["REQUEST_URI"]?>?utm_source=google&utm_medium=teaser&utm_term=<?=$soc_network?>&utm_campaign=<?=$arPost["ID"]?>",function(data){});});
	</script>
	<?
	$image = 'http://myqube.ru/'.CFile::GetPath($arPost["PROPERTIES"]["OG_IMAGE"]["VALUE"]);
	$APPLICATION->SetAdditionalCSS("/layout/css/teaser.css", true);
	?>

	<div class='teaser'>
		<?=(isset($_REQUEST['bg']) ? "<div class='teaser__background' style='background-image: url(".$image.")'></div>":"")?>
		<div class='teaser__content'>
			<div class='teaser__logo'><img src="/layout/images/svg/logo.svg" alt="" width="97" height="30"/></div>
			<div class='teaser__wrapper'>
				<div class='teaser__image' style='background-image: url(<?=$image?>)'></div>
				<div class='teaser__description'>
					<h1 class='teaser__title'><?=$arPost["NAME"]?></h1>
					<div class='teaser__text'>
						<?=$arPost["PROPERTIES"]["OG_DESCRIPTION"]["VALUE"]["TEXT"]?>
					</div>
					<?$APPLICATION->IncludeComponent(
						"bitrix:system.auth.form",
						"teaser",
						array(
							"REGISTER_URL" => "/club/group/search/",
							"PROFILE_URL" => "/user/profile/",
							"FORGOT_PASSWORD_URL" => "",
							"SHOW_ERRORS" => "Y",
							"ONLY_SOCNET" => "Y",
							"BACKURL" => $backurl
						),
						false
					);?>

				</div>
			</div>

		</div>
	</div>
<?} else {?>

	<link type="text/css" rel="stylesheet" href="/css/teaser.css">
	<script type="text/javascript" src="/js/plugins/jquery-ui/jquery-ui.min.js"></script>
    <script src="jquery.ui.touch-punch.min.js"></script>
	<script type="text/javascript" src="/js/plugins/jquery.slimscroll/jquery.slimscroll.min.js"></script>
	<script type="text/javascript" src="/js/plugins/jquery.fancybox/jquery.fancybox.js"></script>
	<link type="text/css" rel="stylesheet" href="/js/plugins/jquery.fancybox/jquery.fancybox.css">
	<script type="text/javascript" src="/js/web20/script.js"></script>
	<style>
		.main { width:100%; }
		.black-menu { width:100%; }
		.content { padding: 0px; }
		.black-menu-select a { text-decoration: none; }
		.count_n {margin-left:5px;}
		.like-ico {margin-top:1px;}
	</style>
	<script>
		$(document).ready(function(){$.get("http://myqube.ru<?=$_SERVER["REQUEST_URI"]?>?utm_source=google&utm_medium=teaser&utm_term=<?=$soc_network?>&utm_campaign=<?=$arPost["ID"]?>",function(data){});});
	</script>
	<div class="black-menu">
		<div class="black-menu-wrap">
			<div class="black-menu-select"><a href="/group/<?=$_GET["GROUP_ID"].$backurl?>">У меня уже есть аккаунт</a></div>
			<div class="black-menu-select"><a href="/group/<?=$_GET["GROUP_ID"].$backurl?>">Присоединиться к проекту</a></div>
		</div>
	</div>

	<div class="main">
		<div class="main-head">
			<div class="main-text"><?=$arPost["NAME"]?></div>
		</div>
		<div class="content">
			<div class="left-block">
				<!-- Три иконки справа -->
				<div class="like-menu">
					<div class="like-ico"><img src="/bitrix/templates/web20/images/like.png" alt="pic"><span class="count_n"><?=$arPost["PROPERTIES"]["LIKES"]["VALUE"]?></span></div>
					<div class="comment-ico"><img src="/images/comment.png" alt="pic"><span class="count_n"><?=$arPost["PROPERTIES"]["COMMENTS_COUNT"]["VALUE"]?></span></div>
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
							"PAGE_TITLE" => $arPost["NAME"],
							"PAGE_IMAGE" => "http://myqube.ru".$ogImage["src"],
							"SHORTEN_URL_LOGIN" => "",
							"SHORTEN_URL_KEY" => ""
						),
						false
					);?>
				</div>
				<div class="info-block">
					<div class="info-block-head">
					Дата публикации:</div>
					<div class="info-block-text"><?=FormatDate(array("d" => 'j F Y, H:i'), MakeTimeStamp($arPost["ACTIVE_FROM"], "DD.MM.YYYY HH:MI:SS"))?></div>
				</div>
				<div class="info-info-block">
					<div class="info-block">
						<div class="info-block-head">Описание:</div>
						<div class="info-block-text"><?=$arPost["PROPERTIES"]["OG_DESCRIPTION"]["VALUE"]["TEXT"]?></div>
					</div>
				</div>
			</div>
			<div class="right-block">
				<div class="main-img"style="height: auto; background:none;">
					<img src="<?=CFile::GetPath($arPost["PREVIEW_PICTURE"])?>" width="780">
				</div>
			</div>
		</div>
	</div>
<?}?>
