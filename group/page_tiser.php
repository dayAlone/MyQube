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
$res = CIBlockElement::GetList(array(), array("ID" => $_GET["POST_ID"]));
while($arRes = $res->GetNextElement()){
	$arItem = $arRes->GetFields();
	$arItem["PROPERTIES"] = $arRes->GetProperties();
	$arPost = $arItem;
}
$ogImage = CFile::ResizeImageGet($arPost["PROPERTIES"]["OG_IMAGE"]["VALUE"], array('width'=>600, 'height'=>600), BX_RESIZE_IMAGE_PROPORTIONAL, true);?>
<title><?=$arPost["NAME"]?></title>
<meta name="description" content="<?=$arPost["PROPERTIES"]["OG_DESCRIPTION"]["VALUE"]["TEXT"]?>">
<link rel="image_src" href="http://myqube.ru<?=$ogImage["src"]?>" />
<?
$APPLICATION->SetPageProperty("title", $arPost["NAME"]);
$APPLICATION->SetPageProperty("description", $arPost["PROPERTIES"]["OG_DESCRIPTION"]["VALUE"]["TEXT"]);
$APPLICATION->SetPageProperty("og:title", $arPost["NAME"]);
$APPLICATION->SetPageProperty("og:description", $arPost["PROPERTIES"]["OG_DESCRIPTION"]["VALUE"]["TEXT"]);
$APPLICATION->SetPageProperty("og:image", "http://myqube.ru".str_replace(' ','%20',$ogImage["src"]));
$APPLICATION->SetPageProperty("og:url", "http://myqube.ru".$_SERVER["REQUEST_URI"]);

if($arPost["IBLOCK_ID"] == 1 || $arPost["IBLOCK_ID"] == 7) {?>
	<!--link type="text/css" rel="stylesheet" href="/css/teaser.css"-->
<!--	<script type="text/javascript" src="/js/plugins/jquery-ui/jquery-ui.min.js"></script>
	<script type="text/javascript" src="/js/plugins/jquery.slimscroll/jquery.slimscroll.min.js"></script>
	<script type="text/javascript" src="/js/plugins/jquery.fancybox/jquery.fancybox.js"></script>
	<link type="text/css" rel="stylesheet" href="/js/plugins/jquery.fancybox/jquery.fancybox.css"> -->
<!--	<script type="text/javascript" src="/js/web20/script.js"></script>-->
	<style> 
	
 	@font-face {
    font-family: "GothamProRegular";
    src: url("/bitrix/fonts/GothamProRegular/GothamProRegular.eot");
    src: url("/bitrix/fonts/GothamProRegular/GothamProRegular.eot?#iefix")format("embedded-opentype"),
    url("/bitrix/fonts/GothamProRegular/GothamProRegular.woff") format("woff"),
    url("/bitrix/fonts/GothamProRegular/GothamProRegular.ttf") format("truetype");
    font-style: normal;
    font-weight: normal;
	}
	@font-face {
		font-family: "GothamProBold";
		src: url("/bitrix/fonts/GothamProBold/GothamProBold.eot");
		src: url("/bitrix/fonts/GothamProBold/GothamProBold.eot?#iefix")format("embedded-opentype"),
		url("/bitrix/fonts/GothamProBold/GothamProBold.woff") format("woff"),
		url("/bitrix/fonts/GothamProBold/GothamProBold.ttf") format("truetype");
		font-style: normal;
		font-weight: normal;
	} 
	
	
	.ntiser-body-wrapper {
		width: 1000px;
		margin:5% auto 0;
	
	}
	body{
		margin:0;
		background: #e6e6e6;
	}

	.ntiser-body{
		overflow: hidden;
		width: 1000px;
		border-radius: 7px;
		background: #010D23;
		box-shadow: 0px 0px 20px #828282;
	}
	.ntiser-body p {
		line-height: 1.3;
		font-size: 16px;
		margin: 15px 0px;
	}
	.ntiser-logo{
		margin:15px 0;
	}
	.ntiser-img{
		background: url( '<?=CFile::GetPath($arPost["PREVIEW_PICTURE"])?>' );
		width: 500px;
		height: 340px;
		float: left;
	}
	.ntiser-text{
		font-family: GothamProRegular,"Helvetica Neue",Helvetica,Arial,sans-serif;
		padding: 0 35px;
		color: #fff;
		width: 430px;
		float: left;
		background: #010D23;
		
	}
	.ntiser-text h1{
		font-family: GothaProBold, sans-serif;
		font-weight: 800;
		text-transform: uppercase;
		font-size: 36px;
		margin: 25px 0;
	}

	.ntiser-text .center button{
		width: 250px;
		border: 3px solid #4AB7D4;
		height: 50px;
		color: #fff;
		background: rgba(255,255,255, 0);
		text-transform: uppercase;
		font-size: 14px;
		font-weight: 800;
		cursor: pointer;
	}
	
	div.nteaser-text-small{
		font-size: 11px; 
		    float: left;
			margin: 20px 34px;
	}
	
	
	.mobile-block{
		display: none;
	}
		.nomobile{
			display: block;
		}

	@media screen and (max-device-width: 640px) { 

		
		.ntiser-body{
			width: 100%;
		}
		
		.ntiser-body{
			box-shadow: none;
		}
		.ntiser-logo{
			margin-left:3.4%;
			width: 200px;
		}
		.ntiser-body-wrapper{
			width:100%;
		}
		.ntiser-text .center button {
			font-size:22px;
			width: 320px;
			height:65px;
		}
		div.nteaser-text-small{
			font-size: 18px;
			text-align: center;
			margin: 20px auto;
			width: 100%;
		
		}
		.ntiser-img{
			float: none;
			width: 100%;
			background-size: cover;
		}
		.ntiser-text{
			width: 90%;
			padding: 0 5%;
		}
		.center{
			text-align: center;
		}

		body{
			background: #010D23;
		}
		.ntiser-body{
			border-radius: 0px;
		}
		
		.nomobile{
			display: none;
		}
		.mobile-block{
			display: block;
		}	



	 }
	</style>
	
	<script>
		$(document).ready(function(){$.get("http://myqube.ru<?=$_SERVER["REQUEST_URI"]?>?utm_source=google&utm_medium=teaser&utm_term=<?=$soc_network?>&utm_campaign=<?=$arPost["ID"]?>",function(data){});});
	</script>
	<div class="ntiser-body-wrapper">
		<img src="/images/logo-nteaser.png" alt="MyQube" class="ntiser-logo">
		<div class="ntiser-body">
			<div class="ntiser-img nomobile"></div>
			<div class="ntiser-text">
				<h1><?=$arPost["NAME"]?></h1>
				<div class="ntiser-img mobile-block"></div>
				<p class="nteaser-text-big"><?=$arPost["PROPERTIES"]["OG_DESCRIPTION"]["VALUE"]["TEXT"]?></p>
				<div class="center">
					<button onclick="location.href='/group/<?=$_GET["GROUP_ID"].$backurl?>'"><?=$arPost['IBLOCK_ID'] == 7 ? "К фотоотчёту" : "Читать далее"?></button>
				</div>			
			
			</div>
			<div class="nteaser-text-small">Материал доступен только зарегистрированным пользователям</div>
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