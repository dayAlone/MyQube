<?
	require($_SERVER['DOCUMENT_ROOT'] . '/bitrix/php_interface/init.php');
	require($_SERVER['DOCUMENT_ROOT'] . '/includes/helpers.php');
	define('IB_LIKE', 1);
	use Bitrix\Highloadblock as HL;
	use Bitrix\Main\Entity;


	AddEventHandler("main", "OnBeforeUserRegister", "OnBeforeUserRegisterHandler");
	AddEventHandler("main", "OnBeforeUserUpdate", "OnBeforeUserUpdateHandler");
	AddEventHandler("main", "OnAfterUserRegister", "OnAfterUserRegisterHandler");
	AddEventHandler("main", "OnAfterUserLogin", "OnAfterUserLoginHandler");

	function OnBeforeUserUpdateHandler(&$arFields) {
		if (isset($arFields['UF_GROUPS']) && in_array(1, $arFields['UF_GROUPS'])) {
			$user = CUser::GetByID($arFields['ID'])->Fetch();

			if (!in_array(1, $user['UF_GROUPS'])) {
				CModule::IncludeModule("iblock");
				$rsUsers = CUser::GetList(($by="id"), ($order="desc"), array('UF_GROUPS' => 1), array('NAV_PARAMS' => array("nTopCount" => 0)));
				CIBlockElement::SetPropertyValues(1, 4, $rsUsers->NavRecordCount, "USERS");
			}
		}
	}
	function OnBeforeUserRegisterHandler(&$arFields) {
		if (strlen($arFields['PHOTO']) > 0) {
			$arFields['PERSONAL_PHOTO'] = CFile::MakeFileArray($arFields['PHOTO']);
		}
	}
	function OnAfterUserRegisterHandler($arFields) {
		global $APPLICATION;
		if($arFields["USER_ID"] > 0) {
			$token = sha1($arFields["USER_ID"]."".date("d.m.Y H:i:s"));
			$APPLICATION->set_cookie("MQ_AUTH_TOKEN", $token, time() + 60 * 60 * 24 * 30 * 12 * 4,"/");

			$user = new CUser;
			$user->Update($arFields["USER_ID"], array('UF_AUTH_TOKEN' => $token, 'UF_TOKEN' => $token));

		}
	}
	function OnAfterUserLoginHandler(&$arFields) {
		CModule::IncludeModule("iblock");
		CModule::IncludeModule("highloadblock");
		global $APPLICATION;

		$user = CUser::GetByID($arFields['USER_ID'])->Fetch();
		$fields = getValuesList('UF_STATUS', 'USER', 'ID');
		$flipFields = array_flip($fields);

		if (intval($user['UF_USER_PARENT']) > 0
			&& $APPLICATION->get_cookie("MQ_REGISTRATION_TOKEN")
			&& $user['UF_INVITE_STATUS'] != 1) { // && $user['UF_STATUS'] === $fields[4]['ID'] &&

			$groups = CUser::GetUserGroup($user['UF_USER_PARENT']);
			$types = array(getValuesList('UF_TYPE', 'HLBLOCK_2', 'ID'), getValuesList('UF_TYPE_2', 'HLBLOCK_2', 'ID'));

			$newStatus = in_array(8, $groups) ? 6 : 4;

			$raw = new CUser;
			$raw->Update($arFields["USER_ID"], array('UF_INVITE_STATUS' => 1, 'UF_STATUS' => $fields[$newStatus]));

			$arGroups = CUser::GetUserGroup($user["ID"]);
			$arGroups[] = 5;
			CUser::SetUserGroup($user["ID"], $arGroups);

			$hbKPI     = HL\HighloadBlockTable::getById(2)->fetch();
			$entityKPI = HL\HighloadBlockTable::compileEntity($hbKPI);
			$logKPI    = $entityKPI->getDataClass();

			$logKPI::add(
			        array(
			            'UF_USER'        => intval($user["ID"]),
			            'UF_AMPLIFIER'   => intval($user['UF_USER_PARENT']),
			            'UF_EVENT'       => 0,
			            'UF_DATE_TIME'   => date("Y-m-d H:i:s"),
			            'UF_ACTION_CODE' => 103,
			            'UF_ACTION_TEXT' => "change_status",
			            'UF_TYPE'        => $user['UF_STATUS'] ? $types[0][$flipFields[$user['UF_STATUS']]] : 1,
			            'UF_TYPE_2'      => $types[1][$newStatus]
			        )
			    );

			$hbLOG = HL\HighloadBlockTable::getById(4)->fetch();
			$entityLOG = HL\HighloadBlockTable::compileEntity($hbLOG);
			$logLOG = $entityLOG->getDataClass();
			$res = $logLOG::add(
				array(
					'UF_USER'        => intval($user["ID"]),
		            'UF_AMPLIFIER'   => intval($user['UF_USER_PARENT']),
		            'UF_EVENT'       => 0,
		            'UF_DATE_TIME'   => date("d.m.Y H:i:s", time()),
					"UF_ACTION_CODE" => 104,
					"UF_ACTION_TEXT" => "Приглашение принято",
					"UF_TYPE"        => $user['UF_STATUS'] ? $flipFields[$user['UF_STATUS']] : 1,
					"UF_TYPE_2"      => $newStatus
				)
			);
		}
	}
?>
