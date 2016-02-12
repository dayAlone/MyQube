<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");$APPLICATION->SetTitle("Главная");?>
<?if($_GET["logout"] == "y"){ $USER->Logout();}?>
<div class="show-message">
	<?if($_GET["add_user"] == "Y"):?>Пользователь успешно добавлен.<?endif;?>
	<?if($_GET["add_user"] == "N"):?><span style="color: red;">Пользователь Не добавлен.</span><?endif;?>
</div>
<ul class="menu">
	<li>
		<a href="/amplifiers/add_user/">Добавить контакт</a>
	</li>
	<li>
		<a href="/amplifiers/blog/">Блог</a>
	</li>
	<li>
		<a href="/amplifiers/calendar/">Календарь</a>
	</li>
	<li>
		<a href="/amplifiers/contact/">Контакты</a>
	</li>
	<li>
		<a href="?logout=y">Выход</a>
	</li>
</ul>
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>