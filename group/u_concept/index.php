<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$page_name="u_concept";
if(!$USER->IsAuthorized()) {
	include("teaser.php");
} else {
	/*if(time() < 1446336000 && $USER->GetID() != 2 && $USER->GetID() != 3 && $USER->GetID() != 5399 && $USER->GetID() != 43937) {
		include("teaser_1.php");
	} else {*/
		include("dop.php");
	//}
}
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");
?>