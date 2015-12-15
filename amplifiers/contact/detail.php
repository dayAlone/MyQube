<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");$APPLICATION->SetTitle("Поиск контактов");?>
<?$Data = CustomUser::SearchUser(array("ID" => $_GET["ID"]),array("ID","NAME","LAST_NAME","EMAIL","SELECT"=>array("UF_*")));?>
<table cellpadding="0" cellspacing="0">
	<?if(!empty($Data)):?>
	<tr>
		<td colspan="2">Регистрационная информация</td>
	</tr>
	<tr>
		<td>Дата обновления:</td>
		<td><?=$Data[0]["TIMESTAMP_X"];?></td>
	</tr>
	<tr>
		<td>Дата регистрации:</td>
		<td><?=$Data[0]["DATE_REGISTER"];?></td>
	</tr>
	<tr>
		<td>Имя:</td>
		<td><?=$Data[0]["NAME"];?></td>
	</tr>
	<tr>
		<td>Фамилия:</td>
		<td><?=$Data[0]["LAST_NAME"];?></td>
	</tr>
	<tr>
		<td>Отчество:</td>
		<td><?=$Data[0]["SECOND_NAME"];?></td>
	</tr>
	<tr>
		<td>E-Mail:</td>
		<td><?=$Data[0]["EMAIL"];?></td>
	</tr>
	<tr>
		<td>Логин:</td>
		<td><?=$Data[0]["LOGIN"];?></td>
	</tr>
	<tr>
		<td colspan="2">Личные данные</td>
	</tr>
	<tr>
		<td>Дата рождения:</td>
		<td><?=$Data[0]["PERSONAL_BIRTHDAY"];?></td>
	</tr>
	<tr>
		<td>Телефон:</td>
		<td><?=$Data[0]["PERSONAL_PHONE"];?></td>
	</tr>
	<tr>
		<td>Мобильный:</td>
		<td><?=$Data[0]["PERSONAL_MOBILE"];?></td>
	</tr>
	<tr>
		<td colspan="2">Доп. поля</td>
	</tr>
	<tr>
		<td>Вам есть 18?:</td>
		<td><?=$Data[0]["UF_YOU_HAVE_18"] == 1 ? "Да" : "Нет";?></td>
	</tr>
	<tr>
		<td>Вы курите?:</td>
		<td><?=$Data[0]["UF_DO_YOU_SMOKE"] == 1 ? "Да" : "Нет";?></td>
	</tr>
	<tr>
		<td>Марка 1:</td>
		<td><?=$Data[0]["UF_BRAND_1"];?></td>
	</tr>
	<tr>
		<td>Марка 2:</td>
		<td><?=$Data[0]["UF_BRAND_2"];?></td>
	</tr>
	<tr>
		<td>Согласны получать уведомления от компании ВАТ?</td>
		<td><?=$Data[0]["UF_NOTICE_FROM_BAT"] == 1 ? "Да" : "Нет";?></td>
	</tr>
	<tr>
		<td>FB:</td>
		<td><?=$Data[0]["UF_FB"];?></td>
	</tr>
	<tr>
		<td>VK:</td>
		<td><?=$Data[0]["UF_VK"];?></td>
	</tr>
	<tr>
		<td>G+:</td>
		<td><?=$Data[0]["UF_G_PLUS"];?></td>
	</tr>
	<?else:?>
	<tr>
		<td colspan="2"><?ShowError("Данные не найденны!");?></td>
	</tr>
	<?endif;?>
</table>
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>