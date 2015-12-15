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
if(isset($_GET['id'])){
	$ampId = $_GET['id'];
	$amp = CUser::GetByID($ampId)->Fetch();
	$str = "<a target=\"top\" href=\"/club/user/{$amp["ID"]}/\">({$amp["LOGIN"]})</a> {$amp["NAME"]} {$amp["LAST_NAME"]}";
	$ampUsers = array();
	$ampUsersObj = CUser::GetList(($by="id"), ($order="asc"), array(
	   "DATE_REGISTER_1" => $date_from,
	   "DATE_REGISTER_2" => $date_to,
	   "UF_USER_PARENT" => $ampId
	));
	while($ampUser = $ampUsersObj->Fetch()){
		$ampUsers[] = $ampUser;
	}
	print "<h2>$str. Список приглашенных участников.</h2>";
	print "<div style=\"text-align: center\"><small><i>Нажмите ESC чтобы закрыть это окно.</i></small></div>";
	print "<table class=\"stat-table\">";
	print "<thead><tr>";
	print "<th>ID</th><th>Дата регистрации</th><th>Активирован</th><th>Логин</th><th>Имя</th>";
	print "</tr></thead>";
	foreach($ampUsers as $item){
		print "<tr>
			<td>{$item["ID"]}</td>
			<td>{$item["DATE_REGISTER"]}</td>
			<td>".($item["ACTIVE"] == "Y" ? "Да" : "нет")."</td>
			<td><a target=\"top\" href=\"/club/user/{$item["ID"]}/\">{$item["LOGIN"]}</a></td>
			<td>{$item["NAME"]}&nbsp;{$item["LAST_NAME"]}</td>
		</tr>";
	}
	print "</table>";
	print "<div style=\"text-align: center\"><small><i>Нажмите ESC чтобы закрыть это окно.</i></small></div>";
	die();
}

$APPLICATION->ShowHead();
CJSCore::Init("jquery");
$APPLICATION->ShowPanel();
$APPLICATION->SetTitle("Статистика приглашений");
$groupObj = CGroup::GetList();
$groups = array();
while($group = $groupObj->Fetch()){
	if($group["ID"] == 8 || $group["ID"] == 9){ //Усилители / Сотрудники
		$groups[$group["ID"]] = $group["NAME"];
	}
}

$usersObj = CUser::GetList(($sort = "id"), ($direct = "asc"), array(
   "DATE_REGISTER_1" => $date_from,
   "DATE_REGISTER_2" => $date_to
), array("SELECT" => array("UF_*"), "FIELDS" => array("ID")));
$counter = array();

while($user = $usersObj->Fetch()){	
	if($user["UF_USER_PARENT"]){		
		$counter[$user["UF_USER_PARENT"]][] = $user["ID"];
	}
}

$table = array();
foreach($counter as $uid => $joined){	

	$ampUsers = array();
	$ampUsersObj = CUser::GetList(($sort = "id"), ($direct = "asc"), array(
	   "DATE_REGISTER_1" => $date_from,
	   "DATE_REGISTER_2" => $date_to,
	   "UF_USER_PARENT" => $uid
	), array("SELECT" => array("UF_*")));
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
			"city" => $amp["PERSONAL_CITY"],
			"count" => count($joined)
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
	function showJoinedBy(id, date_from, date_to){
		var url = "/stats.php?id=" + id + "&date_from=" + date_from + "&date_to=" + date_to;
		var target = $(".joined-list");
		var placholder = $(".joined-placeholder");
		window.open("/stats.php?id=" + id + "&date_from=" + date_from + "&date_to=" + date_to, "", "width=800,height=600,left=100,top=100,resizable=yes,scrollbars=yes");
		/*$.ajax({
			url: url,
			dataType: "html",
			success: function(resp){
				target.html(resp);
				placholder.fadeIn();
			}
		});*/
	}
</script>
<div class="wrapper">
<h2><?= $APPLICATION->ShowTitle(); ?></h2>
<h2>
	<a href="stats_detail.php">Статистика приглашений детально</a>
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
<thead><tr><th>Группа</th><th>ID</th><th>Логин</th><th>Имя пригласившего</th><th>Город</th><th>Количество приглашенных</th></tr></thead><tbody>
<?
$even = false;
$total = 0;
foreach($table as $cells): 
	$total += $cells["count"];
	//echo '<pre>'; print_r($cells); echo '</pre>';
	?>
	<tr class="<?=($even ? "even" : "odd")?>">
		<td><?=$cells["group"]?></td>
		<td><?=$cells["id"]?></td>
		<td><a target="top" href="<?=$cells["profile"]?>"><?=$cells["login"]?></a></td>
		<td><?=$cells["name"]?></td>
		<td><?=$cells["city"]?></td>
		<td class="count"><a href="javascript:showJoinedBy(<?=$cells["id"]?>, '<?=$date_from?>', '<?=$date_to?>')"><?=$cells["count"]?></a></td>
	</tr>
<?
$even = !$even;
endforeach; ?>
<tr class="total">
		<td colspan="5">ИТОГО</td>
		<td><?=$total?></td>
	</tr>
</tbody></table>
</div>
<div class="joined-placeholder">
	<div class="joined-list"></div>
</div>
<?// require_once $_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/epilog_after.php";?>
<? //require_once $_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php"; ?>