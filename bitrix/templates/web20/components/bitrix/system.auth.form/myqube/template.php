<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<script src="http://code.jquery.com/jquery-1.11.3.min.js"></script>
<?
if(strripos($_SERVER['HTTP_USER_AGENT'],"iphone") || strripos($_SERVER['HTTP_USER_AGENT'],"android") || strripos($_SERVER['HTTP_USER_AGENT'],"ipod") || strripos($_SERVER['HTTP_USER_AGENT'],"windows phone")) {
	$Dir = explode("/",$_SERVER["REQUEST_URI"]);
	if($_GET["backurl"])
		$backurl = "?backurl=".$_GET["backurl"];
	elseif($Dir[1] == "group" && $Dir[2] == 1)
		$backurl = "?backurl=/group/1/";
	else
		$backurl = "";
}
?>
<script type="text/javascript">
	var Timer;
	var NewWindow;
	$(document).ready(function(){
		$(".auth-socserv-fb").each(function(){SetPostAuthSocNet($(this),"/facebook.php<?=$backurl?>");});
		$(".auth-socserv-vk").each(function(){SetPostAuthSocNet($(this),"/vk.php<?=$backurl?>");});
		$(".auth-socserv-gp").each(function(){SetPostAuthSocNet($(this),"/google.php<?=$backurl?>");});
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
<style>
	#page_inside_middle {
		vertical-align: middle;
		display: table-cell;
	}
	.enter_page_leftcol_cont {
		vertical-align: middle;
		display: table;
	}
</style>
<div id="page_inside_middle">
	<?if($arParams["ONLY_SOCNET"] !== "Y") {?>
		<img src="<?=SITE_TEMPLATE_PATH?>/images/myqube_enterpage.png" class="enter_page_leftcol_lock_icon"><br>
		<div class="enter_page_leftcol_text"><br><br>
			<span style="font-weight: 800; font-size: 16px;">ЗАКРЫТАЯ СЕТЬ<br>
			ТЕМАТИЧЕСКИХ СООБЩЕСТВ<br>
			ДЛЯ ЕДИНОМЫШЛЕННИКОВ</span><br><br><br>
			<span style="font-size: 11px;">ВВЕДИТЕ ЛОГИН И ПАРОЛЬ</span>
		</div>
		<form name="system_auth_form<?=$arResult["RND"]?>" id="enter_page_form" method="post" target="_top" action="<?=$arResult["AUTH_URL"]?><?if($_GET["backurl"]) echo "&backurl=".$_GET["backurl"];?>">
			<?if($arResult["BACKURL"] <> ''){?>
				<input type="hidden" name="backurl" value="<?=$arResult["BACKURL"]?>" />
			<?}?>
			<?foreach ($arResult["POST"] as $key => $value){?>
				<input type="hidden" name="<?=$key?>" value="<?=$value?>" />
			<?}?>
			<input type="hidden" name="AUTH_FORM" value="Y" />
			<input type="hidden" name="TYPE" value="AUTH" />
			<input type="text" name="USER_LOGIN" maxlength="50" placeholder="Логин или адрес электронной почты" class="enter_page_input"><br>
			<input type="password" name="USER_PASSWORD" maxlength="50" placeholder="Пароль" class="enter_page_input">
			<br>
			<button type="submit" name="Login" class="enter_page_submit"><span></span>Войти</button>
		</form>
	<?}?>
	<div class="enter_page_social" style="margin-top:0; position: relative;"><?if($arParams["ONLY_SOCNET"] !== "Y") {?>Или<br>
	Авторизируйтесь с помощью социальных сетей<br><?}?>
		<div style="width: 280px; display: inline; padding: 15px 25px 5px; border: 2px solid #ffffff; border-radius: 8px;">
			<a class="auth-socserv-fb" href="javascript:void(0)"><img src="<?=SITE_TEMPLATE_PATH?>/images/login_fb.png"></a>
			<a class="auth-socserv-vk" href="javascript:void(0)"><img src="<?=SITE_TEMPLATE_PATH?>/images/login_vk.png"></a>
			<a class="auth-socserv-gp" href="javascript:void(0)"><img src="<?=SITE_TEMPLATE_PATH?>/images/login_gp.png"></a>
		</div>
	</div>
</div>
