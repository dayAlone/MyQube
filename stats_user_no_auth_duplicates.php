<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");?>
<?
	if(!CModule::IncludeModule("iblock")){die("Error include \"iblock\".");}
	
	$Data = array(
		"FB" => array("List" => array(),"Count" => 0),
		"GP" => array("List" => array(),"Count" => 0),
		"VK" => array("List" => array(),"Count" => 0)
	);
	
	$Query = CIBlockElement::GetList(array(),array("IBLOCK_ID" => 19));
	while($Answer = $Query->GetNextElement()){
		$ListSocNet = array();
		$Fields = $Answer->GetFields();
		$Properties = $Answer->GetProperties();
		
		if(trim($Properties["FB"]["VALUE"]) != ""){
			$ListSocNet[] = "FB";
		}
		
		if(trim($Properties["GP"]["VALUE"]) != ""){
			$ListSocNet[] = "GP";
		}
		
		if(trim($Properties["VK"]["VALUE"]) != ""){
			$ListSocNet[] = "VK";
		}
		
		foreach($ListSocNet as $key => $value){
			if(isset($Data[$value]["List"][$Properties[$value]["VALUE"]])){
				$Data[$value]["Count"] += 1;
				
				$Data[$value]["List"][$Properties[$value]["VALUE"]]["Count"] += 1;
				
				$Data[$value]["List"][$Properties[$value]["VALUE"]]["Id"][] = $Fields["ID"];
				$Data[$value]["List"][$Properties[$value]["VALUE"]]["Parent"][] = $Properties["PARENT"]["VALUE"];
				
			} else {
				$Data[$value]["List"][$Properties[$value]["VALUE"]] = array(
					"Name" => $Properties["NAME"]["VALUE"],
					"LastName" => $Properties["LAST_NAME"]["VALUE"],
					"Parent" => array($Properties["PARENT"]["VALUE"]),
					"Id" => array($Fields["ID"]),
					"Count" => 1
				);
			}
		}	
	}	
?>
<h2 style="text-align: center; border-bottom: 1px solid #cccccc;padding-bottom: 5px;padding-top: 15px;font-size: 120%;">
	Статистика приглашений пользователей отказавшихся от регистрации дубликаты
</h2>
<h2 style="text-align: center; border-bottom: 1px solid #cccccc;padding-bottom: 5px;padding-top: 15px;font-size: 120%;">
	<a style="text-decoration: none;" href="stats_user_no_auth.php">
		Статистика приглашений пользователей отказавшихся от регистрации
	</a>
</h2>
<h2 style="text-align: center; border-bottom: 1px solid #cccccc;padding-bottom: 5px;padding-top: 15px;font-size: 120%;">
	<a style="text-decoration: none;" href="stats_user_no_auth_detail.php">
		Статистика приглашений пользователей отказавшихся от регистрации детально
	</a>
</h2>
<table cellpadding="0" cellspacing="0" style="width:100%;">
<?foreach($Data as $key => $value):?>
	<tr style="background-color:#269;color:#fff;font-size:18px;">
		<td style="padding:5px;" colspan="2"><?=$key;?></td>
		<td style="padding:5px;"><?=$value["Count"];?></td>
	</tr>
	<?$Flag = false;?>
	<?foreach($value["List"] as $keyList => $valueList):?>
		<?if($valueList["Count"] == 1){continue;}?>
		<tr <?=$Flag ? " style=\"background-color:#eef;\"" : ""?>>
			<td style="border: 1px solid #38b;padding:5px;"><?=$keyList;?></td>
			<td style="border: 1px solid #38b;padding:5px;"><?=$valueList["Name"]." ".$valueList["LastName"];?></td>
			<td style="border: 1px solid #38b;padding:5px;">
				Id пользователя: <?=implode(",",$valueList["Id"]);?><br />
				Родитель: <?=implode(",",$valueList["Parent"]);?>
			</td>
		</tr>
		<?$Flag = !$Flag;?>
	<?endforeach;?>
<?endforeach;?>
</table>
<style type="text/css">
	a {
	    color: #eef;
	}
</style>
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/epilog_after.php");?>