<?
require_once($_SERVER['DOCUMENT_ROOT'].'/includes/social.php');
$_GET["backurl"] = $_GET["backurl"] ? $_GET["backurl"] : (intval($_GET['GROUP_ID']) > 0 ? "/group/".$_GET['GROUP_ID']."/" : "/");
?>
<div class="login login--full-width" data-backurl="<?=$_GET["backurl"]?>">
	<div class="login__social-frame">
		<a href="#" class="login__social login__social--fb" data-url="<?=MyQubeSocialAuth::getLink('facebook');?>"><?=svg('fb')?></a>
		<a href="#" class="login__social login__social--vk" data-url="<?=MyQubeSocialAuth::getLink('vk');?>"><?=svg('vk')?></a>
		<a href="#" class="login__social login__social--gp" data-url="<?=MyQubeSocialAuth::getLink('google');?>"><?=svg('gp')?></a>
	</div>
</div>
