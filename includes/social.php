<?
	class MyQubeSocialAuth
	{
		private $network  = '';
		private $code     = '';
		private $token    = '';
		private $settings = array();
		private $data     = array();

		function __construct($network, $code) {
			$this->settings = MyQubeSocialAuth::getSettings($network);
			$this->network  = $network;
			$this->code     = $code;
			$this->token    = $this->getToken();
		}

		function getData() {
			if ($this->token) {
				$params = array(
					fields       => $this->settings['fields'],
					access_token => $this->token
				);
				$curl = curl_init();
				curl_setopt($curl, CURLOPT_URL, $this->settings['dataUri'] . '?' . urldecode(http_build_query($params)));
				curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
				curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
				$data = json_decode(curl_exec($curl), true);
				switch ($this->network) {
					case 'vk':
						$data            = $data['response'][0];
						$data['picture'] = $data['photo_big'];
						$data['id']      = $data['uid'];
						$data['city']    = $data['home_town'];
						$data['gender']  =  intval($data['sex']) == 0 ? false : intval($data['sex']) == 2 ? 'M' : 'F';

						unset($data['photo_big'], $data['user_id'], $data['home_town'], $data['sex']);
						break;

					case 'facebook':
						$data['picture'] = $data['picture']['data']['url'];
						$data['city']    = $data['hometown'] ? $data['hometown'] : $data['location']['name'] ? $data['location']['name'] : false;
						$data['gender']  = strlen($data['gender']) == 0 ? false : $data['gender'] == 'male' ? 'M' : 'F';
						unset($data['hometown'], $data['location']);
						break;
					case 'google':
						$data['picture']    = $data['image']['url'];
						$data['email']      = $data['emails'][0]['value'];
						$data['first_name'] = $data['name']['givenName'];
						$data['last_name']  = $data['name']['familyName'];
						$data['age_range']  = $data['ageRange'];
						$data['gender']     = strlen($data['gender']) == 0 ? false : $data['gender'] == 'male' ? 'M' : 'F';
						$data['city']       = is_array($data['placesLived']) && count($data['placesLived']) > 0 ? $data['placesLived'][0]['value'] : false;
						unset($data['emails'], $data['image'], $data['name'], $data['ageRange'], $data['placesLived']);
						break;
				}
				$this->data = array_merge($this->data, $data);
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
				'facebook' => array(
					'clientId'     => '974777605876398',
					'clientSecret' => 'b553b6ae0e23e093cea3bcd7cdbdc9c5',
					'authUri'      => 'https://www.facebook.com/dialog/oauth',
					'tokenUri'     => 'https://graph.facebook.com/v2.3/oauth/access_token',
					'dataUri'      => 'https://graph.facebook.com/me',
					'scope'        => 'email,user_birthday,publish_actions,user_location,user_hometown',
					'fields'       => 'id,age_range,email,first_name,last_name,birthday,picture.type(large),hometown,location,gender'
				),
				'vk' => array(
					'clientId'     => '5002353',
					'clientSecret' => 'C5Pxo5vrnz8kPOwkscrl',
					'authUri'      => 'https://oauth.vk.com/authorize/',
					'tokenUri'     => 'https://oauth.vk.com/access_token',
					'dataUri'      => 'https://api.vk.com/method/users.get',
					'scope'        => 'email,user_birthday,publish_stream',
					'fields'       => 'uid,photo_big,email,first_name,last_name,bdate,home_town,sex'

				),
				'google' => array(
					'clientId'     => '247902913440-bkocvmnoscqamblogttbjn0f3q966j74.apps.googleusercontent.com',
					'clientSecret' => 'sZV6ZSEFq8Oppd7xjg1YQhyh',
					'authUri'      => 'https://accounts.google.com/o/oauth2/auth',
					'tokenUri'     => 'https://accounts.google.com/o/oauth2/token',
					'dataUri'      => 'https://www.googleapis.com/plus/v1/people/me',
					'scope'        => 'https://www.googleapis.com/auth/plus.login https://www.googleapis.com/auth/plus.me https://www.googleapis.com/auth/userinfo.email https://www.googleapis.com/auth/userinfo.profile',
					'fields'       => 'aboutMe,ageRange,birthday,currentLocation,emails/value,id,image/url,name(familyName,givenName),placesLived/value,gender'
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
?>
