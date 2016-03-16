<?
	require($_SERVER['DOCUMENT_ROOT'] . '/bitrix/php_interface/init.php');
	require($_SERVER['DOCUMENT_ROOT'] . '/includes/helpers.php');
	define('IB_LIKE', 1);
	use Bitrix\Highloadblock as HL;
	use Bitrix\Main\Entity;

	AddEventHandler("main", "OnBeforeUserRegister", "OnBeforeUserRegisterHandler");
	AddEventHandler("main", "OnBeforeUserUpdate", "OnBeforeUserUpdateHandler");
	AddEventHandler("main", "OnAfterUserRegister", "OnAfterUserRegisterHandler");
	//AddEventHandler("main", "OnBeforeUserAdd", "OnBeforeUserAddHandler");

	function OnBeforeUserAddHandler(&$arFields) {
		$bdate = $arFields["PERSONAL_BIRTHDAY"];
		if (!isset($bdate) || strtotime($bdate) > strtotime('-18 years') || strlen($bdate) == 0 || strtotime($bdate) < strtotime('-65 years')) {
			global $APPLICATION;
            $APPLICATION->throwException("Ваш возраст должен быть больше 18 лет.");
            return false;
		}
	}

	function OnBeforeUserUpdateHandler(&$arFields) {
		if (isset($arFields['UF_GROUPS']) && in_array(1, $arFields['UF_GROUPS'])) {
			$user = CUser::GetByID($arFields['ID'])->Fetch();

			if (!in_array(1, $user['UF_GROUPS'])) {
				CModule::IncludeModule("iblock");
				$rsUsers = CUser::GetList(($by="id"), ($order="desc"), array('UF_GROUPS' => 1), array('NAV_PARAMS' => array("nTopCount" => 0)));
				CIBlockElement::SetPropertyValues(1, 4, $rsUsers->NavRecordCount, "USERS");
				$groups = CUser::GetUserGroup($user['UF_USER_PARENT']);
				$fields = array_flip(getValuesList('UF_STATUS', 'USER', 'ID'));

				if (intval($user['UF_USER_PARENT']) > 0
					&& $fields[$user['UF_STATUS']] == 4) {

					if (in_array(8, $groups)) changeUserStatus($user['ID'], $user['UF_USER_PARENT'], $user['UF_STATUS'], 6, "Регистрация в KENT Lab");

				}

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



AddEventHandler("main", "OnAfterUserAuthorize", "UserLoginHandler");
AddEventHandler("main", "OnAfterUserLogin", "UserLoginHandler");

function UserLoginHandler(&$arFields) {
	CModule::IncludeModule("iblock");
	CModule::IncludeModule("highloadblock");
	global $APPLICATION;

	$user = CUser::GetByID($arFields['USER_ID'])->Fetch();

	if (intval($user['UF_USER_PARENT']) > 0
		&& $APPLICATION->get_cookie("MQ_REGISTRATION_TOKEN")
		&& $user['UF_INVITE_STATUS'] != 1) {
		$fields = array_flip(getValuesList('UF_STATUS', 'USER', 'ID'));
		if ($fields[$user['UF_STATUS']] != 4) {
			changeUserStatus($user['ID'], $user['UF_USER_PARENT'], $user['UF_STATUS'], 4, "Приглашение принято");
		}


	}
}

?>
