<?
CModule::IncludeModule("iblock");
$arSelect = Array("ID", "IBLOCK_ID", "*");
$_GET["GROUP_ID"] = intval($_GET["GROUP_ID"]);
$arFilter = Array("IBLOCK_ID"=>4, "ID"=>$_GET["GROUP_ID"], "ACTIVE"=>"Y");
$res = CIBlockElement::GetList(Array(), $arFilter, false, false, $arSelect);
while($ob = $res->GetNextElement())
{
	$arFields = $ob->GetFields();
	$arProps = $ob->GetProperties();
	$arGroup = $arFields;
	$arGroup["PROPERTIES"] = $arProps;
}	
//echo "<xmp>";print_r($arGroup);echo "</xmp>"; die();
$APPLICATION->SetPageProperty("title", $arGroup["NAME"]);
$APPLICATION->SetTitle($arGroup["NAME"]);

if((!$USER->IsAuthorized() || $_GET["message"] == "birthday" || $_GET["message"] == "checking_user_fields" || $_GET["message"] == "you_are_under_18") && empty($_GET["POST_ID"])) {
	?>
	<style>
		input[type="checkbox"] + label {
			margin-left: 0px;
		}
		.enter_page_leftcol label div {
			margin-left: 0px;
			width: auto;
		}
		.error {
			margin-left: 0px;
		}
	</style>
	<script>
		$(function(){
			$("#enter_page_form").submit(function(){
				$(".error").hide();
				var submit = true;				
				$(this).find('.requried').each(function(){
					if($(this).attr("type") == "checkbox"){
						if(!$(this).prop("checked")){
							submit = false;
							var id = $(this).attr("id");
							$("."+id).css({"display":"inline-block"});
							$("#return_main_page").show();
						}
					} else {
						if($(this).val() == ''){
							submit = false;
							var id = $(this).attr("id");
							if(id)
								$("."+id).css({"display":"inline-block"});
							else
								$(".birthday").css({"display":"inline-block"});
							$("#return_main_page").show();
						}
					}
				});
				return submit;
			});
		});
	</script>
	<div class="enter_page">
		<div class="enter_page_rightcol" style="background: url('<?=CFile::GetPath($arGroup["DETAIL_PICTURE"])?>') no-repeat; background-size: 100% 100%; display:table; position: relative;">
		<?if($_GET["message"] == "checking_user_fields" && $_GET["step"] == "2") {?>
			<script src="http://code.jquery.com/jquery-1.8.3.js"></script>
            
			<link type="text/css" rel="stylesheet" href="/css/groupmobile.css">
			<script type="text/javascript" src="/js/web20/script.js"></script>
			<script type="text/javascript" src="/js/plugins/jquery.slimscroll/jquery.slimscroll.min.js"></script>
			<div class="container" style="display: block; position: absolute;">
				<div class="background-container"></div>
				<div class="privacy-window">
					<div class="wrap-privacy">
						<div class="privacy-text">
							������� �� ������ ��������������������, ��, �������� � ������������ �� ����� ����� � ������ ����������:

							1. �������������� ��������* �� ��������� ������ 9 ������������ ������ � 152-�� �� ������������ ������� �� 27.07.2006 � �� ��������� ��.152.1 �� ��, ���� �������� �� ��������� ��������������� ���� ������������ ������, � ����� �� ������������� � ������������� ������ ����������� ��� ������� ��� ��������������, �� ��������� ��������:

							1.1. ���������� ���� ������������ ������, � ����� �����������, ���������� � ���������� ���������� ����-, �����- ��� ����������, ����� �������������� ��������� (����, ������, ��������������, ����������, ��������, ���������, ���������, ����������, �������������, �������������, �������������, ������������, ��������, �����������, � ����� ���� ������� ���������, �������, �� �� ������������� ��������� ������ ������� �����, � �������� � �������� ��������� ��������, � ��� ����� � ������ ������������ �������������� �������� ������ �� ���������� �����, �������������� ���������� ������ ������������ ������, �������� ������, ������������� ����������� ������� �� ������� � ����� �����, �������������� ���������� � �������� ������������), ��� � ����������� ������� �������������, ��� � ��� ������������� ����� �������, ������������� ��� ������������� ������������ ��������, ��� ������������ �������������� ���� ������ � ������������ �������� ��������� ������� �������� �������, ��� �������������� ���������� � ������������� �������� ���������, ��� ���������� ������� � ���������� ������������, ��� ���������� ������������� ���������� �� ����������� ������ �������� � ������ � ��������� "������ �������� �������", � ��� ����� kent.ru, � ����� ��� ����������� ���� ����������, ��������� � ������������� �������� � ����������� �������������.

							1.2. �� ����� ������������ �� ������� �������� ������������� ���������� � ����� ���������� � ����� �������� ������ ��������������� (18+). ��� ���� �������� ��������� ���������� ���������� ����� ���������� ����� ���������� �������� ��������.

							1.3. ��� �������, ����������� � ������� ������� �������, ����� ���� �������� ��� ��������� ������ ������������� ���������� �����. �������� ������ ������ ������� ��������� � �������� ������ � ����� ��������� �������� � ���: �. �. �., ���, ������� � �����.

							1.4. �������� ������������ ��������� ���������� ������������ ������ �� ���������� ����� ���������.

							1.5. �������� ������ ������������ ���������� ������������ ������ ��� ������� ����������� �� ������������������ � ������������. �������� � ������� ��������� ���������� �������� � �������� � ������������������ ����������.

							1.6. ���� �������� ����� ���� �������� � ������������ � ����������� �����������������.

							1.7. �� ���������� �������� �������� �� ��������� ����� ���������� ���� ����������, ������� ���������� ������.

							2. ��������� �� �������������, ��� ��� ���������� ���� ���������� ������������� ����������������, �������, ��, �� ������������� ����� ��������� � ���������� � ����������� �������� ���������. �� ����� ������������� ���� �������� �������� ���������� � �������� ��������� ������� �������� �������, �������� ���������� ��� ���������� ������� � ���������� ������������, � ����� ���� ����������, ��������� � ������������� �������� � ����������� �������������.

							3. �� ����� �������� � ���������, ��� ���������� ���� �������� �� �����, ����� ��� �������� ���� ����� ������������ ���������� ����� ��������������� ����������� � ����������� ��������, ����������� ���������� ���������� ����������� ��������, ������� �������� �������������� ����������, ������������� �� ��������� ���������, ������� � ����������� ������, � ������ ������� � ��� ����� ������� ��� �����������.

							* ��� �������������� ������ �� ���������� ������: 121614, �. ������, ��. ����������, �. 17, ����. 2; www.bat.com.

						</div>
					</div>
					<div class="privacy-shadow"></div>
					<!--div class="privacy-button"><button class="close">�������</button></div-->
				</div>
				<script type="text/javascript">
					$(function(){
						$('.privacy-text').slimScroll({
							color: '#00d6ff',
							size: '10px',
							width: '630px',
							height: '430px',
							distance: '10px',
							alwaysVisible: true
						});
					});
				</script>
			</div>
		<?}?>
			<div id="scroll" style="display:table-cell; vertical-align: bottom;">
				<a href="/group/<?=$arGroup["ID"]?>/" class="enter_page_group_item" style="position: static; height: auto; border: none;">
					<h1 style="width: 400px;"><?=$arGroup["NAME"]?><br><?=$arGroup["PREVIEW_TEXT"]?></h1>
					<div class="enter_page_members" style="position:relative; margin-top: 10px; margin-bottom: 30px;"><img src="<?=SITE_TEMPLATE_PATH?>/images/members_icon.png"><?if($arGroup["PROPERTIES"]["USERS"]["VALUE"]) echo count($arGroup["PROPERTIES"]["USERS"]["VALUE"]); else echo 0;?> ����������</div>
					<div class="enter_page_group_lock" style="position: absolute; top:45%; right:43%;"><img src="<?=SITE_TEMPLATE_PATH?>/images/lock_group_icon.png"><br>��� �������� ������</div>
				</a>
			</div>
		</div>
		<div class="enter_page_leftcol">
			<div class="enter_page_leftcol_cont">
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
						LocalRedirect("/group/1/?backurl=".$backurl);
					}
					?>
					<img src="/bitrix/templates/web20/images/enter_page_calendar.png" class="enter_page_leftcol_lock_icon">
					<br>
					<div class="enter_page_leftcol_text">
						��� ����������� ����� ���������� ����<br>
						�� ��� ��������������� ��� �������.<br>
						������ ������ ����, ����� � ��� ������ ��������.<br>
						<a href="/" id="return_main_page" style="display:none;">������� �� ������� ��������</a>
					</div>
					<form name="BIRTHDAY" id="enter_page_form" method="post" target="_top" action="?message=birthday">
						<input type="text" name="DD" maxlength="2" placeholder="��" class="enter_page_input requried" style="width: 80px; text-align: center; padding: 0;">
						<input type="text" name="MM" maxlength="2" placeholder="��" class="enter_page_input requried" style="width: 80px; text-align: center; padding: 0; margin-left: 20px;">
						<input type="text" name="YYYY" maxlength="4" placeholder="����" class="enter_page_input requried" style="width: 80px; text-align: center; padding: 0; margin-left: 20px;"><br>
						<div class="error birthday">����������, ������� ����<br> ���� ��������</div><br>
						<input type="checkbox" name="DO_YOU_SMOKE" id="do_you_smoke" class="enter_page_input requried">
						<label for="do_you_smoke">
							<div>� �����������, ��� �������<br> ���������������� �����������</div>
						</label>
						<div class="error do_you_smoke">������ ������ �������������<br> ��� ���������������� �����������</div><br><br><br><br><br><br>
						<input type="submit" src="/bitrix/templates/web20/images/enter_page_submit.png" value="����������" style="border-style: solid; border-width: 2px; border-color: #fff; border-radius: 8px; background-color: #ff4500; font-size: 11px; font-family: 'GothamProBold'; color: #fff; text-transform: uppercase; text-align: center; width: 338px; height: 50px;">
					</form>
					<?
				} elseif($_GET["message"] == "checking_user_fields") {
					$CurentUser = CUser::GetByID($USER->GetID())->Fetch();
					$date = explode(".", $CurentUser["PERSONAL_BIRTHDAY"]);
					if($_POST["USER_NAME"]) {
						$Fields = array(
							"NAME" => $_POST["USER_NAME"],
							"EMAIL" => $_POST["USER_EMAIL"],
							"PERSONAL_BIRTHDAY" => $_POST["DD"].'.'.$_POST["MM"].'.'.$_POST["YYYY"]
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
						LocalRedirect("/group/1/?backurl=".$backurl);
					}
					?>
					<img src="/bitrix/templates/web20/images/enter_page_add_user.png" class="enter_page_leftcol_lock_icon">
					<br>
					<div class="enter_page_leftcol_text">
						<h4>�����������</h4>
						�� ������������ ��� �� �������� ������<br>
						��������� ��������� ���������� Kent Lab!<br>
						<a href="/" id="return_main_page" style="display:none;">������� �� ������� ��������</a>
					</div>
					<form name="REGISTRATION" id="enter_page_form" method="post" target="_top" action="?message=checking_user_fields&step=2">
						<?if(empty($_GET["step"])) {?>
							<input type="text" name="USER_NAME" id="user_name" maxlength="50" value="<?=$CurentUser["NAME"]?>" class="enter_page_input requried" placeholder="������� ���"><br>
							<div class="error user_name">����������, ������� ���� ���</div>
							<input type="text" name="USER_EMAIL" id="user_email" maxlength="50" value="<?=$CurentUser["EMAIL"]?>" class="enter_page_input requried" placeholder="����� ����������� �����"><br>
							<div class="error user_email">����������, ������� ����������<br> ����� ����������� �����</div>
							<input type="text" name="DD" maxlength="2" placeholder="��"<?if(!empty($date)) echo " disabled";?> value="<?=$date[0]?>" class="enter_page_input requried" style="width: 80px; text-align: center; padding: 0;">
							<input type="text" name="MM" maxlength="2" placeholder="��"<?if(!empty($date)) echo " disabled";?> value="<?=$date[1]?>" class="enter_page_input requried" style="width: 80px; text-align: center; padding: 0; margin-left: 20px;">
							<input type="text" name="YYYY" maxlength="4" placeholder="����"<?if(!empty($date)) echo " disabled";?> value="<?=$date[2]?>" class="enter_page_input requried" style="width: 80px; text-align: center; padding: 0; margin-left: 20px;"><br>
							<div class="error birthday">����������, ������� ����<br> ���� ��������</div>
							<input type="submit" src="/bitrix/templates/web20/images/enter_page_submit.png" value="������� �� ��������� ��� �����������" style="border-style: solid; border-width: 2px; border-color: #fff; border-radius: 8px; background-color: #ff4500; font-size: 11px; font-family: 'GothamProBold'; color: #fff; text-transform: uppercase; text-align: center; width: 338px; height: 50px;">
						<?} elseif($_GET["step"] == 2) {?>						
							<input type="text" name="BRAND_1" maxlength="50" placeholder="����� �������" class="enter_page_input"><br>
							<input type="text" name="BRAND_2" maxlength="50" placeholder="����� �������" class="enter_page_input"><br><br><br>
							<input type="checkbox" name="IAGREE" id="iagree" class="enter_page_input requried">
							<label for="iagree">
								<div>��� �������� �� ���������<br> ���� ������������ ������</div>
							</label><br>
							<div class="error iagree">��������� �������� �� ���������<br> ����� ������������ ������</div><br>
							<input type="checkbox" name="DO_YOU_SMOKE"<?if(!empty($CurentUser["UF_DO_YOU_SMOKE"])) echo ' checked style="display:none;"';?> id="do_you_smoke" class="enter_page_input requried">
							<label for="do_you_smoke"<?if(!empty($CurentUser["UF_DO_YOU_SMOKE"])) echo ' style="display:none;"';?>>
								<div>� �����������, ��� �������<br> ���������������� �����������</div>
							</label>
							<div class="error do_you_smoke">������ ������ �������������<br> ��� ���������������� �����������</div><br>
							<input type="submit" src="/bitrix/templates/web20/images/enter_page_submit.png" value="������������������" style="border-style: solid; border-width: 2px; border-color: #fff; border-radius: 8px; background-color: #ff4500; font-size: 11px; font-family: 'GothamProBold'; color: #fff; text-transform: uppercase; text-align: center; width: 338px; height: 50px;">
						<?}?>
					</form>
					<?
				} elseif($_GET["message"] == "you_are_under_18") {
					?><br><br><br><br><br><br>
					<img src="/bitrix/templates/web20/images/enter_page_no_access.png" class="enter_page_leftcol_lock_icon">
					<br>
					<div class="enter_page_leftcol_text">
						� ���������, ������ ������ ������� ������<br>
						��� ���������������� �����������.<br>
						<a href="/">������� �� ������� ��������</a>
					</div>
					<?
				} else {					
					?>
					<link type="text/css" rel="stylesheet" href="/css/groupmobile.css">
					<script type="text/javascript" src="/js/web20/script.js"></script>
					<script type="text/javascript" src="/js/plugins/jquery.slimscroll/jquery.slimscroll.min.js"></script>
					<div class="container" style="display:none;">
						<div class="background-container"></div>
						<?include("ajax/1/manifest.php");?>
					</div>
					<?
					$APPLICATION->IncludeComponent(
						"bitrix:system.auth.form", 
						"myqube_groups", 
						array(
							"REGISTER_URL" => "/club/group/search/",
							"PROFILE_URL" => "/personal/profile/",
							"FORGOT_PASSWORD_URL" => "",
							"SHOW_ERRORS" => "Y"
						),
						false
					);
				}?>
				<div class="enter_page_rights">
					� 2015 MyQube. ��� ����� ��������.<br>
					���������� ���� ������������� ��� ��� ������ 18 ���
				</div>
			</div>
		</div>
	</div>
<?
} elseif(CustomUser::UserCheckFields() || $USER->IsAdmin()) {
	if($page_name=="lenta_detail")
				include($_SERVER["DOCUMENT_ROOT"]."/group/lenta/dop_detail.php");
			else {
	?>
	<link type="text/css" rel="stylesheet" href="/css/groupmobile.css">
	<script type="text/javascript" src="/js/plugins/jquery-ui/jquery-ui.min.js"></script>
	<script type="text/javascript" src="/js/plugins/jquery.slimscroll/jquery.slimscroll.min.js"></script>
	<script type="text/javascript" src="/js/plugins/jquery.fancybox/jquery.fancybox.js"></script>
	<link type="text/css" rel="stylesheet" href="/js/plugins/jquery.fancybox/jquery.fancybox.css">
    
	<header class="full_h" style="background-image: url('<?=CFile::GetPath($arGroup["PREVIEW_PICTURE"])?>');">
	<script type="text/javascript" src="/js/web20/script.js"></script>
		<div class="events">
				<?if($arResult["VARIABLES"]["group_id"] == 1 || true) {?>
					<div class="container" style="display:none;">
						<div class="background-container"></div>
						
						<?include("ajax/1/about_group.php");?>
						<?include("ajax/1/manifest.php");?>
						<?include("ajax/1/konfidance.php");?>
						<?include("ajax/1/contact.php");?>
						
					</div>
					<div style="position:absolute; right: 150px; bottom: 150px; font-size: 12px;">* ��������� ���������� �����</div>
					<div style="float: left; padding: 0 20px; color: rgb(153,153,153)">111�� ���������� �� �������� �������� ��������1123</div>
					<!--a href="#" id="konfidance" onclick="openPopup('konfidance')"><?=mb_strtoupper("�������� ������������������")?></a>|-->
					<a href="#" id="about_group" onclick="openPopup('about_group')"><?=mb_strtoupper("� ������")?></a>|
					<a href="#" id="manifest" onclick="openPopup('manifest')"><?=mb_strtoupper("��������")?></a>
				<?}?>
		</div>
		<?/*?><div class="group_info">
			<div class="group_info_title">
				<?=mb_strtoupper($arGroup["NAME"])?>
			</div>
			<div class="group_info_slogan">
				<?=mb_strtoupper($arGroup["PREVIEW_TEXT"])?>
			</div>
			<div class="group_info_details">
				<img src="<?=SITE_TEMPLATE_PATH?>/images/date_icon.png" width="" height="" alt="">
				<span><?=FormatDate(array("d" => 'l, j F'), MakeTimeStamp(date('d.m.Y', time())), time());?></span>
			</div>
			<div class="group_info_more" onclick="openPopup('about_group')">������ ������</div>
		</div>
        
        <div class="banners">
			<?
			$arSelect = Array("ID", "IBLOCK_ID", "*");
			$arFilter = Array("IBLOCK_ID"=>9, "ACTIVE"=>"Y", "PROPERTY_TYPE"=>7);
			$res = CIBlockElement::GetList(Array("SORT"=>"ASC"), $arFilter, false, array("nTopCount"=>3), $arSelect);
			while($ob = $res->GetNextElement())
			{
				$arFields = $ob->GetFields();
				$arFields["PROPERTIES"] = $ob->GetProperties();
				$arBanner[] = $arFields;
			}	
			?>
			<div class="banner_item">
				<a href="<?=$arBanner[0]["PROPERTIES"]["LINK"]["VALUE"]?>">
					<div class="banner_num">01</div><div class="banner_name"><?=$arBanner[0]["PREVIEW_TEXT"]?></div>
				</a>
			</div>
			<div class="banner_item">
				<a href="<?=$arBanner[1]["PROPERTIES"]["LINK"]["VALUE"]?>">
					<div class="banner_num">02</div><div class="banner_name"><?=$arBanner[1]["PREVIEW_TEXT"]?></div>
				</a>
			</div>
			<div class="banner_item">
				<a href="<?=$arBanner[2]["PROPERTIES"]["LINK"]["VALUE"]?>">
					<div class="banner_num">03</div><div class="banner_name"><?=$arBanner[2]["PREVIEW_TEXT"]?></div>
				</a>
			</div>
		</div><?*/?>
	
	</header>
	<?
	$APPLICATION->IncludeComponent("bitrix:menu", "top_line", Array(
		"ROOT_MENU_TYPE"	=>	"left",
		"MAX_LEVEL"	=>	"1",
		"CHILD_MENU_TYPE"	=>	"left",
		"USE_EXT"	=>	"Y",
		"MENU_CACHE_TYPE" => "A",
		"MENU_CACHE_TIME" => "3600",
		"MENU_CACHE_USE_GROUPS" => "Y",
		"MENU_CACHE_GET_VARS" => array(
			0 => "SECTION_ID",
			1 => "page",
		),
		"group_id" => $_GET["GROUP_ID"],
		"show_logo" => "Y"
		)
	);?>
	<div id="content_container">	
	<?if($page_name!=="events_detail"&&$page_name!=="photo_detail"&&$page_name!=="video_detail"&&$page_name!=="contest_detail"){?>		
			<?
			$arBanner = array();
			$arSelect = Array("ID", "IBLOCK_ID", "*");
			$arFilter = Array("IBLOCK_ID"=>9, "ACTIVE"=>"Y", "PROPERTY_TYPE"=>8, "PROPERTY_SOC_GROUP"=>$arGroup["ID"]);
			$res = CIBlockElement::GetList(Array("SORT"=>"ASC"), $arFilter, false, array("nTopCount"=>2), $arSelect);
			while($ob = $res->GetNextElement())
			{
				$arFields = $ob->GetFields();
				$arFields["PROPERTIES"] = $ob->GetProperties();
				$arBanner[] = $arFields;
			}
			if(isset($arBanner[0]))
				$image_1 = CFile::ResizeImageGet($arBanner[0]["PREVIEW_PICTURE"], array("width" => 180, "height" => 160), BX_RESIZE_IMAGE_EXACT);
			if(isset($arBanner[1]))
				$image_2 = CFile::ResizeImageGet($arBanner[1]["PREVIEW_PICTURE"], array("width" => 180, "height" => 350), BX_RESIZE_IMAGE_EXACT);
			?>

	
		<?}?>
		<div id="content_inner" <?=($page_name=="events_detail"||$page_name=="photo_detail"||$page_name=="video_detail"||$page_name=="contest_detail")?"style=\"width:1100px;\"":""?>>
		<script>
			$(function(){
				var inProgress = false;
				var path = host_url+"/group/<?=$page_name?>/ajax_<?=$page_name?>.php";
				var currentPage = <?if($_SESSION["BackFromDetail"]["group_6"]["nPageSize"])
						echo $_SESSION["BackFromDetail"]["group_6"]["nPageSize"];
					else
						echo 1;?>;	
				var postsCounter = $("#block-wrapper").data("count");
				var stop = false;				
				if(currentPage * 9 >= postsCounter)
					var stop = true;
				$(window).scroll(function(){
					if($(window).scrollTop() + $(window).height() >= $(document).height()-500 && !inProgress && !stop) {
						$.ajax({
							url: path,
							method: 'GET',
							data: {PAGEN_1: ++currentPage, GROUP_ID: <?=$_GET["GROUP_ID"]?>},
							beforeSend: function() {inProgress = true;}
						}).done(function(data){
							$("#block-wrapper").append(data);
							$(".lenta_item").hover(
								function(){
									$(this).children(".lenta_item_hover").fadeTo(300,0);
									$(".cover_bottom_info").hide();
									var id_p=$(this).attr('id');
									$("#bottom_"+id_p).show();
									$("#bottom_"+id_p).animate({ bottom: '0' }, 1200);
									
									$("#bottom_"+id_p+" .fb_share_count").each(function() { 
										if($(this).text()=="")
										{
											var e=this;
											$.get(host_url+"/counters.php?url="+$( this ).attr('link'), function( data ) {
											  var res = JSON.parse(data);	
											  $(e).text(res.sum);
											  /*$(e).parent().children(".vk_share_count").text(res.vk);
											  $(e).parent().children(".g_share_count").text(res.vk);*/
											});
										}
									})
									
								},  
								function(){
									$(this).children(".lenta_item_hover").fadeTo(300,0.5);
									var id_p=$(this).attr('id');
									$("#bottom_"+id_p).show();
									$("#bottom_"+id_p).delay(1000).animate({ bottom: '-300px' }, 1200);	
								}
							);
							inProgress = false;
						});						
						if(currentPage * 9 >= postsCounter)
							stop = true;
					}
							  topsideHeight=300;
							  var scrollTop = $(this).scrollTop();
							  if(scrollTop >= topsideHeight){
							   $("header").addClass("fixed");
							   $("#content_left_wrapper").addClass("thin");
							   $("#content_left").addClass("thin");
							   $("header").css('background-image', "url('<?=CFile::GetPath($arGroup["PROPERTIES"]["THIN_PICT"]["VALUE"])?>')");
							   $("#nav_1").addClass("fixed");
							   $("#content_container").css({"margin-top":"510px"});
							   /*$("#content_left").css({"margin-top":"140px"});*/
							  }else if(scrollTop<=100){
							   $("header").removeClass("fixed");
							    $("#content_left_wrapper").removeClass("thin");
							   $("#content_left").removeClass("thin");
							   $("header").css('background-image', "url('<?=CFile::GetPath($arGroup["PREVIEW_PICTURE"])?>')");
							   $("#nav_1").removeClass("fixed");
							   $("#content_container").css({"margin-top":"68px"});
							   /*$("#content_left").css({"margin-top":"0px"});*/
							  }
						 });
				
				/*var path = host_url+"/group/<?=$page_name?>/ajax_<?=$page_name?>.php";
				var currentPage = <?if($_SESSION["BackFromDetail"]["group_6"]["nPageSize"])
					echo $_SESSION["BackFromDetail"]["group_6"]["nPageSize"];
				else
					echo 1;?>;
				$("#addposts").click(function(e){
					$.get(path, {PAGEN_1: ++currentPage, GROUP_ID: <?=$_GET["GROUP_ID"]?>}, function(data){
						$("#block-wrapper").append(data);
						$(".lenta_item").hover(
						function(){
								$(this).children(".lenta_item_hover").fadeTo(300,0);
								var id_p=$(this).attr('id');
								$("#bottom_"+id_p).show();
								$("#bottom_"+id_p).animate({ bottom: '0' }, 1200);
							},  
						function(){
								$(this).children(".lenta_item_hover").fadeTo(300,0.5);
								var id_p=$(this).attr('id');
								$("#bottom_"+id_p).show();
								$("#bottom_"+id_p).delay(1000).animate({ bottom: '-300px' }, 1200);	
							});
					});
					e.preventDefault();
					var count = $("#block-wrapper").data("count");
					if(currentPage * 6 >= count)
						$("#addposts").hide();
				});*/
				$(".lenta_item").hover(
					function(){
							$(this).children(".lenta_item_hover").fadeTo(300,0);
							$(".cover_bottom_info").hide();
							var id_p=$(this).attr('id');
							$("#bottom_"+id_p).show();
							$("#bottom_"+id_p).animate({ bottom: '0' }, 1200);
							$("#bottom_"+id_p+" .fb_share_count").each(function() { 
								if($(this).text()=="")
								{
									var e=this;
									$.get(host_url+"/counters.php?url="+$( this ).attr('link'), function( data ) {
									  var res = JSON.parse(data);	
									  $(e).text(res.sum);
									  /*$(e).parent().children(".vk_share_count").text(res.vk);
									  $(e).parent().children(".g_share_count").text(res.vk);*/
									});
								}
							});
						},  
					function(){
							$(this).children(".lenta_item_hover").fadeTo(300,0.5);
							var id_p=$(this).attr('id');
							$("#bottom_"+id_p).show();
							$("#bottom_"+id_p).delay(1000).animate({ bottom: '-300px' }, 1200);
							
						});
				$("div.likes").click(function(){
					$( this ).toggleClass( "active" );
					var path = host_url+"/group/lenta/like_post.php";
					$.get(path, {post_id: $(this).attr('id'),like: Number($( this ).hasClass( "active" ))}, function(data){
					});
				});
				$(".show_popup").click(function(){
					$("#show_popup").fadeIn();
					$(".dark-background").fadeIn();
				});
				$(document).mouseup(function (e){
					var div = $("#show_popup");
					var close = $(".close_popup");
					if ((!div.is(e.target) && div.has(e.target).length === 0) || close.is(e.target)) {
						div.fadeOut();				
						$(".dark-background").fadeOut();
					}
				});
			});
		</script>
		
		<?
			if($page_name=="lenta")
				include($_SERVER["DOCUMENT_ROOT"]."/group/".$page_name."/indexmobile.php");
			else if($page_name=="events_detail")
				include($_SERVER["DOCUMENT_ROOT"]."/group/events/dop_detail.php");
			else if($page_name=="photo_detail")
				include($_SERVER["DOCUMENT_ROOT"]."/group/photo/dop_detail.php");
			else if($page_name=="video_detail")
				include($_SERVER["DOCUMENT_ROOT"]."/group/video/dop_detail.php");
			else if($page_name=="contest_detail")
				include($_SERVER["DOCUMENT_ROOT"]."/group/contest/dop_detail.php");
			else 
				include($_SERVER["DOCUMENT_ROOT"]."/group/".$page_name."/dop.php");
		?>
			
		</div>
		<div class="clear"></div>
	</div>
			<?}
} elseif($_GET["POST_ID"]) {	
	$res = CIBlockElement::GetList(array(), array("ID" => $_GET["POST_ID"]));
	while($arRes = $res->GetNextElement()){
		$arItem = $arRes->GetFields();
		$arItem["PROPERTIES"] = $arRes->GetProperties();
		$arPost = $arItem;
	}
	$ogImage = CFile::ResizeImageGet($arPost["PROPERTIES"]["OG_IMAGE"]["VALUE"], array('width'=>200, 'height'=>200), BX_RESIZE_IMAGE_PROPORTIONAL, true);?>	
	<title><?=$arPost["NAME"]?></title>
	<meta name="description" content="<?=$arPost["PROPERTIES"]["OG_DESCRIPTION"]["VALUE"]["TEXT"]?>">
	<link type="text/css" rel="stylesheet" href="/css/teaser.css">
	<script type="text/javascript" src="/js/plugins/jquery-ui/jquery-ui.min.js"></script>
	<script type="text/javascript" src="/js/plugins/jquery.slimscroll/jquery.slimscroll.min.js"></script>
	<script type="text/javascript" src="/js/plugins/jquery.fancybox/jquery.fancybox.js"></script>
	<link type="text/css" rel="stylesheet" href="/js/plugins/jquery.fancybox/jquery.fancybox.css">
	<script type="text/javascript" src="/js/web20/script.js"></script>
	<link rel="image_src" href="http://myqube.ru<?=$ogImage["src"]?>" />
	<style>
		.main { width:100%; }
		.black-menu { width:100%; }
		.content { padding: 0px; }
		.black-menu-select a { text-decoration: none; }
	</style>
	<div class="black-menu">
		<div class="black-menu-wrap">
			<div class="black-menu-select"><a>� ���� ��� ���� �������</a></div>
			<div class="black-menu-select"><a>�������������� � �������</a></div>
		</div>
	</div>
	<?
	/*if(empty($arPost["PREVIEW_PICTURE"]) && !empty($arPost["PROPERTIES"]["VIDEO"]["VALUE"])) {
		$parsed_url = parse_url($arPost["PROPERTIES"]["VIDEO"]["VALUE"]);
		parse_str($parsed_url['query'], $parsed_query);
		$pic = "http://img.youtube.com/vi/".$parsed_query['v']."/0.jpg";
	} else {
		$pic = CFile::GetPath($arPost["PREVIEW_PICTURE"]);
	}*/
	$APPLICATION->SetPageProperty("title", $arPost["NAME"]);
	$APPLICATION->SetPageProperty("description", $arPost["PROPERTIES"]["OG_DESCRIPTION"]["VALUE"]["TEXT"]);
	$APPLICATION->SetPageProperty("og:title", $arPost["NAME"]);
	$APPLICATION->SetPageProperty("og:description", $arPost["PROPERTIES"]["OG_DESCRIPTION"]["VALUE"]["TEXT"]);
	$APPLICATION->SetPageProperty("og:image", "http://myqube.ru".$ogImage["src"]);
	$APPLICATION->SetPageProperty("og:url", "http://".$_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI']);
	//echo '<pre>'; print_r($arPost); echo '</pre>';
	?>
	<div class="main">

	<div class="main-head">
		<div class="main-text"><?=$arPost["NAME"]?></div>
	</div>
	<div class="content">
		<div class="left-block">
			<!-- ��� ������ ������ -->
			<div class="like-menu">
					<div class="like-ico"><img src="/images/like.png" alt="pic"></div>
					<div class="comment-ico"><img src="/images/comment.png" alt="pic"></div>
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
				<div class="info-block-head">���� ����������:</div>
				<div class="info-block-text"><?=FormatDate(array("d" => 'j F Y, H:i'), MakeTimeStamp($arPost["ACTIVE_FROM"], "DD.MM.YYYY HH:MI:SS"))?></div>
			</div>
			<div class="info-info-block">
			<div class="info-block">
				<div class="info-block-head">��������:</div>
				<div class="info-block-text"><?=$arPost["PREVIEW_TEXT"]?></div>
			</div>
			</div>
			<!--div class="acccept">
				<button>��������� ��������</button>
			</div-->

		</div>

		<div class="right-block">
			<div class="main-img"style="height: auto; background:none;">
				<img src="<?=CFile::GetPath($arPost["PREVIEW_PICTURE"])?>" width="780">
			</div>

			
		</div>
	</div>
	</div>
<?}?>