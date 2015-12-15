<script src="//code.jquery.com/jquery-1.8.3.js"></script>
<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
<script src="/js/jquery.ui.touch-punch.min.js"></script>			
<script type="text/javascript" src="/js/plugins/jquery.slimscroll/jquery.slimscroll.min.js"></script>
<link type="text/css" rel="stylesheet" href="/css/group.css">
<script type="text/javascript" src="/js/web20/script.js"></script>
<script>
	$(function(){
		$('.privacy-text').slimScroll({
			color: '#00d6ff',
			size: '10px',
			width: '630px',
			height: '430px',
			distance: '10px',
			alwaysVisible: true,
		});
	});
</script>
<style>
		.main {
			padding-left: 0px !important;
		}
        #nav_left_open{
            left: -165px !important;
        }
    
		input[type="checkbox"] + label {
			margin-left: 0px;
		}
		.enter_page_leftcol label div {
			margin-left: 0px;
			width: auto;
		}
		.error {
			margin: auto;
		}
		.slimScrollDiv {
			padding-right:30px;
		}
		.enter_page_rightcol {
			 background-repeat: no-repeat;
			 background-size: 100% 100%;
			 display:table;
			 position: relative;
		}
		.container {
			display: block;
			position: absolute;
		}
		.privacy-window {
			position: absolute;
		}
		#scroll {
			display:table-cell;
			vertical-align: bottom;
		}
		.enter_page_group_item {
			position: static;
			height: auto;
			border: none;
		}
		.enter_page_group_item h1 {
			width: 400px;
		}
		.enter_page_members {
			position:relative;
			margin-top: 10px;
			margin-bottom: 30px;
		}
		.enter_page_group_lock {
			position: absolute;
			top:45%;
			right:43%;
		}
	</style>
	<div class="enter_page">
		<div class="enter_page_rightcol" style="background-image: url('<?=CFile::GetPath($arGroup["DETAIL_PICTURE"])?>');">
		
			<?if($_GET["message"] == "checking_user_fields" && $_GET["step"] == "2") {?>
				
				<div class="container">
					<div class="privacy-window">
						<div class="wrap-privacy">
							<div class="privacy-text">
							
							<?include("registration_info.php");?>
							
							</div>
						</div>
						<div class="privacy-shadow"></div>
					</div>
				</div>
				
			<?}?>
		
			<div id="scroll">
				<div class="enter_page_group_item">
					<h1><?=$arGroup["NAME"]?><br><?=$arGroup["PREVIEW_TEXT"]?></h1>
					<div class="enter_page_members"><img src="<?=SITE_TEMPLATE_PATH?>/images/members_icon.png"><?=$arProps["USERS"]["VALUE"] ? $arProps["USERS"]["VALUE"] : 0?> Участников</div>
					<div class="enter_page_group_lock"><img src="<?=SITE_TEMPLATE_PATH?>/images/lock_group_icon.png"><br>Это закрытая группа</div>
				</div>
			</div>
		</div>
		<div class="enter_page_leftcol">
		
			<?if($_GET["message"] == "birthday") {?>
			
				<style>
                       @media screen and (max-device-width: 640px){
                            .enter_page_leftcol_text{
                                height: auto;
                            }
                            
                            .enter_page_input{
                                margin-bottom: 0px;
                            }  
                            
                            .popup-text-reg-block{
                                z-index: 10;
                                position: absolute;
                                width: 100%;
                                height: 100%;
                                background: rgba(0,0,0,.9);
                                color: #fff;
                            } 
                            
                            .popup-text-reg-block-text{
                                margin: 20px;
                                height: 60%;
                                text-align: left;
                                font-size: 14px;
                                line-height: 1.5;
                                overflow-y: scroll;
                            }      
                            .popup-text-reg-block-text:after{
                                width: 100%;
                                height: 100px;
                                position: relative;
                                top: -100px;
                                background: #ffffff;
                                background: -moz-linear-gradient(top,  #ffffff 0%, #000000 100%);
                                background: -webkit-gradient(linear, left top, left bottom, color-stop(0%,#ffffff), color-stop(100%,#000000));
                                background: -webkit-linear-gradient(top,  #ffffff 0%,#000000 100%);
                                background: -o-linear-gradient(top,  #ffffff 0%,#000000 100%);
                                background: -ms-linear-gradient(top,  #ffffff 0%,#000000 100%);
                                background: linear-gradient(to bottom,  rgba( 0,0,0,0 ) 0%, rgba( 0,0,0,1 ) 100%);
                                filter: progid:DXImageTransform.Microsoft.gradient( startColorstr="#ffffff", endColorstr="#000000",GradientType=0 );  
                                
                            }
                            .popup-text-reg-block input{
                                margin: 20px auto;
                                position: static;
                                height: 40px;
                                width: 40px;
                            }
                        
                        .popup-text-reg-block-input-text{
                            font-size: 20px;
                        }

                            
                                 
                        }
				</style>
				<div class="mobile-block popup-text-reg-block">
					<div class="popup-text-reg-block-text">
					
						<?include("registration_info.php");?>
					
					</div>
					<div class="popup-text-reg-block-shadow"></div>
					<input id="popup-chechbox" type="checkbox"/>
					<div class="popup-text-reg-block-input-text">СОГЛАСЕН С ПРАВИЛАМИ</div>
				</div>  
				
			<?}?>
			
			<style>
				.enter_page_leftcol_cont {
					vertical-align: middle;
					display: table;	
				}
				#page_inside_middle {
					vertical-align: middle;
					display: table-cell;
				}
                @media screen and (max-device-width: 640px){
                    .enter_page_leftcol_cont {
                        display: block;
                        
                    }  
    				#page_inside_middle {
    				    display: block;
    				}                     
                }
				#return_main_page {
					display:none;
				}
				.enter_page_input_date {
					width: 80px;
					text-align: center;
					padding: 0;
					margin-left: 20px;
				}
				#enter_page_form input[type=submit] {
					border-style: solid;
					border-width: 2px;
					border-color: #fff;
					border-radius: 8px;
					background-color: #ff4500;
					font-size: 11px;
					font-family: 'GothamProBold';
					color: #fff;
					text-transform: uppercase;
					text-align: center;
					width: 338px;
					height: 50px;
					cursor: pointer;
					-webkit-appearance: none;
				}
			</style>
			<div class="enter_page_leftcol_cont">
			<style>
			@media screen and (max-device-width: 640px){
			.enter_page_leftcol_cont {				
				min-height: auto !important;
			}
			}
			</style>
			
				<?if($_GET["message"] == "birthday") {
					if($_POST["DD"]) {
						if($_POST["DO_YOU_SMOKE"]) $smoke = true; else $smoke = false;
						if(18 > (date("Y") - date("Y",strtotime($_POST["DD"].'.'.$_POST["MM"].'.'.$_POST["YYYY"])))) $smoke = false;
						$Fields = array(
							"PERSONAL_BIRTHDAY" => $_POST["DD"].'.'.$_POST["MM"].'.'.$_POST["YYYY"],
							"UF_DO_YOU_SMOKE" => $_POST["DO_YOU_SMOKE"]
						);
						CustomUser::UserUpdate($Fields);
						if(strripos($_GET["backurl"], "?message="))
							$backurl = substr($_GET["backurl"], 0, strripos($_GET["backurl"], "?message="));
						LocalRedirect("/group/1/&backurl=".$backurl);                        
					}?>

					<link rel="stylesheet" href="../../mobile/reg.css">
                    <div class="mobile-block header-reg-mobile">
                        <div class="header-reg-mobile-up">
                            <div class="header-reg-mobile-up-left"></div>
                            <div class="header-reg-mobile-up-logo"></div>
                        </div>
                        <div class="header-reg-mobile-down">
                            <div class="header-reg-mobile-down-lock"></div>
                            <div class="header-reg-mobile-down-text">KENT Lab Innovations, Experience, Trends</div>
                        </div>
                    </div>
					<div id="page_inside_middle">
						<img src="/bitrix/templates/web20/images/enter_page_calendar.png" class="enter_page_leftcol_lock_icon">
						<br>
						<div class="enter_page_leftcol_text">
							При авторизации через социальную сеть<br>
							не был идентифицирован Ваш возраст.<br>
							Просим ввести день, месяц и год Вашего рождения.<br>
							<a href="/" id="return_main_page">Перейти на главную страницу</a>
						</div>
						<form name="BIRTHDAY" id="enter_page_form" method="post" target="_top" action="?message=birthday&backurl=<?=$_GET["backurl"];?>">
							<input type="text" name="DD" maxlength="2" placeholder="ДД" class="enter_page_input enter_page_input_date requried">
							<input type="text" name="MM" maxlength="2" placeholder="ММ" class="enter_page_input enter_page_input_date requried">
							<input type="text" name="YYYY" maxlength="4" placeholder="ГГГГ" class="enter_page_input enter_page_input_date requried"><br>
							<div class="error birthday">Пожалуйста, укажите вашу<br> дату рождения</div><br>
							<input type="checkbox" name="DO_YOU_SMOKE" id="do_you_smoke" class="enter_page_input requried">
							<label for="do_you_smoke">
								<div>Я подтверждаю, что являюсь<br> совершеннолетним курильщиком</div>
							</label>
							<!--div class="error do_you_smoke">Данная группа предназначена<br> для совершеннолетних курильщиков</div--><br>
							<input type="submit" src="/bitrix/templates/web20/images/enter_page_submit.png" value="Продолжить">
						</form>
					</div>
					
				<?} elseif($_GET["message"] == "checking_user_fields") {
					$CurentUser = CUser::GetByID($USER->GetID())->Fetch();
					$date = explode(".", $CurentUser["PERSONAL_BIRTHDAY"]);
					if($_POST["USER_NAME"]) {
						$Fields = array(
							"NAME" => $_POST["USER_NAME"],
							"EMAIL" => $_POST["USER_EMAIL"],
							//"PERSONAL_BIRTHDAY" => $_POST["DD"].'.'.$_POST["MM"].'.'.$_POST["YYYY"]
						);
						CustomUser::UserUpdate($Fields);
						if(strripos($_GET["backurl"], "?message="))
							$backurl = substr($_GET["backurl"], 0, strripos($_GET["backurl"], "?message="));
						LocalRedirect("/group/1/?message=checking_user_fields&step=2&backurl=".$backurl);
					} elseif($_GET["step"] == 2 && $_POST["BRAND_1"]) {		
						if($_POST["DO_YOU_SMOKE"]) $smoke = true; else $smoke = false;
						if($_POST["IAGREE"]) $iagree = true; else $iagree = false;
						$Fields = array(
							"UF_IAGREE" => $iagree,
							"UF_DO_YOU_SMOKE" => $smoke,
							"UF_BRAND_1" => $_POST["BRAND_1"],
							"UF_BRAND_2" => $_POST["BRAND_2"]
						);
						CustomUser::UserUpdate($Fields);
						if(strripos($_GET["backurl"], "?message="))
							$backurl = substr($_GET["backurl"], 0, strripos($_GET["backurl"], "?message="));
						LocalRedirect("/group/1/&backurl=".$backurl);
					}
					?>
					
                    <link rel="stylesheet" href="../../mobile/reg.css">
                    <div class="mobile-block header-reg-mobile">
                        <div class="header-reg-mobile-up">
                            <a href="../../index.php"><div class="header-reg-mobile-up-left"></div></a>
                            <div class="header-reg-mobile-up-logo"></div>
                        </div>
                        <div class="header-reg-mobile-down">
                            <div class="header-reg-mobile-down-lock"></div>
                            <div class="header-reg-mobile-down-text">KENT Lab Innovations, Experience, Trends</div>
                        </div>
                    </div>
                    <div id="page_inside_middle">
						<img src="/bitrix/templates/web20/images/enter_page_add_user.png" class="enter_page_leftcol_lock_icon">
						<br>
						<div class="enter_page_leftcol_text">
							<h4>Регистрация</h4>
							Мы приветствуем Вас на странице самого<br>
							стильного закрытого сообщества Kent Lab!<br>
							<a href="/" id="return_main_page">Перейти на главную страницу</a>
						</div>
						<form name="REGISTRATION" id="enter_page_form" method="post" target="_top" action="?message=checking_user_fields&step=2&backurl=<?=$_GET["backurl"];?>">
						
							<?if(empty($_GET["step"])) {?>
							
								<input type="text" name="USER_NAME" id="user_name" maxlength="50" value="<?=$CurentUser["NAME"]?>" class="enter_page_input requried" placeholder="Введите имя"><br>
								<div class="error user_name">Пожалуйста, укажите ваше имя</div>
								<input type="email" name="USER_EMAIL" id="user_email" maxlength="50" value="<?=strripos($CurentUser["EMAIL"], "kentlabemail") ? "" : $CurentUser["EMAIL"]?>" class="enter_page_input requried" placeholder="Адрес электронной почты"><br>
								<div class="error user_email">Пожалуйста, укажите корректный<br> адрес электронной почты</div>
								<input type="text" name="DD" maxlength="2" placeholder="ДД"<?if(!empty($date)) echo " disabled";?> value="<?=$date[0]?>" class="enter_page_input enter_page_input_date requried">
								<input type="text" name="MM" maxlength="2" placeholder="ММ"<?if(!empty($date)) echo " disabled";?> value="<?=$date[1]?>" class="enter_page_input enter_page_input_date requried">
								<input type="text" name="YYYY" maxlength="4" placeholder="ГГГГ"<?if(!empty($date)) echo " disabled";?> value="<?=$date[2]?>" class="enter_page_input enter_page_input_date requried"><br>
								<div class="error birthday">Пожалуйста, укажите вашу<br> дату рождения</div>
								<input type="submit" src="/bitrix/templates/web20/images/enter_page_submit.png" value="Перейти на последний шаг регистрации">
								
							<?} elseif($_GET["step"] == 2) {?>	
							
								<style>
									@media screen and (max-device-width: 640px){
										.enter_page_leftcol{
											position: static !important;
											left:0px !important;
										}
										.enter_page_leftcol_text{
											height: auto !important;
										}
									}
								</style>					
								<input type="text" id="user_brand1" name="BRAND_1" maxlength="50" placeholder="Предпочитаемая марка сигарет 1" class="enter_page_input requried"><br>
								<div class="error user_brand1">Введите марку сигарет</div>
								<input type="text" id="user_brand2" name="BRAND_2" maxlength="50" placeholder="Предпочитаемая марка сигарет 2" class="enter_page_input"><br>
								<div class="error user_brand2">Введите марку сигарет</div>		
								<input type="checkbox" name="IAGREE" id="iagree" class="enter_page_input requried">
								<label for="iagree">
									<div>Даю согласие на обработку моих персональных данных</div>
								</label><br>
								<div class="error iagree">Требуется согласие на обработку<br /> ваших персональных данных</div><br>
								<input type="checkbox" name="DO_YOU_SMOKE"<?if(!empty($CurentUser["UF_DO_YOU_SMOKE"])) echo ' checked style="display:none;"';?> id="do_you_smoke" class="enter_page_input requried">
								<label for="do_you_smoke"<?if(!empty($CurentUser["UF_DO_YOU_SMOKE"])) echo ' style="display:none;"';?>>
									<div>Я подтверждаю, что являюсь<br> совершеннолетним курильщиком</div>
								</label>
								<!--div class="error do_you_smoke">Данная группа предназначена<br> для совершеннолетних курильщиков</div-->
								<input type="submit" src="/bitrix/templates/web20/images/enter_page_submit.png" value="Зарегистрироваться">
								
							<?}?>
							
						</form>
					</div>
					
				<?} elseif($_GET["message"] == "you_are_under_18") {?>
				
					<br><br><br><br><br><br>
					<img src="/bitrix/templates/web20/images/enter_page_no_access.png" class="enter_page_leftcol_lock_icon">
					<br>
					<div class="enter_page_leftcol_text">
						К сожалению, данная группа открыта только<br>
						для совершеннолетних курильщиков.<br>
						<a href="/">Перейти на главную страницу</a>
					</div>
					
				<?} else {?>
				
                    <div class="container" style="display:none;">
						<div class="background-container"></div>
						
						<?include("ajax/1/manifest.php");?>
						
					</div>
                    <style>
						@media screen and (max-device-width: 640px){
							.enter_page_leftcol{
								left: 0px;
							}
							.enter_page{
							   min-height: 960px;  
							}
							.enter_page_leftcol_text{
								height: auto;
							}
							.enter_page_input{
								margin-bottom: 0px;
							}  	
							div.main{
								height: auto !important;
							}							
						}
                    </style>
                    <link rel="stylesheet" href="../../mobile/reg.css">  
					<div class="mobile-block header-reg-mobile">
                        <div class="header-reg-mobile-up">
                            <a href="../../index.php"><div class="header-reg-mobile-up-left"></div></a>
                            <div class="header-reg-mobile-up-logo"></div>
                        </div>
                        <div class="header-reg-mobile-down">
                            <div class="header-reg-mobile-down-lock"></div>
                            <div class="header-reg-mobile-down-text">KENT Lab Innovations, Experience, Trends</div>
                        </div>
                    </div>
					
					<?$APPLICATION->IncludeComponent(
						"bitrix:system.auth.form", 
						"myqube", 
						array(
							"REGISTER_URL" => "/",
							"PROFILE_URL" => "/user/profile/",
							"FORGOT_PASSWORD_URL" => "",
							"SHOW_ERRORS" => "Y"
						),
						false
					);?>
				<?}?>
				
				<div class="enter_page_rights">
					© 2015 MyQube. Все права защищены.<br>
					Социальная сеть предназначена для лиц старше 18 лет
				</div>
			</div>
            <div class="reg-mobile-footer mobile-block">
                <div>ПОЛИТИКА КОНФИДЕНЦИАЛЬНОСТИ</div>
                <div>
					<span>О ГРУППЕ   </span>|
					<span>  МАНИФЕСТ</span>                
                </div>
            </div>
		</div>
	</div>