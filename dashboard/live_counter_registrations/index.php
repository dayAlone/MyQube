<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");$APPLICATION->SetTitle("Мои консультанты");?>
<?if(in_array(12,$Data["User"]["Group"]) || in_array(1,$Data["User"]["Group"])):?>
	<?
		$APPLICATION->AddHeadScript("/js/dashboard.js");
		$Query = CUser::GetList(
			($by="id"),
			($order="desc"),
			array(
				"GROUPS_ID" => array(9),
				(in_array(12,$Data["User"]["Group"]))? array(
					"GROUPS_ID" => array(9),
					"UF_ID_SUPERVISOR" => $USER->GetID()
				):
				array(
					"GROUPS_ID" => array(9)
				)			),
			array("SELECT" => array("UF_*"))
		);
	?>
	<div id="event_date_interval">
		<?$APPLICATION->IncludeComponent("bitrix:main.calendar","",Array(
			 "SHOW_INPUT" => "Y",
			 "FORM_NAME" => "",
			 "INPUT_NAME" => "DateFrom",
			 "INPUT_NAME_FINISH" => "DateTo",
			 "INPUT_VALUE" => date("d.m.Y H:i:s"),
			 "INPUT_VALUE_FINISH" => date("d.m.Y H:i:s"), 
			 "SHOW_TIME" => "Y",
			 "HIDE_TIMEBAR" => "Y"
			)
		);?>
		<input type="button" class="btn" onclick="Dashboard.SetLiveCounterRegistrations();"  value="Сформировать">
	</div>
	<table class="table_cons_list" cellpadding="0" cellspacing="0">
		<thead>
			<tr>
				<td>Id</td>
				<td>Активность</td>
				<td>Логин</td>
				<td>E-Mail</td>
				<td>Город</td>
				<td>Количество зарегистрированных</td>
			</tr>
		</thead>
		<tbody id="ListConsultant">
			<?while($Answer = $Query->Fetch()):?>
			<tr>
				<td><?=$Answer["ID"];?></td>
				<td><?=($Answer["ACTIVE"] == "Y" ? "Да" : "Нет")?></td>
				<td><?=preg_replace('/@.*$/', ' ', $Answer["LOGIN"]);?></td>
				<td><?=$Answer["EMAIL"];?></td>
				<td><?=$Answer["WORK_CITY"];?></td>
				<td id="live_c_r_<?=$Answer["ID"];?>">
					
				</td>
			</tr>
			<?endwhile;?>
			<?if($Query->SelectedRowsCount() == 0):?>
			<tr>
				<td colspan="7">Данных не найдено</td>
			</tr>
			<?endif;?>
		</tbody>
	</table>
<?else:?>
	<?ShowError("Раздел для менеджеров.");?>
<?endif;?>
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>