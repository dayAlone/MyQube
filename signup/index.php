<?
	error_reporting( E_ALL);
	require_once($_SERVER['DOCUMENT_ROOT'].'/bitrix/modules/main/include/prolog_before.php');
	require_once($_SERVER['DOCUMENT_ROOT'].'/includes/social.php');

	switch ($_REQUEST['action']) {
		case 'facebook':
		case 'vk':
		case 'google':

			// Получаем данные из соц. сетей
			$api    = new MyQubeSocialAuth($_REQUEST['action'], $_REQUEST['code']);
			$data   = $api->getData();
			$result = array('auth'=> false);

			if ($data) {


				$ID = false;
				$shorts = array('facebook'=>'FB', 'vk'=>'VK', 'google'=>'GP');

				if ($APPLICATION->get_cookie("MQ_REGISTRATION_TOKEN")) {

					// Вход по текену из куков

					$userByToken = CUser::GetList(
						($by='id'),
						($order='desc'),
						array('UF_TOKEN' => $APPLICATION->get_cookie("MQ_REGISTRATION_TOKEN")),
						array('FIELDS' => array('ID', 'EMAIL', 'UF_'.$shorts[$_REQUEST['action']].'_PROFILE'))
						)->Fetch();
					if (intval($userByToken['ID']) > 0) {
						$ID = $userByToken['ID'];
					}
				} else {

					// Поиск по эл. почте или ID из соц. сети

					$userByEmail = CUser::GetList(
						($by='id'),
						($order='desc'),
						array(
							array(
								'LOGIC' => 'OR',
					        	array('EMAIL' => $data['email']),
					        	array('UF_'.$shorts[$_REQUEST['action']].'_PROFILE' => $data['id'])
							)
						),
						array('FIELDS' => array('ID', 'EMAIL', 'UF_'.$shorts[$_REQUEST['action']].'_PROFILE'))
						)->Fetch();
					if (intval($userByEmail['ID']) > 0) {
						$ID = $userByEmail['ID'];
					}
				}

				// Подготавливаем поля для регистрации
				var_dump($data);
				die();
				if (!$ID) {
					$fields = array(
						'NAME'                 => $data['first_name'],
						'LAST_NAME'            => $data['last_name'],
						'LOGIN'                => $data['email'],
						'EMAIL'                => $data['email'],
						'LID'                  => 'ru',
						'ACTIVE'               => 'Y',
						'GROUP_ID'             => array(3, 4, 5),
						'PASSWORD'             => md5($data['id']),
						'CONFIRM_PASSWORD'     => md5($data['id']),
						'UF_YOU_HAVE_18'       => isset($data['age_range']) && $data['age_range']['min'] >= 18 ? 1 : strtotime($data['bdate']) < strtotime('-18 years') ? 1 : 0,
						'UF_AUTH_SOCNET'       => 1,
						'UF_PRIVATE_MYPAGE'    => 1,
						'UF_PRIVATE_MYFRIENDS' => 5,
						'UF_PRIVATE_MYGROUPS'  => 9,
						'UF_INVITE_STATUS'     => 1,
						'PERSONAL_CITY'        => $data['city'],
						'PERSONAL_PHOTO'       => strlen($data['picture']) > 0 ? CFile::MakeFileArray($data['picture'])['tmp_name'] : false,
						'PERSONAL_BIRTHDAY'    => isset($data['bdate']) ? $data['bdate'] : '',
						'UF_AMBASSADOR'        => $APPLICATION->get_cookie("MQ_AMBASSADOR") ? 1 : false,
						'PERSONAL_GENDER'      => $data['gender'],
						'UF_'.$shorts[$_REQUEST['action']].'_PROFILE' => $data['id'],
					);
					if ($fields['UF_YOU_HAVE_18'] > 0) {
						if (strlen($fields['PERSONAL_BIRTHDAY']) === 0) {
							$result = array_merge($result, array(
								'fields' => $fields,
								'url' => '/signup/age/'
							));
						} else {

							// Регистрация совершеннолетнего пользователя

							$raw = new CUser;
							$ID = $raw->Add($fields);

							if (!$ID) {
								$result = array_merge($result, array(
									'url' => '/signup/error/',
									'error' => htmlspecialchars(strip_tags($raw->LAST_ERROR))
								));
							}

						}
					} else {
						$result['url'] = '/signup/lock/';
					}

				}

				if ($ID) {
					$USER->Authorize($ID);
					if($USER->IsAuthorized()) {

						$result['auth'] = true;

						// Тут что-то обновляется неведомое от старого сайта
						/*
						$fields = array(
							'UF_'.$shorts[$_REQUEST['action']].'_PROFILE' => $data['id']
						);
						if ($APPLICATION->get_cookie("MQ_REGISTRATION_TOKEN")) {
							$fields = array_merge($fields, array(
								'UF_INVITE_STATUS' => 1,
								'UF_STATUS' => 31
							));
						}
						CUser:Update($ID, array($fields));

						if ($APPLICATION->get_cookie("MQ_AMBASSADOR"))  {
							$APPLICATION->set_cookie("MQ_AMBASSADOR", 0, time() - 60, "/");
							CUser::SetUserGroup($UserId, array_merge(array(13), CUser::GetUserGroup($ID)));
						}
						*/
					}
				}

			} else {
				$result['url'] = '/signup/error/';
			}
			?>
			<script type="text/javascript">
				if(window.opener) {
					window.opener.postMessage(<?=json_encode($result, JSON_UNESCAPED_UNICODE)?>, '*');
			  	}
			</script>
			<?
			break;


		case 'age':
			//{"NAME":"Andrey","LAST_NAME":"Kolmakov","LOGIN":"code_red@mail.ru","EMAIL":"code_red@mail.ru","LID":"ru","ACTIVE":"Y","GROUP_ID":[3,4,5],"PASSWORD":"1badd63eeb04408a60aa7da14aca0bc6","CONFIRM_PASSWORD":"1badd63eeb04408a60aa7da14aca0bc6","UF_YOU_HAVE_18":1,"UF_AUTH_SOCNET":1,"UF_PRIVATE_MYPAGE":1,"UF_PRIVATE_MYFRIENDS":5,"UF_PRIVATE_MYGROUPS":9,"UF_INVITE_STATUS":1,"PERSONAL_CITY":false,"PERSONAL_PHOTO":{"name":"1378371_10202314149880939_392229151_n.jpg","size":6034,"tmp_name":"/Users/slider/Documents/Projec'... (length=693)
			require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");

			$APPLICATION->SetPageProperty("page_class", "page--age page--clean");
			$APPLICATION->IncludeComponent("bitrix:main.register",
				"age",
				Array(
		            "USER_PROPERTY_NAME" => "",
		            "SEF_MODE"           => "Y",
		            "SHOW_FIELDS"        => Array("NAME", "LAST_NAME", "LOGIN", "EMAIL", "GROUP_ID", "PASSWORD", "CONFIRM_PASSWORD", "PERSONAL_CITY", "PERSONAL_PHOTO", "PERSONAL_BIRTHDAY", "PERSONAL_GENDER"),
		            "REQUIRED_FIELDS"    => Array("NAME"),
		            "AUTH"               => "Y",
		            "USE_BACKURL"        => "Y",
		            "USE_CAPTCHA"        => "N",
		            "SUCCESS_PAGE"       => $_REQUEST['backurl'],
		            "SET_TITLE"          => "N",
		            "USER_PROPERTY"      => Array('UF_YOU_HAVE_18', 'UF_AUTH_SOCNET', 'UF_PRIVATE_MYPAGE', 'UF_PRIVATE_MYFRIENDS', 'UF_PRIVATE_MYGROUPS', 'UF_INVITE_STATUS', 'UF_AMBASSADOR', 'UF_FB_PROFILE'),
					"SEF_FOLDER"         => "/",
		            "VARIABLE_ALIASES"   => Array()
		        )
		    );
			break;
		default:
			?><a href='<?=MyQubeSocialAuth::getLink('google')?>'>google</a><br/><?
			?><a href='<?=MyQubeSocialAuth::getLink('vk')?>'>vkontakte</a><br/><?
			?><a href='<?=MyQubeSocialAuth::getLink('facebook')?>'>facebook</a><br/><?
			break;
	}

?>
