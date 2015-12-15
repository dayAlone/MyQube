<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");

if($_GET["del_sub"] == 1) {
	$Me = CUser::GetByID($USER->GetID())->Fetch();
	$Her = CUser::GetByID($_GET["userID"])->Fetch();
	$posHerInMyUSub = array_search($Her["ID"], $Me["UF_USER_SUB"]);
	if($posHerInMyUSub !== false)
		unset($Me["UF_USER_SUB"][$posHerInMyUSub]);	
	$posMeInHerUSubIn = array_search($Me["ID"], $Her["UF_USER_SUB_IN"]);
	if($posMeInHerUSubIn !== false)
		unset($Her["UF_USER_SUB_IN"][$posMeInHerUSubIn]);
	CustomUser::AnotherUserUpdate($Me["ID"], array("UF_USER_SUB" => $Me["UF_USER_SUB"]));
	CustomUser::AnotherUserUpdate($Her["ID"], array("UF_USER_SUB_IN" => $Her["UF_USER_SUB_IN"]));
} else {
	$Me = CUser::GetByID($USER->GetID())->Fetch();
	$Her = CUser::GetByID($_GET["userID"])->Fetch();
	if(!is_array($Her["UF_FRIENDS"])) $Her["UF_FRIENDS"] = array();
	if(!is_array($Her["UF_FRIENDS_SUB"])) $Her["UF_FRIENDS_SUB"] = array();
	if(!is_array($Her["UF_FRIENDS_SUB_IN"])) $Her["UF_FRIENDS_SUB_IN"] = array();
	if(!is_array($Her["UF_USER_SUB"])) $Her["UF_USER_SUB"] = array();
	if(!is_array($Her["UF_USER_SUB_IN"])) $Her["UF_USER_SUB_IN"] = array();
	if(!is_array($Me["UF_FRIENDS"])) $Me["UF_FRIENDS"] = array();
	if(!is_array($Me["UF_FRIENDS_SUB"])) $Me["UF_FRIENDS_SUB"] = array();
	if(!is_array($Me["UF_FRIENDS_SUB_IN"])) $Me["UF_FRIENDS_SUB_IN"] = array();
	if(!is_array($Me["UF_USER_SUB"])) $Me["UF_USER_SUB"] = array();
	if(!is_array($Me["UF_USER_SUB_IN"])) $Me["UF_USER_SUB_IN"] = array();
	$posHerInMyFriends = array_search($Her["ID"], $Me["UF_FRIENDS"]);

	if($posHerInMyFriends !== false) { // Если друзья
		$posHerInMyUSub = array_search($Her["ID"], $Me["UF_USER_SUB"]);
		if($posHerInMyUSub !== false)
			unset($Me["UF_USER_SUB"][$posHerInMyUSub]);	
		$posMeInHerUSubIn = array_search($Me["ID"], $Her["UF_USER_SUB_IN"]);
		if($posMeInHerUSubIn !== false)
			unset($Her["UF_USER_SUB_IN"][$posMeInHerUSubIn]);
		if($posHerInMyFriends !== false)
			unset($Me["UF_FRIENDS"][$posHerInMyFriends]);
		$posMeInHerFriends = array_search($Me["ID"], $Her["UF_FRIENDS"]);
		if($posMeInHerFriends !== false)
			unset($Her["UF_FRIENDS"][$posMeInHerFriends]);
		CustomUser::AnotherUserUpdate($Me["ID"], array("UF_FRIENDS" => $Me["UF_FRIENDS"], "UF_USER_SUB" => $Me["UF_USER_SUB"]));
		CustomUser::AnotherUserUpdate($Her["ID"], array("UF_FRIENDS" => $Her["UF_FRIENDS"], "UF_USER_SUB_IN" => $Her["UF_USER_SUB_IN"]));
		echo "add";
	} else { // Если не друзья
		$posHerInMySubIn = array_search($Her["ID"], $Me["UF_FRIENDS_SUB_IN"]);
		$posHerInMySub = array_search($Her["ID"], $Me["UF_FRIENDS_SUB"]);
		if($posHerInMySubIn !== false) { // если существует входящий запрос
			$posMeInHerSub = array_search($Me["ID"], $Her["UF_FRIENDS_SUB"]);
			if($_GET["subin"] !== "delete") { // принять входящий запрос
				array_push($Me["UF_FRIENDS"], $Her["ID"]);
				array_push($Her["UF_FRIENDS"], $Me["ID"]);
				$posHerInMyUSub = array_search($Her["ID"], $Me["UF_USER_SUB"]);
				if($posHerInMyUSub === false)
					array_push($Me["UF_USER_SUB"], $Her["ID"]);
				$posHerInMyUSubIn = array_search($Me["ID"], $Her["UF_USER_SUB_IN"]);
				if($posHerInMyUSubIn === false)
					array_push($Her["UF_USER_SUB_IN"], $Me["ID"]);
				if($posHerInMySubIn !== false)
					unset($Me["UF_FRIENDS_SUB_IN"][$posHerInMySubIn]);			
				if($posMeInHerSub !== false)
					unset($Her["UF_FRIENDS_SUB"][$posMeInHerSub]);
				CustomUser::AnotherUserUpdate($Me["ID"], array("UF_FRIENDS" => $Me["UF_FRIENDS"], "UF_FRIENDS_SUB_IN" => $Me["UF_FRIENDS_SUB_IN"], "UF_USER_SUB" => $Me["UF_USER_SUB"]));
				CustomUser::AnotherUserUpdate($Her["ID"], array("UF_FRIENDS" => $Her["UF_FRIENDS"], "UF_FRIENDS_SUB" => $Her["UF_FRIENDS_SUB"], "UF_USER_SUB_IN" => $Her["UF_USER_SUB_IN"]));
				echo "del";
			} else { // отклонить входящий запрос
				if($posHerInMySubIn !== false)
					unset($Me["UF_FRIENDS_SUB_IN"][$posHerInMySubIn]);
				if($posMeInHerSub !== false)
					unset($Her["UF_FRIENDS_SUB"][$posMeInHerSub]);
				CustomUser::AnotherUserUpdate($Me["ID"], array("UF_FRIENDS_SUB_IN" => $Me["UF_FRIENDS_SUB_IN"]));
				CustomUser::AnotherUserUpdate($Her["ID"], array("UF_FRIENDS_SUB" => $Her["UF_FRIENDS_SUB"]));
				echo "add";
			}
		} elseif($posHerInMySub !== false) { // если существует исходящий запрос
			$posHerInMyUSub = array_search($Her["ID"], $Me["UF_USER_SUB"]);
			if($posHerInMyUSub !== false)
				unset($Me["UF_USER_SUB"][$posHerInMyUSub]);
			$posMeInHerUSubIn = array_search($Me["ID"], $Her["UF_USER_SUB_IN"]);
			if($posMeInHerUSubIn !== false)
				unset($Her["UF_USER_SUB_IN"][$posMeInHerUSubIn]);
			if($posHerInMySub !== false)
				unset($Me["UF_FRIENDS_SUB"][$posHerInMySub]);
			$posMeInHerSubIn = array_search($Me["ID"], $Her["UF_FRIENDS_SUB_IN"]);
			if($posMeInHerSubIn !== false)
				unset($Her["UF_FRIENDS_SUB_IN"][$posMeInHerSubIn]);
			CustomUser::AnotherUserUpdate($Me["ID"], array("UF_FRIENDS_SUB" => $Me["UF_FRIENDS_SUB"], "UF_USER_SUB" => $Me["UF_USER_SUB"]));
			CustomUser::AnotherUserUpdate($Her["ID"], array("UF_FRIENDS_SUB_IN" => $Her["UF_FRIENDS_SUB_IN"], "UF_USER_SUB_IN" => $Her["UF_USER_SUB_IN"]));
			echo "add";
		} else { // если исходящие и входящие запросы пусты
			$posMeInHerUSub = array_search($Her["ID"], $Me["UF_USER_SUB"]);
			if($posMeInHerUSub === false)
				array_push($Me["UF_USER_SUB"], $Her["ID"]);
			$posMeInHerUSubIn = array_search($Me["ID"], $Her["UF_USER_SUB_IN"]);
			if($posMeInHerUSubIn === false)
				array_push($Her["UF_USER_SUB_IN"], $Me["ID"]);
			array_push($Me["UF_FRIENDS_SUB"], $Her["ID"]);
			array_push($Her["UF_FRIENDS_SUB_IN"], $Me["ID"]);
			CustomUser::AnotherUserUpdate($Me["ID"], array("UF_FRIENDS_SUB" => $Me["UF_FRIENDS_SUB"], "UF_USER_SUB" => $Me["UF_USER_SUB"]));
			CustomUser::AnotherUserUpdate($Her["ID"], array("UF_FRIENDS_SUB_IN" => $Her["UF_FRIENDS_SUB_IN"], "UF_USER_SUB_IN" => $Her["UF_USER_SUB_IN"]));
			echo "del";
		}
	}
}
?>