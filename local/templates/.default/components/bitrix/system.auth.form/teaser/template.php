<? $_GET['backurl'] = $arParams['BACKURL']; ?>
<script type="text/javascript">

	$(document).ready(function(){
		$(".login__link").on('click', function(e) {
			var NewWindow = window.open($(this).data('url'),'','width=660,height=425,scrollbars=1');
			var Timer = setInterval(function() {
				if(NewWindow.closed) {
			        window.location.href = '<?=$arParams['BACKURL']?>'
			    }
			}, 1000);
			e.preventDefault()
		})

	});

</script>

<div class='login login--social'>
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
