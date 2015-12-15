<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<link href='https://fonts.googleapis.com/css?family=Exo+2:100,400,300,600,700&subset=latin,cyrillic' rel='stylesheet' type='text/css'>
<link rel="stylesheet" href="/css/font-awesome_concept.min.css">
<link rel="stylesheet" href="/css/main_concept.css">
<!-- begin l-container  -->
<div class="l-container">
	<div class="b-navigation">
		<ul>
			<li class="active"><a href="#about"></a></li>
			<!-- <li><a href="#authors"></a></li> -->
			<li><a href="#projects"></a></li>
			<li><a href="#winner"></a></li>
		
			<!--li><a href="#registration"></a></li-->
			<li><a href="#photos"></a></li>
			<!--li><a href="#final"></a></li-->
		</ul>
	</div>
	<header class="b-header">
		<div class="b-header-wrapper">
			<button class="b-header__toggle" title="Открыть меню">
				<span></span>
				<span></span>
				<span></span>
			</button>
			<a href="/group/1/" class="b-header__close">
				<img src="/images/uconcept/close.svg" alt="Иконка кнопки">
			</a>
			<?$APPLICATION->IncludeComponent(
				"bitrix:main.share", 
				"myqube_uconcept", 
				array(
					"COMPONENT_TEMPLATE" => "myqube_uconcept",
					"HIDE" => "N",
					"HANDLERS" => array(
						0 => "facebook",
						1 => "vk",
						2 => "Google",
					),
					"PAGE_URL" => "/group/1/u_concept/",
					"PAGE_TITLE" => "U_CONCEPT",
					"PAGE_IMAGE" => "http://myqube.ru/upload/Concept-Ural_sharing_960.jpg",
					"SHORTEN_URL_LOGIN" => "",
					"SHORTEN_URL_KEY" => ""
				),
				false
			);?>
			<p class="b-header__title">U_concept*</p>
			<span class="b-header__desc">*ю_концепт</span>
		</div>
	</header>
	<!-- begin l-content  -->
	<div class="l-content">		
		<?
		$_SESSION["BackFromDetail"]["u_concept"] = 1;
		include("page_about.php");
		//include("page_users.php");
		include("page_projects.php");
		//include("page_performance.php");
		include("page_winner.php");
		include("page_photo.php");
		//include("page_final.php");
		?>
		<?$APPLICATION->IncludeComponent(
			"bitrix:main.share", 
			"myqube_uconcept_bottom", 
			array(
				"COMPONENT_TEMPLATE" => "myqube_uconcept",
				"HIDE" => "N",
				"HANDLERS" => array(
					0 => "facebook",
					1 => "vk",
					2 => "Google",
				),
				"PAGE_URL" => "/group/1/u_concept/",
				"PAGE_TITLE" => "U_CONCEPT",
				"PAGE_IMAGE" => "http://myqube.ru/upload/Concept-Ural_sharing_960.jpg",
				"SHORTEN_URL_LOGIN" => "",
				"SHORTEN_URL_KEY" => ""
			),
			false
		);?>	
	</div>
	<!-- end l-content -->
</div>
<!-- end l-container -->
<!-- begin b-modal  -->
<div class="b-modal b-modal--sm" id="code-error-modal">
	<p>вы не ввели код</p>
</div>
<div class="b-modal b-modal--sm" id="code_e-error-modal">
	<p>Введенный вами код не действителен</p>
</div>
<div class="b-modal b-modal--sm" id="email-error-modal">
	<p>вы не ввели email</p>
</div>
<div class="b-modal b-modal--sm" id="phone-error-modal">
	<p>вы не ввели телефон</p>
</div>
<div class="b-modal " id="form-success-modal">
	<p>Вы успешно зарегистрировались. Электронный билет отправлен на введенный вами e-mail</p>
</div>
<div class="b-modal " id="form-fail-modal">
	<p>Регистрация не удалась. Вероятно закончились свободные места, либо введеный код уже был использован</p>
</div>
<div class="b-modal " id="form-double-modal">
	<p>Вы уже были зарегистрированы на один из городских спектаклей</p>
</div>
<!-- end b-modal -->
<script src="/js/main_concept.js"></script>