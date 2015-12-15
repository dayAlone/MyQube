<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
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
			NewTime	= 1000
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
		$.post(Url, function( data ) {
			StrHtml = "NewWindow = window.open('"+data+"','','width=660,height=425,scrollbars=1');"
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
	<img src="<?=SITE_TEMPLATE_PATH?>/images/enter_page_lock_icon.png" class="enter_page_leftcol_lock_icon"><br>
	<div class="enter_page_leftcol_text">
		Для входа в группу примените логин или пароль</br>
		либо авторизуйтесь через социальные сети.</br>
		Важно знать, что участникам группы должно быть</br>
		от 18 лет. <!--С правилами группы вы можете ознакомиться<br>
		<a href="#" id="about_group" onclick="openPopup('about_group')">в разделе правил</a>-->
	</div>
	<form name="system_auth_form<?=$arResult["RND"]?>" id="enter_page_form" method="post" target="_top" action="<?=$arResult["AUTH_URL"]?>">
		<?if($arResult["BACKURL"] <> ''){?>
			<input type="hidden" name="backurl" value="<?=$arResult["BACKURL"]?>" />
		<?}?>
		<?foreach ($arResult["POST"] as $key => $value){?>
			<input type="hidden" name="<?=$key?>" value="<?=$value?>" />
		<?}?>
		<input type="hidden" name="AUTH_FORM" value="Y" />
		<input type="hidden" name="TYPE" value="AUTH" />
		<input type="image" name="Login" src="<?=SITE_TEMPLATE_PATH?>/images/enter_page_submit.png" value="Войти" class="enter_page_submit">
		<input type="text" name="USER_LOGIN" maxlength="50" placeholder="Логин или адрес электронной почты" class="enter_page_input" style="margin-left:53px;"><br>
		<input type="password" name="USER_PASSWORD" maxlength="50" placeholder="Пароль" class="enter_page_input" style="margin-left:53px;">
	</form>
	<div class="enter_page_social">
		Авторизируйтесь с помощью социальных сетей<br>
		<div style="width: 280px; display: inline; padding: 15px 25px 5px; border: 2px solid #ffffff; border-radius: 8px;">
			<a class="auth-socserv-fb" href="javascript:void(0)"><img src="<?=SITE_TEMPLATE_PATH?>/images/login_fb.png"></a>
			<!--a class="auth-socserv-tw" href="javascript:void(0)"><img src="<?=SITE_TEMPLATE_PATH?>/images/login_tw.png"></a-->
			<a class="auth-socserv-vk" href="javascript:void(0)"><img src="<?=SITE_TEMPLATE_PATH?>/images/login_vk.png"></a>
			<a class="auth-socserv-gp" href="javascript:void(0)"><img src="<?=SITE_TEMPLATE_PATH?>/images/login_gp.png"></a>
		</div>
	</div>
</div>