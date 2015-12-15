<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");$APPLICATION->SetTitle("Поиск контактов");?>
<div class="show-message"> </div>
<?
	$Data = array(
		"Params" => isset($_POST["User"]) ? $_POST["User"] : array()
	);
	if(!empty($Data["Params"])){
		$Data["Result"] = CustomUser::SearchUser(
			array(
				"!ID" => "1",
				"NAME" => "%".$Data["Params"]["Name"]."%",
				"LAST_NAME" => "%".$Data["Params"]["LastName"]."%",
				"EMAIL" => "%".$Data["Params"]["Email"]."%"
			),
			array("ID","NAME","LAST_NAME","EMAIL")
		);
	}
?>

<form method="POST">
	<table cellpadding="0" cellspacing="0">
		<tr>
			<td>
				Имя
			</td>
			<td>
				<input type="text" name="User[Name]" value="<?=$Data["Params"]["Name"];?>"/>
			</td>
		</tr>
		<tr>
			<td>
				Фамилия
			</td>
			<td>
				<input type="text" name="User[LastName]" value="<?=$Data["Params"]["LastName"];?>"/>
			</td>
		<tr>
			<td>
				Эл. почта
			</td>
			<td>
				<input type="text" name="User[Email]" value="<?=$Data["Params"]["Email"];?>"/>
			</td>
		</tr>
		<tr>
			<td colspan="2">
				<input type="submit"/>
			</td>
		</tr>
	</table>
</form>
<?if(!empty($Data["Params"])):?>
<table cellpadding="0" cellspacing="0">
	<?if(!empty($Data["Result"])):?>
		<?foreach($Data["Result"] as $key => $value):?>
		<tr>
			<td><?=$value["NAME"];?></td>
			<td><?=$value["LAST_NAME"];?></td>
			<td><?=$value["EMAIL"];?></td>
			<td>
				<a href="detail.php?ID=<?=$value["ID"];?>" >Детально</a>
			</td>
		</tr>
		<?endforeach;?>
	<?else:?>
	<tr>
		<td colspan="4"><?ShowError("Данные не найденны!");?></td>
	</tr>
	<?endif;?>
</table>
<?endif;?>
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>