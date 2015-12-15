 <?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");$APPLICATION->SetTitle("Мои консультанты");?>
<?if(in_array(12,$Data["User"]["Group"]) || in_array(1,$Data["User"]["Group"])):?>
	<?
		$APPLICATION->AddHeadScript("/js/dashboard.js");
		$APPLICATION->AddHeadScript("/js/plugins/jquery.fancybox/jquery.fancybox.js");
		$APPLICATION->SetAdditionalCSS("/js/plugins/jquery.fancybox/jquery.fancybox.css");
		$Query = CUser::GetList(
			($by="id"),
			($order="desc"),
			array(
				"GROUPS_ID" => array(9),
				"UF_ID_SUPERVISOR" => $USER->GetID()
			),
			array("SELECT" => array("UF_*"))
		);
	?>
	<table cellpadding="0" cellspacing="0" class="dashboard_list">
		<thead>
			<tr>
				<td>Id</td>
				<td>Активность</td>
				<td>Имя</td>
				<td>Фамилия</td>
				<td>E-Mail</td>
				<td>Город</td>
				<td></td>
			</tr>
		</thead>
		<tbody>
			<?
			$tmp=0;
			while($Answer = $Query->Fetch()):?>
			<? 
				$tmp_even_odd=($tmp==1)?"odd":"even";
				$tmp = ($tmp+1)% 2; 
			?>
			<tr class="<?=$tmp_even_odd?>">
				<td><?=$Answer["ID"];?></td>
				<td><?=($Answer["ACTIVE"] == "Y" ? "Да" : "Нет")?></td>
				<td><?=$Answer["NAME"];?></td>
				<td><?=$Answer["LAST_NAME"];?></td>
				<td><?=$Answer["EMAIL"];?></td>
				<td><?=$Answer["WORK_CITY"];?></td>
				<td>
					<a 
						onclick="Dashboard.GetStatisticsRegistrationsConsultant(this);" 
						id="<?=$Answer["ID"];?>" 
						href="javascript:void(0)">
					Лог регистрации
					</a>
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