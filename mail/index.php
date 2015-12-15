<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Рассылки");
?><?
CModule::IncludeModule("iblock");
if(!empty($_GET["p"])) {
	$pUsers = "";
	$res = CIBlockElement::GetList(array(), array("IBLOCK_ID" => 20, "PROPERTY_PERFORMANCE" => $_GET["p"], "PROPERTY_USED" => 1));
	while($ob = $res->GetNextElement()) {
		$arProps = $ob->GetProperties();
		$pUsers = $pUsers.$arProps["USER"]["VALUE"]." | ";
	}	
	if(!empty($pUsers)) {		
		$filter = Array
		(
			"ACTIVE"              => "Y",
			"UF_GROUPS"			  => array(1),
			"UF_NOTICE_FROM_BAT"		  => 0
		);
		$filter["ID"] = $pUsers;
	} else {		
		$filter = Array("ID" => 0);
	}
} else {	
	$filter = Array
	(
		"ACTIVE"              => "Y",
		"GROUPS_ID"           => Array(13,1),
		"UF_GROUPS"			  => array(1),
		"UF_NOTICE_FROM_BAT"		  => 0
	);
}
$rsUsers = CUser::GetList(($by="personal_country"), ($order="desc"), $filter); // выбираем пользователей
$is_filtered = $rsUsers->is_filtered; // отфильтрована ли выборка ?
$rsUsers->NavStart(50); // разбиваем постранично по 50 записей
echo $rsUsers->NavPrint(GetMessage("PAGES")); // печатаем постраничную навигацию
?>
<script type="text/javascript" src="/js/tablesorter/jquery.tablesorter.js"></script> 
<link href="/js/tablesorter/themes/blue/style.css" type="text/css"  rel="stylesheet" />
<style>
	.inside {
		margin:20px 20px;
	}
	/*.accept_user {
		float:right;
	}
	.line {
		width:100%;
	}*/
	h1 {
		font-size: 20px;
	}
	table.tablesorter thead tr .header {
		color:#000;
	}
	.inside input[type="checkbox"] {
		position:initial;
	}
	#import_users td,#templ td{
		padding:10px 20px;
	}
	#text_message {
		display:none;
		color:#FFF;
		padding:20px;
		border:1px solid red;
		font-size:24px;
	}
</style>
<script>
	$(document).ready(function() 
		{ 
			$("#myTable").tablesorter(); 
			$("#myTable_import").tablesorter(); 			
			var files;
			
			$('.set_checkbox').on('change', setCheckbox);
			
			function setCheckbox()
			{
				if($('#'+$(this).data("table")+' input[type=checkbox]').prop('checked')) {
					$('#'+$(this).data("table")+' input[type=checkbox]').prop('checked', false);
				} else {
					$('#'+$(this).data("table")+' input[type=checkbox]').prop('checked', true);
				}
			}
			
			// Add events
			$('input[type=file]').on('change', prepareUpload);

			// Grab the files and set them to our variable
			function prepareUpload(event)
			{
			  files = event.target.files;
			}
			
			$('form#import_users').on('submit', uploadFiles);
			$('form#send_users').on('submit', sendUsers);

			function sendUsers(event)
			{
				data = $("#imported_users" ).serialize()+"&"+$("#ambasadors_users" ).serialize()+"&"+$("#send_users" ).serialize();
				event.stopPropagation(); // Stop stuff happening
				event.preventDefault(); // Totally stop stuff happening
				$.ajax({
				  type: "POST",
				  url: "send_users.php",
				  data: data,
				  success: function(data, textStatus, jqXHR)
				  {
					$("#text_message").html("Письма отправлены");
					$("#text_message").show();
				  },
				  dataType: 'json'
				});
			}
			// Catch the form submit and upload the files
			function uploadFiles(event)
			{
				event.stopPropagation(); // Stop stuff happening
				event.preventDefault(); // Totally stop stuff happening

				// START A LOADING SPINNER HERE

				// Create a formdata object and add the files
				var data = new FormData();
				$.each(files, function(key, value)
				{
					data.append(key, value);
				});

				$.ajax({
					url: 'import_users.php?files',
					type: 'POST',
					data: data,
					cache: false,
					dataType: 'json',
					processData: false, // Don't process the files
					contentType: false, // Set content type to false as jQuery will tell the server its a query string request
					success: function(data, textStatus, jqXHR)
					{
						$( "#import_form" ).append( data.formData );
					},
					error: function(jqXHR, textStatus, errorThrown)
					{
						// Handle errors here
						console.log('ERRORS: ' + textStatus);
						// STOP LOADING SPINNER
					}
				});
			}
		}
	); 
</script>
<div class="inside">
	<h1>Фильтр "Посетившие мероприятия" </h1><br>
	<select onchange="location=this.options[this.selectedIndex].value;">
		<option value="/mail/">---</option>
		<?$performance = CIBlockElement::GetList(array(), array("IBLOCK_ID" => 21));
		while($ob = $performance->GetNextElement()) {
			$arPerformance = $ob->GetFields();
			if($arPerformance["ID"] == $_GET["p"]) $selected = " selected"; else $selected = "";
			echo "<option value=\"?p=".$arPerformance["ID"]."\"".$selected.">".$arPerformance["NAME"]." (".$arPerformance["ID"].")</option>";
		}?>
	</select>
	<br><br><br><br>
	<h1><input type="checkbox" class="set_checkbox" data-table="ambasadors_users" checked> <?if(!empty($_GET["p"])) { echo "Пользователи"; }else{echo"Амбасадоры";}?></h1>
	<form action="index.php" id="ambasadors_users" method="post">
		<table id="myTable" class="tablesorter"> 
			<thead> 
				<tr> 
					<th>ID</th> 
					<th>Имя</th> 
					<th>Фамилия</th> 
					<th>Email</th> 
					<th><?=$_GET["p"] ? "Использован код" : "Свободных кодов"?></th>
					<th>Отправить письмо</th>
				</tr> 
			</thead> 
			<tbody> 
				<?
				while($rsUsers->NavNext(true, "f_")) :
					if($_GET["p"]) {
						$res = CIBlockElement::GetList(array(), array("IBLOCK_ID" => 20, "PROPERTY_USER" => $f_ID));
						$input = "";
						while($ob = $res->GetNextElement()) {
							$arFields = $ob->GetFields();
							$input = $input.$arFields["NAME"]." | ";
						}
						$input = substr($input, 0, -2);
					} else {
						$res = CIBlockElement::GetList(array(), array("IBLOCK_ID" => 20, "PROPERTY_AMBASSADOR" => $f_ID, "PROPERTY_USER" => false));
						$countCode = 0;
						while($ob = $res->GetNextElement()) {
							$countCode++;
						}
						$input = $countCode;
					}
					echo "<tr><td>".$f_ID."</td><td>".$f_NAME."</td><td>".$f_LAST_NAME."</td><td>".$f_EMAIL."</td><td>".$input."</td><td><input name=\"name[".$f_ID."]\" class=\"accept_user\" type=\"checkbox\" checked></td></tr>";	
				endwhile;
				?>
			</tbody> 
		</table> 
		<?if(!empty($_GET["p"])) {?>
			<input type="hidden" name="performance" value="<?=$_GET["p"]?>">
		<?}?>
	</form>
	<h1><input type="checkbox" class="set_checkbox" data-table="imported_users" checked> Импортированные пользователи</h1>
	<form action="index.php" id="imported_users" method="post">
	<table id="myTable_import" class="tablesorter"> 
		<thead> 
			<tr> 
				<th>ID</th> 
				<th>Имя</th> 
				<th>Фамилия</th> 
				<th>Email</th> 
				<th>Свободных кодов</th>
				<th>Отправить письмо</th>
			</tr> 
		</thead> 
		<tbody id="import_form"> 
		</tbody> 
	</table> 
	</form>
	<div style="float:left; width:50%;">
		<form action="import_users.php" method="post" id="import_users" OnSubmit="return false;" enctype="multipart/form-data">
			<table>
				<tr>
					<td width="20%">Выбрать файл</td>
					<td width="80%"><input type="file" name="file" id="file" /></td>
				</tr>
				<tr>
					<td>Импортировать</td>
					<td><input type="submit" name="submit" /></td>
				</tr>
			</table>
		</form>
	</div>
	<form action="send_users.php" method="post" id="send_users" OnSubmit="return false;" enctype="multipart/form-data">
		<div style="float:left; width:50%;">
			<table id="templ"><tbody>
				<tr>
					<td width="40%">
						Выбрать шаблон письма
					</td>
					<td width="60%">
						<select name="mail_template">
						  <option value="29">Приглашение на Launch (29)</option>
						  <option value="32">Амбассадор. Регистрационное письмо (32)</option>
						  <option value="34">Коды для амбассадоров (34)</option>
						  <option value="36">Неиспользованные коды (36)</option>
						  <option value="37">Благодарность за участие (37)</option>
						  <option value="38">Приглашение на фотоотчет (38)</option>
						  <option value="39">Подведение итогов u_concept (39)</option>						  
						  <option value="41">Приглашение на Launch_flagship (41)</option>				  
						  <option value="42">winner_WOM (42)</option>
						</select>
					</td>
				</tr>
				<tr>
					<td>Отправить письма</td>
					<td><input type="submit" name="submit" /></td>
				</tr>
			</tbody></table>
		</div>
	</form>
	<div style="clear:both;"></div>
	<div id="text_message"></div>
</div>
<br><?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>