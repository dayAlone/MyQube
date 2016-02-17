<pre>
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
			var_dump($data);
			
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

				$ID = false;

				// Подготавливаем поля для регистрации

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
						'PERSONAL_CITY'        => 123,
						'PERSONAL_PHOTO'       => CFile::MakeFileArray($data['picture']),
						'PERSONAL_BIRTHDAY'    => isset($data['bdate']) ? $data['bdate'] : '',
						'UF_AMBASSADOR'        => $APPLICATION->get_cookie("MQ_AMBASSADOR") ? 1 : false,
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
					}
				}


				//var_dump($fields);
				/*

				 else if (strlen($data['email']) > 0) {

				}*/
			} else {
				$result['url'] = '/signup/error/';
			}

			echo json_encode($result, JSON_UNESCAPED_UNICODE);

			break;

		default:
			?><a href='<?=MyQubeSocialAuth::getLink('google')?>'>google</a><br/><?
			?><a href='<?=MyQubeSocialAuth::getLink('vk')?>'>vkontakte</a><br/><?
			?><a href='<?=MyQubeSocialAuth::getLink('facebook')?>'>facebook</a><br/><?
			break;
	}

?>
</pre>
