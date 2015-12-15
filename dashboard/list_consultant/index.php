<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");$APPLICATION->SetTitle("Список консультантов");?>
<?if(in_array(10,$Data["User"]["Group"]) || in_array(1,$Data["User"]["Group"])):?>
	<?
		$APPLICATION->AddHeadScript("/js/dashboard.js");
		$APPLICATION->AddHeadScript("/js/plugins/jquery.fancybox/jquery.fancybox.js");
		$APPLICATION->SetAdditionalCSS("/js/plugins/jquery.fancybox/jquery.fancybox.css");
		$Query = CUser::GetList(
			($by="id"),
			($order="desc"),
			array(
				"GROUPS_ID" => array(9)
			),
			array("SELECT" => array("UF_*"))
		);
	?>
	<table cellpadding="0" cellspacing="0" class="dashboard_list">
		<thead>
			<tr>
				<td>Id</td>
				<td >Активность</td>
				<td>Логин</td>
				<td>E-Mail</td>
				<td>Город</td>
				<td>Активировать</td>
				<td>Статистика регистраций</td>
				<td>Прикрепить к супервайзеру</td>
				<td>Редактировать</td>
			</tr>
		</thead>
		<tbody>
			<?	$tmp=0;
				while($Answer = $Query->Fetch()):?>
				<?
					$tmp_even_odd=($tmp==1)?"odd":"even";
					$tmp = ($tmp+1)% 2;
					$Answer["UF_ID_SUPERVISOR"] = ($Answer["UF_ID_SUPERVISOR"] == "" ? -1 : $Answer["UF_ID_SUPERVISOR"]);
				?>
			<tr class="<?=$tmp_even_odd?>">
				<td><?=$Answer["ID"];?></td>
				<td><?=($Answer["ACTIVE"] == "Y" ? "Да" : "Нет")?></td>
				<td >
					<a href="/dashboard/new_consultant/?action=edit&id=<?=$Answer["ID"];?>">
						<?=preg_replace('/@.*$/', ' ', $Answer["EMAIL"]);?>
					</a>
				</td>
				<td><?=$Answer["EMAIL"];?></td>
				<td><?=$Answer["WORK_CITY"];?></td>
				<td>
					<a onclick="Dashboard.ChangeUserStatus(this);" href="javascript:void(0)" id="<?=$Answer["ID"];?>">
						<?=($Answer["ACTIVE"] == "Y" ? "Деактивировать" : "Активировать")?>
					</a>
				</td>
				<td>
					<a 
						onclick="Dashboard.GetStatisticsRegistrationsConsultant(this);" 
						href="javascript:void(0)" 
						id="<?=$Answer["ID"];?>">
						Статистика регистраций 
					</a>
				</td>
				<td>
					<a 
						onclick="Dashboard.SetSupervisor(this,<?=$Answer["UF_ID_SUPERVISOR"];?>);" 
						href="javascript:void(0)" 
						id="<?=$Answer["ID"];?>">
						Прикрепить к супервайзеру 
					</a>
				</td>
				<td>

					<a 
						href="/dashboard/new_consultant/?action=edit&id=<?=$Answer["ID"];?>">
						Редактировать 
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