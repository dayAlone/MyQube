<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");?>
<?
$page_name="video";

include($_SERVER["DOCUMENT_ROOT"]."/group/header.php");
function fetch_vimeo_id($url) {
					$headers = get_headers($url);
					# Reverse loop because we want the last matching header,
					# as Vimeo does multiple redirects with your `https` URL
					for($i = count($headers) - 1; $i >= 0; $i--) {
						$header = $headers[$i];
						//echo $header."#<br>";
						if(strpos($header, "Location: /") === 0) {
							return substr($header, strlen("Location: /"));
						}
					}
					# Could not find id
					return null;
				}
?>
<link type="text/css" rel="stylesheet" href="/css/events_detail.css">
<style>
	.likes-wrap {
		width:60px !important;
	}
	a.likes {
		margin-top:1px;
	}
</style>
<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");
?>