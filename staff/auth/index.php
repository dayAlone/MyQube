<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");$APPLICATION->SetTitle("Авторизация");?>
<ul class="menu">
	<li>
		<a href="/staff/">Добавить контакт</a>
	</li>
</ul>
<?$APPLICATION->IncludeComponent("bitrix:system.auth.form", "system.auth.form.default", Array(
		"REGISTER_URL" => "/auth/",	// Страница регистрации
		"PROFILE_URL" => "/amplifiers/",	// Страница профиля
	),
	false
);?>
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>