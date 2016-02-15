<?
	require($_SERVER['DOCUMENT_ROOT'] . '/bitrix/php_interface/init.php');
	function page_class()
	{
		global $APPLICATION;
		if($APPLICATION->GetPageProperty('page_class')) {
			return $APPLICATION->GetPageProperty('page_class');
		}
	}
	function svg($value='')
	{
		$path = $_SERVER["DOCUMENT_ROOT"]."/layout/images/svg/".$value.".svg";
		return file_get_contents($path);
	}
?>
