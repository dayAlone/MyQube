<?
	$url=urlencode($_GET['url']);
	function vk_shares($url) {
		$str = @file_get_contents("http://vk.com/share.php?act=count&index=1&url=".$url);
		preg_match('#VK.Share.count\(1, ([0-9]+)\);#', $str, $matches);
		return (count($matches) > 1) ? intval($matches[1]) : false;
	}
	function fb_shares($url) {
		$str = @file_get_contents("http://graph.facebook.com/?id=".$url);
		$shares = json_decode($str, true);
		if($shares["shares"])
			return $shares["shares"];
		else
			return 0;
	}
	function g_shares($url) {
		$str = @file_get_contents("https://plusone.google.com/_/+1/fastbutton?url=".$url);
		preg_match('/<div id="aggregateCount" class="Oy">([0-9]+)<\/div>/', $str, $matches);
		return (count($matches) > 1) ? intval($matches[1]) : false;
	}
	$k1 = fb_shares($url);
	$k2 = vk_shares($url);
	$k3 = g_shares($url);
	$json = '{"fb":"'.$k1.'","vk":"'.$k2.'","g":"'.$k3.'","sum":"'.($k1+$k2+$k3).'"}';
	echo $json;
?>