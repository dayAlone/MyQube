<?
	class MyQubeSocialAuth
	{
		private $network = '';
		private $code = '';
		private $token = '';
		private $settings = array();
		private $data = array();

		function __construct($network, $code)
		{
			$this->settings = MyQubeSocialAuth::getSettings($network);
			$this->network  = $network;
			$this->code     = $code;
			$this->token    = $this->getToken();
		}

		function getData() {
			if ($this->token) {
				$params = array(
					fields => $this->settings['fields'],
					access_token => $this->token
				);
				$curl = curl_init();
				curl_setopt($curl, CURLOPT_URL, $this->settings['dataUri'] . '?' . urldecode(http_build_query($params)));
				curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
				curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
				$data = json_decode(curl_exec($curl), true);
				switch ($this->network) {
					case 'vk':
						$data = $data['response'][0];
						$data['picture'] = $data['photo_big'];
						unset($data['photo_big']);
						$this->data = array_merge($this->data, $data);
						break;

					case 'facebook':
						$data['picture'] = $data['picture']['data']['url'];
						$this->data = array_merge($this->data, $data);
						break;
				}

				curl_close($curl);
				return $this->data;
			}
			return false;
		}

		private function getToken() {
			$params = array(
				'client_id'     => $this->settings['clientId'],
				'client_secret' => $this->settings['clientSecret'],
				'redirect_uri'  => 'http://'.$_SERVER['SERVER_NAME'].'/signup/'.$this->network.'/',
				'grant_type'    => 'authorization_code',
				'code'          => $this->code
			);
			$curl = curl_init();
			curl_setopt($curl, CURLOPT_URL, $this->settings['tokenUri']);
			curl_setopt($curl, CURLOPT_POST, 0);
			curl_setopt($curl, CURLOPT_POSTFIELDS, urldecode(http_build_query($params)));
			curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
			$result = json_decode(curl_exec($curl), true);
			$this->data = $result;
			if (is_array($result) && !$result['error']) return $result['access_token'];
		}

		static function getSettings($network) {
			$settings = array(
				facebook => array(
					clientId     => '974777605876398',
					clientSecret => 'b553b6ae0e23e093cea3bcd7cdbdc9c5',
					authUri      => 'https://www.facebook.com/dialog/oauth',
					tokenUri     => 'https://graph.facebook.com/v2.3/oauth/access_token',
					dataUri      => 'https://graph.facebook.com/me',
					scope        => 'email,user_birthday,publish_actions',
					fields       => 'id,age_range,email,first_name,last_name,birthday,picture.type(large)'
				),
				vk => array(
					clientId     => '5248591',
					clientSecret => 'CUYKlxAhs94WEiTKn861',
					authUri      => 'https://oauth.vk.com/authorize/',
					tokenUri     => 'https://oauth.vk.com/access_token',
					dataUri      => 'https://api.vk.com/method/users.get',
					scope        => 'email,user_birthday,publish_stream',
					fields       => 'uid,photo_big,email,first_name,last_name,bdate'

				),
				google => array(
					clientId     => '247902913440-bkocvmnoscqamblogttbjn0f3q966j74.apps.googleusercontent.com',
					clientSecret => 'sZV6ZSEFq8Oppd7xjg1YQhyh',
					authUri      => 'https://accounts.google.com/o/oauth2/auth',
					tokenUri     => 'https://accounts.google.com/o/oauth2/token',
					dataUri      => 'https://www.googleapis.com/plus/v1/people/me',
					scope        => 'https://www.googleapis.com/auth/plus.login',
					fields       => ''
				)
			);
			return $settings[$network];
		}

		static function getLink($network) {
			$settings = MyQubeSocialAuth::getSettings($network);
			$params = array(
				redirect_uri  => 'http://'.$_SERVER['SERVER_NAME'].'/signup/'.$network.'/',
				response_type => 'code',
				client_id     => $settings['clientId'],
				scope         => $settings['scope'],
				display       => 'popup'
			);
			$href = $settings['authUri'] . '?' . urldecode(http_build_query($params));
			return $href;
		}
	}
