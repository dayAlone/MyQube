<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?
/*function vk_shares($url) {
    $str = @file_get_contents("http://vk.com/share.php?act=count&index=1&url=".urlencode($url));
    preg_match('#VK.Share.count\(1, ([0-9]+)\);#', $str, $matches);
    return (count($matches) > 1) ? intval($matches[1]) : false;
}
function fb_shares($url) {
    $str = @file_get_contents("http://graph.facebook.com/?id=".urlencode($url));
    $shares = json_decode($str, true);
    if($shares["shares"])
		return $shares["shares"];
	else
		return 0;
}*/?>
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
<a href="http://www.facebook.com/share.php?u=http://myqube.ru/group/1/post/10/&amp;t=" onclick="return fbs_click('http://myqube.ru/group/1/post/10/', '');" target="_blank"><span class="icon_fb"></span><!--b>Фейсбук</b--><div class="clear"></div></a>
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
<a href="http://vkontakte.ru/share.php?url=http://myqube.ru/group/1/post/10/" onclick="return vk_click('http://myqube.ru/group/1/post/10/');" target="_blank"><span class="icon_vk"></span><!--b>Вконтакте</b--><div class="clear"></div></a>
<a href=""><span class="icon_gp"></span><!--b>Гугл+</b--><div class="clear"></div></a>
<?/*if (strlen($arResult["PAGE_URL"]) > 0)
{
		if (is_array($arResult["BOOKMARKS"]) && count($arResult["BOOKMARKS"]) > 0)
		{
			echo '<pre>'; print_r($arResult); echo '</pre>';
			foreach($arResult["BOOKMARKS"] as $name => $arBookmark)
			{
				?>
				<a href=""><span class="icon_fb"></span><b>Фейсбук</b><div class="clear"></div></a>
				<a href=""><span class="icon_vk"></span><b>Вконтакте</b><div class="clear"></div></a>
				<a href=""><span class="icon_gp"></span><b>Гугл+</b><div class="clear"></div></a>
					<div class="bookmarks"><?=$arBookmark["ICON"]?></div> <div class="count-share">
					<?if($name == 1) 
						echo vk_shares("http://".SITE_SERVER_NAME.$arParams["PAGE_URL"]);
					elseif($name == 0)
						echo fb_shares("http://".SITE_SERVER_NAME.$arParams["PAGE_URL"]);?>
				</div><?
			}
		}
}
else
{
	?><?=GetMessage("SHARE_ERROR_EMPTY_SERVER")?><?
}*/
?>