<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
LocalRedirect('/group/1/u_concept/');
require($_SERVER["DOCUMENT_ROOT"].'/group/u_creative/include/check.php');
$page_name="u_concept";?>
<script type="text/javascript" src="/group/u_creative/js/frontend.js" defer async></script>
<link rel="stylesheet" href="/group/u_creative/css/frontend.css" media="screen" title="no title" charset="utf-8">
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
//echo $record->city->name . "\n"; // 'Yekaterinburg'
*/
$geiop = CAltasibGeoBase::GetAddres();
//var_dump($geiop['CITY_NAME']);
?><div data-city='<?=$geiop['CITY_NAME']?>'></div><?
if($USER->IsAuthorized()) {// && ($geiop['CITY_NAME'] == CITY_NAME || $USER->IsAdmin())) {
    ?>
    <div class="contest contest--demo contest--active <?=(checkExist($USER->GetID(), $USER->GetEmail()) ? "contest--locked" : "")?>">
      <div class="contest__header">
          <span>*ю_концепт</span>
          <?
            /*
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
                    "PAGE_URL" => "/group/1/u_conсept/",
                    "PAGE_TITLE" => "u_creative",
                    "PAGE_IMAGE" => "http://myqube.ru/upload/Concept-Ural_sharing_960.jpg",
                    "SHORTEN_URL_LOGIN" => "",
                    "SHORTEN_URL_KEY" => ""
                ),
                false
            );
            */
        ?>
      </div>
      <div class='detail_page'>
          <nav class="detail_page_nav">
              <a href="/group/1/" class="close_nav"><span class="icon_close"></span><b>Закрыть конкурс</b><div class="clear"></div></a>
              <?/*
              $APPLICATION->IncludeComponent(
                  "bitrix:main.share",
                  "myqube",
                  Array(
                      "COMPONENT_TEMPLATE" => ".default",
                      "HIDE" => "N",
                      "HANDLERS" => array("vk", "facebook", "google"),
                      "PAGE_URL" => "/group/1/u_conсept/",
                      "SHORTEN_URL_LOGIN" => "",
                      "SHORTEN_URL_KEY" => ""
                  )
              );*/?>
              <?
              $res_like = CIBlockElement::GetList(array(), array("IBLOCK_ID" => 6, "PROPERTY_LIKE" => "32332", "PROPERTY_USER" => $USER->GetID() ),array());
              ?>
              <a class="photo_list_like <?=($res_like>0)?"like_active":""?>" id="like_post_32332"></a>
          </nav>
      </div>
      <?$APPLICATION->IncludeComponent("bitrix:menu", "top_line", Array(
          "ROOT_MENU_TYPE"	      =>	"left",
          "MAX_LEVEL"	          =>	"1",
          "CHILD_MENU_TYPE"	      =>	"left",
          "USE_EXT"	              =>	"Y",
          "MENU_CACHE_TYPE"       => "A",
          "MENU_CACHE_TIME"       => "3600",
          "MENU_CACHE_USE_GROUPS" => "Y",
          "MENU_CACHE_GET_VARS"   => array(
              0 => "SECTION_ID",
              1 => "page",
          ),
          "group_id"              => 1,
          "show_logo"             => "Y",
          "search"                => "n",
          "search_pos"            => "r"
          )
      );?>
      <? require($_SERVER["DOCUMENT_ROOT"].'/group/u_creative/include/blocks.php'); ?>
      <div class='contest__comments comments'>
            <div class='center'>
                <a href='#' class='comments__trigger'>
                    <span class='show'><span class='text'>Показать комментарии</span> <span class='count'>(0)</span></span>
                    <span class='h'><span class='text'>Скрыть комментарии</span></span>

                </a>
            </div>

            <div class='comments__list'>
                <?
                $APPLICATION->IncludeComponent("smsmedia:comments", "myqube_event", Array(
            			"OBJECT_ID"                       => "u_creative",	// ID объекта комментирования
            			"OBJECT_ID_W"                     => "u_creative",
            			"IBLOCK_TYPE"                     => "comments",	// Тип инфоблока
            			"COMMENTS_IBLOCK_ID"              => "5",	 // ID инфоблока, в котором хранятся комментарии
            			"LEFT_MARGIN"                     => "",	// Отступ для дочерних комментариев
            			"SHOW_USERPIC"                    => "Y",	// Показывать аватар
            			"SHOW_DATE"                       => "Y",	// Показывать дату комментария
            			"SHOW_COUNT"                      => "Y",	// Показывать количество комментариев
            			"CACHE_TYPE"                      => "A",	// Тип кеширования
            			"CACHE_TIME"                      => "3600",// Время кеширования (сек.)
            			"NO_FOLLOW"                       => "Y",	// Добавить атрибут rel="nofollow" к ссылкам в комментариях
            			"NO_INDEX"                        => "Y",	// Не индексировать комментрии
            			"NON_AUTHORIZED_USER_CAN_COMMENT" => "N",	// Разрешить неавторизованным пользователям добавлять комменарии
            			"USE_CAPTCHA"                     => "N",	// Показывать капчу для неавторизованных пользователей
            			"AUTH_PATH"                       => "/auth/",	// Путь до страницы авторизации
            			"COMPONENT_TEMPLATE"              => "myqube"
            		),
            		false
            	);?>
            </div>
      </div>

    </div>
    <?
    require($_SERVER["DOCUMENT_ROOT"].'/group/u_creative/include/modals.php');
} else {
    require($_SERVER["DOCUMENT_ROOT"].'/group/u_creative/teaser.php');
}
if (isset($_REQUEST['v']) && isset($_REQUEST['h']) && isset($_REQUEST['g'])) {
    $APPLICATION->SetPageProperty("og:image", "http://".$_SERVER['SERVER_NAME']."/group/u_creative/images/sharing/".$_REQUEST['g']."/".$_REQUEST['g']."_design_dev_".$_REQUEST['v']."_".$_REQUEST['h'].'.jpg');
    $APPLICATION->SetPageProperty("og:url", "http://".$_SERVER['SERVER_NAME']."/group/u_creative/?g=".$_REQUEST['g']."&v=".$_REQUEST['v']."&h=".$_REQUEST['h']);
    //$APPLICATION->SetPageProperty("title", "Заголовок для шера");
    //$APPLICATION->SetPageProperty("description", "Текст для шера");
    $APPLICATION->SetPageProperty("og:title", "Заголовок для шера");
    $APPLICATION->SetPageProperty("og:description", "Текст для шера");
}
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");
?>
