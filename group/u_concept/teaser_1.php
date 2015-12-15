<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>U_concept*</title>
    <meta name="description" content="Здесь разные виды искусств образуют невиданные ранее пары, чтобы на выходе подарить зрителю совершенно новый опыт. Только в Екатеринбурге. Зарегистрируйся, чтобы узнать больше.">
    <meta name="viewport" content="width=device-width, initial-scale=1; maximum-scale=1.0; user-scalable=0;">
    <link rel="stylesheet" href="/teaser_1/css/font-awesome.min.css">
    <link rel="stylesheet" href="/teaser_1/css/main2.css">
	<style>
			.b-header-share button{
				-webkit-appearance: none;
			}
		@media screen and (max-device-width: 640px){
			#nav_left_open{
				left: -100px;
			}
			
			.mobile-menu-ico {
				background: url(/images/menuicon.png );
				width: 40px;
				height: 40px;
				margin-left: 20px;
				position: absolute;
				top: 8px;
				left: 0px;
			}
			
	
			
			
			/* Menu */
			
							/* Menu icon  */
				.nav_item span.icon_userprofile{
					width: 14px;
					height: 14px;
					background-size: 100%;
				}
				.nav_item span.icon_usergroups{
					width: 18px;
					height: 14px;
					background-size: 100%;
				}
				.nav_item span.icon_group {
					width: 22px;
					height: 15px;
					/* background: url(/images/group_admin.png) 0px 0 no-repeat; */
					background-size: 100%;
				}
				.nav_item span.icon_communication {
					width: 18px;
					height: 15px;
					background-size: 100%;
				}
				.nav_item span.icon_usernews{
					    width: 18px;
						height: 14px;
						background-size:100%;
				}
				
				.nav_item span.icon_usercalendar{
					width: 15px;
					height: 20px;
					background-size: 100%;
				}
				
				.nav_item span.icon_logout{
					width: 18px;
					height: 18px;
					background-size: 100%;
				}
				

			/* End Menu icon  */
			
			
			
			
			
			
			
			
			
			
			

			#nav_left_open .nav_item{
				height: 60px !important;
			}
			
			.show_full_nav_full{
				width: 52px !important;
				margin-left: 25px !important;
			}

			
			#nav_left_open .nav_item span.nav_text{
				font-size: 10px;
			}
			#nav_left_open{
				width: 100px !important;
			}
			
/* 			.nav_item span:not(.nav_text){
				width: 14px;
				height: 14px;
				background-size: 100%;
			} */
			
			#nav_1{
				height:35px;
			}
			
			.nav_item_1{
				margin-top: 10px;
			}
			
			.show_full_nav{
				width: 17px;
				height: 27px;
				background-size: 100%;
			}
			

			#nav_1 a{
				margin: 0 12px;
				font-size: 12px !important;
			}
			#nav_1 div.item{
				margin-top:0px;
				line-height: 32px !important;
			}

			section nav#nav_1{
				top: 30px !important;
			}
			.mobile-menu-ico{
				width: 20px;
				height: 20px;
				background-size: 100%;
			}
		}
	</style>
</head>
<body>
<div class="l-wrapper-main">	
	<div class="b-header"><div class="mobile-block mobile-menu-ico" id="menu-button" style="display: block;"></div>
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
			"SHORTEN_URL_LOGIN" => "",
			"SHORTEN_URL_KEY" => ""
		),
		false
	);?>
		<p class="b-header__title">U_concept*</p>
		<span class="b-header__desc">*ю_концепт</span>
	</div>
	<div class="l-content">
		<div class="l-section l-section_about">
			<div class="l-container">
				<div class="l-row">
					<div class="l-row__col l-row__col_sm_6 b-img-block">
						<img class="b-img-block__img" src="/teaser_1/img/teaser2-img.jpg" alt="">
					</div>
					<div class="l-row__col l-row__col_sm_6 b-text-block b-text-block_transparent">
						<p class="b-title b-title_uppercase">О платформе</p>
						<p>В уникальном городском спектакле в рамках платформы «U_CONCEPT» соединились самая прогрессивная граффити-тусовка Екатеринбурга: Rayons, интерактивный театр, поэт и рэпер Наум Блик, известный дизайнер одежды Наталья Пастухова, а также лучшие деятели оперного и танцевального искусств города Екатеринбурга, известные далеко за его пределами. Что получилось из этих творческих союзов, вы узнаете совсем скоро.</p>
						<div class="b-mob-img">
							<img src="/teaser_1/img/teaser2-img-mob.jpg" class="b-mob-img__img" alt="">							
						</div>
						<div class="b-mob-img2">
							<img src="/teaser_1/img/teaser2-img-mob2.jpg" class="b-mob-img__img" alt="">							
						</div>
						<p class="b-text b-text_strong">До старта проекта осталось</p>
						<div class="b-timer"></div>
					</div>
				</div>				
			</div>
		</div>
		
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
			"SHORTEN_URL_LOGIN" => "",
			"SHORTEN_URL_KEY" => ""
		),
		false
	);?>	
	</div>
</div>
	<script>
	if($("#menu-button").css("display")=="block") {
			$("#menu-button").click(function(){
				if($("#nav_left_open").css('left') == '-100px'){
					$("#nav_left_open").animate({ left: '0' }, 600);
					$("div.main").animate({ left: '100' }, 600); 
					$("#nav_1").animate({ left: '100' }, 600); 
					$(".l-wrapper-main").animate({ left: '100' }, 600); 
					
					
				}
				if($("#nav_left_open").css('left') == '0px'){
					$("#nav_left_open").animate({ left: '-100' }, 600);
					$("div.main").animate({ left: '0' }, 600);
					$("#nav_1").animate({ left: '0' }, 600);
					$(".l-wrapper-main").animate({ left: '0' }, 600); 
				}
			});
	}
	
	</script>
	<script src="/teaser_1/js/main2.js"></script>
	<script>
	$('.b-timer').countdown('2015/11/01 02:00', function(event) {
    $(this).html(event.strftime("<span>%D</span><span>%H</span><span>%M</span>"));
  });
  </script>
</body>
</html>