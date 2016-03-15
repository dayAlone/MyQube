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

				// Сказала ли соц сеть что пользователь восемнадцатилетний
				$have18 = false;
				if (isset($data['age_range']) && ($data['age_range']['min'] >= 18 || $data['age_range']['max'] >= 18)) $have18 = true;
				if (isset($data['bdate']) && strtotime($data['bdate']) < strtotime('-18 years'))  $have18 = true;


				$ID = $USER->IsAuthorized() ? $USER->GetID() : false;
				$shorts = array('facebook'=>'FB', 'vk'=>'VK', 'google'=>'GP');
				$token = sha1($ID."".date("d.m.Y H:i:s"));

				if (!$ID && $APPLICATION->get_cookie("MQ_REGISTRATION_TOKEN")) {

					// Вход по текену из приложения

					$userByAppToken = CUser::GetList(
						($by='id'),
						($order='desc'),
						array('UF_TOKEN' => $APPLICATION->get_cookie("MQ_REGISTRATION_TOKEN")),
						array('FIELDS' => array('ID'))
						)->Fetch();
					if (intval($userByAppToken['ID']) > 0) {
						$ID = $userByAppToken['ID'];
					}
				}

				if (!$ID && $APPLICATION->get_cookie("MQ_AUTH_TOKEN")) {

					// Вход по текену из куков

					$userByAuthToken = CUser::GetList(
						($by='id'),
						($order='desc'),
						array('UF_AUTH_TOKEN' => $APPLICATION->get_cookie("MQ_AUTH_TOKEN")),
						array('FIELDS' => array('ID'))
						)->Fetch();
					if (intval($userByAuthToken['ID']) > 0) {
						$ID = $userByAuthToken['ID'];
					} else {
						$APPLICATION->set_cookie("MQ_AMBASSADOR", 0, time() - 60, "/");
					}
				}

				if (!$ID) {

					// Поиск по эл. почте

					$userByEmail = CUser::GetList(
						($by='id'),
						($order='desc'),
						array('EMAIL' => $data['email']),
						array('FIELDS' => array('ID'))
						)->Fetch();

					if (intval($userByEmail['ID']) > 0) {
						$ID = $userByEmail['ID'];
					}

				}

				if (!$ID || $USER->IsAuthorized()) {

					// Поиск по соц. сети

					$userBySocial = CUser::GetList(
						($by='id'),
						($order='desc'),
						array('UF_'.$shorts[$_REQUEST['action']].'_PROFILE' => $data['id']),
						array('FIELDS' => array('ID'))
						)->Fetch();

					if (intval($userBySocial['ID']) > 0) {
						if ($USER->IsAuthorized()) {

							// Проверка прикрепленного аккаунта
							if ($userBySocial['ID'] !== $ID) {

								$result = array_merge($result, array(
									'error' => 'Пользователь данной социальной сети уже зарегистрирован на&nbsp;сайте'
								));
							}

						} else {
							$ID = $userBySocial['ID'];
						}
					}

				}

				if (!$ID) {

					// Подготавливаем поля для регистрации

					$fields = array(
						'NAME'                 => $data['first_name'],
						'LAST_NAME'            => $data['last_name'],
						'LOGIN'                => $shorts[$_REQUEST['action']].'_'.$data['id'],
						'EMAIL'                => $data['email'],
						'LID'                  => 'ru',
						'ACTIVE'               => 'Y',
						'GROUP_ID'             => array(3, 4, 5),
						'PASSWORD'             => md5($data['id']),
						'CONFIRM_PASSWORD'     => md5($data['id']),
						'PERSONAL_CITY'        => $data['city'],
						'PHOTO'                => $data['picture'],
						'PERSONAL_PHOTO'       => strlen($data['picture']) > 0 ? CFile::MakeFileArray($data['picture']) : false,
						'PERSONAL_BIRTHDAY'    => isset($data['bdate']) ? $data['bdate'] : '',
						'PERSONAL_GENDER'      => $data['gender'],
						'UF_YOU_HAVE_18'       => $have18 ? 1 : 0,
						'UF_AUTH_SOCNET'       => 1,
						'UF_PRIVATE_MYPAGE'    => 1,
						'UF_PRIVATE_MYFRIENDS' => 5,
						'UF_PRIVATE_MYGROUPS'  => 9,
						'UF_INVITE_STATUS'     => 1,
						'UF_AMBASSADOR'        => $APPLICATION->get_cookie("MQ_AMBASSADOR") ? 1 : false,
						'UF_TOKEN'             => $token,
						'UF_'.$shorts[$_REQUEST['action']].'_PROFILE' => $data['id'],
					);

					if ($have18) {
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
									'url' => '/',
									'error' => htmlspecialchars(strip_tags($raw->LAST_ERROR))
								));
							}

						}
					} else {
						$result['url'] = '/signup/lock/';
					}

				}

				if ($ID && !isset($result['error'])) {

					if (!$have18) {

						// Если соц. сеть вдруг вернула возраст меньше 18, то деактевируем пользователя

						$result['url'] = '/signup/lock/';

						$user = new CUser;
						$user->Update($ID, array('ACTIVE' => 'N', 'UF_YOU_HAVE_18' => 0));


					} else {


						$user = CUser::GetByID($ID)->Fetch();
						$accounts = $user['UF_'.$shorts[$_REQUEST['action']].'_PROFILE'];

						// Объединяем несколько аккаунтов соц сетей (а вдруг)

						if (count($accounts) > 0 && intval($accounts[0]) > 0) {
							$fields = array(
								'UF_'.$shorts[$_REQUEST['action']].'_PROFILE' => array_unique(array_merge(array($data['id']), $accounts)),
								'UF_AUTH_SOCNET' => 1
							);
						} else {
							$fields = array(
								'UF_'.$shorts[$_REQUEST['action']].'_PROFILE' => array($data['id']),
								'UF_AUTH_SOCNET' => 1
							);
						}

						// Заменяем почту, если она есть

						if (strlen($data['email']) > 0 && (strstr($user['EMAIL'], '@xyz.xyz') || strstr($user['LOGIN'], '@xyz.xyz'))) {
							$email = CUser::GetList(($by="id"), ($order="desc"), array('EMAIL' => $data['email']))->Fetch();
							$login = CUser::GetList(($by="id"), ($order="desc"), array('LOGIN' => $data['email']))->Fetch();
							if (!$exist) {
								$fields['EMAIL'] = $data['email'];
								$fields['LOGIN'] = $data['email'];
							}
						}


						if ($user['ACTIVE'] === 'Y') {

							// Авторизация

							if (!$USER->IsAuthorized()) $USER->Authorize($ID, true);

							if($USER->IsAuthorized()) {

								$result['auth'] = true;

								// Тут что-то обновляется неведомое от старого сайта

								/*
								if ($APPLICATION->get_cookie("MQ_REGISTRATION_TOKEN")) {
									$fields = array_merge($fields, array(
										'UF_INVITE_STATUS' => 1,
										'UF_STATUS' => 31
									));
								}
								*/

								if (!$APPLICATION->get_cookie("MQ_AUTH_TOKEN")) {
									$APPLICATION->set_cookie("MQ_AUTH_TOKEN", $token, time() + 60 * 60 * 24 * 30 * 12 * 4,"/");
									$fields = array_merge($fields, array(
										'UF_AUTH_TOKEN' => $token
									));
								}

								if ($APPLICATION->get_cookie("MQ_AMBASSADOR"))  {
									$APPLICATION->set_cookie("MQ_AMBASSADOR", 0, time() - 60, "/");
									CUser::SetUserGroup($ID, array_merge(array(13), CUser::GetUserGroup($ID)));
								}
							}
						} else {

							$result['url'] = '/signup/lock/';

						}

						$user = new CUser;

						$user->Update($ID, $fields);

					}

				}

			} else {
				$result['url'] = '/';
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

			// Уточнение возраста

			require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
			if ($USER->IsAuthorized()) LocalRedirect('/');
			$APPLICATION->SetPageProperty("page_class", "page--age page--clean");
			$APPLICATION->IncludeComponent("bitrix:main.register",
				"age",
				Array(
		            "USER_PROPERTY_NAME" => "",
		            "SEF_MODE"           => "Y",
		            "SHOW_FIELDS"        => Array("NAME", "LAST_NAME", "LOGIN", "EMAIL", "GROUP_ID", "PASSWORD", "CONFIRM_PASSWORD", "PERSONAL_CITY", "PERSONAL_PHOTO", "PERSONAL_BIRTHDAY", "PERSONAL_GENDER", "PHOTO"),
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
		case 'lock':

			// Сообщение для несовершеннолетних

			require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
			$APPLICATION->SetPageProperty("page_class", "page--lock page--clean");
			?>
			<div class="lock qblock">
		      <div class="qblock__content"><img src="/layout/images/svg/logo-full.svg" alt="" class="lock__logo"><br><img src="/layout/images/svg/lock-enter.svg" alt="" width="109" class="lock__icon">
		        <p>
		          К сожалению, социальная сеть MyQube открыта<br/>
		          только для совершеннолетних.<br/>
		          <a href='/'>Перейти на главную страницу</a>

		        </p>
		        <div class="lock__footer qblock__footer">
		          <? include($_SERVER['DOCUMENT_ROOT'] . '/includes/footer.php') ?>
		        </div>
		      </div>
		    </div>
			<?
			break;
		default:
			//LocalRedirect('/');
			?><a href='<?=MyQubeSocialAuth::getLink('google')?>'>google</a><br/><?
			?><a href='<?=MyQubeSocialAuth::getLink('vk')?>'>vkontakte</a><br/><?
			?><a href='<?=MyQubeSocialAuth::getLink('facebook')?>'>facebook</a><br/><?
			break;
	}

?>
