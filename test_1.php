<?
	require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");
	CModule::IncludeModule("iblock");
	CModule::IncludeModule("highloadblock");
	for($group=1;$group<=9;$group++)
	{
		$filter = Array	("UF_GROUPS" => $group); 
		$rsUsers = CUser::GetList(($by="LAST_NAME"), ($order="asc"), $filter,array('NAV_PARAMS' => array("nTopCount" => 0))); 
		CIBlockElement::SetPropertyValueCode($group, "USERS", $rsUsers->NavRecordCount);
		echo "count = ".$rsUsers->NavRecordCount;
	}
?>