<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

$name = "Google";
$title = "Google+";
$icon_url_template = "<script>
			function gPlus(url){
				window.open(
					'https://plus.google.com/share?url='+url,
					'popupwindow',
					'scrollbars=yes,width=800,height=400'
				).focus();
				return false;
			}
			</script>".'<a href="#" class="google" onclick="gPlus(\'#PAGE_URL#\');" title="Google+"></a>';
$sort = 400;
?>