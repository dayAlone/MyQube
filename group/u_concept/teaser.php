<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="/u_concept_teaser/css/main.css">
	<?if(!empty($_GET["photo"])) {?>		
		<title>Городской спектакль U_concept / Екатеринбург</title>
		<meta name="description" content="Здесь разные виды искусств образуют невиданные ранее пары, чтобы на выходе подарить зрителю совершенно новый опыт. Только в Екатеринбурге. Зарегистрируйся, чтобы узнать больше.">
		<?$image_small = CFile::ResizeImageGet($_GET["photo"], array("width" => 600, "height" => 600));
		$APPLICATION->SetPageProperty("og:image", "http://myqube.ru".$image_small["src"]);
		$APPLICATION->SetPageProperty("og:url", "http://myqube.ru/group/1/u_concept/?photo=".$_GET["photo"]);
		$APPLICATION->SetPageProperty("title", "Городской спектакль U_concept / Екатеринбург");
		$APPLICATION->SetPageProperty("description", "Здесь разные виды искусств образуют невиданные ранее пары, чтобы на выходе подарить зрителю совершенно новый опыт. Только в Екатеринбурге. Зарегистрируйся, чтобы узнать больше.");
		$APPLICATION->SetPageProperty("og:title", "Городской спектакль U_concept / Екатеринбург");
		$APPLICATION->SetPageProperty("og:description", "Здесь разные виды искусств образуют невиданные ранее пары, чтобы на выходе подарить зрителю совершенно новый опыт. Только в Екатеринбурге. Зарегистрируйся, чтобы узнать больше.");
	} else {?>	
		<title>Искусство U_Concept</title>
		<meta name="description" content="Здесь разные виды искусств образуют невиданные ранее пары, чтобы на выходе подарить зрителю совершенно новый опыт. Только в Екатеринбурге. Зарегистрируйся, чтобы узнать больше.">
		<?$APPLICATION->SetPageProperty("og:image", "http://myqube.ru/upload/Concept-Ural_sharing_960.jpg");
		$APPLICATION->SetPageProperty("og:url", "http://myqube.ru/group/1/u_concept/");
		$APPLICATION->SetPageProperty("title", "Искусство U_Concept");
		$APPLICATION->SetPageProperty("description", "Здесь разные виды искусств образуют невиданные ранее пары, чтобы на выходе подарить зрителю совершенно новый опыт. Только в Екатеринбурге. Зарегистрируйся, чтобы узнать больше.");
		$APPLICATION->SetPageProperty("og:title", "Искусство U_Concept");
		$APPLICATION->SetPageProperty("og:description", "Здесь разные виды искусств образуют невиданные ранее пары, чтобы на выходе подарить зрителю совершенно новый опыт. Только в Екатеринбурге. Зарегистрируйся, чтобы узнать больше.");
	}?>
</head>
<body>
<div class="l-wrapper">	
	<div class="b-main">
		<div class="b-main__wrap">
			<h1 class="b-main__title">U_concept<sup>*</sup></h1>
			<p class="b-main__text">Платформа для <span>необычных городских проектов,</span> <span>где встретились представители</span> разных видов искусств. Место действия, <span>сцена, площадка и материал –</span> <span>город Екатеринбург. Зрители – больше чем зрители.</span> <span>И совершенно новый опыт в результате.</span></p>
			<a href="/group/1/?backurl=/group/1/u_concept/" class="b-main__link">зарегистрироваться</a>
			<span class="b-main__desc">*ю_концепт</span>

		</div>
	</div>
</div>
	<script src="/u_concept_teaser/js/main.js"></script>
</body>
</html>