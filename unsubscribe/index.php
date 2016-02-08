<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("unsubscribe");

if(!empty($_GET["id"])) {
	$USER->Update($_GET["id"], array("UF_NOTICE_FROM_BAT" => 1));
	?>
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

		body{
			margin:0;
			background: #010D23;
			font-family: GothaProRegular, sans-serif;
		}
		.unsubscribe{
			font-size: 16px;
			line-height: 1.2;
			width: 350px;
			margin: 30vh auto;
		}
		.unsubscribe button{
			width: 250px;
			border: 3px solid #4AB7D4;
			height: 50px;
			color: #fff;
			background: rgba(255,255,255, 0);
			text-transform: uppercase;
			font-size: 14px;
			font-weight: 800;
			cursor: pointer;
			margin: 40px auto;
			display: block;
		}
		.unsubscribe-text{
			text-align: center;
			margin: auto;
			color: #fff;

		}

		.unsubscribe-logo{
		background: url( /images/uns-kentlab.png);
		width:125px;
		height:27px;
		margin: 20vh auto;
		}

		@media screen and (max-device-width: 640px) {
			.unsubscribe{
				width:320px
			}
			..unsubscribe-text{
			font-size: 12px}

		}


	</style>
	<div class="unsubscribe">
		<p class="unsubscribe-text">Уважаемые пользователи!<br>
		Вы отписались от автоматической рассылки уведомлений закрытой группы Kent Lab
		</p>
		<button onclick="location.href='/group/1/'">Перейти в группу</button>
		<div class="unsubscribe-logo"></div>

	</div>
<?} elseif(!empty($_GET["email"])||!empty($_GET["md_email"])) {
	$Query = CUser::GetList(
			($by="id"),
			($order="desc"),
			array("EMAIL" => $_GET["email"]),
			array("SELECT"=>array("UF_YOU_HAVE_18"))
		)->Fetch();
	if($Query["ID"] > 0) {
		$USER->Update($Query["ID"], array("UF_NOTICE_FROM_BAT" => 1));
	} else {
		CModule::IncludeModule("iblock");
		$NewElement = new CIBlockElement;
		$NewElement->Add(array(
			"NAME" => $_GET["email"],
			"IBLOCK_ID" => 23
		));
	}
	?>
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

		body{
			margin:0;
			background: #010D23;
			font-family: GothaProRegular, sans-serif;
		}
		.unsubscribe{
			font-size: 16px;
			line-height: 1.2;
			width: 350px;
			margin: 30vh auto;
		}
		.unsubscribe button{
			width: 250px;
			border: 3px solid #4AB7D4;
			height: 50px;
			color: #fff;
			background: rgba(255,255,255, 0);
			text-transform: uppercase;
			font-size: 14px;
			font-weight: 800;
			cursor: pointer;
			margin: 40px auto;
			display: block;
		}
		.unsubscribe-text{
			text-align: center;
			margin: auto;
			color: #fff;

		}

		.unsubscribe-logo{
		background: url( /images/uns-kentlab.png);
		width:125px;
		height:27px;
		margin: 20vh auto;
		}

		@media screen and (max-device-width: 640px) {
			.unsubscribe{
				width:320px
			}
			..unsubscribe-text{
			font-size: 12px}

		}


	</style>
	<div class="unsubscribe">
		<p class="unsubscribe-text">Уважаемые пользователи!<br>
		Вы отписались от автоматической рассылки уведомлений закрытой группы Kent Lab
		</p>
		<button onclick="location.href='/group/1/'">Перейти в группу</button>
		<div class="unsubscribe-logo"></div>

	</div>
<?}

require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>
