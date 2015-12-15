<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");$APPLICATION->SetTitle("Контакт успешно добавлен");?>
<?global $USER;if($_GET["logout"] == "y"){ $USER->Logout();}?>
<ul class="menu">
	<li><a href="/staff/">Добавить контакт</a></li>
	<?if($USER->IsAuthorized()):?>
	<li><a href="?logout=y">Выход</a></li>
	<?endif;?>
</ul>
<b>Данные успешно добавлены. <br />Вы можете добавлять данные нового участника!</b>
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>