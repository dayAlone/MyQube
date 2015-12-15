<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");$APPLICATION->SetTitle("Новый консультант");?>
<?if(in_array(10,$Data["User"]["Group"]) || in_array(1,$Data["User"]["Group"])):?>
	<?
		$Form = array(
			"Action" => true,
			"UserId" => -1,
			"Fields" => array(
				"Email" => "",
				"Login" => "",
				"Password" => Date("His"),
				"City" => ""
			),
			"Error" => "",
			"IsFinal" => false
		);
		
		$Form["Action"] = $_REQUEST["action"] == "edit" ? false : true;
		$Form["UserId"] = !empty($_REQUEST["id"]) ? $_REQUEST["id"] : -1;
		
		if(isset($_POST["Form"])){
			$Form["Fields"]["Email"] = $_POST["Form"]["Login"]."@myqube.ru";
			$Form["Fields"]["Login"] = $_POST["Form"]["Login"];
			$Form["Fields"]["Password"] = $_POST["Form"]["Password"];
			$Form["Fields"]["City"] = $_POST["Form"]["City"];
			
			$Fields = array(
				"EMAIL" => $Form["Fields"]["Email"],
				"LOGIN" => $Form["Fields"]["Login"],
				"WORK_CITY" => $Form["Fields"]["City"],
				"ACTIVE" => "Y",
				"GROUP_ID" => array(5,9)
			);
			
			$NewUser = new CUser;
			
			if($Form["Action"]){
				$Fields["PASSWORD"] = $Form["Fields"]["Password"];
				$Fields["CONFIRM_PASSWORD"] = $Form["Fields"]["Password"];
				$Fields["UF_PASSWORD"] = $Form["Fields"]["Password"];
				$Form["UserId"] = $NewUser->add($Fields);
				if($Form["UserId"] > 0){
					$Form["IsFinal"] = true;
				} else {
					$Form["Error"] = $NewUser->LAST_ERROR;
				}
			} else {
				$NewUser->Update($Form["UserId"], $Fields);
				$Form["Error"] = $NewUser->LAST_ERROR;
				if($Form["Error"] == ""){
					$Form["IsFinal"] = true;
				}
			}
		} else {
			
			if($Form["UserId"] != -1){
				$Query = CUser::GetList(($by="id"), ($order="desc"), array("ID"=>$Form["UserId"],"GROUPS_ID"=>9))->Fetch();
				if(!empty($Query)){
					$Form["Fields"]["Email"] = $Query["EMAIL"];
					$Form["Fields"]["Login"] = $Query["LOGIN"];
					$Form["Fields"]["City"] = $Query["WORK_CITY"];
				} else {
					$Form["Action"] = true;
					$Form["UserId"] = -1;
				}
			}
		}
		if($Form["IsFinal"]){
			LocalRedirect("/dashboard/list_consultant/");
		}
	?>
	<?if($Form["Error"] != ""){ShowError($Form["Error"]);}?>
	<form method="POST">
		<?if(!$Form["Action"]):?>
			<input type="hidden" name="id" value="<?=$Form["UserId"];?>"/>
			<input type="hidden" name="action" value="edit"/>
		<?endif;?>
		<table class="table_new_cons" cellpadding="0" cellspacing="0">
			<tr>
				<td>Логин</td>
				<td>
					<input type="text" name="Form[Login]" value="<?=$Form["Fields"]["Login"];?>"/>
				</td>
			</tr>
                     <tr>
				<td>E-Mail</td>
				<td>
					<input type="text" name="Form[Email]" disabled="disabled"  value="<?=$Form["Fields"]["Email"];?>"/>
				</td>
			</tr>
			<?if($Form["Action"]):?>
			<tr>
				<td>Пароль</td>
				<td>
					<input type="text" disabled="disabled" value="<?=$Form["Fields"]["Password"];?>"/>
					<input type="hidden" name="Form[Password]" value="<?=$Form["Fields"]["Password"];?>"/>
				</td>
			</tr>
			<?endif;?>
			<tr>
				<td>Город</td>
				<td>
					<input type="text" name="Form[City]" value="<?=$Form["Fields"]["City"];?>"/>
				</td>
			</tr>
			<tr>
				<td colspan="2">
					<input class="btn" type="submit"/>
				</td>
			</tr>
		</table>		
	</form>
<script type="text/javascript">
	$('input[name="Form[Login]"]').change(function () {
		$('input[name="Form[Email]"]').val($('input[name="Form[Login]"]').val()+"@myqube.ru");
	}).change();	
</script>
<?else:?>
	<?ShowError("Раздел для менеджеров.");?>
<?endif;?>
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>