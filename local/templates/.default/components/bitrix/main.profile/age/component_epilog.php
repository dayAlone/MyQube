<?
	$user = $arResult['arUser'];
	if (
		isset($_REQUEST['save'])
		&& strlen($user["PERSONAL_BIRTHDAY"]) > 0
		&& strlen($arResult["strProfileError"]) == 0
	) {
		if(strripos($_GET["backurl"], "?message=")) {
			$backurl = substr($_GET["backurl"], 0, strripos($_GET["backurl"], "?message="));
		}
		LocalRedirect("/group/1/".(strlen($backurl) > 0 ? "?backurl=" . $backurl : ''));
	}
?>
