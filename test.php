<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");
$cUser = new CUser; 
print_r($cUser->GetByLogin("run182")->Fetch());
?>