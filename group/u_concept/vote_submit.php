<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");
CModule::IncludeModule("iblock");
$iblock_id = 1;
$user_id = $USER->GetID();
if(!empty($_POST["project_vote"])) {
	$res = CIBlockElement::GetList(array(), array("IBLOCK_ID" => 22, "PROPERTY_USER" => $user_id));
	while($ob = $res->GetNextElement()) {
		$Fields = $ob->GetFields();
	}
	if(empty($Fields["ID"])) {
		$arFields = array(
			"IBLOCK_ID" => 22,
			"NAME" => "Голос",
			"PROPERTY_VALUES" => array(
				"VOTE" => $_POST["project_vote"],
				"USER" => $user_id
			)
		);
		$oElement = new CIBlockElement();
		$idElement = $oElement->Add($arFields, false, false, true);
		$countVotes = CIBlockElement::GetProperty($iblock_id, $_POST["project_vote"], array("sort" => "asc"), Array("CODE"=>"VOTES"))->Fetch();
		$userFields = $USER->GetByID($user_id)->Fetch();
		if($userFields["UF_AMBASSADOR"]) {
			$countVotes["VALUE"] = $countVotes["VALUE"]+100;
		} else {
			$countVotes["VALUE"]++;
		}
		CIBlockElement::SetPropertyValues($_POST["project_vote"], $iblock_id, $countVotes["VALUE"], "VOTES");
		$data = array('success' => 1, 'id' => $_POST["project_vote"], 'vote' => $countVotes["VALUE"]);
	}
} else {
	$data = array('success' => 0);
}
echo json_encode($data);
?>