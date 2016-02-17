<?
	require_once($_SERVER['DOCUMENT_ROOT']."/bitrix/modules/main/include/prolog_before.php");
	require_once($_SERVER['DOCUMENT_ROOT'].'/includes/social.php');

	switch ($_REQUEST['action']) {
		case 'facebook':
		case 'vk':
			$api = new MyQubeSocialAuth($_REQUEST['action'], $_REQUEST['code']);
			var_dump($api->getData());
			echo '<a href="/signup/">signup</a>';
			break;

		default:
			?><a href="<?=MyQubeSocialAuth::getLink('google')?>">Go go go</a><?
			break;
	}

?>
