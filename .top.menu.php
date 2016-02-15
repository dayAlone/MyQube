<?
$aMenuLinks = Array(
	Array(
		"Профиль",
		"/user/profile/",
		Array(),
		Array("CODE"=> "profile"),
		""
	),
	Array(
		"Группы",
		"/user/groups/",
		Array(),
		Array("CODE"=> "group"),
		""
	),
	Array(
		"В группу",
		$_SESSION["MQ_GROUP_LAST_POINT"] ? $_SESSION["MQ_GROUP_LAST_POINT"] : '/group/1/',
		Array(),
		Array("CODE"=> "back", "href"=>"В группу"),
		""
	),
	Array(
		"Сообщения",
		"/communication/",
		Array(),
		Array("CODE"=> "message"),
		""
	),
	Array(
		"Новости",
		"/user/news/",
		Array(),
		Array("CODE"=> "news"),
		""
	),
	Array(
		"Календарь",
		"/user/calendar/",
		Array(),
		Array("CODE"=> "calendar", "href"=>"КАЛЕНДАРЬ"),
		""
	),
	/*Array(
		"Мои конкурсы",
		"/user/contest/",
		Array(),
		Array("CODE"=> "contest"),
		"CSite::InPeriod(1441054800,1441141200)"
	),*/
	Array(
		"Выход",
		"?logout=yes",
		Array(),
		Array("CODE"=> "exit"),
		""
	)
);
?>
