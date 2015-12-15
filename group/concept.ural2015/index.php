<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("projectekb");
if($USER->IsAuthorized()) {
	LocalRedirect("/group/1/u_concept/");
} else {
	$APPLICATION->set_cookie("MQ_AMBASSADOR", 1, time()+60*60*24*3,"/");
	LocalRedirect("/group/1/u_concept/");
}
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>