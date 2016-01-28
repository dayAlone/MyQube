<? //require_once $_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php";
if(!isset($_GET["csv"]))
{
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
	/*
	.stat-table tr.even td{
		background: #eef;
	}
	*/
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
}
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
if(!isset($_GET["csv"])){
	$APPLICATION->ShowHead();
	CJSCore::Init("jquery");
	$APPLICATION->ShowPanel();
	$APPLICATION->SetTitle("Статистика приглашений");
}
else
{
	header("Content-type: text/csv");
	header("Content-Disposition: attachment; filename=amplifiers_stat_".$date_from."-".$date_to.".csv");
	header("Pragma: no-cache");
	header("Expires: 0");

}
/*$groupObj = CGroup::GetList();
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
}*/	
	$err_mess = "Error in Query to `kpi_amplifier`: ";
	$strSql = "SELECT `b2`.`NAME` as `a_name`,`b2`.`LAST_NAME` as `a_last_name`,`b2`.`LOGIN` as `a_login`,`b1_d`.`UF_VK_PROFILE`,`b1_d`.`UF_FB_PROFILE`,`b1_d`.`UF_GP_PROFILE`,`kpi_amplifier`.*,
	`b1`.`PERSONAL_BIRTHDAY` as `u_birth_date`,`b1`.`PERSONAL_PHONE` as `u_phone_1`,`b1`.`PERSONAL_MOBILE` as `u_phone_2`,`b1`.`NAME` as `u_name`,`b1`.`LAST_NAME` as `u_last_name`,`b1`.`EMAIL` as `u_email`,`b1`.`LOGIN` as `u_login` FROM `kpi_amplifier` RIGHT JOIN `b_user` as `b1` ON `b1`.`ID`=`kpi_amplifier`.`UF_USER` RIGHT JOIN `b_uts_user` as `b1_d` ON `b1`.`ID`=`b1_d`.`VALUE_ID` RIGHT JOIN `b_user` as `b2` ON `b2`.`ID`=`kpi_amplifier`.`UF_AMPLIFIER` RIGHT JOIN `b_user_group` ON `b_user_group`.`USER_ID`=`kpi_amplifier`.`UF_AMPLIFIER` WHERE `b_user_group`.`GROUP_ID`=8 AND (`kpi_amplifier`.`UF_EVENT`>0 OR `kpi_amplifier`.`UF_ACTION_TEXT`='change_status') AND `UF_DATE_TIME` >='".ConvertDateTime($date_from, "YYYY-MM-DD", "ru")."' AND `UF_DATE_TIME`<='".ConvertDateTime($date_to, "YYYY-MM-DD", "ru")."' ORDER BY `ID` desc LIMIT 0,10000";
	$res = $DB->Query($strSql, false, $err_mess.__LINE__);
if(!isset($_GET["csv"])){?>

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
		padding:5px;
	}
	
	.stat-table td{
		padding: 5px;
		border: 1px solid #38b;
	}
	
	.stat-table td.count{
		text-align: right;
	}
	/*
	.stat-table tr.even td{
		background: #eef;
	}
	*/
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
		font-size:20px;
		margin-bottom:12px;
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
	.wrapper form {
		margin-bottom: 20px;
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
<p>
	<form method="get">
		<span>Временной период</span>
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
		&nbsp;&nbsp;&nbsp;<a href="/stats_amplifiers.php?date_from=<?=$date_from?>&date_to=<?=$date_to?>&csv=1">Скачать отчёт</a>
	</form>
</p>
<table class="stat-table">
<thead><tr><th>ID сотрудника</th><th>Логин сотрудника</th><th>Имя сотрудника</th><th>Фамилия сотрудника</th>
<th>Город</th><th>Дата</th><th>ID события</th><th>ID контакта</th><th>Имя контакта</th><th>Фамилия контакта</th>
<th>email контакта</th><th>телефон контакта</th><th>FB</th><th>VK</th><th>G+</th><th>Дата рождения</th>
<th>Информационный</th><th>Конверсивный</th><th>Регистрационный</th><th>Повторный</th></tr></thead><tbody>
<?
}
else
{
	?>ID сотрудника;Логин сотрудника;Имя сотрудника;Фамилия сотрудника;Город;Дата;ID события;ID контакта;Имя контакта;Фамилия контакта;email контакта;телефон контакта;FB;VK;G+;Дата рождения;Информационный;Конверсивный;Регистрационный;Повторный
<?
}
$even = false;
$total = 0;
$events = Array(0=>"");
CModule::IncludeModule("iblock");
while ($cells = $res->Fetch())
{
	if(!isset($events[$cells["UF_EVENT"]]))
	{
		$res_1 = CIBlockElement::GetList(array(), array("IBLOCK_ID" => 2, "ID" => $cells["UF_EVENT"]));
		while($arRes_1 = $res_1->GetNextElement()){
			$arItem = $arRes_1->GetFields();
			$arItem["PROPERTIES"] = $arRes_1->GetProperties();
			$arEvent = $arItem["PROPERTIES"];
			//echo "<xmp>";print_r($arEvent);echo "</xmp>";
		}
	}
	if(!isset($_GET["csv"]))
	{?>
		<tr class="<?=($even ? "even" : "odd")?>">
			<td><?=$cells["UF_AMPLIFIER"]?></td>
			<td><?=$cells["a_login"]?></td>
			<td><?=$cells["a_name"]?></td>
			<td><?=$cells["a_last_name"]?></td>
			<td><?=$arEvent["PLACE_EVENT"]["VALUE"]?></td>
			<td><?=$cells["UF_DATE_TIME"]?></td>
			<td><?=$cells["UF_EVENT"]?></td>
			<td><?=$cells["UF_USER"]?></td>
			<td><?=$cells["u_name"]?></td>
			<td><?=$cells["u_last_name"]?></td>
			<td><?=$cells["u_email"]?></td>
			<td><?=$cells["u_phone_1"]." ".$cells["u_phone_2"]?></td>
			<td><?=implode(" ",unserialize($cells["UF_FB_PROFILE"]));?></td>
			<td><?=implode(" ",unserialize($cells["UF_VK_PROFILE"]));?></td>
			<td><?=implode(" ",unserialize($cells["UF_GP_PROFILE"]));?></td>
			<td><?=$cells["u_birth_date"]?></td>
			<td><?=($cells["UF_TYPE"]==34||$cells["UF_TYPE_2"]==39)?"1":""?></td>
			<td><?=($cells["UF_TYPE"]==36||$cells["UF_TYPE_2"]==41)?"1":""?></td>
			<td><?=($cells["UF_TYPE"]==35||$cells["UF_TYPE_2"]==40)?"1":""?></td>
			<td><?=($cells["UF_TYPE"]==37||$cells["UF_TYPE_2"]==42)?"1":""?></td>
		</tr>
	<?	}
	else
	{
		echo $cells["UF_AMPLIFIER"].";".$cells["a_login"].";".$cells["a_name"].";".$cells["a_last_name"].";";
		echo $arEvent["PLACE_EVENT"]["VALUE"].";".$cells["UF_DATE_TIME"].";".$cells["UF_EVENT"].";".$cells["UF_USER"].";".$cells["u_name"].";".$cells["u_last_name"].";".$cells["u_email"].";".$cells["u_phone_1"]." ".$cells["u_phone_2"].";".implode(" ",unserialize($cells["UF_FB_PROFILE"])).";".implode(" ",unserialize($cells["UF_VK_PROFILE"])).";".implode(" ",unserialize($cells["UF_GP_PROFILE"])).";".$cells["u_birth_date"].";".(($cells["UF_TYPE"]==34||$cells["UF_TYPE_2"]==39)?"1":"").";".(($cells["UF_TYPE"]==36||$cells["UF_TYPE_2"]==41)?"1":"").";".(($cells["UF_TYPE"]==35||$cells["UF_TYPE_2"]==40)?"1":"").";".(($cells["UF_TYPE"]==37||$cells["UF_TYPE_2"]==42)?"1":"").";
"; 
	}
 $even = !$even;
}
if(!isset($_GET["csv"])){?>
</tbody></table>
</div>
<div class="joined-placeholder">
	<div class="joined-list"></div>
</div>
<?}// require_once $_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/epilog_after.php";?>
<? //require_once $_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php"; ?>