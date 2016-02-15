<?
use Bitrix\Highloadblock as HL;
use Bitrix\Main\Entity;

define('CITY_NAME', 'Екатеринбург');

AddEventHandler("main", "OnAfterUserLogin", Array("OnAfterUserLogin", "AuthRemember"));
AddEventHandler('main', 'OnBeforeProlog', Array("OnBeforeProlog", 'CustomSetLastActivityDate'));
AddEventHandler("main", "OnBeforeProlog", Array("OnBeforeProlog", "MyOnBeforePrologHandler"));
AddEventHandler('main', 'OnEpilog', 'onEpilog');
AddEventHandler("iblock", "OnAfterIBlockElementAdd", "NWCommentsCounter");
AddEventHandler("iblock", "OnBeforeIBlockElementDelete", "NWCommentsCounterDel");

class OnAfterUserLogin {
	function AuthRemember(&$arFields) {
		if($arFields['USER_ID'] > 0) {
			global $APPLICATION;
			if($APPLICATION->get_cookie("MQ_REGISTRATION_TOKEN")) {
				$rsUser = CUser::GetByLogin($arFields['LOGIN']);
				if($arUser = $rsUser->Fetch()) {
					if($arUser['UF_INVITE_STATUS'] != 1) {
						$contact_type_ret = array(
							28 => 1,
							29 => 2,
							30 => 3,
							31 => 4,
							32 => 5
						);
						$Fields["UF_INVITE_STATUS"] = 1;
						CustomUser::UserUpdate($Fields);
						CModule::IncludeModule("iblock");
						CModule::IncludeModule("highloadblock");
						$data = array(
							"UF_USER" => $arUser['ID'],
							"UF_AMPLIFIER" => $arUser['UF_USER_PARENT'],
							"UF_EVENT" => 0,
							"UF_DATE_TIME" => date("d.m.Y H:i:s", time()),
							"UF_ACTION_CODE" => 104,
							"UF_ACTION_TEXT" => "Приглашение принято",
							"UF_TYPE" => $contact_type_ret[$arUser['UF_STATUS']],
							"UF_TYPE_2" => $contact_type_ret[$arUser['UF_STATUS']]
						);
						$hlblock = HL\HighloadBlockTable::getById(4)->fetch();
						$entity = HL\HighloadBlockTable::compileEntity($hlblock);
						$entity_data_class = $entity->getDataClass();
						$result = $entity_data_class::add($data);
					}
				}
			}
		}
	}
}
class OnBeforeProlog {
	function CustomSetLastActivityDate() {
		if($GLOBALS['USER']->IsAuthorized()) CUser::SetLastActivityDate($GLOBALS['USER']->GetID());
	}
	function MyOnBeforePrologHandler() {
		global $USER;
		global $APPLICATION;
		/**
			u - User Id
			p - Parent User
			d - Create user date
		*/

		$Dir = explode("/",$_SERVER["REQUEST_URI"]);
		$Query_string = explode("&",$_SERVER["QUERY_STRING"]);
		$Query = explode("=",$Query_string[0]);
		$authString = explode("?",$_SERVER["REQUEST_URI"]);
		if($authString[0]=='/vk.php'||$authString[0]=='/facebook.php'||$authString[0]=='/google.php'||$authString[0]=='/app.php'||$authString[0]=='/mail.php'||$Dir[1]=='unsubscribe') $socAuth = true;

		if($_GET["AUTH_SOCNET"]) {
			$Fields = array("UF_AUTH_SOCNET"=>"1");
			CustomUser::UserUpdate($Fields);
		}
		if($USER->GetID() > 0 && !$USER->GetByID($USER->GetID())->Fetch()["UF_AUTH_SOCNET"]) {
			echo "<div class=\"after-login-message\">
				<div class=\"after-login-message-inner\">
					<h4>Для удобства использования социальной сети вы можете авторизоваться через:</h4>";
					$APPLICATION->IncludeComponent(
						"bitrix:system.auth.form",
						"myqube",
						array(
							"REGISTER_URL" => "/club/group/search/",
							"PROFILE_URL" => "/user/profile/",
							"FORGOT_PASSWORD_URL" => "",
							"SHOW_ERRORS" => "Y",
							"ONLY_SOCNET" => "Y"
						),
						false
					);
			echo "<div class=\"after-login-message-n\"><a href=\"?AUTH_SOCNET=N\">ОТКАЗАТЬСЯ</a></div>
				</div>
			</div>";
		}
		if(isset($_GET["token"])){
			$APPLICATION->set_cookie("MQ_REGISTRATION_TOKEN", $_GET["token"], time()+60*60*24*30*12*4,"/");
		}

		// Редиректы со старого сайта
		if($Dir[1] == "personal") {
			LocalRedirect(str_replace("personal", "user", $_SERVER["REQUEST_URI"]));
		}
		if($Dir[1] == "club") {
			CModule::IncludeModule("iblock");
			if($Dir[2] == "group" && $Dir[3] == 6 && $Dir[4] == "post") {
				$res = CIBlockElement::GetList(Array(), Array("IBLOCK_ID"=>1, "PROPERTY_OLD_ID"=>$Dir[5]), false, Array(), Array("ID"));
				while($ob = $res->GetNextElement())
					$arFields = $ob->GetFields();
				if($arFields["ID"] > 0) {
					LocalRedirect("/group/1/post/".$arFields["ID"]."/");
				} else {
					LocalRedirect("/");
				}
			}
			if($Dir[2] == "group" && $Dir[3] == 6 && $Dir[4] == "events") {
				$res = CIBlockElement::GetList(Array(), Array("IBLOCK_ID"=>2, "PROPERTY_OLD_ID"=>$Query[1]), false, Array(), Array("ID"));
				while($ob = $res->GetNextElement())
					$arFields = $ob->GetFields();
				if($arFields["ID"] > 0) {
					LocalRedirect("/group/1/events/".$arFields["ID"]."/");
				} else {
					LocalRedirect("/");
				}
			}
			if($Dir[2] == "group" && $Dir[3] == 6 && $Dir[4] == "photo") {
				$res = CIBlockElement::GetList(Array(), Array("IBLOCK_ID"=>7, "PROPERTY_OLD_ID"=>$Dir[6]), false, Array(), Array("ID"));
				while($ob = $res->GetNextElement())
					$arFields = $ob->GetFields();
				if($arFields["ID"] > 0) {
					LocalRedirect("/group/1/photo/".$arFields["ID"]."/");
				} else {
					LocalRedirect("/");
				}
			}
		}
		// Редиректы со старого сайта

		if($Dir[1] == "group" && $Dir[2] == 1 && $Dir[3] !== "post" && !empty($Dir[3]))
			$_SESSION["BackFromDetail"]["group_6"]["nPageSize"] = 1;

		$CurentUser = array();

		if(!empty($_GET["backurl"])) {
			$backurl = "&backurl=".$_GET["backurl"];
		}
		if(!$USER->IsAuthorized() && empty($_GET["POST_ID"]) && !empty($Dir[1]) && $Dir[1]!=='group' && $Dir[1]!=='bitrix' && !$socAuth && empty($backurl)) {
			LocalRedirect("/?backurl=".$_SERVER["REQUEST_URI"]);
		}
		if(!$USER->IsAdmin()){
			$CurentUserGroup = CUser::GetUserGroup($USER->GetID());
			if(preg_match("#^/staff/#",$_SERVER["REQUEST_URI"])){

				if(!in_array(9,$CurentUserGroup)){
					LocalRedirect("/");
				}

			} else if(preg_match("#^/amplifiers/#",$_SERVER["REQUEST_URI"])){

				if(!in_array(8,$CurentUserGroup)){
					LocalRedirect("/");
				}



			} else if($Dir[1] == "group" && $Dir[2] == 1){
				if($USER->IsAuthorized()){
					$CurentUser = CUser::GetByID($USER->GetID())->Fetch();

					if(!in_array(1,$CurentUser["UF_GROUPS"])) { // не член 1 группы
						if(empty($backurl) && !empty($Dir[3])) {
							LocalRedirect("/group/1/?backurl=".$_SERVER["REQUEST_URI"]);
						}
						if(strlen($CurentUser["PERSONAL_BIRTHDAY"]) > 0){ // ДатаРождения заполнена
							if(CustomUser::UserCheckFields()) { // все поля заполнены корректно
								CustomUser::UserUpdate(array("UF_GROUPS" => array(1)));
								CModule::IncludeModule("iblock");
								$filter = Array	("UF_GROUPS" => 1);
								//$rsUsers = CUser::GetList(($by="timestamp_x"), ($order="desc"), $filter);
								//CIBlockElement::SetPropertyValues(1, 4, $rsUsers->NavRecordCount, "USERS");
								LocalRedirect("/group/1/".$backurl);
							} elseif(18 <= (date("Y") - date("Y",strtotime($CurentUser["PERSONAL_BIRTHDAY"])))) { // старше 18 лет, но не все поля заполнены
								CustomUser::UserUpdate(array("UF_YOU_HAVE_18" => true));
								if($_GET["message"] !== "checking_user_fields") {
									LocalRedirect("/group/1/?message=checking_user_fields".$backurl);
								}
							} elseif(18 > (date("Y") - date("Y",strtotime($CurentUser["PERSONAL_BIRTHDAY"])))) { // младше 18 лет
								CustomUser::UserUpdate(array("UF_YOU_HAVE_18" => false, "UF_DO_YOU_SMOKE" => false));
								if($_GET["message"] !== "you_are_under_18") {
									LocalRedirect("/group/1/?message=you_are_under_18".$backurl);
								}
							} else {
								echo "Какая-то другая ошибка";
							}
						} else { // ДатаРождения не заполнена
							if($_GET["message"] !== "birthday") {
								if($_SERVER["REQUEST_URI"] == "/group/1/u_concept/") $backurl="&backurl=/group/1/u_concept/";
								LocalRedirect("/group/1/?message=birthday".$backurl);
							}
						}
					} elseif(!empty($_GET["message"])) {
						LocalRedirect("/group/1/".$backurl);
					}
				} elseif(!empty($Dir[3]) && empty($_GET["POST_ID"]) && empty($backurl) && $Dir[4] !== "u_creative" && $Dir[3] !== "u_concept" && $Dir[3] !== "concept.ural2015") {
						LocalRedirect("/?backurl=".$_SERVER["REQUEST_URI"]);
				}
			}
		}
		if(!empty($_GET["backurl"]) && $USER->IsAuthorized() && empty($_GET["message"])) {
			LocalRedirect($_GET["backurl"]);
		}
	}
}
function onEpilog(){
    global $APPLICATION;
    $arPageProp = $APPLICATION->GetPagePropertyList();
    $arMetaPropName = array('og:title','og:description','og:image','og:type','og:url','fb:admins','fb:app_id');
    foreach ($arMetaPropName as $name){
	$key = mb_strtoupper($name, 'UTF-8');
        if (isset($arPageProp[$key])){
            $APPLICATION->AddHeadString('<meta property="'.$name.'" content="'.htmlspecialchars($arPageProp[$key]).'">',$bUnique=true);
        }
    }
}
function NWCommentsCounter(&$arFields)
{
	if($arFields["IBLOCK_ID"]==5)
	{
		$post_id_tmp = $arFields["PROPERTY_VALUES"]["OBJECT_ID"];
		$Res = 	CIBlockElement::GetByID($post_id_tmp);
		if ($arItem = $Res->GetNext()) {
			$infoblock_id_tmp = $arItem["IBLOCK_ID"];

			$res =CIBlockElement::GetProperty($infoblock_id_tmp,$post_id_tmp,Array(),Array("CODE" => "COMMENTS_COUNT"));
			$ob = $res->GetNext();
			CIBlockElement::SetPropertyValuesEx($post_id_tmp, false, Array("COMMENTS_COUNT"=>$ob["VALUE"]+1));

			/*$fr = fopen($_SERVER['DOCUMENT_ROOT']."/logg.txt", 'a');
				fputs($fr, "???".$post_id_tmp."???".$infoblock_id_tmp."^^^".var_export($res, true));
				fclose($fr);*/
		}
	}
	else if($arFields["IBLOCK_ID"]==6)
	{
		$post_id_tmp = $arFields["PROPERTY_VALUES"]["LIKE"]["n0"]["VALUE"];
		$Res = 	CIBlockElement::GetByID($post_id_tmp);
		if ($arItem = $Res->GetNext()) {
			$infoblock_id_tmp = $arItem["IBLOCK_ID"];

			$res =CIBlockElement::GetProperty($infoblock_id_tmp,$post_id_tmp,Array(),Array("CODE" => "LIKES"));
			$ob = $res->GetNext();
			CIBlockElement::SetPropertyValuesEx($post_id_tmp, false, Array("LIKES"=>$ob["VALUE"]+1));

			/*$fr = fopen($_SERVER['DOCUMENT_ROOT']."/logg.txt", 'a');
				fputs($fr, "???".$post_id_tmp."???".$infoblock_id_tmp."^^^".var_export($arFields, true));
				fclose($fr);*/
		}
	}
	else if($arFields["IBLOCK_ID"]==20)
	{
		include_once($_SERVER["DOCUMENT_ROOT"]."/tmp/phpqrcode/qrlib.php");
		QRcode::png("http://myqube.ru/QR/".$arFields["NAME"]."/", $_SERVER["DOCUMENT_ROOT"]."/upload/qr/qr_".$arFields["NAME"].".png", "L", 7, 7);
		$arLoadProductArray = Array(
		  "PREVIEW_PICTURE" => CFile::MakeFileArray($_SERVER["DOCUMENT_ROOT"]."/upload/qr/qr_".$arFields["NAME"].".png")
		  );
		$el = new CIBlockElement;
		$res_1 = $el->Update($arFields["ID"], $arLoadProductArray);
	}
}
function NWCommentsCounterDel($post_id_tmp)
{
	$Res = 	CIBlockElement::GetByID($post_id_tmp);
	if ($arItem = $Res->GetNext()) {
		$infoblock_id_tmp = $arItem["IBLOCK_ID"];
		$db_props = CIBlockElement::GetProperty($infoblock_id_tmp,$post_id_tmp);
		if($ar_props = $db_props->Fetch())
		{
			if($infoblock_id_tmp==6)
			{
				$arr_t=Array("CODE" => "LIKES");
				$str_t="LIKES";
			}
			else if($infoblock_id_tmp==5)
			{
				$arr_t=Array("CODE" => "COMMENTS_COUNT");
				$str_t="COMMENTS_COUNT";
			}
			if($infoblock_id_tmp==5 || $infoblock_id_tmp==6)
			{
				$post_id = $ar_props["VALUE"];
				$Res_1 = 	CIBlockElement::GetByID($post_id);
				if ($arItem_1 = $Res_1->GetNext()) {
					$res_1 =CIBlockElement::GetProperty($arItem_1["IBLOCK_ID"],$post_id,Array(),Array("CODE" => $str_t));
					$ob = $res_1->GetNext();

					/*$fr = fopen($_SERVER['DOCUMENT_ROOT']."/logg.txt", 'a');
					fputs($fr, "???".$post_id_tmp."!!!".$post_id."???".var_export($ob, true));
					fclose($fr);*/
				}
				CIBlockElement::SetPropertyValuesEx($post_id, false, Array($str_t=>max(intval($ob["VALUE"])-1,0)));
			}
		}
	}
}
class CustomUser {

	public static $TextError = "";

	public static function CheckBirthday($Date){
		return strtotime(date("d.m").".".(date("Y")-18)." ".date("H:i:s")) > strtotime($Date) ? 1 : 0;
	}

	function AddUserGroupClosedCommunity($Fields){
		if($Fields["USER_ID"] > 0 && $Fields["UF_YOU_HAVE_18"] == 1){
			if(CModule::IncludeModule("socialnetwork")){
				CSocNetUserToGroup::Add(
					array(
						"USER_ID" => $Fields["USER_ID"],
						"GROUP_ID" => 6,
						"ROLE" => SONET_ROLES_USER,
						"=DATE_CREATE" => $GLOBALS["DB"]->CurrentTimeFunction(),
						"=DATE_UPDATE" => $GLOBALS["DB"]->CurrentTimeFunction(),
						"INITIATED_BY_TYPE" => SONET_INITIATED_BY_USER,
						"INITIATED_BY_USER_ID" => 1,
						"MESSAGE" => false,
					)
				);
			}
		}
	}

	public static function UserYouHave18(){
		global $USER;
		$Query = CUser::GetList(
			($by="id"),
			($order="desc"),
			array("ID" => $USER->GetID()),
			array("SELECT"=>array("UF_YOU_HAVE_18"))
		)->Fetch();
		return $Query["UF_YOU_HAVE_18"] == 1 ? true : false;
	}

	public static function UserCheckFields($Fields = "", $Value = ""){
		global $USER;
		$Flag = false;
		$Query = self::SearchUser(
			array("ID" => $USER->GetID()),
			array("SELECT"=>array("PERSONAL_BIRTHDAY","UF_DO_YOU_SMOKE","UF_YOU_HAVE_18","UF_IAGREE"))
		);
		if($Fields != ""){
			if($Query[0][$Fields] == $Value){
				$Flag = true;
			}
		} else {
			if(
				$Query[0]["PERSONAL_BIRTHDAY"] != ""
				&&
				(date("Y")-date("Y",strtotime($Query[0]["PERSONAL_BIRTHDAY"]))) >= 18
				&&
				$Query[0]["UF_DO_YOU_SMOKE"] == 1
				&&
				$Query[0]["UF_YOU_HAVE_18"] == 1
				&&
				$Query[0]["UF_IAGREE"] == 1
			){
				$Flag = true;
			}
		}
		if(!$USER->IsAuthorized())
			$Flag = false;

		return $Flag;
	}

	public static function ExistenceUserLogin($Login = ""){
		$Query = CUser::GetByLogin($Login)->Fetch();
		return (empty($Query) ? 0 : $Query["ID"]);
	}

	public static function ExistenceVKProfile($Profile = ""){
		$sort_by = "ID";
		$sort_ord = "ASC";
		$arFilter = array(
		   "UF_VK_PROFILE" => $Profile
		);
		$dbUsers = CUser::GetList($sort_by, $sort_ord, $arFilter);
		while($arUser = $dbUsers->Fetch())
			$userID = $arUser["ID"];
		return (empty($userID) ? 0 : $userID);
	}

	public static function ExistenceFBProfile($Profile = ""){
		$sort_by = "ID";
		$sort_ord = "ASC";
		$arFilter = array(
		   "UF_FB_PROFILE" => $Profile
		);
		$dbUsers = CUser::GetList($sort_by, $sort_ord, $arFilter);
		while($arUser = $dbUsers->Fetch())
			$userID = $arUser["ID"];
		return (empty($userID) ? 0 : $userID);
	}

	public static function ExistenceGPProfile($Profile = ""){
		$sort_by = "ID";
		$sort_ord = "ASC";
		$arFilter = array(
		   "UF_GP_PROFILE" => $Profile
		);
		$dbUsers = CUser::GetList($sort_by, $sort_ord, $arFilter);
		while($arUser = $dbUsers->Fetch())
			$userID = $arUser["ID"];
		return (empty($userID) ? 0 : $userID);
	}

	public static function NewUser($Fields = array()){
		$User = new CUser;
		$Id = $User->Add($Fields);
		if(intval($Id) > 0) {
			CModule::IncludeModule("iblock");
			$el_log = new CIBlockElement;
			$PROP_log = array();
			$PROP_log["ID"] = $Id;
			$PROP_log["PERSONAL_BIRTHDAY"] = $Fields["PERSONAL_BIRTHDAY"];
			$PROP_log["UF_IAGREE"] = $Fields["UF_IAGREE"];
			$PROP_log["UF_YOU_HAVE_18"] = $Fields["UF_YOU_HAVE_18"];
			$PROP_log["UF_DO_YOU_SMOKE"] = $Fields["UF_DO_YOU_SMOKE"];
			$PROP_log["TYPE"] = "new_user";
			$arLoadProductArray_log = Array(
			  "IBLOCK_ID"      => 26,
			  "PROPERTY_VALUES"=> $PROP_log,
			  "NAME"           => $Id
			);
			$el_log->Add($arLoadProductArray_log);
			if($Fields["UF_AMBASSADOR"]) {
				$res = CIBlockElement::GetList(Array(), Array("IBLOCK_ID"=>20, "PROPERTY_AMBASSADOR"=>false, "ACTIVE"=>"Y"), false, Array("nTopCount"=>5), Array("ID"));
				while($ob = $res->GetNextElement()) {
					$arFields = $ob->GetFields();
					CIBlockElement::SetPropertyValues($arFields["ID"], 20, $Id, "AMBASSADOR");
				}
			}
			$Token = sha1($Id."".date("d.m.Y H:i:s"));
			global $APPLICATION;
			$APPLICATION->set_cookie("MQ_REGISTRATION_TOKEN", $Token, time()+60*60*24*30*12*4,"/");
			$Field["UF_TOKEN"] = $Token;
			$User->Update($Id,$Field);
			return $Id;
		} else
			return 0;
	}

	public static function UserUpdate($Fields = array()){
		global $USER;
		$User = new CUser;
		if($USER->IsAuthorized()){
			$User->Update($USER->GetID(),$Fields);
		}
		CModule::IncludeModule("iblock");
		$el_log = new CIBlockElement;
		$PROP_log = array();
		$PROP_log["ID"] = $USER->GetID();
		$PROP_log["PERSONAL_BIRTHDAY"] = $Fields["PERSONAL_BIRTHDAY"];
		$PROP_log["UF_IAGREE"] = $Fields["UF_IAGREE"];
		$PROP_log["UF_YOU_HAVE_18"] = $Fields["UF_YOU_HAVE_18"];
		$PROP_log["UF_DO_YOU_SMOKE"] = $Fields["UF_DO_YOU_SMOKE"];
		$PROP_log["TYPE"] = "user_update";
		$arLoadProductArray_log = Array(
		  "IBLOCK_ID"      => 26,
		  "PROPERTY_VALUES"=> $PROP_log,
		  "NAME"           => $USER->GetID()
		);
		$el_log->Add($arLoadProductArray_log);
	}

	public static function AnotherUserUpdate($id, $Fields = array()){
		global $USER;
		$User = new CUser;
		$res = $User->Update($id,$Fields);
		CModule::IncludeModule("iblock");
		$el_log = new CIBlockElement;
		$PROP_log = array();
		$PROP_log["ID"] = $id;
		$PROP_log["PERSONAL_BIRTHDAY"] = $Fields["PERSONAL_BIRTHDAY"];
		$PROP_log["UF_IAGREE"] = $Fields["UF_IAGREE"];
		$PROP_log["UF_YOU_HAVE_18"] = $Fields["UF_YOU_HAVE_18"];
		$PROP_log["UF_DO_YOU_SMOKE"] = $Fields["UF_DO_YOU_SMOKE"];
		$PROP_log["TYPE"] = "another_user_update";
		$arLoadProductArray_log = Array(
		  "IBLOCK_ID"      => 26,
		  "PROPERTY_VALUES"=> $PROP_log,
		  "NAME"           => $id
		);
		$el_log->Add($arLoadProductArray_log);
		return $res;
	}

	public static function SearchUser($Filter = array(),$Fields = array()){
		$Result = array();
		$Query = CUser::GetList(
			($by="id"),
			($order="desc"),
			$Filter,
			$Fields
		);
		while($Answer = $Query->Fetch()){
			$Result[] = $Answer;
		}
		return $Result;
	}

	public static function Set($Data){
		global $USER;
		if(!CModule::IncludeModule("iblock")){return false;}
		$Token = "";
		$User = new CUser;
		$NewElement = new CIBlockElement;
		$Id = 0;
		$Password = date("His");
		if(18 <= (date("Y") - date("Y",strtotime($Data["PERSONAL_BIRTHDAY"])))) {
			if($Data["INFO"] == 1){
				$Id = $NewElement->Add(array(
					"NAME" => date("d.m.Y H:i:s"),
					"IBLOCK_ID" => "19",
					"ACTIVE" => "Y",
					"PROPERTY_VALUES" => array(
						"120" => $Data["UF_FB"], //FB
						"121" => $Data["UF_G_PLUS"], //G+
						"122" => $Data["UF_VK"], //VK
						"117" => $Data["PERSONAL_BIRTHDAY"], //Дата рождения
						"114" => $Data["NAME"], //Имя
						"118" => $Data["UF_BRAND_1"], //Марка 1
						"119" => $Data["UF_BRAND_2"], //Марка 2
						"116" => $Data["EMAIL"], //Почта
						"115" => $Data["LAST_NAME"], //Фамилия
						"123" => $USER->GetID(), //Родитель
						"124" => $Data["PERSONAL_MOBILE"], //Мобильный телефон
						"125" => $Data["SOURSE"] //Источник данных app_staff или app_amplifier или web_staff или любая другая метка
					)
				));

				if(!intval($Id)){
					self::$TextError = $User->LAST_ERROR;
				}
				return (intval($Id) > 0 ? true : false);
			}

			$Fields = Array(
				"NAME" => $Data["NAME"],
				"LAST_NAME" => $Data["LAST_NAME"],
				"EMAIL" => $Data["EMAIL"],
				"LOGIN" => $Data["EMAIL"],
				"LID" => "ru",
				"ACTIVE" => "Y",
				"PERSONAL_BIRTHDAY" => $Data["PERSONAL_BIRTHDAY"],
				"UF_IAGREE" => $Data["UF_IAGREE"],
				"GROUP_ID" => array(3,4,5),
				"PASSWORD" => $Password,
				"CONFIRM_PASSWORD" => $Password,
				"PERSONAL_MOBILE" => $Data["PERSONAL_MOBILE"],
				"UF_YOU_HAVE_18" => $Data["UF_YOU_HAVE_18"],
				"UF_DO_YOU_SMOKE" => $Data["UF_DO_YOU_SMOKE"],
				"UF_GP_PROFILE" => $Data["UF_G_PLUS"],
				"UF_FB_PROFILE" => $Data["UF_FB"],
				"UF_VK_PROFILE" => $Data["UF_VK"],
				"UF_LATITUDE" => $Data["UF_LATITUDE"],
				"UF_LONGITUDE" => $Data["UF_LONGITUDE"],
				"UF_USER_PARENT" => $USER->GetID(),
				"UF_BRAND_1" => $Data["UF_BRAND_1"],
				"UF_BRAND_2" => $Data["UF_BRAND_2"],
				"UF_PASSWORD" => $Password,
				"UF_SOURSE" => $Data["SOURSE"],
				"UF_PRIVATE_MYPAGE" => 1,
				"UF_PRIVATE_MYFRIENDS" => 5,
				"UF_PRIVATE_MYGROUPS" => 9,
				"UF_GROUPS" => array(1)
			);

			$Id = $User->Add($Fields);
			if(intval($Id)){
				$el_log = new CIBlockElement;
				$PROP_log = array();
				$PROP_log["ID"] = $id;
				$PROP_log["PERSONAL_BIRTHDAY"] = $Fields["PERSONAL_BIRTHDAY"];
				$PROP_log["UF_IAGREE"] = $Fields["UF_IAGREE"];
				$PROP_log["UF_YOU_HAVE_18"] = $Fields["UF_YOU_HAVE_18"];
				$PROP_log["UF_DO_YOU_SMOKE"] = $Fields["UF_DO_YOU_SMOKE"];
				$PROP_log["TYPE"] = "set_user";
				$arLoadProductArray_log = Array(
				  "IBLOCK_ID"      => 26,
				  "PROPERTY_VALUES"=> $PROP_log,
				  "NAME"           => $id
				);
				$el_log->Add($arLoadProductArray_log);
				$Token = sha1($Id."".date("d.m.Y H:i:s"));
				$Fields["UF_TOKEN"] = $Token;
				$User->Update($Id,$Fields);
				self::$TextError = "Пользователь успешно добавлен.";
				$eventFields = array(
					"USER_ID" => $Id,
					"LOGIN" => $Data["EMAIL"],
					"EMAIL" => $Data["EMAIL"],
					"NAME" => $Data["NAME"],
					"LAST_NAME" => $Data["LAST_NAME"],
					"PASSWORD" => $Password,
					"TOKEN" => $Token
				);
				$userFields = $USER->GetByID($USER->GetID())->Fetch();
				if($Fields["UF_USER_PARENT"] == 29808 || $Fields["UF_USER_PARENT"] == 7813 || $Fields["UF_USER_PARENT"] == 43546 || $Fields["UF_USER_PARENT"] == 43562 || $Fields["UF_USER_PARENT"] == 43563 || $Fields["UF_USER_PARENT"] == 43547 || $Fields["UF_USER_PARENT"] == 43575 || $Fields["UF_USER_PARENT"] == 43731 || $Fields["UF_USER_PARENT"] == 43735 || $Fields["UF_USER_PARENT"] == 43551 || $Fields["UF_USER_PARENT"] == 43553 || $Fields["UF_USER_PARENT"] == 32177 || $Fields["UF_USER_PARENT"] == 32175 || $Fields["UF_USER_PARENT"] == 32176 || $Fields["UF_USER_PARENT"] == 32169 || $Fields["UF_USER_PARENT"] == 32173 || $Fields["UF_USER_PARENT"] == 32172 || $Fields["UF_USER_PARENT"] == 32174 || $Fields["UF_USER_PARENT"] == 32170) {
					CEvent::Send("registration", "s1", $eventFields);
				} elseif($userFields["PERSONAL_CITY"] == "Екатеринбург") {
					CEvent::Send("NEW_USER", "s1", $eventFields);
				} else {
					CEvent::Send("NEW_USER_NEW", "s1", $eventFields);
				}
			} else {
				self::$TextError = $User->LAST_ERROR;
			}
		}
		return (intval($Id) > 0 ? true : false);
	}
}
function getNumEnding($number, $endingArray) {
	$number = $number % 100;
	if ($number>=11 && $number<=19) {
		$ending=$endingArray[2];
	} else 	{
		$i = $number % 10;
		switch ($i)	{
			case (1): $ending = $endingArray[0]; break;
			case (2):	case (3):	case (4): $ending = $endingArray[1]; break;
			default: $ending=$endingArray[2];
		}
	}
	return $ending;
}
?>
