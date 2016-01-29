
<script type="text/javascript">
	var Timer;
	var NewWindow;
	var backurl = "<?=$arParams['BACKURL']?>"
	$(document).ready(function(){
		$(".login__link--fb").each(function(){SetPostAuthSocNet($(this),"/facebook.php<?=$backurl?>");});
		$(".login__link--vk").each(function(){SetPostAuthSocNet($(this),"/vk.php<?=$backurl?>");});
		$(".login__link--gp").each(function(){SetPostAuthSocNet($(this),"/google.php<?=$backurl?>");});	
	});
	function SetTimerAuthSocNet(NewTime){
		if(NewTime == null || typeof NewTime == "undefined"){
			NewTime	= 1000;
		}
		Timer = setInterval(function() {
		    if(NewWindow.closed) {
		        clearInterval(Timer);
		        window.location.href = window.location.href;
		    }
		}, NewTime);
	}
	function SetPostAuthSocNet(Obj,Url){
		var StrHtml = "";
		$.get(Url, function( data ) {
			StrHtml = "NewWindow = window.open('"+data+"','','width=660,height=425,scrollbars=1');";
			StrHtml += "SetTimerAuthSocNet()";
			$(Obj).attr("onclick",StrHtml);
		});
	}
</script>

<div class='login login--social'>
	Чтобы читать дальше,<br>авторизируйтесь через соцсеть
	<br>
	<a href="javascript:void(0)" class='login__link login__link--fb'>
		<img src="/layout/images/svg/fb.svg" alt="" />
	</a>
	<a href="javascript:void(0)" class='login__link login__link--vk'>
		<img src="/layout/images/svg/vk.svg" alt="" />
	</a>
	<a href="javascript:void(0)" class='login__link login__link--gp'>
		<img src="/layout/images/svg/gp.svg" alt="" />
	</a>
</div>
