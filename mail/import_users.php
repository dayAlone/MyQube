<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");?>
<?
	/*error_reporting(E_ALL);*/
	$data = array();

if(isset($_GET['files']))
{  
    $error = false;
    $files = array();

    $uploaddir = './upload/test2/';
	$lines  = array();
	$emails = array();
    foreach($_FILES as $file)
    {
        /*if(move_uploaded_file($file['tmp_name'], $uploaddir .basename($file['name'])))
        {
            $files[] = $uploaddir .$file['name'];
        }
        else
        {
            $error = true;
        }*/
		$fh = fopen($file['tmp_name'], 'r+');
		while( ($row = fgetcsv($fh, 8192)) !== FALSE ) {
			//$lines[] = $row;
			$emails[]=$row[0];
		}
    }
	/*echo "<xmp>";
	print_r($emails);
	echo "</xmp>";*/
	if(!empty($emails))
	{
		CModule::IncludeModule("iblock");
		$filter = Array
		(
		  "EMAIL"               => implode(" | ",$emails)
		);
		$rsUsers = CUser::GetList(($by="personal_country"), ($order="desc"), $filter,array("SELECT"=>array("UF_*"))); // выбираем пользователей
		$tmp = "";
		while($arUser = $rsUsers->Fetch()) :
	$res = CIBlockElement::GetList(array(), array("IBLOCK_ID" => 20, "PROPERTY_AMBASSADOR" => $arUser["ID"], "PROPERTY_USER" => false));
			$countCode = 0;
			while($ob = $res->GetNextElement()) {
				$countCode++;
				//$arFields = $ob->GetFields();
			}
			$del_val = $arUser["EMAIL"];
			if(($key = array_search($del_val, $emails)) !== false) {
				unset($emails[$key]);
			}
			if($arUser["UF_NOTICE_FROM_BAT"] == 1) continue;
			$tmp.= "<tr><td>".$arUser["ID"]."</td><td>".$arUser["NAME"]."</td><td>".$arUser["LAST_NAME"]."</td><td>".$arUser["EMAIL"]."</td><td>".$countCode."</td><td><input name=\"name[".$arUser["ID"]."]\" class=\"accept_user\" type=\"checkbox\" checked></td></tr>";	
		endwhile;
		if(!empty($emails))
		{
			foreach ($emails as $k=>$v)
			{
				$tmp.= "<tr><td></td><td></td><td></td><td>".$v."</td><td>загружен</td><td><input name=\"email[".$v."]\" class=\"accept_user\" type=\"checkbox\" checked></td></tr>";	
			}
		}
		$data = array('success' => 'Form was submitted', 'formData' => $tmp);
	}
    //$data = ($error) ? array('error' => 'There was an error uploading your files') : array('files' => $files);
}
else
{
    $data = array('success' => 'Form was submitted', 'formData' => $_POST);
}

echo json_encode($data);
?>