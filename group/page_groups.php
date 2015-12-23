<? $geiop = CAltasibGeoBase::GetAddres();?>
<link type="text/css" rel="stylesheet" href="/css/group.css">
		<script type="text/javascript" src="/js/plugins/jquery-ui/jquery-ui.min.js"></script>
		<script type="text/javascript" src="/js/plugins/jquery.slimscroll/jquery.slimscroll.min.js"></script>
		<script type="text/javascript" src="/js/plugins/jquery.fancybox/jquery.fancybox.js"></script>
		<link type="text/css" rel="stylesheet" href="/js/plugins/jquery.fancybox/jquery.fancybox.css">
		<script type="text/javascript" src="/js/web20/script.js"></script>

		<style>
			.events .slogan {
				position:absolute;
				right: 15px;
				bottom: 15px;
				font-size: 12px;
			}
			.events .nomobile {
				float: right;
				padding: 0 20px;
				color: #FFFFFF;
				line-height:28px;
				margin-top: -10px;
			}
			.events .nomobile img {
				margin-right:10px;
				vertical-align:top;
			}
			.search-form {
				position: absolute;
				right: 0;
				width: 10% !important;
			}
		</style>

	    <div class="shadow-menu-popup">
            <div class="menu-popup">
                <div class="close-menu-popup">x</div>
                <ul>
                    <li><a href="/group/1/">Лента</a></li>
                    <li><a href="/group/1/photo/">Фото</a></li>
                    <li><a href="/group/1/video/">Видео</a></li>
                    <li><a href="/group/1/event/">События</a></li>
                    <li><a href="/group/1/explore/">Кент Эксплор</a></li>
                    <li><a href="/group/1/about/">О бренде</a></li>
					<li><a href="/group/1/u_concept/">U_concept</a></li>


                    <!--<li><a href="/group/1/contest/">Конкурсы</a></li>-->
					<?if($page_name=="lenta"){?>
                    <!--<li><a onclick="openPopup('manifest')">Манифест</a></li>
                    <li><a onclick="openPopup('about_group')">О группе</a></li>-->
					<?}?>
                </ul>
            </div>
        </div>

					<div class="container" style="display:none;">
						<div class="background-container"></div>
						<?include("ajax/1/about_group.php");?>
						<?include("ajax/1/manifest.php");?>

						<?include("ajax/1/konfidance.php");?>
						<?include("ajax/1/contact.php");?>

					</div>

		<header class="full_h" style="background-image: url('<?=($_GET["v"]==1)?"/images/shapka_2_big.png":CFile::GetPath($arGroup["PREVIEW_PICTURE"])?>');">
			<div class="mobile-block mobile-menu-ico" id="menu-button"></div>
			<div class="events">

				<?if($arResult["VARIABLES"]["group_id"] == 1 || true) {?>


					<div class="slogan">*Инновации. Впечатления. Тренды</div>
					<div class="nomobile"><?echo $_SESSION["mobile_template"];?><img src="/images/18_plus.png">ВЫ НАХОДИТЕСЬ НА САЙТЕ ТАБАЧНОЙ КОМПАНИИ</div>
					<!--a href="#" id="konfidance" onclick="openPopup('konfidance')"><?=mb_strtoupper("Политика конфиденциальности")?></a>|-->
					<div class="about-group-block">
						<a href="#" id="about_group" onclick="openPopup('about_group')"><?=mb_strtoupper("О группе")?></a>|
						<a href="#" id="manifest" onclick="openPopup('manifest')"><?=mb_strtoupper("Манифест")?></a>
					</div>

				<?}?>

			</div>
		</header>

		<?$APPLICATION->IncludeComponent("bitrix:menu", "top_line", Array(
			"ROOT_MENU_TYPE"	=>	"left",
			"MAX_LEVEL"	=>	"1",
			"CHILD_MENU_TYPE"	=>	"left",
			"USE_EXT"	=>	"Y",
			"CACHE_NOTES" => $geiop['CITY_NAME'],
			"MENU_CACHE_TYPE" => "A",
			"MENU_CACHE_TIME" => "3600",
			"MENU_CACHE_USE_GROUPS" => "Y",
			"MENU_CACHE_GET_VARS" => array(
				0 => "SECTION_ID",
				1 => "page",
			),
			"group_id" => $_GET["GROUP_ID"],
			"show_logo" => "Y",
			"search" => "y",
			"search_pos" => "r"
			)
		);?>

		<script>
		$(function(){
			var page = "<?echo $page_name?>";
			if($("#menu-button").css("display")=="block"){

			function remove_elements(){
				removed = 0;
				for(i=0; i<arguments.length; i++){
					element=$(".item:nth-child(" + (arguments[i]+removed) + ")");
					console.log(element.children('a'));
					if (!element.children('a').hasClass("selected")){
						element.remove();
					}
					else{
						i++
					}

				}
			}

			/* if(page=="lenta"){remove_elements(7)};
			if(page=="contest"){remove_elements(2)} else {remove_elements(7)};		 */
			remove_elements(5,4,3);


			$(".nav-inner").append("<div class='item'><a href='/group/1/u_concept/'>U_CONCEPT</a></div><div class='item'><a href='/group/1/explore/'>КЕНТ ЭКСПЛОР</a></div><div class='item menu-popup-button'><a>+</a></div>")
			}

			$(".menu-popup-button").click(function(){
				$(".shadow-menu-popup").fadeIn();
			})

			$(".close-menu-popup").click(function(){
				$(".shadow-menu-popup").fadeOut();
			})

		})
		</script>

		<div id="content_container">

			<?if(isset($_GET["about"])&&$_GET["about"]==1){
				include("about.php");
			}	elseif($page_name!="lenta")	{?>

				<style>
					header.full_h {
						background-image: url("<?=CFile::GetPath($arGroup["PROPERTIES"]["THIN_PICT"]["VALUE"])?>") !important;
						height: 90px !important;
						top:0px;
					}
					header.full_h, nav#nav_1 {
						position: fixed;
						z-index: 2;
						padding-left:0px;
					}
					nav#nav_1 {
						top: 90px;
					}
					#content_container {
						margin-top:165px !important;
					}
					.events {
						display:none;
					}
					#content_left_wrapper.thin {
						top:0px;
					}
					@media screen and (max-device-width: 640px){
						header.full_h{
							height: 45px !important;
						}
						section nav#nav_1{
							top: 44px;
						}
					}
				</style>

			<?}
			if($page_name!=="events_detail"&&$page_name!=="photo_detail"&&$page_name!=="video_detail"&&$page_name!=="contest_detail"&&$page_name!=="events"&&$page_name!=="u_concept"&&$page_name!=="explore"){

				$arBanner = array();
				$arSelect = Array("ID", "IBLOCK_ID", "*");
				$arFilter = Array("IBLOCK_ID"=>9, "ACTIVE"=>"Y", "PROPERTY_TYPE"=>8, "PROPERTY_SOC_GROUP"=>$arGroup["ID"]);
				if(isset($_GET["about"])&&$_GET["about"]==1){
					$arFilter["PROPERTY_NAME_PAGE"]="about";
				}
				$res = CIBlockElement::GetList(Array("SORT"=>"ASC"), $arFilter, false, array(), $arSelect);
				while($ob = $res->GetNextElement())	{
					$arFields = $ob->GetFields();
					$arFields["PROPERTIES"] = $ob->GetProperties();
					$file = CFile::ResizeImageGet($arFields["PREVIEW_PICTURE"], array("width" => 180, "height" => 160), BX_RESIZE_IMAGE_EXACT);
					$arFields["src"] = $file["src"];
					if (($arFields["PROPERTIES"]["ONLY"]["VALUE_XML_ID"] == 'Y' && ($geiop['CITY_NAME'] == CITY_NAME || $USER->IsAdmin())) || !$arFields["PROPERTIES"]["ONLY"]["VALUE_XML_ID"]) {
						if(!isset($arBanner[intval($arFields["PROPERTIES"]["POSITION"]["VALUE"])][0])) {
							$arBanner[intval($arFields["PROPERTIES"]["POSITION"]["VALUE"])][] = $arFields;
						}
					}

				}?>

				<div id="content_left_wrapper" <?if($page_name!="lenta"&&$_GET["about"]!=1){?>class="thin"<?}?>>
					<div id="content_left" <?if($page_name!="lenta"&&$_GET["about"]!=1){?>class="thin"<?}?>>
						<?for($i=1;$i<=4;$i++) {
							if(isset($arBanner[$i])) {?>
								<div class="banner" id="banner_<?=$i?>">
									<div class="banner_ins">
										<?foreach($arBanner[$i] as $k=>$v) {?>
											<a class="banner_a" href="<?=$v["PROPERTIES"]["LINK"]["VALUE"]?>"><img width="" src="<?=$v["src"]?>"/></a>
										<?}?>
									</div>
									<?if(sizeof($arBanner[$i])>1){?>
										<div class="banner_arrow"></div>
									<?}?>
								</div>
							<?}?>
						<?}?>
						<?
							/*if ($page_name!=="contest" && ($geiop['CITY_NAME'] == CITY_NAME || $USER->IsAdmin())) {?>
							<div class="banner" id="banner_4">
								<div class="banner_ins">
									<a class="banner_a" href="/group/1/u_contest/"><img width="180" src="/group/u_contest/images/small-banner.jpg"/></a>
								</div>
							</div>
							<?}*/
						?>
					</div>
				</div>

			<?}
			if($page_name=="events") {?>

				<style>
					.left-menu {
						float:left;
						width:220px;
					}
					.left-menu div {
						margin: 30px 0;
						margin-left: 45px;
					}
					.left-menu a {
						color: #FFFFFF;
						font-size: 12px;
						text-decoration: none;
						text-transform: uppercase;
						padding-bottom: 5px;
					}
					.left-menu a:hover, .left-menu a.selected {
						color: #FFFFFF;
						text-decoration: none;
						border-bottom: 2px solid #00d7ff;
					}

				  @media screen and (max-device-width: 640px){
					.left-menu{
						width: 100%;
					}

					.left-menu div {
						float: left;
					}

					.left-menu div a{
						font-size: 18px;
					}
				</style>
				<div class="left-menu">
					<div><a href="?filter=next" <?if($_GET["filter"] !== "prev" && $_GET["filter"] !== "my") echo 'class="selected"';?>>Будущие</a></div>
					<div><a href="?filter=prev" <?if($_GET["filter"] == "prev") echo 'class="selected"';?>>Прошедшие</a></div>
					<div><a href="?filter=my" <?if($_GET["filter"] == "my") echo 'class="selected"';?>>Мои события</a></div>
				</div>

			<?}
			if($page_name=="contest") {?>

				<style>
					.left-menu {
						float:left;
						width:210px;
						position:relative;
					}
					.left-menu div {
						margin: 30px 0;
						margin-left: 45px;
					}
					.left-menu a {
						color: #FFFFFF;
						font-size: 12px;
						text-decoration: none;
						text-transform: uppercase;
						padding-bottom: 5px;
					}
					.left-menu a:hover, .left-menu a.selected {
						color: #FFFFFF;
						text-decoration: none;
						border-bottom: 2px solid #00d7ff;
					}
					#content_inner {
						width: 634px !important;
					}
				</style>
				<div class="left-menu">
					<div><a href="?filter=all" <?if($_GET["filter"] !== "my" && $_GET["filter"] !== "archive") echo 'class="selected"';?>>Все</a></div>
					<div><a href="?filter=my" <?if($_GET["filter"] == "my") echo 'class="selected"';?>>Участвую</a></div>
					<div><a href="?filter=archive" <?if($_GET["filter"] == "archive") echo 'class="selected"';?>>Архив</a></div>
				</div>

			<?}?>

			<div id="content_inner" <?=($page_name=="events_detail"||$page_name=="photo_detail"||$page_name=="video_detail"||$page_name=="contest_detail")?"style=\"width:1100px;\"":""?>>

				<?if($page_name=="lenta")
					include($_SERVER["DOCUMENT_ROOT"]."/group/".$page_name."/index.php");
				else if($page_name=="about")
					include($_SERVER["DOCUMENT_ROOT"]."/group/".$page_name."/index.php");
				else if($page_name=="events_detail")
					include($_SERVER["DOCUMENT_ROOT"]."/group/events/dop_detail.php");
				else if($page_name=="photo_detail")
					include($_SERVER["DOCUMENT_ROOT"]."/group/photo/dop_detail.php");
				else if($page_name=="video_detail")
					include($_SERVER["DOCUMENT_ROOT"]."/group/video/dop_detail.php");
				else if($page_name=="contest_detail")
					include($_SERVER["DOCUMENT_ROOT"]."/group/contest/dop_detail.php");
				else
					include($_SERVER["DOCUMENT_ROOT"]."/group/".$page_name."/dop.php");?>

			</div>
			<div class="clear"></div>
		</div>
