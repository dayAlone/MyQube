<? 

require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");
	$Result = array();
	$DateFrom = date("d.m.Y H:i:s",strtotime("13.07.2015 16:40:05"));
	$DateTo = date("d.m.Y H:i:s",strtotime("13.07.2015 16:40:05"));

Application::getConnection()->startTracker();

	if($GLOBALS["USER"]->IsAuthorized()){
		$ListConsultant = array();
		$Query = CUser::GetList(
			($by="id"),
			($order="desc"),
			(in_array(12,$Data["User"]["Group"]))? array(
				"GROUPS_ID" => array(9),
				"UF_ID_SUPERVISOR" => $USER->GetID()
			):
			array(
				"GROUPS_ID" => array(9)
			)			
		);
		while($Answer = $Query->Fetch()){
			$ListConsultant[] = $Answer["ID"];
			$Result[] = array(
				"Id" => $Answer["ID"],
				"Count" => 0
			);
		}

		$Query = CUser::GetList(
			($by="id"),
			($order="desc"),
			array(
				"UF_USER_PARENT" => $ListConsultant,
				"DATE_REGISTER_1" => $DateFrom,
   				"DATE_REGISTER_2" => $DateTo,
			),
			array(
				"SELECT" => array("UF_*")
			)
		);

echo '<pre>', $Query->getTrackerQuery()->getSql(), '</pre>';

	//	die("???");
		while($Answer = $Query->Fetch()){
			foreach($Result as $key => $value){
				if($value["Id"] == $Answer["UF_USER_PARENT"]){
					$Result[$key]["Count"] += 1;
					break;
				}
			}
		}
		
	}

	echo json_encode($Result);
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/epilog_after.php");
?>