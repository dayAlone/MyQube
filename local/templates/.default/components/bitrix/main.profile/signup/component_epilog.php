<?
	$user = $arResult['arUser'];
	if (
		isset($_REQUEST['save'])
		&& strlen($arResult["strProfileError"]) == 0
		&& strlen($user["PERSONAL_BIRTHDAY"]) > 0
		&& strlen($user["UF_BRAND_2"]) > 0
		&& strlen($user["UF_BRAND_1"]) > 0
		&& intval($user["UF_DO_YOU_SMOKE"]) === 1
		&& intval($user["UF_IAGREE"]) === 1
	) {
		if(strripos($_GET["backurl"], "?message="))
			$backurl = substr($_GET["backurl"], 0, strripos($_GET["backurl"], "?message="));
		LocalRedirect("/group/1/".(strlen($backurl) > 0 ? "?backurl=" . $backurl : ''));
	}
?>
