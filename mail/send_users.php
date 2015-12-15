<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");?>
<?
	$sent=Array();
	foreach($_POST["name"] as $k=> $v)
	{
		$rsUser = CUser::GetByID($k);
		$arUser = $rsUser->Fetch();
		if(in_array($arUser["EMAIL"], $sent))continue;else $sent[]=$arUser["EMAIL"];
		if($v=="on")
		{
			if($_POST["mail_template"] == 34 || $_POST["mail_template"] == 36) {
				CModule::IncludeModule("iblock");
				$res = CIBlockElement::GetList(Array(), Array("IBLOCK_ID"=>20, "PROPERTY_AMBASSADOR"=>$arUser["ID"]), false, Array("nTopCount"=>5), Array("*"));
				$IDs = array();
				$IDsUnused = array();
				while($ob = $res->GetNextElement()) {
					$arFieldsCodes = $ob->GetFields();
					$IDs[] = $arFieldsCodes;
					$arPropsCodes = $ob->GetProperties();
					if(empty($arPropsCodes["USER"]["VALUE"]))
						$IDsUnused[] = $arFieldsCodes;
				}
				$eventFields34 = array(
					"EMAIL" => $arUser["EMAIL"],
					"NAME" => $arUser["NAME"],
					"CODE1" => $IDs[0]["NAME"],
					"CODE2" => $IDs[1]["NAME"],
					"CODE3" => $IDs[2]["NAME"],
					"CODE4" => $IDs[3]["NAME"],
					"CODE5" => $IDs[4]["NAME"],
					"DATE" => "00:00  20.11.2015"
				);
				$eventFields36 = array(
					"EMAIL" => $arUser["EMAIL"],
					"NAME" => $arUser["NAME"],
					"CODE1" => $IDsUnused[0]["NAME"],
					"CODE2" => $IDsUnused[1]["NAME"],
					"CODE3" => $IDsUnused[2]["NAME"],
					"CODE4" => $IDsUnused[3]["NAME"],
					"CODE5" => $IDsUnused[4]["NAME"],
					"NUM_CODE" => count($IDsUnused)
				);
				if($_POST["mail_template"] == 36) {
					CEvent::SendImmediate("UNUSED_CODE", "s1", $eventFields36, $Duplicate = "N", $message_id="36");		
				}
				if($_POST["mail_template"] == 34){
					CEvent::SendImmediate("AMBASSADOR_CODE", "s1", $eventFields34, $Duplicate = "N", $message_id="34");
				}
			} elseif($_POST["mail_template"] == 32) {
				$eventFields = array(
					"EMAIL" => $arUser["EMAIL"],
					"NAME" => $arUser["NAME"]
				);
				CEvent::SendImmediate("NEW_AMBASSADOR", "s1", $eventFields, $Duplicate = "N", $message_id="32");
			} elseif($_POST["mail_template"] == 37) {
				$eventFields = array(
					"EMAIL" => $arUser["EMAIL"],
					"NAME" => $arUser["NAME"]
				);
				CEvent::SendImmediate("THANKS_FOR_PARTICIPATING", "s1", $eventFields, $Duplicate = "N", $message_id="37");
			} elseif($_POST["mail_template"] == 39) {
				$eventFields = array(
					"EMAIL" => $arUser["EMAIL"],
					"NAME" => $arUser["NAME"]
				);
				CEvent::SendImmediate("U_CONCEPT", "s1", $eventFields, $Duplicate = "N", $message_id="39");
			} elseif($_POST["mail_template"] == 29) {
				$eventFields = array(
					"EMAIL" => $arUser["EMAIL"],
					"NAME" => $arUser["NAME"],
					"LOGIN" => $arUser["LOGIN"],
					"PASSWORD" => $arUser["PASSWORD"]
				);
				CEvent::SendImmediate("LAUNCH_OFFER", "s1", $eventFields, $Duplicate = "N", $message_id="29");
			} elseif($_POST["mail_template"] == 38) {
				CModule::IncludeModule("iblock");
				$arPerf = CIBlockElement::GetList(Array(), Array("IBLOCK_ID"=>21, "ID" => $_POST["performance"]), false, false, Array("*"));
				while($obPerf = $arPerf->GetNextElement()) {
					$perf = $obPerf->GetProperties();
				}
				$eventFields = array(
					"EMAIL" => $arUser["EMAIL"],
					"NAME" => $arUser["NAME"],
					"DATE" => date("d.m.Y", strtotime($perf["DATE_FROM"]["VALUE"])),
					"LINK_PHOTOREPORT" => "http://myqube.ru/group/1/u_concept/#photos"
				);
				CEvent::SendImmediate("nvitation to the photoreport", "s1", $eventFields, $Duplicate = "N", $message_id="38");
			} elseif($_POST["mail_template"] == 41) {
				$arFields=Array(
				 "EMAIL" => $arUser["EMAIL"],
				 "NAME" => $arUser["NAME"]
				);
				CEvent::SendImmediate("Launch_flagship", "s1", $arFields, $Duplicate = "N", $message_id="41");
			} elseif($_POST["mail_template"] == 42) {
				$arFields=Array(
				 "EMAIL" => $arUser["EMAIL"],
				 "NAME" => $arUser["NAME"]
				);
				CEvent::SendImmediate("winner_WOM", "s1", $arFields, $Duplicate = "N", $message_id="42");
			}
		}
	}
	foreach($_POST['email'] as $k =>$v)
	{
	    if(in_array($k,$sent))continue;else $sent[]=$k;
	    if($v=="on")
	    {
			if($_POST["mail_template"] !== 34 && $_POST["mail_template"] !== 38) {
				if($_POST["mail_template"] == 32) {
					$eventFields = array(
						"EMAIL" => $k,
						"NAME" => ""
					);
					CEvent::SendImmediate("NEW_AMBASSADOR", "s1", $eventFields, $Duplicate = "N", $message_id="32");
				} elseif($_POST["mail_template"] == 37) {
					$eventFields = array(
						"EMAIL" => $k,
						"NAME" => ""
					);
					CEvent::SendImmediate("THANKS_FOR_PARTICIPATING", "s1", $eventFields, $Duplicate = "N", $message_id="37");
				} elseif($_POST["mail_template"] == 39) {
					$eventFields = array(
						"EMAIL" => $k,
						"NAME" => ""
					);
					CEvent::SendImmediate("U_CONCEPT", "s1", $eventFields, $Duplicate = "N", $message_id="39");
				} elseif($_POST["mail_template"] == 29) {
					$eventFields = array(
						"EMAIL" => $k,
						"NAME" => ""
					);
					CEvent::SendImmediate("LAUNCH_OFFER", "s1", $eventFields, $Duplicate = "N", $message_id="29");
				} elseif($_POST["mail_template"] == 41) {
					$arFields=Array(
						"EMAIL" => $k,
						"NAME" => ""
					);
					CEvent::SendImmediate("Launch_flagship", "s1", $arFields, $Duplicate = "N", $message_id="41");
				} elseif($_POST["mail_template"] == 42) {
					$arFields=Array(
						"EMAIL" => $k,
						"NAME" => ""
					);
					CEvent::SendImmediate("winner_WOM", "s1", $arFields, $Duplicate = "N", $message_id="42");
				}
			}
	    }
	}
	
	$data = array('success' => 'Form was submitted', 'formData' => "all ok");
	echo json_encode($data);
?>