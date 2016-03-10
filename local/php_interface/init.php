<?
	require($_SERVER['DOCUMENT_ROOT'] . '/bitrix/php_interface/init.php');
	require($_SERVER['DOCUMENT_ROOT'] . '/includes/helpers.php');

	define('IB_LIKE', 1);



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
		$user = CUser::GetByID($arFields['USER_ID'])->Fetch();
		$fields = getValuesList('UF_STATUS', 'USER');
		if (intval($user['UF_USER_PARENT']) > 0 && $user['UF_STATUS'] === $fields[4]['ID'] && $APPLICATION->get_cookie("MQ_REGISTRATION_TOKEN")) {

			$types = array(getValuesList('UF_TYPE', 'HLBLOCK_2'), getValuesList('UF_TYPE_2', 'HLBLOCK_2'));

			$user = new CUser;
			$user->Update($arFields["USER_ID"], array('UF_STATUS' => $fields[6]['ID']));

			$hbKPI     = HL\HighloadBlockTable::getById(HLBLOCK_KPIAMPLIFIER)->fetch();
			$entityKPI = HL\HighloadBlockTable::compileEntity($hbKPI);
			$logKPI    = $entityKPI->getDataClass();
			$logKPI::add(
		        array(
		            'UF_USER'        => IntVal($user["ID"]),
		            'UF_AMPLIFIER'   => $user['UF_USER_PARENT'],
		            'UF_EVENT'       => 0,
		            'UF_DATE_TIME'   => date("Y-m-d H:i:s"),
		            'UF_ACTION_CODE' => 103,
		            'UF_ACTION_TEXT' => "change_status",
		            'UF_TYPE'        => $types[0][4],
		            'UF_TYPE_2'      => $types[1][6]
		        )
		    );
		}
	}
?>
