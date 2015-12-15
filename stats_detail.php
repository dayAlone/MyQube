<? //require_once $_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php"; ?>
<style type="text/css">
	.stat-table{
		width: 100%;
		border-collapse: collapse;
	}
	
	.stat-table th{
		background: #269;
		color: #fff;
		border: 1px solid #38b;
		font-size: 1.2em;
	}
	
	.stat-table td{
		padding: 5px;
		border: 1px solid #38b;
	}
	
	.stat-table td.count{
		text-align: right;
	}
	
	.stat-table tr.even td{
		background: #eef;
	}
	
	.stat-table tr.total td{
		font-weight: bold;
		text-align: right;
		text-transform: uppercase;
		background: #269;
		color: #fff;
		font-size: 1.2em;
	}
	
	h2{
		text-align: center;
	}
	.wrapper{
		margin: 1em;
	}
	
	.joined-placeholder{
		display: none;
		position: fixed;
		top: 0;
		left: 0;
		width: 100%;
		height: 100%;		
		background: #999;
		background: rgba(0,0,0,.5);
	}
	.joined-list{
		margin: 10px 100px;
		height: 90%;
		background: #fff;
		padding: 1em;
		overflow-y: scroll
	}
</style>
<?

require_once $_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php";

if(!function_exists("d")){
	function d(){
		$args = func_get_args();
		print "<hr /><pre>";
		foreach($args as $arg){
			print_r($arg);
		}
		print "</pre>";
	}
}

if($_GET["date_from"] || $_GET["date_to"])
{
	$date_from = $_GET["date_from"];
	$date_to = $_GET["date_to"];
}
else
{
	$date_from = date('d.m.Y', time()-3600*24*10);
	$date_to = date('d.m.Y', time());	
}
$APPLICATION->ShowHead();
CJSCore::Init("jquery");
$APPLICATION->ShowPanel();
$APPLICATION->SetTitle("Статистика приглашений детально");
$groupObj = CGroup::GetList();
$groups = array();
while($group = $groupObj->Fetch()){
	if($group["ID"] == 8 || $group["ID"] == 9){ //Усилители / Сотрудники
		$groups[$group["ID"]] = $group["NAME"];
	}
}

$arFilter = array(
   "DATE_REGISTER_1" => $date_from,
   "DATE_REGISTER_2" => $date_to
);
$usersObj = CUser::GetList(($sort = "id"), ($direct = "asc"), $arFilter, array("SELECT" => array("UF_*"), "FIELDS" => array("*")));
$counter = array();

while($user = $usersObj->Fetch()){	
	if($user["UF_USER_PARENT"]){		
		$counter[$user["UF_USER_PARENT"]][] = $user;
	}
}

$table = array();
foreach($counter as $uid => $joined){	

	$ampUsers = array();
	$arFilter = array(
	   "DATE_REGISTER_1" => $date_from,
	   "DATE_REGISTER_2" => $date_to,
	   "UF_USER_PARENT" => $uid
	);
	$ampUsersObj = CUser::GetList(($sort = "id"), ($direct = "asc"), $arFilter, array("SELECT" => array("UF_*")));
	while($ampUser = $ampUsersObj->Fetch()){
		$ampUsers[$ampUser["UF_USER_PARENT"]] = $ampUser;
	}
	
	if(!empty($ampUsers[$uid]))
	{
		$amp = CUser::GetByID($uid)->Fetch();	
		$arName = array($amp["NAME"], $amp["LAST_NAME"]);
		$ampGroupsObj = CUser::GetUserGroupList($amp["ID"]);
		$ampGroups = array();
		while($ampGroup = $ampGroupsObj->Fetch()){		
			if(array_key_exists($ampGroup["GROUP_ID"], $groups)){
				$ampGroups[] = $groups[$ampGroup["GROUP_ID"]];
			}		
		}
		
		$arr = array(
			"profile" => "/club/user/{$amp["ID"]}/",
			"group" => implode("<br />", $ampGroups),
			"id" => $amp["ID"],
			"login" => $amp["LOGIN"],
			"name" => implode(" ", $arName),
			"list" => $joined,
			"city" => $amp["PERSONAL_CITY"]
		);
		$table[] = $arr;
	}
}
?>

<style type="text/css">
	.stat-table{
		width: 100%;
		border-collapse: collapse;
	}
	
	.stat-table th{
		background: #269;
		color: #fff;
		border: 1px solid #38b;
		font-size: 1.2em;
	}
	
	.stat-table td{
		padding: 5px;
		border: 1px solid #38b;
	}
	
	.stat-table td.count{
		text-align: right;
	}
	
	.stat-table tr.even td{
		background: #eef;
	}
	
	.stat-table tr.total td{
		font-weight: bold;
		text-align: right;
		text-transform: uppercase;
		background: #269;
		color: #fff;
		font-size: 1.2em;
	}
	
	h2{
		text-align: center;
	}
	.wrapper{
		margin: 1em;
	}
	
	.joined-placeholder{
		display: none;
		position: fixed;
		top: 0;
		left: 0;
		width: 100%;
		height: 100%;		
		background: #999;
		background: rgba(0,0,0,.5);
	}
	.joined-list{
		margin: 10px 100px;
		height: 90%;
		background: #fff;
		padding: 1em;
		overflow-y: scroll
	}
</style>
<script type="text/javascript">	
	$(document).keydown(function(e){
		if(e.keyCode == 27){
			$(".joined-placeholder").hide();
		}
	})
</script>
<div class="wrapper">
<h2><?= $APPLICATION->ShowTitle(); ?></h2>
<h2>
	<a href="stats.php">Статистика приглашений</a>
</h2>
<p>
	<form method="get">
		<span>Период регистрации </span>
		<?$APPLICATION->IncludeComponent("bitrix:main.calendar","",Array(
			 "SHOW_INPUT" => "Y",
			 "FORM_NAME" => "",
			 "INPUT_NAME" => "date_from",
			 "INPUT_NAME_FINISH" => "date_to",
			 "INPUT_VALUE" => $date_from,
			 "INPUT_VALUE_FINISH" => $date_to, 
			 "SHOW_TIME" => "Y",
			 "HIDE_TIMEBAR" => "Y"
			)
		);?>
		<input type="submit" value="Сформировать">
	</form>
</p>
<table class="stat-table">
<thead><tr><th>Группа</th><th>ID</th><th>Логин</th><th>Город</th><th>Имя пригласившего</th>
<th>ID</th><th>Дата регистрации</th><th>Активирован</th><th>Логин</th><th>Имя</th>
</tr>
 
 </thead><tbody>
<?
$even = false;
foreach($table as $cells): ?>
	<?foreach($cells["list"] as $keyList => $valueList):?>
	<tr class="<?=($even ? "even" : "odd")?>">
		<td><?=$cells["group"]?></td>
		<td><?=$cells["id"]?></td>
		<td><a target="top" href="<?=$cells["profile"]?>"><?=$cells["login"]?></a></td>
		<td><?=$cells["city"]?></td>
		<td><?=$cells["name"]?></td>
		<td class="count"><?=$valueList["ID"];?></td>
		<td class="count"><?=$valueList["DATE_REGISTER"];?></td>
		<td class="count"><?=$valueList["ACTIVE"] == "Y" ? "Да" : "Нет";?></td>
		<td class="count">
			<a target="top" href="/club/user/<?=$valueList["ID"];?>/"><?=$valueList["LOGIN"];?></a>
		</td>
		<td class="count"><?=$valueList["NAME"]."&nbsp;".$valueList["LAST_NAME"];?></td>
	</tr>
		<?$even = !$even;?>
	<?endforeach;?>
<?endforeach;?>
</tbody></table>
</div>
<div class="joined-placeholder">
	<div class="joined-list"></div>
</div>
<?// require_once $_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/epilog_after.php";?>