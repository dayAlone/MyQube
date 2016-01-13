<?
    require_once($_SERVER['DOCUMENT_ROOT']."/bitrix/modules/main/include.php");
    require_once($_SERVER["DOCUMENT_ROOT"].'/group/u_contest/include/check.php');
    require_once($_SERVER["DOCUMENT_ROOT"].'/group/u_contest/vendor/autoload.php');
    CModule::IncludeModule("iblock");
    $emails = array(
        '66_region@bk.ru', '79122227771@yandex.ru', 'aalleexx69@mail.ru', 'aanna.tae@gmail.com', 'aleksbobrysheva@gmail.ru', 'Aleksey_vikulin@mail.ru', 'ansh9696@mail.ru', 'Arina.puzakova@mail.ru', 'arkadvseti@bk.ru', 'arthur_shonin@mail.ru', 'babikov95@bk.ru', 'babikovagalina@bk.ru', 'bacardi56@mail.ru', 'best.ylitka@mail.ru', 'bogostap@mail.ru', 'boyarindmitry@gmail.com', 'caymanpress@yandex.ru', 'Chekaroff@gmail.com', 'danil89533858840@gmail.com', 'darya.kinga@icloud.com', 'dasha.gol19@mail.ru', 'Deeas89@gmail.ru', 'dim.shainurov@yandex.ru', 'Dukinikita616@mail.ru', 'Dymarskaya@mail.ru', 'ea7llc@gmail.com', 'elena16.06@mail.ru', 'eriktv1@yandex.ru', 'f13997@icloud.com', 'fatima-15911@mail.ru', 'fe10wka@bk.ru', 'fobika@rambler.ru', 'fokinzks@mail.ru', 'g.zlygosteva@icloud.com', 'golda@e1.ru', 'Grasmikman@yandex.ru', 'homegreed@gmail.com', 'igor_lavrov777@mail.ru', 'iphone.r.petrov@gmail.com', 'ivanka.vaskov@mail.ru', 'jake_169@mail.ru', 'Juliata_million@mail.ru', 'justflip-ekb@yandex.ru', 'Karek2D@mail.ru', 'katena.pasyuta@mail.ru', 'kerim-guliev@mail.ru', 'kirillkakud@gmail.com', 'kostar97@mail.ru', 'kristokareva@yandex.ru', 'kusova.marina@bk.ru', 'kvsuvalko@icloud.com', 'm68912180@mail.ru', 'mahmudov1493@mail.ru', 'mech_ta_96@mail.ru', 'Meloch088@bk.ru', 'mitya.ozr@rambler.ru', 'mr.yakovlev1@ya.ru', 'mylan@list.ru', 'narina_mar@mail.ru', 'nastyatish@list.ru', 'natali9871351@yandex.ru', 'novoselova_vlada@mail.ru', 'obukhovm@mail.ru', 'oleg_luzenin@bat.com', 'ololosh944@mail.ru', 'olyalya576@rambler.ru', 'pavlova_masha_1@mail.ru', 'pila.ivanovna@mail.ru', 'polulak@supr1.ru', 'ramis13@bk.ru', 'sattarov88@list.ru', 'schneidereddy@icloud.com', 'sergey_lavrov777@mail.ru', 'Sergey_Rast@mail.ru', 'sev-vldmr@yandex.ru', 'sfera3005@mail.ru', 'shvecovaen@mail.ru', 'sitay16god@mail.ru', 'sylversite@yandex.ru', 'tiron@inkapri-ural.ru', 'tksg@bk.ru', 'tukva50@mail.ru', 'tumanrf@mail.ru', 'tytvkontakte@mail.ru', 'ural-mafia@mail.ru', 'valentina-shnayder@mail.ru', 'vyacheslav.kazak@mail.ru', 'web@semiryakov.ru', 'yaroslav.bazhenov@yandex.ru', 'zaurbekov.max@gmail.com', 'zhanocka@gmail.com', 'zheninajul18@gmail.com'
    );
    var_dump(defined(IBLOCK_ID));
    define("NO_KEEP_STATISTIC", true);
	define("NOT_CHECK_PERMISSIONS", true);;
    function getSections() {
        CModule::IncludeModule("iblock");
        $obCache  = new CPHPCache;
        $lifeTime = 60 * 60 * 2;
        $cacheId  = 'u_contest_sections';

        $data = array();
        $arFilter = array('IBLOCK_ID' => IBLOCK_ID);
        $raw = CIBlockSection::GetList(array('ID' => 'ASC'), $arFilter);
        while ($item = $raw->Fetch()) {
            $data[$item['CODE']] = $item['ID'];
        }
        $obCache->StartDataCache($lifeTime, $cacheId, "/");
        $obCache->EndDataCache(array("SECTIONS" => $data));
        return $data;

    }

    $sections = getSections();
    for ($i=0; $i < count($emails); $i++) {
        $array = Array(
            "ACTIVE"            => "Y",
            "NAME"              => "Заказ: ".$emails[$i],
            "IBLOCK_ID"         => IBLOCK_ID,
            "PROPERTY_VALUES"   => array('EMAIL' => $emails[$i]),
            "IBLOCK_SECTION_ID" => $sections['exist']
        );
        $raw = new CIBlockElement;
        $ID = $raw->Add($array);
        var_dump($array);
    }
?>
