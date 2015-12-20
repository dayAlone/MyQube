<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$page_name="u_concept";?>
<script type="text/javascript" src="/group/u_contest/js/frontend.js" defer async></script>
<link rel="stylesheet" href="/group/u_contest/css/frontend.css" media="screen" title="no title" charset="utf-8">
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Exo+2:100,400,300,600,700&amp;subset=latin,cyrillic"/>
<link rel="stylesheet" href="/css/font-awesome_concept.min.css">
<?

/*
require_once 'vendor/autoload.php';
use GeoIp2\WebService\Client;
if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
    $ip = $_SERVER['HTTP_CLIENT_IP'];
} elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
    $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
} else {
    $ip = $_SERVER['REMOTE_ADDR'];
}
$client = new Client(107700, 'QZ51sMdTQode');
$record = $client->city($ip);
echo $record->city->name . "\n"; // 'Yekaterinburg'
*/
if($USER->IsAuthorized()) {
    ?>
    <div class="contest contest--demo contest--active">
      <div class="contest__header">
          <?
            $APPLICATION->IncludeComponent(
                "bitrix:main.share",
                "myqube_uconcept",
                array(
                    "COMPONENT_TEMPLATE" => "myqube_uconcept",
                    "HIDE" => "N",
                    "HANDLERS" => array(
                        0 => "facebook",
                        1 => "vk",
                        2 => "Google",
                    ),
                    "PAGE_URL" => "/group/1/u_contest/",
                    "PAGE_TITLE" => "U_CONTEST",
                    "PAGE_IMAGE" => "http://myqube.ru/upload/Concept-Ural_sharing_960.jpg",
                    "SHORTEN_URL_LOGIN" => "",
                    "SHORTEN_URL_KEY" => ""
                ),
                false
            );?>
      </div>
      <?
      $APPLICATION->IncludeComponent("bitrix:menu", "top_line", Array(
          "ROOT_MENU_TYPE"	=>	"left",
          "MAX_LEVEL"	=>	"1",
          "CHILD_MENU_TYPE"	=>	"left",
          "USE_EXT"	=>	"Y",
          "MENU_CACHE_TYPE" => "A",
          "MENU_CACHE_TIME" => "3600",
          "MENU_CACHE_USE_GROUPS" => "Y",
          "MENU_CACHE_GET_VARS" => array(
              0 => "SECTION_ID",
              1 => "page",
          ),
          "group_id" => 1,
          "show_logo" => "Y"
          )
      );?>
      <? require($_SERVER["DOCUMENT_ROOT"].'/group/u_contest/include/blocks.php'); ?>
    </div>
    <?
    require($_SERVER["DOCUMENT_ROOT"].'/group/u_contest/include/modals.php');
} else {

}
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");
?>
