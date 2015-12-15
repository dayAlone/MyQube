<!-- begin b-about  -->
<div class="l-section l-section--first b-about" id="about">
<meta name="viewport" content="width=device-width, initial-scale=1">
	<style>
	@media screen and (max-device-width: 640px){
	
	.l-container{
		position: relative;
	}
	
	#nav_left_open{
			left: -100px;
			width: 100px !important;
	}	
	
				/* Menu */
				
				#nav_left_open .nav_item{
					
					
				}
			
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
					background: url(/images/group_admin.png) 0px 0 no-repeat;
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
				
				#nav_left_open .nav_item {
					height: 54px!important;
				}
				#nav_left_open .nav_item span.nav_text{
					font-size:12px;
				}
				.nav_item_1 {
					margin-top: 0px !important;
				}
			/* End Menu icon  */
			
			
			
	}
	
	</style>
	<script>
		
			$(".b-header__toggle").click(function(){
				if($("#nav_left_open").css('left') == '-100px'){
					$("#nav_left_open").animate({ left: '0' }, 600);
			/* 		$("div.main").animate({ left: '100' }, 600);  */
					$("#nav_1").animate({ left: '100' }, 600); 	
					$(".l-container").animate({ left: '100' }, 600);  	
						
				}
				if($("#nav_left_open").css('left') == '0px'){
					$("#nav_left_open").animate({ left: '-100' }, 600);
				/* 	$("div.main").animate({ left: '0' }, 600); */
					$("#nav_1").animate({ left: '0' }, 600);
				 	$(".l-container").animate({ left: '0' }, 600); 	 
				}
			});
	
	
	</script>
	

	<div class="l-row">
		<div class="l-row__col l-row__col_sw_5 l-row__col_mw_6 l-row__col_sw_push_7 l-row__col_mw_push_6 b-text">
			<div class="b-text__title">О платформе</div><br>
			<p>Когда при взаимодействии пары объектов в результате получается нечто большее, чем просто их сумма, нам сразу хочется заглянуть внутрь процесса. Ведь именно благодаря подобным союзам привычные вещи трансформируются во что-то действительно необычное.<br>
			<span class="l-row__col_sw--unhide">Платформа <strong>«U_CONCEPT»</strong> создана для поддержки творческих союзов, синергия которых дарит зрителю совершенно новый уникальный опыт.</span></p>
		</div>
		<div class="l-row__col l-row__col_sw_7 l-row__col_mw_6 l-row__col_sw_pull_5 l-row__col_mw_pull_6 b-image">
			<img src="/images/uconcept/about-image.jpg" alt="Картинка к тексту">
		</div>
		<div class="l-row__col l-row__col_sw_5 l-row__col_sw--hide b-text">
			Платформа <strong>«U_CONCEPT»</strong> создана для поддержки творческих союзов, синергия которых дарит зрителю совершенно новый уникальный опыт.
		</div>
	</div>
</div>
<!-- end b-about -->