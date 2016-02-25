<?
require_once($_SERVER['DOCUMENT_ROOT'].'/includes/social.php');
$_GET["backurl"] = $_GET["backurl"] ? $_GET["backurl"] : (intval($_GET['GROUP_ID']) > 0 ? "/group/".$_GET['GROUP_ID']."/" : "/");
?>
<div class="toolbar">
  <div class="row">
	<div class="col-xs-7"><img src="/layout/images/svg/logo-full.svg" alt="" class="toolbar__logo"></div>
	<div class="col-xs-5 right"><a href="#" class="toolbar__trigger"><img src="/layout/images/svg/arrow-right.svg" alt=""></a><a href="#" class="toolbar__profile"><img src="/layout/images/svg/user.svg" alt=""></a></div>
  </div>
</div>
<div class="login qblock" data-backurl="<?=$_GET["backurl"]?>">
	<img src="/layout/images/svg/logo-full.svg" alt="" class="login__logo">
	<div class="qblock__content">
	<div class="login__title">
		Закрытая есть<br/>
		тематических сообществ<br/>
		для единомышленников
	</div>
    <div class='login__errors'></div>
	<a href="#" class="login__trigger">Войти по логину и паролю</a>
	<form action='' method='post' class='login__age'>
		<input type="hidden" name="fields" value=""/>
	</form>
	<form class='login__form' data-parsley-validate method="POST" action="<?=(intval($_GET['GROUP_ID']) > 0 ? "/group/".$_GET['GROUP_ID']."/" : "/?login=yes")?>">
		<input type="hidden" name="USER_REMEMBER" value="Y">
		<input type="hidden" name="AUTH_FORM" value="Y">
		<input type="hidden" name="TYPE" value="AUTH">
		<input type="hidden" name="backurl" value="<?=$_REQUEST['backurl']?>">
		<label class="login__label">Введите логин и пароль</label><br>
		<input type="text" name="USER_LOGIN" placeholder="Логин или адрес электронной почты" required class="login__input"><br>
		<input type="password" name="USER_PASSWORD" placeholder="Пароль" required class="login__input"><br>
		<button type="submit" class="login__button" name="Login"><img src="/layout/images/svg/lock.svg" alt=""><span>Войти</span></button>
	</form><br>
	<label class="login__label">
		или <br/>
		авторизуйтесь с&nbsp;помощью социальных&nbsp;сетей
	</label>
	<div class="login__social-frame">
		<a href="#" class="login__social login__social--fb" data-url="<?=MyQubeSocialAuth::getLink('facebook');?>"><?=svg('fb')?></a>
		<a href="#" class="login__social login__social--vk" data-url="<?=MyQubeSocialAuth::getLink('vk');?>"><?=svg('vk')?></a>
		<a href="#" class="login__social login__social--gp" data-url="<?=MyQubeSocialAuth::getLink('google');?>"><?=svg('gp')?></a>
	</div>
	<div class="login__footer qblock__footer">
		<? include($_SERVER['DOCUMENT_ROOT'] . '/includes/footer.php') ?>
	</div>
	</div>
</div>
