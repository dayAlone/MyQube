<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?
	global $USER;
	global $Data; 
	$Data = array();
	
	if($_GET["logout"] == "y"){ $USER->Logout();}
	
	$Data["User"]["Group"] = CUser::GetUserGroup($USER->GetID());
	if(!$USER->IsAuthorized() && (!in_array(10,$Data["User"]["Group"]) || !in_array(1,$Data["User"]["Group"]))){
		LocalRedirect("/");
	}
	
?>
<!DOCTYPE html>
<html>
	<head>
		<script type="text/javascript" src="/js/plugins/jquery-1.11.2.min.js"></script>
		<title><?$APPLICATION->ShowTitle()?></title>
		<?$APPLICATION->ShowHead()?>
	</head>
	<body>
		<div><?$APPLICATION->ShowPanel();?></div>
		<div class="container">
			<div class="header">
				<div class="header-menu">
					<?if(in_array(10,$Data["User"]["Group"]) || in_array(1,$Data["User"]["Group"])):?>
					<a href="/dashboard/new_consultant/">Новый консультант</a>
					<a href="/dashboard/new_supervisor/">Новый супервайзер</a>
					<a href="/dashboard/list_consultant">Список консультантов</a>
					<a href="/dashboard/list_supervisor">Список супервайзеров</a>
					<?endif;?>
					<?if(in_array(12,$Data["User"]["Group"]) || in_array(1,$Data["User"]["Group"])):?>
					<a href="/dashboard/my_consultant/">Мои консультанты</a>
					<a href="/dashboard/live_counter_registrations/">Live-Счетчик регистраций</a>
					<?endif;?>
					<a href="?logout=y">Выход</a>
				</div> 
			</div>
			<div class="content">