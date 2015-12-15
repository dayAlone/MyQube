<?
$aMenuLinks = Array(
	Array(
		"ПРОФИЛЬ", 
		"/user/profile/", 
		Array(), 
		Array(), 
		"" 
	),
	Array(
		"ГРУППЫ", 
		"/user/groups/", 
		Array(), 
		Array(), 
		"" 
	),
	Array(
		"Вернуться в группу", 
		$_SESSION["MQ_GROUP_LAST_POINT"] ? $_SESSION["MQ_GROUP_LAST_POINT"] : '/group/1/', 
		Array(), 
		Array("href"=>"В группу"), 
		"" 
	),
	Array(
		"СООБЩЕНИЯ", 
		"/communication/", 
		Array(), 
		Array(), 
		"" 
	),
	Array(
		"НОВОСТИ", 
		"/user/news/", 
		Array(), 
		Array(), 
		"" 
	),
	Array(
		"КАЛЕНДАРЬ СОБЫТИЙ", 
		"/user/calendar/", 
		Array(), 
		Array("href"=>"КАЛЕНДАРЬ"), 
		"" 
	),
	Array(
		"МОИ КОНКУРСЫ", 
		"/user/contest/", 
		Array(), 
		Array(), 
		"CSite::InPeriod(1441054800,1441141200)" 
	),
	Array(
		"ВЫХОД", 
		"?logout=yes", 
		Array(), 
		Array(), 
		"" 
	)
);
?>