<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");

//global $USER;

/*$arResult = $USER->ChangePassword("admin", "admin12345", "admin12345", "admin12345");
if($arResult["TYPE"] == "OK") echo "Пароль успешно сменен.";
else ShowMessage($arResult);*/

/*$USER->Authorize(107);*/
updateGroupCounters();

// подключение эпилога
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");