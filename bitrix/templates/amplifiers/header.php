<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?
	$APPLICATION->ShowPanel = false;
	global $USER;
	if($USER->IsAuthorized()){
		$UserData = CustomUser::SearchUser(array("ID" => $USER->GetID()));
		if($UserData[0]["PERSONAL_PHOTO"] > 0){
			$UserData[0]["PERSONAL_PHOTO_RESIZE"] = CFile::ResizeImageGet(
				CFile::GetByID($UserData[0]["PERSONAL_PHOTO"])->Fetch(), 
				array("width"=>60, "height"=>60),
				BX_RESIZE_IMAGE_PROPORTIONAL,
				true
			);
		}
	} else {
		if($_SERVER["PHP_SELF"] != "/amplifiers/auth/index.php"){
			LocalRedirect("/amplifiers/auth/");
		}
	}
?>
<!DOCTYPE html>
<html>
	<head>
		<script type="text/javascript" src="/js/plugins/jquery-1.11.2.min.js"></script>
		<link rel="shortcut icon" type="image/x-icon" href="/img/favicon.ico" />
		<title><?$APPLICATION->ShowTitle()?></title>
		<script type="text/javascript">
			$(document).ready(function(){
				$("#CheckIn").bind("click",function(){
					if(navigator.geolocation) {
					    navigator.geolocation.getCurrentPosition(function(position) {
				            $.post("/amplifiers/geolocation.php",
							  {Latitude: position.coords.latitude,Longitude: position.coords.longitude}
							);
						});
					}
				});
			});
		</script>
		<?$APPLICATION->ShowHead()?>
	</head>
	<body>
		<div><?$APPLICATION->ShowPanel();?></div>
		<div class="container">
			<div class="header">
				<div class="header-user">
					<?if($USER->IsAuthorized()):?>
					<div 
						class="header-user-data" 
						style="background-image:url(<?=$UserData[0]["PERSONAL_PHOTO_RESIZE"]["src"];?>)">
						<?=$UserData[0]["NAME"];?>
						<br />
						<?=$UserData[0]["LAST_NAME"];?>
					</div>
					<a href="javascript:void(0)" id="CheckIn" class="header-check-in"></a>
					<?else:?>
						Авторизация
					<?endif;?>
				</div>
			</div>