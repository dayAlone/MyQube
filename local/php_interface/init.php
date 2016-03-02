<?
	require($_SERVER['DOCUMENT_ROOT'] . '/bitrix/php_interface/init.php');
	function page_class()
	{
		global $APPLICATION;
		if($APPLICATION->GetPageProperty('page_class')) {
			return $APPLICATION->GetPageProperty('page_class');
		}
	}
	function svg($value='')
	{
		$path = $_SERVER["DOCUMENT_ROOT"]."/layout/images/svg/".$value.".svg";
		return file_get_contents($path);
	}
	function pluralize($num, $arEnds) {

		if (strlen($num)>1 && substr($num, strlen($num)-2, 1)=="1")
		{
			return $arEnds[0];
		}
		else
		{
			$c = IntVal(substr($num, strlen($num)-1, 1));
			if ($c==0 || ($c>=5 && $c<=9))
				return $arEnds[1];
			elseif ($c==1)
				return $arEnds[2];
			else
				return $arEnds[3];
		}
	}

	AddEventHandler("main", "OnBeforeUserRegister", "OnBeforeUserRegisterHandler");
	AddEventHandler("main", "OnBeforeUserUpdate", "OnBeforeUserUpdateHandler");
	AddEventHandler("main", "OnAfterUserRegister", "OnAfterUserRegisterHandler");

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


?>
