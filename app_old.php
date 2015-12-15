<?
header('Content-Type: application/json');
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");

CModule::IncludeModule("iblock");
CModule::IncludeModule("highloadblock");
use Bitrix\Highloadblock as HL;
use Bitrix\Main\Entity;
global $USER;

//checkauth
if($_REQUEST["mode"] == "checkauth") {
	$rsUser = $USER->GetByLogin($_SERVER['PHP_AUTH_USER']);
	if($arUser = $rsUser->Fetch()) {
		$arGroups = array();
		$arGroups = $USER->GetUserGroup($arUser["ID"]);
		if(in_array(8, $arGroups) || in_array(9, $arGroups)) { // amplifier || adviser
			$salt = substr($arUser['PASSWORD'], 0, (strlen($arUser['PASSWORD']) - 32));

			$realPassword = substr($arUser['PASSWORD'], -32);
			$password = md5($salt.$_SERVER['PHP_AUTH_PW']);

			if($password == $realPassword) {
				$USER->Authorize($arUser["ID"]);
				$promo = "N";
				if(in_array(8, $arGroups))	$role = "amplifier";
				elseif(in_array(9, $arGroups))	{ $role = "adviser"; $promo = "Y"; }
				print json_encode(array(
					array(
						"status" => "OK",
						"status_msg" => "Авторизация успешна",
						"role" => $role,
						"sessid" => bitrix_sessid_get(),
						"show_promo" => $promo
					)
				), JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
			} else {
				print json_encode(array(
					array(
						"status" => "ERROR",
						"status_msg" => "Вы не авторизованы (неверный пароль)",
						"status_code" => 101,
					)
				), JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
			}
		} else {
			print json_encode(array(
				array(
					"status" => "ERROR",
					"status_msg" => "Вы не администратор",
					"bitrix_result" => $arGroups
				)
			), JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
		}
	} else {
		print json_encode(array(
			array(
				"status" => "ERROR",
				"status_msg" => "Вы не авторизованы (пользователь с логином ".$_SERVER['PHP_AUTH_USER']." не найден)",
				"status_code" => 101
			)
		), JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
	}
}

//log
if($_REQUEST["mode"] == "log") {
	if(!$USER->IsAuthorized()) {
		exit();
	}
	if($_REQUEST["log"] == "read") {
		 
		$hlblock = HL\HighloadBlockTable::getById(4)->fetch();
		$entity = HL\HighloadBlockTable::compileEntity($hlblock);		 
		$entity_data_class = $entity->getDataClass();
		$entity_table_name = $hlblock['log'];
		 
		$arFilter = array();
		 
		$sTableID = 'tbl_'.$entity_table_name;
		$rsData = $entity_data_class::getList(array(
			"select" => array('*'),
			"filter" => $arFilter,
			"order" => array("UF_DATE_TIME"=>"ASC")
		));
		$rsData = new CDBResult($rsData, $sTableID);
		$log = array();
		while($arRes = $rsData->Fetch()){
			$log[] = array(
				"id" => $arRes["ID"],
				"dt" => $arRes["UF_DATE_TIME"] ? date("Y-m-d H:i:s", strtotime($arRes["UF_DATE_TIME"])) : "",
				"contact_id" => $arRes["UF_USER"] ? $arRes["UF_USER"] : 0,
				"action_code" => $arRes["UF_ACTION_CODE"] ? $arRes["UF_ACTION_CODE"] : 0,
				"action_text" => $arRes["UF_ACTION_TEXT"] ? $arRes["UF_ACTION_TEXT"] : "",
				"uf_type" => $arRes["UF_TYPE"] ? $arRes["UF_TYPE"] : 0,
				"uf_type_2" => $arRes["UF_TYPE_2"] ? $arRes["UF_TYPE_2"] : 0,
			);
		}
		print json_encode(array(
			array(
				"status" => "OK",
				"status_msg" => "LogRead",
				"log" => $log
			)
		), JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
	}
	if($_REQUEST["log"] == "write") {
		$log = array();
		$json = json_decode(file_get_contents('php://input'), true);
		if(!isset($json)) {
			print json_encode(array(
				array(
					"status" => "ERROR",
					"status_msg" => "NO DATA"
				)
			), JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
			exit();
		}
		if(!is_array($json)) {
			print json_encode(array(
				array(
					"status" => "ERROR",
					"status_msg" => "Некорректные данные - не массив"
				)
			), JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
			exit();
		}
		if(empty($json)) {
			print json_encode(array(
				array(
					"status" => "ERROR",
					"status_msg" => "Некорректные данные - пустой массив"
				)
			), JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
			exit();
		}
		foreach($json as $key => $val) {
			$data = array(
			   "UF_USER" => $val["contact_id"],
			   "UF_AMPLIFIER" => $USER->GetID(),
			   "UF_EVENT" => $val["uf_event"],
			   "UF_DATE_TIME" => date("d.m.Y H:i:s", strtotime($val["dt"])),
			   "UF_ACTION_CODE" => $val["action_code"],
			   "UF_ACTION_TEXT" => $val["action_text"],
			   "UF_TYPE" => $val["uf_type"],
			   "UF_TYPE_2" => $val["uf_type_2"]
		    );
			$hlblock = HL\HighloadBlockTable::getById(4)->fetch(); 
			$entity = HL\HighloadBlockTable::compileEntity($hlblock);
			$entity_data_class = $entity->getDataClass();		 
			$result = $entity_data_class::add($data);
			$ID = $result->getId(); //$result->getErrorMessages()[0]
			$log[] = array(
				"status" => "OK",
				"status_msg" => "LogAdd",
				"app_id" => $val["app_id"] ? $val["app_id"] : 0,
				"external_id" => $ID ? $ID : 0
			);
		}
		print json_encode($log, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
	}
	if($_REQUEST["log"] !== "read" && $_REQUEST["log"] !== "write")
		print json_encode(array(
			array(
				"status" => "ERROR",
				"status_msg" => "NO DATA"
			)
		), JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
}

//promo
if($_REQUEST["mode"] == "promo") {	
	if(!$USER->IsAuthorized()) {
		exit();
	}
	$promo = CIBlockElement::GetProperty(18, 763)->GetNext();
	print json_encode(array(
		array(
			"status" => "OK",
			"status_msg" => "PROMO",
			"url_list" => array("http://".SITE_SERVER_NAME.CFile::GetPath($promo["VALUE"])),
			"filetime" => array($promo["TIMESTAMP_X"])
		)
	), JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
}

//new_contact
if($_REQUEST["mode"] == "new_contact") {
	if(!$USER->IsAuthorized()) {
		exit();
	}
	$json = json_decode(file_get_contents('php://input'), true);
	if(!isset($json)) {
		print json_encode(array(
			array(
				"status" => "ERROR",
				"status_msg" => "NO DATA"
			)
		), JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
		exit();
	}
	if(!is_array($json)) {
		print json_encode(array(
			array(
				"status" => "ERROR",
				"status_msg" => "Некорректные данные - не массив"
			)
		), JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
		exit();
	}
	if(empty($json)) {
		print json_encode(array(
			array(
				"status" => "ERROR",
				"status_msg" => "Некорректные данные - пустой массив"
			)
		), JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
		exit();
	}
	$contact_type = array(
		1 => 28,
		2 => 29,
		3 => 30,
		4 => 31,
		5 => 32
	);
	$status = array(
		"Y" => 1,
		"N" => 0
	);
	foreach($json as $key => $val) {
		if($val["contact_type"] == 0) $val["contact_type"] = 1;
		$Fields = array(
			"NAME" => $val["NAME"],
			"LAST_NAME" => $val["LAST_NAME"],
			"LOGIN" => $val["EMAIL"] ? $val["EMAIL"] : $val["app_id"].time().'@xyz.xyz',
			"EMAIL" => $val["EMAIL"] ? $val["EMAIL"] : $val["app_id"].time().'kentlabemail@xyz.xyz',
			"ACTIVE" => "Y",
			"PASSWORD" => $val["app_id"].time(),
			"CONFIRM_PASSWORD" => $val["app_id"].time(),
			"PERSONAL_MOBILE" => $val["PERSONAL_MOBILE"],
			"PERSONAL_BIRTHDAY" => $val["PERSONAL_BIRTHDAY"],
			"UF_FB_PROFILE" => array($val["UF_FB"]),
			"UF_VK_PROFILE" => array($val["UF_VK"]),
			"UF_GP_PROFILE" => array($val["UF_G_PLUS"]),
			"UF_MARK_1" => $val["UF_MARK_1"],
			"UF_MARK_2" => $val["UF_MARK_2"],
			"ADMIN_NOTES" => $val["ADMIN_NOTES"],
			"INFO" => $val["INFO"],
			"UF_IAGREE" => 1,
			"UF_YOU_HAVE_18" => 1,
			"UF_DO_YOU_SMOKE" => 1,
			"UF_EVENT" => $val["UF_EVENT"],
			"UF_APP_ID" => $val["app_id"],
			"UF_STATUS" => $contact_type[$val["contact_type"]],
			"UF_USER_PARENT" => $USER->GetID(),
			"UF_GROUPS" => array(1)
		);
		$user = new CUser;
		$ID = $user->Add($Fields);		
		
		if(intval($ID) > 0) {	
			$el_log = new CIBlockElement;
			$PROP_log = array();
			$PROP_log["ID"] = $ID;
			$PROP_log["PERSONAL_BIRTHDAY"] = $val["PERSONAL_BIRTHDAY"];
			$PROP_log["PARENT_USER"] = $USER->GetID();
			$PROP_log["UF_IAGREE"] = $status[$val["UF_IAGREE"]];
			$PROP_log["UF_YOU_HAVE_18"] = $status[$val["UF_YOU_HAVE_18"]];
			$PROP_log["UF_DO_YOU_SMOKE"] = $status[$val["UF_DO_YOU_SMOKE"]];
			$PROP_log["TYPE"] = "app_user_add";
			$arLoadProductArray_log = Array(
			  "IBLOCK_ID"      => 26,
			  "PROPERTY_VALUES"=> $PROP_log,
			  "NAME"           => $ID
			);
			$el_log->Add($arLoadProductArray_log);		
			
			$Hash = md5($ID.$USER->GetID().time());		
			if(!empty($val["EMAIL"])) {
				$arEventFields = array( 
					"USER_ID" => $ID,
					"LOGIN" => $Fields["LOGIN"],
					"EMAIL" => $Fields["EMAIL"],
					"NAME" => $Fields["NAME"],
					"LAST_NAME" => $Fields["LAST_NAME"],
					"PASSWORD" => $Fields["PASSWORD"],
					"TOKEN" => $Hash
				); 
				CModule::IncludeModule("main");
				$userFields = $USER->GetByID($USER->GetID())->Fetch();
				if($userFields["PERSONAL_CITY"] == "Екатеринбург") {
					CEvent::Send("NEW_USER", "s1", $arEventFields);
				} else {
					CEvent::Send("NEW_USER_NEW", "s1", $arEventFields);					
				}
			}
			$usersInGroup = CIBlockElement::GetProperty(4, 1, array("sort" => "asc"), Array("CODE"=>"USERS"))->Fetch();
			$usersInGroup["VALUE"]++;
			CIBlockElement::SetPropertyValues(1, 4, $usersInGroup["VALUE"], "USERS");
			$Field["UF_HASH"] = $Hash;
			$Field["UF_TOKEN"] = $Hash;
			$USER->Update($ID,$Field);
			
			$arKpi = CIBlockElement::GetList(Array(), Array("IBLOCK_ID"=>17, "><DATE_ACTIVE_FROM" => array(date($DB->DateFormatToPHP(CLang::GetDateFormat("SHORT")), mktime(0,0,0,date("n"),1,date("Y"))), date($DB->DateFormatToPHP(CLang::GetDateFormat("SHORT")), mktime(0,0,0,date("n")+1,1,date("Y")))), "PROPERTY_USER_ID" => $USER->GetID()), false, false, Array("*"));
			while($obKpi = $arKpi->GetNextElement()) {
				$kpi = $obKpi->GetFields();
			}
			if($kpi["ID"] > 0) {
				$kpiCount = CIBlockElement::GetProperty(17, $kpi["ID"], array("sort" => "asc"), Array("CODE"=>"KPI_".$val["contact_type"]))->Fetch();
				$kpiCount["VALUE"]++;
				CIBlockElement::SetPropertyValues($kpi["ID"], 17, $kpiCount["VALUE"], "KPI_".$val["contact_type"]);
			} else {
				$kpi = array(1 => 103, 2 => 104, 3 => 105, 4 => 106, 5 => 107);
				$el = new CIBlockElement;
				$PROP = array();
				$PROP[101] = $USER->GetID();
				$PROP[$kpi[$val["contact_type"]]] = 1;
				$arLoadProductArray = Array(
				  "IBLOCK_ID"      => 17,
				  "PROPERTY_VALUES"=> $PROP,
				  "NAME"           => $USER->GetLogin(),
				  "DATE_ACTIVE_FROM" => date("d.m.Y H:i:s")
				);
				$el->Add($arLoadProductArray);
			}
			
			$data = array(
			   "UF_USER" => $ID,
			   "UF_AMPLIFIER" => $USER->GetID(),
			   "UF_EVENT" => $val["UF_EVENT"],
			   "UF_DATE_TIME" => date("d.m.Y H:i:s"),
			   "UF_ACTION_CODE" => 101,
			   "UF_ACTION_TEXT" => "add",
			   "UF_TYPE" => $val["contact_type"],
			   "UF_TYPE_2" => $val["contact_type"]
			);
			$hlblock = HL\HighloadBlockTable::getById(4)->fetch(); 
			$entity = HL\HighloadBlockTable::compileEntity($hlblock);
			$entity_data_class = $entity->getDataClass();		 
			$result = $entity_data_class::add($data);
		}
		
		if(intval($ID) > 0)
			$res[] = array(
				"status" => "OK",
				"status_msg" => "NewUserAdd",
				"date_update" => date("Y-m-d H:i:s", time()),
				"app_id" => $val["app_id"] ? $val["app_id"] : 0,
				"ID" => $ID,
				"hash" => $Hash,
				"type" => $val["contact_type"] ? $val["contact_type"] : 0
			);
		else				
			$res[] = array(
				"status" => "ERROR",
				"status_msg" => str_replace('&quot;', '', strip_tags($user->LAST_ERROR)),
				"app_id" => $val["app_id"] ? $val["app_id"] : 0
			);			
	}
	print json_encode($res, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
}

//update_contact
if($_REQUEST["mode"] == "update_contact") {
	if(!$USER->IsAuthorized()) {
		exit();
	}
	$json = json_decode(file_get_contents('php://input'), true);
	if(!isset($json))
		print json_encode(array(
			array(
				"status" => "ERROR",
				"status_msg" => "NO DATA"
			)
		), JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
	if(!is_array($json))
		print json_encode(array(
			array(
				"status" => "ERROR",
				"status_msg" => "Некорректные данные - не массив"
			)
		), JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
	if(empty($json))
		print json_encode(array(
			array(
				"status" => "ERROR",
				"status_msg" => "Некорректные данные - пустой массив"
			)
		), JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);		
	$contact_type = array(
		1 => 28,
		2 => 29,
		3 => 30,
		4 => 31,
		5 => 32
	);
	$contact_type_ret = array(
		28 => 1,
		29 => 2,
		30 => 3,
		31 => 4,
		32 => 5
	);
	$status = array(
		"Y" => 1,
		"N" => 0
	);
	foreach($json as $key => $val) {
		$Fields = array(
			"NAME" => $val["NAME"],
			"LAST_NAME" => $val["LAST_NAME"],
			"PERSONAL_MOBILE" => $val["PERSONAL_MOBILE"],
			"UF_FB_PROFILE" => array($val["UF_FB"]),
			"UF_VK_PROFILE" => array($val["UF_VK"]),
			"UF_GP_PROFILE" => array($val["UF_G_PLUS"]),
			"UF_MARK_1" => $val["UF_MARK_1"],
			"UF_MARK_2" => $val["UF_MARK_2"],
			"ADMIN_NOTES" => $val["ADMIN_NOTES"],
			"INFO" => $val["INFO"],
			"UF_EVENT" => $val["UF_EVENT"],
			"UF_APP_ID" => $val["app_id"],
			"UF_BRAND_ID" => $val["brand_id"],
			"UF_BRAND_NAME" => $val["brand_name"],
			"UF_STATUS" => $contact_type[$val["contact_type"]]
		);
		if($val["EMAIL"]) {
			$Fields["LOGIN"] = $val["EMAIL"];
			$Fields["EMAIL"] = $val["EMAIL"];
		}
		if($val["PERSONAL_BIRTHDAY"]) {
			$Fields["PERSONAL_BIRTHDAY"] = $val["PERSONAL_BIRTHDAY"];
		}
		$userType = $USER->GetByID($val["ID"])->Fetch();
		
		$user = new CUser;
		$ID = $user->Update($val["ID"], $Fields);		
		
		$el_log = new CIBlockElement;
		$PROP_log = array();
		$PROP_log["ID"] = $val["ID"];
		$PROP_log["PERSONAL_BIRTHDAY"] = $val["PERSONAL_BIRTHDAY"];
		$PROP_log["UF_IAGREE"] = $status[$val["UF_IAGREE"]];
		$PROP_log["UF_YOU_HAVE_18"] = $status[$val["UF_YOU_HAVE_18"]];
		$PROP_log["UF_DO_YOU_SMOKE"] = $status[$val["UF_DO_YOU_SMOKE"]];
		$PROP_log["TYPE"] = "app_user_update";
		$arLoadProductArray_log = Array(
		  "IBLOCK_ID"      => 26,
		  "PROPERTY_VALUES"=> $PROP_log,
		  "NAME"           => $val["ID"]
		);
		$el_log->Add($arLoadProductArray_log);
		
		/*$arKpi = CIBlockElement::GetList(Array(), Array("IBLOCK_ID"=>17, "><DATE_ACTIVE_FROM" => array(date($DB->DateFormatToPHP(CLang::GetDateFormat("SHORT")), mktime(0,0,0,date("n"),1,date("Y"))), date($DB->DateFormatToPHP(CLang::GetDateFormat("SHORT")), mktime(0,0,0,date("n")+1,1,date("Y")))), "PROPERTY_USER_ID" => $USER->GetID()), false, false, Array("*"));
		while($obKpi = $arKpi->GetNextElement()) {
			$kpi = $obKpi->GetFields();
		}
		if($kpi["ID"] > 0) {
			$kpiCount = CIBlockElement::GetProperty(17, $kpi["ID"], array("sort" => "asc"), Array("CODE"=>"KPI_".$val["contact_type"]))->Fetch();
			$kpiCount["VALUE"]++;
			CIBlockElement::SetPropertyValues($kpi["ID"], 17, $kpiCount["VALUE"], "KPI_".$val["contact_type"]);
		} else {
			$kpi = array(1 => 103, 2 => 104, 3 => 105, 4 => 106, 5 => 107);
			$el = new CIBlockElement;
			$PROP = array();
			$PROP[101] = $USER->GetID();
			$PROP[$kpi[$val["contact_type"]]] = 1;
			$arLoadProductArray = Array(
			  "IBLOCK_ID"      => 17,
			  "PROPERTY_VALUES"=> $PROP,
			  "NAME"           => $USER->GetLogin(),
			  "DATE_ACTIVE_FROM" => date("Y.m.d H:i")
			);
			$el->Add($arLoadProductArray);
		}*/
		
		$data = array(
           "UF_USER" => $val["ID"],
           "UF_AMPLIFIER" => $USER->GetID(),
		   "UF_EVENT" => $val["UF_EVENT"],
		   "UF_DATE_TIME" => date("d.m.Y H:i:s"),
		   "UF_ACTION_CODE" => 102,
		   "UF_ACTION_TEXT" => "update",
		   "UF_TYPE" => $contact_type_ret[$userType["UF_STATUS"]],
		   "UF_TYPE_2" => $val["contact_type"] ? $val["contact_type"] : $userType["UF_STATUS"]
	    );
		$hlblock = HL\HighloadBlockTable::getById(4)->fetch(); 
		$entity = HL\HighloadBlockTable::compileEntity($hlblock);
		$entity_data_class = $entity->getDataClass();		 
		$result = $entity_data_class::add($data);
		
		if(intval($ID) > 0)
			$res[] = array(
				"status" => "OK",
				"status_msg" => "UserUpdate",
				"date_update" => date("Y-m-d H:i:s", time()),
				"app_id" => $val["app_id"] ? $val["app_id"] : 0,
				"ID" => $val["ID"],
				"type" => $val["contact_type"] ? $val["contact_type"] : 0
			);
		else				
			$res[] = array(
				"status" => "ERROR",
				"status_msg" => strip_tags($user->LAST_ERROR),
				"app_id" => $val["app_id"] ? $val["app_id"] : 0
			);
	}
	print json_encode($res, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
}

//isloggedin
if($_REQUEST["mode"] == "isloggedin") {
	if($USER->IsAuthorized())
		print json_encode(array(
			array(
				"status" => "OK",
				"status_msg" => "Вы авторизованы"
			)
		), JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
	else
		print json_encode(array(
			array(
				"status" => "ERROR",
				"status_msg" => "Вы не авторизованы",
				"status_code" => 102
			)
		), JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
}

//get_kpi
if($_REQUEST["mode"] == "get_kpi") {
	if(!$USER->IsAuthorized()) {
		exit();
	}
	$arKpi = CIBlockElement::GetList(Array(), Array("IBLOCK_ID"=>16, "PROPERTY_TYPE" => 27), false, false, Array("*"));
	while($obKpi = $arKpi->GetNextElement()) {
		$kpi["FIELDS"] = $obKpi->GetFields();
		$kpi["PROPERTIES"] = $obKpi->GetProperties();
		
		$arKpiRes = CIBlockElement::GetList(Array(), Array("IBLOCK_ID"=>17, "><DATE_ACTIVE_FROM" => array(date($DB->DateFormatToPHP(CLang::GetDateFormat("SHORT")), mktime(0,0,0,date("n"),1,date("Y"))), date($DB->DateFormatToPHP(CLang::GetDateFormat("SHORT")), mktime(0,0,0,date("n")+1,1,date("Y")))), "PROPERTY_USER_ID" => $USER->GetID()), false, false, Array("*"));
		while($obKpiRes = $arKpiRes->GetNextElement()) {
			$kpiRes["FIELDS"] = $obKpiRes->GetFields();
			$kpiRes["PROPERTIES"] = $obKpiRes->GetProperties();
		}
	}
	print json_encode(array(
		array(
			"status" => "OK",
			"status_msg" => "KPI",
			"data" => array(
				0 => array(
					"sum" => $kpiRes["PROPERTIES"]["KPI_1"]["VALUE"] ? $kpiRes["PROPERTIES"]["KPI_1"]["VALUE"] : 0,
					"type" => 1,
					"target_kpi" => $kpi["PROPERTIES"]["KPI_1"]["VALUE"] ? $kpi["PROPERTIES"]["KPI_1"]["VALUE"] : 0
				),
				1 => array(
					"sum" => $kpiRes["PROPERTIES"]["KPI_2"]["VALUE"] ? $kpiRes["PROPERTIES"]["KPI_2"]["VALUE"] : 0,
					"type" => 2,
					"target_kpi" => $kpi["PROPERTIES"]["KPI_2"]["VALUE"] ? $kpi["PROPERTIES"]["KPI_2"]["VALUE"] : 0
				),
				2 => array(
					"sum" => $kpiRes["PROPERTIES"]["KPI_3"]["VALUE"] ? $kpiRes["PROPERTIES"]["KPI_3"]["VALUE"] : 0,
					"type" => 3,
					"target_kpi" => $kpi["PROPERTIES"]["KPI_3"]["VALUE"] ? $kpi["PROPERTIES"]["KPI_3"]["VALUE"] : 0
				),
				3 => array(
					"sum" => $kpiRes["PROPERTIES"]["KPI_4"]["VALUE"] ? $kpiRes["PROPERTIES"]["KPI_4"]["VALUE"] : 0,
					"type" => 4,
					"target_kpi" => $kpi["PROPERTIES"]["KPI_4"]["VALUE"] ? $kpi["PROPERTIES"]["KPI_4"]["VALUE"] : 0
				),
				4 => array(
					"sum" => $kpiRes["PROPERTIES"]["KPI_5"]["VALUE"] ? $kpiRes["PROPERTIES"]["KPI_5"]["VALUE"] : 0,
					"type" => 5,
					"target_kpi" => $kpi["PROPERTIES"]["KPI_5"]["VALUE"] ? $kpi["PROPERTIES"]["KPI_5"]["VALUE"] : 0
				)
			)
		)
	), JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
}

//get_contact_list
if($_REQUEST["mode"] == "get_contact_list") {
	if(!$USER->IsAuthorized()) {
		exit();
	}
	$dbUsers = CUser::GetList(($by="ID"), ($order="ASC"), array("UF_USER_PARENT" => $USER->GetID()), array("SELECT"=>array("UF_*")));
	$arUsers = array();
	$contact_type_ret = array(
		28 => 1,
		29 => 2,
		30 => 3,
		31 => 4,
		32 => 5
	);
	while($arUser = $dbUsers->Fetch()) {
		$user = array(
			"invite_status" => $arUser["UF_INVITE_STATUS"] ? $arUser["UF_INVITE_STATUS"] : 0,
			"hash" => $arUser["UF_HASH"] ? $arUser["UF_HASH"] : "",
			"type" => $arUser["UF_STATUS"] ? $contact_type_ret[$arUser["UF_STATUS"]] : 0,
			"brand_id" => $arUser["UF_BRAND_ID"] ? $arUser["UF_BRAND_ID"] : 0,
			"brand_name" => $arUser["UF_BRAND_NAME"] ? $arUser["UF_BRAND_NAME"] : "",
			"ID" => $arUser["ID"],
			"DATE_REGISTER" => $arUser["DATE_REGISTER"],
			"DATE_UPDATE" => $arUser["TIMESTAMP_X"],
			"LAST_LOGIN" => $arUser["LAST_LOGIN"] ? $arUser["LAST_LOGIN"] : "",
			"NAME" => $arUser["NAME"] ? $arUser["NAME"] : "",
			"LAST_NAME" => $arUser["LAST_NAME"] ? $arUser["LAST_NAME"] : "",
			"EMAIL" => strpos($arUser["EMAIL"], "@xyz.xyz") ? "" : $arUser["EMAIL"],
			"PERSONAL_MOBILE" => $arUser["PERSONAL_MOBILE"] ? $arUser["PERSONAL_MOBILE"] : "",
			"PERSONAL_BIRTHDAY" => $arUser["PERSONAL_BIRTHDAY"] ? $arUser["PERSONAL_BIRTHDAY"] : "",
			"UF_FB" => $arUser["UF_FB_PROFILE"][0] ? $arUser["UF_FB_PROFILE"][0] : "",
			"UF_VK" => $arUser["UF_VK_PROFILE"][0] ? $arUser["UF_VK_PROFILE"][0] : "",
			"UF_G_PLUS" => $arUser["UF_GP_PROFILE"][0] ? $arUser["UF_GP_PROFILE"][0] : "",
			"UF_MARK_1" => $arUser["UF_MARK_1"] ? $arUser["UF_MARK_1"] : "",
			"UF_MARK_2" => $arUser["UF_MARK_2"] ? $arUser["UF_MARK_2"] : "",
			"UF_DO_YOU_SMOKE" => $arUser["UF_DO_YOU_SMOKE"] ? "Y" : "N",
			"UF_YOU_HAVE_18" => $arUser["UF_YOU_HAVE_18"] ? "Y" : "N",
			"ADMIN_NOTES" => $arUser["ADMIN_NOTES"] ? $arUser["ADMIN_NOTES"] : "",
			"PERSONAL_PHOTO_SMALL" => array(),
			"PERSONAL_PHOTO_BIG" => array()
		);
		if($arUser["PERSONAL_PHOTO"]) {
			$user["PERSONAL_PHOTO_SMALL"] = CFile::ResizeImageGet($arUser["PERSONAL_PHOTO"], array('width'=>192, 'height'=>192), BX_RESIZE_IMAGE_EXACT, true);
			$user["PERSONAL_PHOTO_BIG"] = CFile::ResizeImageGet($arUser["PERSONAL_PHOTO"], array('width'=>800, 'height'=>800), BX_RESIZE_IMAGE_EXACT, true);
		}
		$arUsers[] = $user;
	}	
	print json_encode(array(
		array(
			"status" => "OK",
			"status_msg" => "ContactList",
			"contact_list" => $arUsers
		)
	), JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
}

//get_event_list
if($_REQUEST["mode"] == "get_event_list") {	
	if(!$USER->IsAuthorized()) {
		exit();
	}
	$arEvents = CIBlockElement::GetList(Array(), Array("IBLOCK_ID"=>2), false, false, Array("*"));
	$events = array();
	while($obEvents = $arEvents->GetNextElement()) {
		$event["FIELDS"] = $obEvents->GetFields();
		$event["PROPERTIES"] = $obEvents->GetProperties();
		
		$arKpi = CIBlockElement::GetList(Array(), Array("IBLOCK_ID"=>16, "PROPERTY_EVENT_ID" => $event["FIELDS"]["ID"]), false, false, Array("*"));
		while($obKpi = $arKpi->GetNextElement()) {
			$kpi["FIELDS"] = $obKpi->GetFields();
			$kpi["PROPERTIES"] = $obKpi->GetProperties();
			
			$arKpiRes = CIBlockElement::GetList(Array(), Array("IBLOCK_ID"=>17, "PROPERTY_EVENT_ID" => $event["FIELDS"]["ID"], "PROPERTY_USER_ID" => $USER->GetID()), false, false, Array("*"));
			while($obKpiRes = $arKpiRes->GetNextElement()) {
				$kpiRes["FIELDS"] = $obKpiRes->GetFields();
				$kpiRes["PROPERTIES"] = $obKpiRes->GetProperties();
			}
		}
		$events[] = array(
			"ID" => $event["FIELDS"]["ID"],
			"NAME" => $event["FIELDS"]["NAME"],
			"DATE_EVENT" => $event["PROPERTIES"]["START_DATE"]["VALUE"] ? $event["PROPERTIES"]["START_DATE"]["VALUE"] : "",
			"DATE_EVENT_END" => $event["PROPERTIES"]["END_DATE"]["VALUE"] ? $event["PROPERTIES"]["END_DATE"]["VALUE"] : "",
			"OG_DESCRIPTION" => $event["FIELDS"]["PREVIEW_TEXT"] ? strip_tags($event["FIELDS"]["PREVIEW_TEXT"]) : "",
			"USERS" => $event["PROPERTIES"]["USERS"]["VALUE"] ? $event["PROPERTIES"]["USERS"]["VALUE"] : array(),
			"PLACE_EVENT" => $event["PROPERTIES"]["PLACE_EVENT"]["VALUE"] ? $event["PROPERTIES"]["PLACE_EVENT"]["VALUE"] : "",
			"CLUB_NAME" => $event["PROPERTIES"]["CLUB_NAME"]["VALUE"] ? $event["PROPERTIES"]["CLUB_NAME"]["VALUE"] : "",
			"kpi" => array(
				0 => array(
					"type" => 1,
					"target_kpi" => $kpi["PROPERTIES"]["KPI_1"]["VALUE"] ? $kpi["PROPERTIES"]["KPI_1"]["VALUE"] : 0,
					"sum" => $kpiRes["PROPERTIES"]["KPI_1"]["VALUE"] ? $kpiRes["PROPERTIES"]["KPI_1"]["VALUE"] : 0
				),
				1 => array(
					"type" => 2,
					"target_kpi" => $kpi["PROPERTIES"]["KPI_2"]["VALUE"] ? $kpi["PROPERTIES"]["KPI_2"]["VALUE"] : 0,
					"sum" => $kpiRes["PROPERTIES"]["KPI_2"]["VALUE"] ? $kpiRes["PROPERTIES"]["KPI_2"]["VALUE"] : 0
				),
				2 => array(
					"type" => 3,
					"target_kpi" => $kpi["PROPERTIES"]["KPI_3"]["VALUE"] ? $kpi["PROPERTIES"]["KPI_3"]["VALUE"] : 0,
					"sum" => $kpiRes["PROPERTIES"]["KPI_3"]["VALUE"] ? $kpiRes["PROPERTIES"]["KPI_3"]["VALUE"] : 0
				),
				3 => array(
					"type" => 4,
					"target_kpi" => $kpi["PROPERTIES"]["KPI_4"]["VALUE"] ? $kpi["PROPERTIES"]["KPI_4"]["VALUE"] : 0,
					"sum" => $kpiRes["PROPERTIES"]["KPI_4"]["VALUE"] ? $kpiRes["PROPERTIES"]["KPI_4"]["VALUE"] : 0
				),
				4 => array(
					"type" => 5,
					"target_kpi" => $kpi["PROPERTIES"]["KPI_5"]["VALUE"] ? $kpi["PROPERTIES"]["KPI_5"]["VALUE"] : 0,
					"sum" => $kpiRes["PROPERTIES"]["KPI_5"]["VALUE"] ? $kpiRes["PROPERTIES"]["KPI_5"]["VALUE"] : 0
				)
			)
		);
	}
	print json_encode(array(
		array(
			"event_list" => $events,
			"status" => "OK",
			"status_msg" => "EventList"
		)
	), JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
}

//get_brand_list
if($_REQUEST["mode"] == "get_brand_list") {	
	if(!$USER->IsAuthorized()) {
		exit();
	}
	$res = CIBlockElement::GetList(Array(), Array("IBLOCK_ID"=>24), false, false, Array("*"));
	$brands = array();
	while($ob = $res->GetNextElement()) {
		$arResult["FIELDS"] = $ob->GetFields();
		
		$brands[] = array(
			"brand_id"	=> $arResult["FIELDS"]["ID"],
			"brand_name"	=> $arResult["FIELDS"]["NAME"]
		);
	}
	print json_encode(array(
		array(
			"brand_list" => $brands,
			"status" => "OK",
			"status_msg" => "BrandList"
		)
	), JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
}

//put_photo
if($_REQUEST["mode"] == "put_photo") {
	if(!$USER->IsAuthorized()) {
		exit();
	}
	$full_path = $_SERVER['DOCUMENT_ROOT'].'/upload/tmp_selfie/'.$_REQUEST['UF_USER'].'.jpg';
	$input = fopen("php://input", "r");
	$target = fopen($full_path, "w");
	stream_copy_to_stream($input, $target);
	fclose($input);
	fclose($target);
	CModule::IncludeModule("main");
	$arFile = CFile::MakeFileArray($full_path);
	$arFile['MODULE_ID'] = 'main';
	$fid = CFile::SaveFile($arFile, "selfie");
	$Fields = array(
		"PERSONAL_PHOTO" => CFile::MakeFileArray($fid),
		"UF_STATUS" => 32,
		"UF_EVENT" => $_REQUEST['UF_EVENT']
	);
	$userType = $USER->GetByID($_REQUEST['UF_USER'])->Fetch();
	$user = new CUser;
	$res = $user->Update($_REQUEST['UF_USER'], $Fields);					
	$contact_type_ret = array(
		28 => 1,
		29 => 2,
		30 => 3,
		31 => 4,
		32 => 5
	);
	$data = array(
		"UF_USER" => $_REQUEST['UF_USER'],
		"UF_AMPLIFIER" => $USER->GetID(),
		"UF_EVENT" => $_REQUEST['UF_EVENT'] ? $_REQUEST['UF_EVENT'] : 0,
		"UF_DATE_TIME" => date("d.m.Y H:i:s"),
		"UF_ACTION_CODE" => 103,
		"UF_ACTION_TEXT" => "change_status",
		"UF_TYPE" => $contact_type_ret[$userType["UF_STATUS"]],
		"UF_TYPE_2" => 5
	);
	
	$arKpi = CIBlockElement::GetList(Array(), Array("IBLOCK_ID"=>17, "><DATE_ACTIVE_FROM" => array(date($DB->DateFormatToPHP(CLang::GetDateFormat("SHORT")), mktime(0,0,0,date("n"),1,date("Y"))), date($DB->DateFormatToPHP(CLang::GetDateFormat("SHORT")), mktime(0,0,0,date("n")+1,1,date("Y")))), "PROPERTY_USER_ID" => $USER->GetID()), false, false, Array("*"));
	while($obKpi = $arKpi->GetNextElement()) {
		$kpi = $obKpi->GetFields();
	}
	if($kpi["ID"] > 0) {
		$kpiCount = CIBlockElement::GetProperty(17, $kpi["ID"], array("sort" => "asc"), Array("CODE"=>"KPI_5"))->Fetch();
		$kpiCount["VALUE"]++;
		CIBlockElement::SetPropertyValues($kpi["ID"], 17, $kpiCount["VALUE"], "KPI_5");
	} else {
		$kpi = array(1 => 103, 2 => 104, 3 => 105, 4 => 106, 5 => 107);
		$el = new CIBlockElement;
		$PROP = array();
		$PROP[101] = $USER->GetID();
		$PROP[$kpi[5]] = 1;
		$arLoadProductArray = Array(
		  "IBLOCK_ID"      => 17,
		  "PROPERTY_VALUES"=> $PROP,
		  "NAME"           => $USER->GetLogin(),
		  "DATE_ACTIVE_FROM" => date("Y.m.d H:i")
		);
		$el->Add($arLoadProductArray);
	}
			
	$hlblock = HL\HighloadBlockTable::getById(4)->fetch(); 
	$entity = HL\HighloadBlockTable::compileEntity($hlblock);
	$entity_data_class = $entity->getDataClass();		 
	$result = $entity_data_class::add($data);
	$data = array(
		'UF_AMPLIFIER' => $USER->GetID(),
		'UF_USER' => $_REQUEST['UF_USER'],
		'UF_EVENT' => $_REQUEST['UF_EVENT'] ? $_REQUEST['UF_EVENT'] : 0,
		'UF_IMAGE' => $fid
	);
	$hlblock = HL\HighloadBlockTable::getById(3)->fetch(); 
	$entity = HL\HighloadBlockTable::compileEntity($hlblock);
	$entity_data_class = $entity->getDataClass();		 
	$result = $entity_data_class::add($data);
	
	if($res)
		print json_encode(array(
			array(
				"status" => "OK",
				"status_msg" => "put_photo_ok"
			)
		), JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
	else
		print json_encode(array(
			array(
				"status" => "ERROR",
				"status_msg" => "put_photo_error"
			)
		), JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
}

require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/epilog_after.php");
?>