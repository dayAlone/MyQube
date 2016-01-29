<?class CustomFBAuth{

	function SetClientId($id){
		$this->client_id = $id;
	}
	function SetClientSecret($secret){
		$this->client_secret = $secret;
	}
	function SetAuthUri($uri){
		$this->auth_uri = $uri;
	}
	function SetRedirectUri($uri){
		$this->redirect_uri = $uri;
	}
	function SetTokenUri($uri){
		$this->token_uri = $uri;
	}
	function SetDataUri($uri){
		$this->data_uri = $uri;
	}

	function GetLink(){
		$url = $this->auth_uri;
		$params = array(
			'redirect_uri'  => $this->redirect_uri,
			'client_id'     => $this->client_id,
			'scope' => 'email,user_birthday,publish_actions',
			'display' => 'popup'
		);
		$href = $url . '?' . urldecode(http_build_query($params));
		return $href;
	}

	function GetToken($GET){
		$result = false;
		$params = array(
			'client_id'     => $this->client_id,
			'client_secret' => $this->client_secret,
			'redirect_uri'  => $this->redirect_uri,
			'code' => $GET["code"]
		);
		$url = $this->token_uri;
		$curl = curl_init();
		curl_setopt($curl, CURLOPT_URL, $url);
		curl_setopt($curl, CURLOPT_POST, 0);
		curl_setopt($curl, CURLOPT_POSTFIELDS, urldecode(http_build_query($params)));
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
		$result = curl_exec($curl);
		curl_close($curl);
		$this->token = json_decode($result, true);
	}

	function GetData($fields = array()){
		$tokenInfo = $this->token;
		$data = array();
		if (isset($tokenInfo['access_token'])) {
			if(!empty($fields)){
				$this->params['fields'] = implode(",",$fields);
			}
			$this->params['access_token'] = $tokenInfo['access_token'];
			$tmpUrl = $this->data_uri . '?' . urldecode(http_build_query($this->params));
			$curl = curl_init();
			curl_setopt($curl, CURLOPT_URL, $tmpUrl);
			curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
			$userInfo = curl_exec($curl);
			curl_close($curl);
		}
		return json_decode($userInfo);
	}
	function UploadAvatar($Url = "",$Folder = "",$FileName = 0,$type = 0){
		$NewAvatar = array();
		if(strlen($Url) > 0){
			if($type == 0){
				$Url = "http://".parse_url($Url, PHP_URL_HOST).parse_url($Url, PHP_URL_PATH);
			} elseif($type == 1){
				$Url = "https://graph.facebook.com/".$Url."/picture?type=large";
			}

			$Avatar = file_get_contents($Url);
			$AvatarPach = $_SERVER["DOCUMENT_ROOT"]."/upload/".$Folder.$FileName.".jpg";
			file_put_contents($AvatarPach, $Avatar);
			if(file_exists($AvatarPach)){
				$NewAvatar = CFile::MakeFileArray($AvatarPach);
			}
		}
		return $NewAvatar;
	}
}

if($_GET["backurl"]) {
	require_once($_SERVER['DOCUMENT_ROOT']."/bitrix/modules/main/include/prolog_before.php");
	global $APPLICATION;
	$backurl = $APPLICATION->get_cookie("MQ_BACKURL");
	if($backurl !== $_GET["backurl"])
		$APPLICATION->set_cookie("MQ_BACKURL", $_GET["backurl"], time()+60,"/");
}

$CustomFBAuth = new CustomFBAuth;
$CustomFBAuth->SetClientId('974777605876398');
$CustomFBAuth->SetClientSecret('b553b6ae0e23e093cea3bcd7cdbdc9c5');
$CustomFBAuth->SetAuthUri('https://www.facebook.com/dialog/oauth');
$CustomFBAuth->SetRedirectUri('http://'.$_SERVER['SERVER_NAME'].'/facebook.php');
$CustomFBAuth->SetTokenUri('https://graph.facebook.com/v2.3/oauth/access_token');
$CustomFBAuth->SetDataUri('https://graph.facebook.com/me');

if(!empty($_GET) && !isset($_GET["backurl"])){
	require_once($_SERVER['DOCUMENT_ROOT']."/bitrix/modules/main/include/prolog_before.php");
	global $USER;

	$CustomFBAuth->GetToken($_GET);
	$UserDate = $CustomFBAuth->GetData(array("id","age_range","email","first_name","last_name","birthday"));

	if($UserDate->id != ""){
		if($USER->IsAuthorized()){
			$Fields = array("UF_FB_PROFILE" => array($UserDate->id),"UF_AUTH_SOCNET"=>"1");
			$Fields["PERSONAL_PHOTO"] = $CustomFBAuth->UploadAvatar($UserDate->id,"facebook_avatar/",$UserDate->id,1);
			if($Fields["PERSONAL_PHOTO"]["type"] == "inode/x-empty")
				$Fields["PERSONAL_PHOTO"] = "";
			if(empty($Fields["PERSONAL_PHOTO"]))
				$Fields["PERSONAL_PHOTO"] = CFile::MakeFileArray($_SERVER["DOCUMENT_ROOT"]."/images/user_photo.png");
			CustomUser::UserUpdate($Fields);
		} else {
			$FBProfile = CustomUser::ExistenceFBProfile($UserDate->id);
			if($FBProfile > 0){
				$USER->Authorize($FBProfile);
			} else {
				$Fields = array(
					"NAME" => $UserDate->first_name,
					"LAST_NAME" => $UserDate->last_name,
					"LOGIN" => "FB_".$UserDate->id,
					"EMAIL" => $UserDate->email != "" ? $UserDate->email : $UserDate->id."kentlabemail@gmail.com",
					"LID" => "ru",
					"ACTIVE" => "Y",
					"GROUP_ID" => array(3,4,5),
					"PASSWORD" => $UserDate->id,
					"CONFIRM_PASSWORD" => $UserDate->id,
					"UF_YOU_HAVE_18" => 0,
					"UF_AUTH_SOCNET" => 1,
					"UF_FB_PROFILE" => array($UserDate->id),
					"UF_PRIVATE_MYPAGE" => 1,
					"UF_PRIVATE_MYFRIENDS" => 5,
					"UF_PRIVATE_MYGROUPS" => 9,
					"UF_INVITE_STATUS" => 1
				);

				$Fields["PERSONAL_PHOTO"] = $CustomFBAuth->UploadAvatar($UserDate->id,"facebook_avatar/",$UserDate->id,1);
				if($Fields["PERSONAL_PHOTO"]["type"] == "inode/x-empty")
					$Fields["PERSONAL_PHOTO"] = "";
				if(empty($Fields["PERSONAL_PHOTO"]))
					$Fields["PERSONAL_PHOTO"] = CFile::MakeFileArray($_SERVER["DOCUMENT_ROOT"]."/images/user_photo.png");

				if(!empty($UserDate->age_range->min)){
					if($UserDate->age_range->min >= 18){
						$Fields["UF_YOU_HAVE_18"] = 1;
					} else {
						$Fields["PERSONAL_BIRTHDAY"] = date("d.m").".".(date("Y")-$UserDate->age_range->min);
					}
				}
				global $APPLICATION;
				$cookieToken = $APPLICATION->get_cookie("MQ_REGISTRATION_TOKEN");
				$ambassador = $APPLICATION->get_cookie("MQ_AMBASSADOR");
				if($ambassador) {
					$Fields["UF_AMBASSADOR"] = 1;
					$APPLICATION->set_cookie("MQ_AMBASSADOR", 0, time()-60,"/");
				}
				if($cookieToken) {
					$sort_by = "ID";
					$sort_ord = "ASC";
					$arFilter = array(
					   "UF_TOKEN" => $cookieToken
					);
					$dbUsers = $USER->GetList($sort_by, $sort_ord, $arFilter);
					while($arUser = $dbUsers->Fetch())
						$UserIdByToken = $arUser["ID"];
					if($UserIdByToken) {
						$UserId = $UserIdByToken;
						$Fields = array();
						$Fields["UF_INVITE_STATUS"] = 1;
						$Fields["UF_STATUS"] = 31;
					} else {
						$UserId = CustomUser::NewUser($Fields);
					}
				} else {
					$UserId = CustomUser::NewUser($Fields);
				}
				if($UserId > 0){
					/*
					if($Fields["UF_YOU_HAVE_18"] == 1){
						CustomUser::AddUserGroupClosedCommunity(array("USER_ID"=> $UserId,"UF_YOU_HAVE_18" => 1));
					}
					*/
					$USER->Authorize($UserId);
					$Fields["UF_FB_PROFILE"] = array($UserDate->id);
					CustomUser::UserUpdate($Fields);

					if($ambassador) {
						$arGroups = CUser::GetUserGroup($UserId);
						$arGroups[] = 13;
						CUser::SetUserGroup($UserId, $arGroups);
					}
				}
			}
		}
	}
	if(strripos($_SERVER['HTTP_USER_AGENT'],"iphone") || strripos($_SERVER['HTTP_USER_AGENT'],"android") || strripos($_SERVER['HTTP_USER_AGENT'],"ipod") || strripos($_SERVER['HTTP_USER_AGENT'],"windows phone")) {
		$backurl = $APPLICATION->get_cookie("MQ_BACKURL");
		if($backurl)
			$APPLICATION->set_cookie("MQ_BACKURL", "", time(),"/");
		LocalRedirect('http://'.$_SERVER['SERVER_NAME']."/?backurl=".$backurl);
	} else {
		echo "<script type=\"text/javascript\">window.close();</script>";
	}
	require_once($_SERVER['DOCUMENT_ROOT']."/bitrix/modules/main/include/epilog_after.php");
} else {
	echo $CustomFBAuth->GetLink();
}?>
