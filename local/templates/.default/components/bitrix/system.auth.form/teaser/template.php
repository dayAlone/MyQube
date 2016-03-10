<?
	require_once($_SERVER['DOCUMENT_ROOT'].'/includes/social.php');
	$_GET['backurl'] = $arParams['BACKURL'];

?>
<div class='login login--social' data-backurl="<?=$_GET["backurl"]?>">
	Чтобы читать дальше,<br>авторизируйтесь через соцсеть
	<br>
	<a href="#" class='login__link login__link--fb' data-url='<?=MyQubeSocialAuth::getLink('facebook')?>'>
		<img src="/layout/images/svg/fb.svg" alt="" />
	</a>
	<a href="#" class='login__link login__link--vk' data-url='<?=MyQubeSocialAuth::getLink('vk')?>'>
		<img src="/layout/images/svg/vk.svg" alt="" />
	</a>
	<a href="#" class='login__link login__link--gp' data-url='<?=MyQubeSocialAuth::getLink('google')?>'>
		<img src="/layout/images/svg/gp.svg" alt="" />
	</a>
</div>
