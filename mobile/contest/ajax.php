<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");?>
<?
CJSCore::Init(array('ajax', 'viewer', 'tooltip', 'popup'));
CModule::IncludeModule("main");
CModule::IncludeModule("iblock");
if($_GET["go"]) {
	$id = $_GET["go"];
	$UID = $USER->GetID();

	$ib_id = 3;
	$EL = new CIBlockElement();
	$resObj = CIBlockElement::GetByID($id);
	$item = $resObj->GetNextElement(true, false);

	$propItems = $item->GetProperty("ANC_ID");
	$prop = $propItems["VALUE"];
	$count = count($prop);
	$prop[] = $UID;
	$prop = array_unique($prop);
	$ok = CIBlockElement::SetPropertyValues($id, $ib_id, $prop, "ANC_ID");
	echo '<div class="accept-event"></div>
		<div class="accept-text">
			Вы уже участвуете в конкурсе
		</div>
		<div class="unaccept-event unaccept_event">
			Отменить участие
		</div>';
}
if($_GET["leave"]) {
	$id = $_GET["leave"];
	$UID = $USER->GetID();

	$ib_id = 3;
	$EL = new CIBlockElement();
	$resObj = CIBlockElement::GetByID($id);
	$item = $resObj->GetNextElement(true, false);

	$propItems = $item->GetProperty("ANC_ID");
	$prop = $propItems["VALUE"];
	unset($prop[array_search($UID, $prop)]);
	$count = count($prop);
	$ok = CIBlockElement::SetPropertyValues($id, $ib_id, $prop, "ANC_ID");
	echo '<div class="accept accept_event"><button>Принять участие</button></div>';
}
/*
$user = new CUser;
$rsUser = $user::GetByID($UID);
$arUser = $rsUser->Fetch();
$fields = Array( 
	"UF_CONTEST" => array_merge($arUser["UF_CONTEST"], array($_GET["go"])), 
); 
$user->Update($UID, $fields);
*/
?>