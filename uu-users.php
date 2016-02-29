<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");
CModule::IncludeModule("iblock");
CModule::IncludeModule("highloadblock");
use Bitrix\Highloadblock as HL;
use Bitrix\Main\Entity;?>
<form method="post" id="import_users" enctype="multipart/form-data">
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
<?if($_FILES['file']['tmp_name']){
	$emails = array();
	$fh = fopen($_FILES['file']['tmp_name'], 'r+');
	$i = 0;
	while(($row = fgetcsv($fh, 8192)) !== FALSE ) {
		/*//if($i > 4030) {
		$arUser = $USER->GetByLogin($row[6])->Fetch();
		$emails = array();
		$pass = mt_rand(10000000, 99999999);
		echo str_replace("/", ".", $row[1]);
		$emails = array(
			"PERSONAL_BIRTHDAY" => date("d.m.Y", strtotime($row[0])),
			"DATE_REGISTER" => str_replace("/", ".", $row[1]),
			"EMAIL" => $row[2],
			"NAME" => $row[3],
			"LAST_NAME" => $row[4],
			//"SECOND_NAME" => $row[6],
			"PERSONAL_MOBILE" => $row[5],
			"UF_USER_PARENT" => $arUser["ID"],
			"LOGIN" => $row[2],
			"PASSWORD" => $pass,
			"UF_GROUPS" => array(1),
			"UF_DO_YOU_SMOKE" => 1,
			"UF_YOU_HAVE_18" => 1,
			"UF_IAGREE" => 1
		);
		$Hash = md5($row[5].$arUser["ID"].time());
		$emails["UF_TOKEN"] = $Hash;
		$emails["UF_HASH"] = $Hash;
		$email[] = $emails;
		$user = new CUser;
		$ID = $user->Add($emails);	
		if(intval($ID) > 0) {
			$eventFields = array(
				"EMAIL" => $row[2],
				"NAME" => $row[3],
				"LOGIN" => $row[2],
				"PASSWORD" => $pass,
				"TOKEN" => $Hash
			);
			if($emails["UF_USER_PARENT"] == 29808 || $emails["UF_USER_PARENT"] == 7813 || $emails["UF_USER_PARENT"] == 43546 || $emails["UF_USER_PARENT"] == 43562 || $emails["UF_USER_PARENT"] == 43563 || $emails["UF_USER_PARENT"] == 43547 || $emails["UF_USER_PARENT"] == 43575 || $emails["UF_USER_PARENT"] == 43731 || $emails["UF_USER_PARENT"] == 43735 || $emails["UF_USER_PARENT"] == 43551 || $emails["UF_USER_PARENT"] == 43553 || $emails["UF_USER_PARENT"] == 32177 || $emails["UF_USER_PARENT"] == 32175 || $emails["UF_USER_PARENT"] == 32176 || $emails["UF_USER_PARENT"] == 32169 || $emails["UF_USER_PARENT"] == 32173 || $emails["UF_USER_PARENT"] == 32172 || $emails["UF_USER_PARENT"] == 32174 || $emails["UF_USER_PARENT"] == 32170) {
				CEvent::SendImmediate("registration", "s1", $eventFields, $Duplicate = "N", $message_id="40");
			} else {
				CEvent::SendImmediate("NEW_USER_NEW", "s1", $eventFields, $Duplicate = "N", $message_id="26");	
			}
			$data = array(
			   "UF_EMAIL" => $emails["EMAIL"],
			   "UF_INT" => $i,
			   "UF_ID" => $ID,
			   "UF_RESULT" => "OK"
		    );
			$hlblock = HL\HighloadBlockTable::getById(6)->fetch(); 
			$entity = HL\HighloadBlockTable::compileEntity($hlblock);
			$entity_data_class = $entity->getDataClass();		 
			$result = $entity_data_class::add($data);
			$ID = $result->getId();	//$result->getErrorMessages()[0];
		} else {				
			echo $user->LAST_ERROR; echo "<br>";
			echo $i; echo "<br>";
			echo $row[2]; echo "<br>";

			$data = array(
			   "UF_EMAIL" => $emails["EMAIL"],
			   "UF_INT" => $i,
			   "UF_ID" => 0,
			   "UF_RESULT" => $user->LAST_ERROR
		    );
			$hlblock = HL\HighloadBlockTable::getById(6)->fetch(); 
			$entity = HL\HighloadBlockTable::compileEntity($hlblock);
			$entity_data_class = $entity->getDataClass();		 
			$result = $entity_data_class::add($data);
			$ID = $result->getId();	//$result->getErrorMessages()[0];
		}
		$i++;
		//}*/

		$emails = array(
			"PERSONAL_BIRTHDAY" => date("d.m.Y", strtotime($row[1]))
		);
		echo $row[0];
		$user = new CUser;
		$res = $user->Update($row[0], $emails);	
		if($res) {
		} else {				
			echo $user->LAST_ERROR; echo "<br>";
			echo $i; echo "<br>";
			echo $row[0]; echo "<br>";
		}
		$i++;
	}
	echo count($email);
	echo "<pre>"; print_r($email); echo "</pre>";
}
?>