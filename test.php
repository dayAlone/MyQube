<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");
$fetch = $USER->GetByLogin("run182")->Fetch();
if(empty($fetch)) {
	echo "y";
} else {
	echo "n";
}
?>