<?
$_GET["backurl"] = $_GET["backurl"] ? $_GET["backurl"] : (intval($_GET['GROUP_ID']) > 0 ? "/group/".$_GET['GROUP_ID']."/" : "/");
?>

<div class="login qblock" data-backurl="<?=$_GET["backurl"]?>">
	<img src="/layout/images/svg/logo-full.svg" alt="" class="login__logo">
	<div class="qblock__content">
	<div class="login__title">
		Закрытая есть<br/>
		тематических сообществ<br/>
		для единомышленников
	</div>
	<a href="#" class="login__trigger">Войти по логину и паролю</a>
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
		<a href="#" class="login__social login__social--fb" data-url="<?require($_SERVER['DOCUMENT_ROOT'].'/facebook.php');?>"><?=svg('fb')?></a>
		<a href="#" class="login__social login__social--vk" data-url="<?require($_SERVER['DOCUMENT_ROOT'].'/vk.php');?>"><?=svg('vk')?></a>
		<a href="#" class="login__social login__social--gp" data-url="<?require($_SERVER['DOCUMENT_ROOT'].'/google.php');?>"><?=svg('gp')?></a>
	</div>
	<div class="login__footer qblock__footer">
		<? include($_SERVER['DOCUMENT_ROOT'] . '/includes/footer.php') ?>
	</div>
	</div>
</div>
