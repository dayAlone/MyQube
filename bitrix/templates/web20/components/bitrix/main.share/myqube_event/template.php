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
<a href="http://www.facebook.com/share.php?u=http://<?=$_SERVER['SERVER_NAME']?><?=$arParams['PAGE_URL']?>&amp;t=" class="share_click" onclick="return fbs_click('http://<?=$_SERVER['SERVER_NAME']?><?=$arParams['PAGE_URL']?>', '');" target="_blank"><span class="icon_fb"></span><b>Фейсбук</b><div class="clear"></div></a>
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
<a href="http://vkontakte.ru/share.php?url=http://<?=$_SERVER['SERVER_NAME']?><?=$arParams['PAGE_URL']?>" class="share_click" onclick="return vk_click('http://<?=$_SERVER['SERVER_NAME']?><?=$arParams['PAGE_URL']?>');" target="_blank"><span class="icon_vk"></span><b>Вконтакте</b><div class="clear"></div></a>
<script>
if (__function_exists('gp_click') == false) 
{
function gp_click(url) 
{ 
window.open('https://plus.google.com/share?url='+encodeURIComponent(url),'sharer','toolbar=0,status=0,width=626,height=436'); 
return false; 
} 
}
</script>
<a href="https://plus.google.com/share?url=http://<?=$_SERVER['SERVER_NAME']?><?=$arParams['PAGE_URL']?>" class="share_click" onclick="return gp_click('http://<?=$_SERVER['SERVER_NAME']?><?=$arParams['PAGE_URL']?>');" target="_blank"><span class="icon_gp"></span><b>Гугл+</b><div class="clear"></div></a>