<? $_GET['backurl'] = $arParams['BACKURL']; ?>
<div class='login login--social' data-backurl="<?=$_GET["backurl"]?>">
	Чтобы читать дальше,<br>авторизируйтесь через соцсеть
	<br>
	<a href="#" class='login__link login__link--fb' data-url='<?=require($_SERVER['DOCUMENT_ROOT'].'/facebook.php');?>'>
		<img src="/layout/images/svg/fb.svg" alt="" />
	</a>
	<a href="#" class='login__link login__link--vk' data-url='<?=require($_SERVER['DOCUMENT_ROOT'].'/vk.php');?>'>
		<img src="/layout/images/svg/vk.svg" alt="" />
	</a>
	<a href="#" class='login__link login__link--gp' data-url='<?=require($_SERVER['DOCUMENT_ROOT'].'/google.php');?>'>
		<img src="/layout/images/svg/gp.svg" alt="" />
	</a>
</div>
