<?
	require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");
	CModule::IncludeModule("iblock");
	$res = CIBlockElement::GetList( Array(),
									Array(
										"IBLOCK_ID"=>12,
										"PROPERTY_USER_IN"=>$USER->GetID(),
										"PROPERTY_READ"=>0
									  ),
									false,
									false,
									Array("ID")
								  );
		$count=$res->SelectedRowsCount();
		echo $count;
?>
