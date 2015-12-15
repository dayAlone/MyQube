<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<script>
if (__function_exists('fbs_click') == false) 
{
	function fbs_click(url, title) 
	{ 
		window.open('http://www.facebook.com/share.php?u='+encodeURIComponent(url)+'&t='+encodeURIComponent(title),'sharer','toolbar=0,status=0,width=626,height=436'); 
		return false; 
	} 
}
</script>
<a href="http://www.facebook.com/share.php?u=http://myqube.ru/group/1/post/10/&amp;t=" onclick="return fbs_click('http://myqube.ru/group/1/post/10/', '');" target="_blank"><span class="icon_fb"></span><b>Фейсбук</b><div class="clear"></div></a>
<script>
if (__function_exists('vk_click') == false) 
{
function vk_click(url) 
{ 
window.open('http://vkontakte.ru/share.php?url='+encodeURIComponent(url),'sharer','toolbar=0,status=0,width=626,height=436'); 
return false; 
} 
}
</script>
<a href="http://vkontakte.ru/share.php?url=http://myqube.ru/group/1/post/10/" onclick="return vk_click('http://myqube.ru/group/1/post/10/');" target="_blank"><span class="icon_vk"></span><b>Вконтакте</b><div class="clear"></div></a>
<a href=""><span class="icon_gp"></span><b>Гугл+</b><div class="clear"></div></a>