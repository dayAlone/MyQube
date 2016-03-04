<?
header('Content-Type: application/json');
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");

CModule::IncludeModule("iblock");
CModule::IncludeModule("highloadblock");
use Bitrix\Highloadblock as HL;
use Bitrix\Main\Entity;
global $USER;

//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
define("HLBLOCK_KPIAMPLIFIER", "2");//Лог и KPI


$arUserType[1] = array("1"=>"33", "2"=>"34", "3"=>"35", "4"=>"36", "5"=>"37", "6"=>"43");
$arUserType[2] = array("1"=>"38", "2"=>"39", "3"=>"40", "4"=>"41", "5"=>"42", "6"=>"44");

$arUserTypeR[1] = array("33"=>"1", "34"=>"2", "35"=>"3", "36"=>"4", "37"=>"5", "43"=>"6");
$arUserTypeR[2] = array("38"=>"1", "39"=>"2", "40"=>"3", "41"=>"4", "42"=>"5", "44"=>"6");

/**
    Функция печатает JSON
*/
function getResultJSON($result) {
    print json_encode(array(
        $result
    ), JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
}

/**
    Функция валидирует JSON
*/
function isValidJSON($json) {
    if(!isset($json)) {
        getResultJSON(
            array(
                "status"     => "ERROR",
                "status_msg" => "NO DATA"
            )
        );
        return false;
    }
    if(!is_array($json)) {
        getResultJSON(
            array(
                "status" => "ERROR",
                "status_msg" => "Некорректные данные - не массив"
            )
        );
        return false;
    }
    if(empty($json)) {
        getResultJSON(
            array(
                "status" => "ERROR",
                "status_msg" => "Некорректные данные - пустой массив"
            )
        );
        return false;
    }
    return true;
}

/**
    Функция добавления информации в Хайлоад блок
*/
function addToHLBlock($id, $data) {
    $hlblock = HL\HighloadBlockTable::getById($id)->fetch();
    $entity = HL\HighloadBlockTable::compileEntity($hlblock);
    $entity_data_class = $entity->getDataClass();
    $result = $entity_data_class::add($data);
    return $result;
}

/**
 * Check last user type in logs
 * @param $userID
 *
 * @return string
 */
function getUserType($userID)
{
    global $USER;

    $hbKPI     = HL\HighloadBlockTable::getById(HLBLOCK_KPIAMPLIFIER)->fetch();
    $entityKPI = HL\HighloadBlockTable::compileEntity($hbKPI);
    $entity_data_class    = $entityKPI->getDataClass();

    $arUserType2R = array("38"=>"1", "39"=>"2", "40"=>"3", "41"=>"4", "42"=>"5", "44"=>"5");
    $rsDataHLAll = $entity_data_class::getList(array(
        "select" => array("*"),
        "order" => array("ID" => "DESC"),
        "filter" => array("UF_AMPLIFIER"=>$USER->GetID(), "UF_USER"=>IntVal($userID))
    ));
    if($ar_fieldsGoodAll = $rsDataHLAll->Fetch())
    {
        return $arUserType2R[$ar_fieldsGoodAll['UF_TYPE_2']];
    }
    else
    {
        return '2';
    }
}


$hbKPI     = HL\HighloadBlockTable::getById(HLBLOCK_KPIAMPLIFIER)->fetch();
$entityKPI = HL\HighloadBlockTable::compileEntity($hbKPI);
$logKPI    = $entityKPI->getDataClass();


//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++

/**
    Авторизация пользователя.
    Проходит с помощью BasicAuth
*/
if($_REQUEST["mode"] == "checkauth") {

    // Поиск пользователья по логину
    $rsUser = $USER->GetByLogin($_SERVER['PHP_AUTH_USER']);

    if($arUser = $rsUser->Fetch()) {
        $arGroups = array();
        $arGroups = $USER->GetUserGroup($arUser["ID"]);

        // Проверка является ли пользователь амплифаером или эдвайзером
        if(in_array(8, $arGroups) || in_array(9, $arGroups)) { // amplifier || adviser

            $salt         = substr($arUser['PASSWORD'], 0, (strlen($arUser['PASSWORD']) - 32));
            $realPassword = substr($arUser['PASSWORD'], -32);
            $password     = md5($salt.$_SERVER['PHP_AUTH_PW']);

            if($password == $realPassword) {

                // Если пароль верный, авторизуем и возвращаем необходимые данные

                $USER->Authorize($arUser["ID"]);
                $promo = "N";

                if(in_array(8, $arGroups)) {
                    $role = "amplifier";
                } elseif(in_array(9, $arGroups)) {
                    $role  = "adviser";
                    $promo = "Y";
                }
                getResultJSON(
                    array(
                        "status"     => "OK",
                        "status_msg" => "Авторизация успешна",
                        "role"       => $role,
                        "sessid"     => bitrix_sessid_get(),
                        "show_promo" => $promo
                    )
                );
            } else {
                getResultJSON(
                    array(
                        "status"      => "ERROR",
                        "status_msg"  => "Вы не авторизованы (неверный пароль)",
                        "status_code" => 101,
                    )
                );
            }
        } else {
            getResultJSON(
                array(
                    "status"        => "ERROR",
                    "status_msg"    => "Вы не администратор",
                    "bitrix_result" => $arGroups
                )
            );
        }
    } else {
        getResultJSON(
            array(
                "status"      => "ERROR",
                "status_msg"  => "Вы не авторизованы (пользователь с логином ".$_SERVER['PHP_AUTH_USER']." не найден)",
                "status_code" => 101
            )
        );
    }
}


/**
    Работа с логом
*/
if($_REQUEST["mode"] == "log") {
    if(!$USER->IsAuthorized()) exit();

    // Чтение лога из Хайлоад инфоблока

    if($_REQUEST["log"] == "read") {

        $hlblock           = HL\HighloadBlockTable::getById(4)->fetch();
        $entity            = HL\HighloadBlockTable::compileEntity($hlblock);
        $entity_data_class = $entity->getDataClass();
        $entity_table_name = $hlblock['log'];

        $arFilter = array();

        $sTableID = 'tbl_'.$entity_table_name;
        $rsData = $entity_data_class::getList(array(
            "select" => array('*'),
            "filter" => $arFilter,
            "order" => array("UF_DATE_TIME"=>"ASC")
        ));
        $rsData = new CDBResult($rsData, $sTableID);
        $log = array();
        while($arRes = $rsData->Fetch()){
            $log[] = array(
                "id"          => $arRes["ID"],
                "dt"          => $arRes["UF_DATE_TIME"] ? date("Y-m-d H:i:s", strtotime($arRes["UF_DATE_TIME"])) : "",
                "contact_id"  => $arRes["UF_USER"] ? $arRes["UF_USER"] : 0,
                "action_code" => $arRes["UF_ACTION_CODE"] ? $arRes["UF_ACTION_CODE"] : 0,
                "action_text" => $arRes["UF_ACTION_TEXT"] ? $arRes["UF_ACTION_TEXT"] : "",
                "uf_type"     => $arRes["UF_TYPE"] ? $arRes["UF_TYPE"] : 0,
                "uf_type_2"   => $arRes["UF_TYPE_2"] ? $arRes["UF_TYPE_2"] : 0,
            );
        }
        getResultJSON(
            array(
                "status"     => "OK",
                "status_msg" => "LogRead",
                "log"        => $log
            )
        );
    }

    // Запись в лог

    if($_REQUEST["log"] == "write") {

        $json = json_decode(file_get_contents('php://input'), true);
        if (!isValidJSON($json)) exit();

        $log  = array();
        foreach($json as $key => $val) {
            $data = array(
                "UF_USER"        => $val["contact_id"],
                "UF_AMPLIFIER"   => $USER->GetID(),
                "UF_EVENT"       => $val["uf_event"],
                "UF_DATE_TIME"   => date("d.m.Y H:i:s", strtotime($val["dt"])),
                "UF_ACTION_CODE" => $val["action_code"],
                "UF_ACTION_TEXT" => $val["action_text"],
                "UF_TYPE"        => $val["uf_type"],
                "UF_TYPE_2"      => $val["uf_type_2"]
            );

            $result = addToHLBlock(4, $data);
            $ID     = $result->getId(); //$result->getErrorMessages()[0]

            $log[] = array(
                "status"      => "OK",
                "status_msg"  => "LogAdd",
                "app_id"      => $val["app_id"] ? $val["app_id"] : 0,
                "external_id" => $ID ? $ID : 0
            );
        }
        getResultJSON(
            $log
        );
    }

    if($_REQUEST["log"] !== "read" && $_REQUEST["log"] !== "write")
        getResultJSON(
            array(
                "status" => "ERROR",
                "status_msg" => "NO DATA"
            )
        );
}

/**
    Показ промо
*/
if($_REQUEST["mode"] == "promo") {
    if(!$USER->IsAuthorized()) exit();

    $promo = CIBlockElement::GetProperty(18, 763)->GetNext();
    getResultJSON(
        array(
            "status"     => "OK",
            "status_msg" => "PROMO",
            "url_list"   => array("http://".SITE_SERVER_NAME.CFile::GetPath($promo["VALUE"])),
            "filetime"   => array($promo["TIMESTAMP_X"])
        )
    );
}

/**
    Добавление нового контакта
*/
if($_REQUEST["mode"] == "new_contact") {
    if(!$USER->IsAuthorized()) exit();

    $json = json_decode(file_get_contents('php://input'), true);
    if (!isValidJSON($json)) exit();

    $contact_type = array(
        1 => 28,
        2 => 29,
        3 => 30,
        4 => 31,
        5 => 32,
        6 => 45
    );
    $status = array(
        "Y" => 1,
        "N" => 0
    );
    foreach($json as $key => $val) {
        if($val["contact_type"] == 0) $val["contact_type"] = 1;

        $groups = array(1);
        if($val["INFO"] == 1) $groups = array();

        $Fields = array(
            "NAME"              => $val["NAME"],                                                                    // Имя
            "LAST_NAME"         => $val["LAST_NAME"],                                                               // Фамилия
            "LOGIN"             => $val["EMAIL"] ? $val["EMAIL"] : $val["app_id"].time().'@xyz.xyz',                // Логин
            "EMAIL"             => $val["EMAIL"] ? $val["EMAIL"] : $val["app_id"].time().'kentlabemail@xyz.xyz',    // Эл. почта
            "ACTIVE"            => "Y",                                                                             // Активность
            "PASSWORD"          => $val["app_id"].time(),                                                           // Пароль
            "CONFIRM_PASSWORD"  => $val["app_id"].time(),                                                           // Повторение паролья
            "PERSONAL_MOBILE"   => $val["PERSONAL_MOBILE"],                                                         // Номер телефона
            "PERSONAL_BIRTHDAY" => $val["PERSONAL_BIRTHDAY"],                                                       // День рождения
            "UF_FB_PROFILE"     => array($val["UF_FB"]),                                                            // Профиль ФБ
            "UF_VK_PROFILE"     => array($val["UF_VK"]),                                                            // Профиль ВК
            "UF_GP_PROFILE"     => array($val["UF_G_PLUS"]),                                                        // Профиль Г+
            "UF_MARK_1"         => $val["UF_MARK_1"],                                                               // Марка сигарет
            "UF_MARK_2"         => $val["UF_MARK_2"],                                                               // Марка сигарет 2
            "ADMIN_NOTES"       => $val["ADMIN_NOTES"],                                                             // Комментарий
            "UF_INFO"           => $val["INFO"],                                                                    // Комментарий
            "UF_IAGREE"         => 1,                                                                               // Согласен с правилами
            "UF_YOU_HAVE_18"    => 1,                                                                               // Есть 18
            "UF_DO_YOU_SMOKE"   => 1,                                                                               // Курильщик
            "UF_EVENT"          => $val["UF_EVENT"],                                                                // Мероприятие
            "UF_APP_ID"         => $val["app_id"],                                                                  // ID приложения
            "UF_STATUS"         => $contact_type[$val["contact_type"]],                                             // Стутус
            "UF_GROUPS"         => $groups                                                                          // Группы
        );

        // Проверка на существование логина
        $checkLogin = $USER->GetByLogin($Fields["LOGIN"])->Fetch();
        if(empty($checkLogin)) {

            // Устанавливаем родителя
            if(!empty($val["PARENT_NAME"])) {
                $arUser                   = $USER->GetByLogin($val["PARENT_NAME"])->Fetch();
                $Fields["UF_USER_PARENT"] = $arUser["ID"];
            } elseif($USER->GetID() > 0) {
                $Fields["UF_USER_PARENT"] = $USER->GetID();
            }

            // Устанавливаем дату регистрации
            if(!empty($val["REG_DATE"])) {
                $Fields["DATE_REGISTER"] = $val["REG_DATE"];
            }

            // Добавляем пользователя
            $user = new CUser;
            $ID = $user->Add($Fields);

            if(intval($ID) > 0) {

                // Записываем в лог регистрацию
                $el_log = new CIBlockElement;
                $PROP_log = array(
                    'ID'                => $ID,
                    'PERSONAL_BIRTHDAY' => $val["PERSONAL_BIRTHDAY"],
                    'PARENT_USER'       => $Fields["UF_USER_PARENT"],
                    'UF_IAGREE'         => $status[$val["UF_IAGREE"]],
                    'UF_YOU_HAVE_18'    => $status[$val["UF_YOU_HAVE_18"]],
                    'UF_DO_YOU_SMOKE'   => $status[$val["UF_DO_YOU_SMOKE"]],
                    'TYPE'              => "app_user_add"
                );
                $arLoadProductArray_log = Array(
                    "IBLOCK_ID"       => 26,
                    "PROPERTY_VALUES" => $PROP_log,
                    "NAME"            => $ID
                );
                $el_log->Add($arLoadProductArray_log);


                // Создаем Токен для пользователя
                $Hash = md5($ID.$USER->GetID().time());

                // Если указана почта отправляем ему письмо с токеном, логином и паролем
                if(!empty($val["EMAIL"])) {

                    CModule::IncludeModule("main");

                    $arEventFields = array(
                        "USER_ID"   => $ID,
                        "LOGIN"     => $Fields["LOGIN"],
                        "EMAIL"     => $Fields["EMAIL"],
                        "NAME"      => $Fields["NAME"],
                        "LAST_NAME" => $Fields["LAST_NAME"],
                        "PASSWORD"  => $Fields["PASSWORD"],
                        "TOKEN"     => $Hash
                    );

                    $userFields = $USER->GetByID($USER->GetID())->Fetch();
                    if($userFields["PERSONAL_CITY"] == "Екатеринбург") {
                        CEvent::SendImmediate("NEW_APP_USER", "s1", $arEventFields);
                    } else {
                        CEvent::SendImmediate("NEW_USER_NEW", "s1", $arEventFields);
                    }
                }

                // Обновляем счетчик для группы KENT Lab
                $usersInGroup = CIBlockElement::GetProperty(4, 1, array("sort" => "asc"), Array("CODE"=>"USERS"))->Fetch();
                $usersInGroup["VALUE"]++;
                CIBlockElement::SetPropertyValues(1, 4, $usersInGroup["VALUE"], "USERS");

                // Сохраняем токены
                $Field["UF_HASH"] = $Hash;
                $Field["UF_TOKEN"] = $Hash;
                $USER->Update($ID, $Field);


                // Добавляем записи в KPI
                $arKpi = CIBlockElement::GetList(Array(), Array("IBLOCK_ID"=>17, "><DATE_ACTIVE_FROM" => array(date($DB->DateFormatToPHP(CLang::GetDateFormat("SHORT")), mktime(0,0,0,date("n"),1,date("Y"))), date($DB->DateFormatToPHP(CLang::GetDateFormat("SHORT")), mktime(0,0,0,date("n")+1,1,date("Y")))), "PROPERTY_USER_ID" => $USER->GetID()), false, false, Array("*"));
                while($obKpi = $arKpi->GetNextElement()) {
                    $kpi = $obKpi->GetFields();
                }
                if($kpi["ID"] > 0) {
                    $kpiCount = CIBlockElement::GetProperty(17, $kpi["ID"], array("sort" => "asc"), Array("CODE"=>"KPI_".$val["contact_type"]))->Fetch();
                    $kpiCount["VALUE"]++;
                    CIBlockElement::SetPropertyValues($kpi["ID"], 17, $kpiCount["VALUE"], "KPI_".$val["contact_type"]);
                } else {
                    $kpi = array(1 => 103, 2 => 104, 3 => 105, 4 => 106, 5 => 107);
                    $el = new CIBlockElement;
                    $PROP = array();
                    $PROP[101] = $USER->GetID();
                    $PROP[$kpi[$val["contact_type"]]] = 1;
                    $arLoadProductArray = Array(
                        "IBLOCK_ID"      => 17,
                        "PROPERTY_VALUES"=> $PROP,
                        "NAME"           => $USER->GetLogin(),
                        "DATE_ACTIVE_FROM" => date("d.m.Y H:i:s")
                    );
                    $el->Add($arLoadProductArray);
                }


                // Записываем информацию в лог

                $data = array(
                    "UF_USER"        => $ID,
                    "UF_AMPLIFIER"   => $Fields["UF_USER_PARENT"],
                    "UF_EVENT"       => $val["UF_EVENT"],
                    "UF_DATE_TIME"   => date("d.m.Y H:i:s"),
                    "UF_ACTION_CODE" => 101,
                    "UF_ACTION_TEXT" => "add",
                    "UF_TYPE"        => $val["contact_type"],
                    "UF_TYPE_2"      => $val["contact_type"]
                );

                addToHLBlock(4, $data);


                //++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
                /*            unset($UF_TYPE);
                            $UF_TYPE = 2;
                            if(strlen(trim($val["EMAIL"]))>0)
                            {
                                $UF_TYPE = 3;
                            }
                            if (strlen(trim($val["UF_FB"])) > 0 || strlen(trim($val["UF_G_PLUS"])) > 0 || strlen(trim($val["UF_VK"])) > 0)
                            {
                                $UF_TYPE = 4;
                            }*/
                CEventLog::Add(array(
                    "SEVERITY"      => "SECURITY",
                    "AUDIT_TYPE_ID" => "TESTER",
                    "MODULE_ID"     => "iblock",
                    "ITEM_ID"       => $val["ID"],
                    "DESCRIPTION"   => json_encode($val),
                ));

                $logKPI::add(
                    array(
                        'UF_USER' => $ID,
                        'UF_AMPLIFIER' => $USER->GetID(),
                        'UF_EVENT' => $val["UF_EVENT"],
                        'UF_DATE_TIME' => date("Y-m-d H:i:s"),
                        'UF_ACTION_CODE' => 101,
                        'UF_ACTION_TEXT' => "add",
                        'UF_TYPE' => $arUserType[1][$val["contact_type"]],
                        'UF_TYPE_2' => $arUserType[2][$val["contact_type"]],
                        "UF_PARENT" => json_encode($val)
                    )
                );
                //++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++



            }

            if(intval($ID) > 0)
                $res[] = array(
                    "status"      => "OK",
                    "status_msg"  => "NewUserAdd",
                    "date_update" => date("Y-m-d H:i:s", time()),
                    "app_id"      => $val["app_id"] ? $val["app_id"] : 0,
                    "ID"          => $ID,
                    "hash"        => $Hash,
                    "type"        => $val["contact_type"] ? $val["contact_type"] : 0
                );
            else
                $res[] = array(
                    "status"     => "ERROR",
                    "status_msg" => str_replace('&quot;', '', strip_tags($user->LAST_ERROR)),
                    "app_id"     => $val["app_id"] ? $val["app_id"] : 0
                );
        }
    }
    getResultJSON(
        $res
    );
}

/**
    Обновление контакта
*/
if($_REQUEST["mode"] == "update_contact") {
    if(!$USER->IsAuthorized()) exit();

    $json = json_decode(file_get_contents('php://input'), true);
    if (!isValidJSON($json)) exit();

    $contact_type = array(
        1 => 28,
        2 => 29,
        3 => 30,
        4 => 31,
        5 => 32,
        6 => 45
    );
    $contact_type_ret = array(
        28 => 1,
        29 => 2,
        30 => 3,
        31 => 4,
        32 => 5,
        45 => 6
    );
    $status = array(
        "Y" => 1,
        "N" => 0
    );
    foreach($json as $key => $val)
    {
        // Создаем запись в логе
        CEventLog::Add(array(
            "SEVERITY" => "SECURITY",
            "AUDIT_TYPE_ID" => "TESTER",
            "MODULE_ID" => "iblock",
            "ITEM_ID" => $val["ID"],
            "DESCRIPTION" => json_encode($val),
        ));





        $Fields = array(
            "NAME"            => $val["NAME"],              // Имя
            "LAST_NAME"       => $val["LAST_NAME"],         // Фамилия
            "PERSONAL_MOBILE" => $val["PERSONAL_MOBILE"],   // Телефон
            "UF_FB_PROFILE"   => array($val["UF_FB"]),      // Профиль ФБ
            "UF_VK_PROFILE"   => array($val["UF_VK"]),      // Профиль ВК
            "UF_GP_PROFILE"   => array($val["UF_G_PLUS"]),  // Профиль Г+
            "UF_MARK_1"       => $val["UF_MARK_1"],         // Марка сигарет
            "UF_MARK_2"       => $val["UF_MARK_2"],         // Марка сигарет 2
            "ADMIN_NOTES"     => $val["ADMIN_NOTES"],       // Комментарии
            "INFO"            => $val["INFO"],              // Комментарии
            "UF_EVENT"        => $val["UF_EVENT"],          // Событие
            "UF_APP_ID"       => $val["app_id"],            // ID приложения
            "UF_BRAND_ID"     => $val["brand_id"],          // Бренд
            "UF_BRAND_NAME"   => $val["brand_name"]         // Название бренда
        );
        if($val["contact_type"]) {
            $Fields["UF_STATUS"] = $contact_type[$val["contact_type"]]; // Статус пользователя
        }
        if($val["EMAIL"]) {
            $Fields["LOGIN"] = $val["EMAIL"]; // Логин
            $Fields["EMAIL"] = $val["EMAIL"]; // Почта
        }
        if($val["PERSONAL_BIRTHDAY"]) {
            $Fields["PERSONAL_BIRTHDAY"] = $val["PERSONAL_BIRTHDAY"]; // День рождения
        }
        $userType = $USER->GetByID($val["ID"])->Fetch();
        $arrUserOldData = $userType;

        $user = new CUser;
        $ID = $user->Update($val["ID"], $Fields);

        $el_log = new CIBlockElement;
        $PROP_log = array(
            "ID"                => $val["ID"],
            "PERSONAL_BIRTHDAY" => $val["PERSONAL_BIRTHDAY"],
            "UF_IAGREE"         => $status[$val["UF_IAGREE"]],
            "UF_YOU_HAVE_18"    => $status[$val["UF_YOU_HAVE_18"]],
            "UF_DO_YOU_SMOKE"   => $status[$val["UF_DO_YOU_SMOKE"]],
            "TYPE"              => "app_user_update"
        );
        $arLoadProductArray_log = Array(
            "IBLOCK_ID"      => 26,
            "PROPERTY_VALUES"=> $PROP_log,
            "NAME"           => $val["ID"]
        );
        $el_log->Add($arLoadProductArray_log);

        $data = array(
            "UF_USER"        => $val["ID"],
            "UF_AMPLIFIER"   => $USER->GetID(),
            "UF_EVENT"       => $val["UF_EVENT"],
            "UF_DATE_TIME"   => date("d.m.Y H:i:s"),
            "UF_ACTION_CODE" => 102,
            "UF_ACTION_TEXT" => "update",
            "UF_TYPE"        => $contact_type_ret[$userType["UF_STATUS"]],
            "UF_TYPE_2"      => $val["contact_type"] ? $val["contact_type"] : $userType["UF_STATUS"]
        );
        addToHLBlock(4, $data);

        if(intval($ID) > 0)
        {


            //++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
            /*            $logKPI::add(
                            array(
                                'UF_USER' => IntVal($val["ID"]),
                                'UF_AMPLIFIER' => $USER->GetID(),
                                'UF_EVENT' => '0',
                                'UF_DATE_TIME' => date("Y-m-d H:i:s"),
                                'UF_ACTION_CODE' => 102,
                                'UF_ACTION_TEXT' => "update",
                                'UF_TYPE' => $arUserType[1][getUserType(IntVal($val["ID"]))],
                                'UF_TYPE_2' =>  $arUserType[2][getUserType(IntVal($val["ID"]))]
                            )
                        );*/

            /*if($val["contact_type"]=='5')
            {*/

            $logKPI::add(
                array(
                    'UF_USER' => IntVal($val["ID"]),
                    'UF_AMPLIFIER' => $USER->GetID(),
                    'UF_EVENT' => '0',
                    'UF_DATE_TIME' => date("Y-m-d H:i:s"),
                    'UF_ACTION_CODE' => 103,
                    'UF_ACTION_TEXT' => "change_status",
                    'UF_TYPE' => $arUserType[1][getUserType(IntVal($val["ID"]))],
                    'UF_TYPE_2' =>  $arUserType[2][$val["contact_type"]],
                    'UF_BRAND_1'=>$arrUserOldData['UF_BRAND_NAME'],
                    'UF_BRAND_2'=>$val["brand_name"]

                )
            );
            /*    }
                elseif(strlen($val["EMAIL"])>0)
                {
                    $UF_TYPE = 3;
                    $logKPI::add(
                        array(
                            'UF_USER' => IntVal($val["ID"]),
                            'UF_AMPLIFIER' => $USER->GetID(),
                            'UF_EVENT' => '0',
                            'UF_DATE_TIME' => date("Y-m-d H:i:s"),
                            'UF_ACTION_CODE' => 103,
                            'UF_ACTION_TEXT' => "change_status",
                            'UF_TYPE' => $arUserType[1][getUserType(IntVal($val["ID"]))],
                            'UF_TYPE_2' =>  $arUserType[2][$UF_TYPE]
                        )
                    );
                }
                elseif (strlen(trim($val["UF_FB"])) > 0 || strlen(trim($val["UF_G_PLUS"])) > 0 || strlen(trim($val["UF_VK"])) > 0)
                {
                    $UF_TYPE = 4;
                    $logKPI::add(
                        array(
                            'UF_USER' => IntVal($val["ID"]),
                            'UF_AMPLIFIER' => $USER->GetID(),
                            'UF_EVENT' => '0',
                            'UF_DATE_TIME' => date("Y-m-d H:i:s"),
                            'UF_ACTION_CODE' => 103,
                            'UF_ACTION_TEXT' => "change_status",
                            'UF_TYPE' => $arUserType[1][getUserType(IntVal($val["ID"]))],
                            'UF_TYPE_2' =>  $arUserType[2][$UF_TYPE]
                        )
                    );
                }*/
            //++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++


            $res[] = array(
                "status" => "OK",
                "status_msg" => "UserUpdate",
                "date_update" => date("Y-m-d H:i:s", time()),
                "app_id" => $val["app_id"] ? $val["app_id"] : 0,
                "ID" => $val["ID"],
                "type" => $val["contact_type"] ? $val["contact_type"] : 0
            );
        }
        else
        {
            $res[] = array(
                "status" => "ERROR",
                "status_msg" => strip_tags($user->LAST_ERROR),
                "app_id" => $val["app_id"] ? $val["app_id"] : 0
            );
        }
    }
    print json_encode($res, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
}

/**
    Проверка авторизован ли пользователь
*/
if($_REQUEST["mode"] == "isloggedin") {
    if($USER->IsAuthorized())
        getResultJSON(
            array(
                "status"     => "OK",
                "status_msg" => "Вы авторизованы"
            )
        );
    else
        getResultJSON(
            array(
                "status"      => "ERROR",
                "status_msg"  => "Вы не авторизованы",
                "status_code" => 102
            )
        );
}

/**
    Получение значений KPI
*/
if($_REQUEST["mode"] == "get_kpi") {
    if(!$USER->IsAuthorized()) exit();

    $arKpi = CIBlockElement::GetList(Array(), Array("IBLOCK_ID"=>16, "PROPERTY_TYPE" => 27), false, false, Array("*"));
    while($obKpi = $arKpi->GetNextElement()) {
        $kpi["FIELDS"] = $obKpi->GetFields();
        $kpi["PROPERTIES"] = $obKpi->GetProperties();

        $arKpiRes = CIBlockElement::GetList(Array(), Array("IBLOCK_ID"=>17, "><DATE_ACTIVE_FROM" => array(date($DB->DateFormatToPHP(CLang::GetDateFormat("SHORT")), mktime(0,0,0,date("n"),1,date("Y"))), date($DB->DateFormatToPHP(CLang::GetDateFormat("SHORT")), mktime(0,0,0,date("n")+1,1,date("Y")))), "PROPERTY_USER_ID" => $USER->GetID()), false, false, Array("*"));
        while($obKpiRes = $arKpiRes->GetNextElement()) {
            $kpiRes["FIELDS"] = $obKpiRes->GetFields();
            $kpiRes["PROPERTIES"] = $obKpiRes->GetProperties();
        }
    }
    getResultJSON(
        array(
            "status" => "OK",
            "status_msg" => "KPI",
            "data" => array(
                0 => array(
                    "sum"        => $kpiRes["PROPERTIES"]["KPI_1"]["VALUE"] ? $kpiRes["PROPERTIES"]["KPI_1"]["VALUE"] : 0,
                    "type"       => 1,
                    "target_kpi" => $kpi["PROPERTIES"]["KPI_1"]["VALUE"] ? $kpi["PROPERTIES"]["KPI_1"]["VALUE"]       : 0
                ),
                1 => array(
                    "sum"        => $kpiRes["PROPERTIES"]["KPI_2"]["VALUE"] ? $kpiRes["PROPERTIES"]["KPI_2"]["VALUE"] : 0,
                    "type"       => 2,
                    "target_kpi" => $kpi["PROPERTIES"]["KPI_2"]["VALUE"] ? $kpi["PROPERTIES"]["KPI_2"]["VALUE"]       : 0
                ),
                2 => array(
                    "sum"        => $kpiRes["PROPERTIES"]["KPI_3"]["VALUE"] ? $kpiRes["PROPERTIES"]["KPI_3"]["VALUE"] : 0,
                    "type"       => 3,
                    "target_kpi" => $kpi["PROPERTIES"]["KPI_3"]["VALUE"] ? $kpi["PROPERTIES"]["KPI_3"]["VALUE"]       : 0
                ),
                3 => array(
                    "sum"        => $kpiRes["PROPERTIES"]["KPI_4"]["VALUE"] ? $kpiRes["PROPERTIES"]["KPI_4"]["VALUE"] : 0,
                    "type"       => 4,
                    "target_kpi" => $kpi["PROPERTIES"]["KPI_4"]["VALUE"] ? $kpi["PROPERTIES"]["KPI_4"]["VALUE"]       : 0
                ),
                4 => array(
                    "sum"        => $kpiRes["PROPERTIES"]["KPI_5"]["VALUE"] ? $kpiRes["PROPERTIES"]["KPI_5"]["VALUE"] : 0,
                    "type"       => 5,
                    "target_kpi" => $kpi["PROPERTIES"]["KPI_5"]["VALUE"] ? $kpi["PROPERTIES"]["KPI_5"]["VALUE"]       : 0
                )
            )
        )
    );
}

/*
    Получаем список пользователей
*/
if($_REQUEST["mode"] == "get_contact_list") {
    if(!$USER->IsAuthorized()) exit();

    $dbUsers = CUser::GetList(($by="ID"), ($order="ASC"), array("UF_USER_PARENT" => $USER->GetID()), array("SELECT"=>array("UF_*")));
    $arUsers = array();
    $contact_type_ret = array(
        28 => 1,
        29 => 2,
        30 => 3,
        31 => 4,
        32 => 5,
        45 => 4
    );
    while($arUser = $dbUsers->Fetch()) {
        $user = array(
            "invite_status"        => $arUser["UF_INVITE_STATUS"] ? $arUser["UF_INVITE_STATUS"]      : 0,
            "hash"                 => $arUser["UF_HASH"] ? $arUser["UF_HASH"]                        : "",
            "type"                 => $arUser["UF_STATUS"] ? $contact_type_ret[$arUser["UF_STATUS"]] : 0,
            "brand_id"             => $arUser["UF_BRAND_ID"] ? $arUser["UF_BRAND_ID"]                : 0,
            "brand_name"           => $arUser["UF_BRAND_NAME"] ? $arUser["UF_BRAND_NAME"]            : "",
            "ID"                   => $arUser["ID"],
            "DATE_REGISTER"        => $arUser["DATE_REGISTER"],
            "DATE_UPDATE"          => $arUser["TIMESTAMP_X"],
            "LAST_LOGIN"           => $arUser["LAST_LOGIN"] ? $arUser["LAST_LOGIN"]                  : "",
            "NAME"                 => $arUser["NAME"] ? $arUser["NAME"]                              : "",
            "LAST_NAME"            => $arUser["LAST_NAME"] ? $arUser["LAST_NAME"]                    : "",
            "EMAIL"                => strpos($arUser["EMAIL"], "@xyz.xyz") ? ""                      : $arUser["EMAIL"],
            "PERSONAL_MOBILE"      => $arUser["PERSONAL_MOBILE"] ? $arUser["PERSONAL_MOBILE"]        : "",
            "PERSONAL_BIRTHDAY"    => $arUser["PERSONAL_BIRTHDAY"] ? $arUser["PERSONAL_BIRTHDAY"]    : "",
            "UF_FB"                => $arUser["UF_FB_PROFILE"][0] ? $arUser["UF_FB_PROFILE"][0]      : "",
            "UF_VK"                => $arUser["UF_VK_PROFILE"][0] ? $arUser["UF_VK_PROFILE"][0]      : "",
            "UF_G_PLUS"            => $arUser["UF_GP_PROFILE"][0] ? $arUser["UF_GP_PROFILE"][0]      : "",
            "UF_MARK_1"            => $arUser["UF_MARK_1"] ? $arUser["UF_MARK_1"]                    : "",
            "UF_MARK_2"            => $arUser["UF_MARK_2"] ? $arUser["UF_MARK_2"]                    : "",
            "UF_DO_YOU_SMOKE"      => $arUser["UF_DO_YOU_SMOKE"] ? "Y"                               : "N",
            "UF_YOU_HAVE_18"       => $arUser["UF_YOU_HAVE_18"] ? "Y"                                : "N",
            "ADMIN_NOTES"          => $arUser["ADMIN_NOTES"] ? $arUser["ADMIN_NOTES"]                : "",
            "PERSONAL_PHOTO_SMALL" => array(),
            "PERSONAL_PHOTO_BIG"   => array()
        );
        if($arUser["PERSONAL_PHOTO"]) {
            $user["PERSONAL_PHOTO_SMALL"] = CFile::ResizeImageGet($arUser["PERSONAL_PHOTO"], array('width'=>192, 'height'=>192), BX_RESIZE_IMAGE_EXACT, true);
            $user["PERSONAL_PHOTO_BIG"] = CFile::ResizeImageGet($arUser["PERSONAL_PHOTO"], array('width'=>800, 'height'=>800), BX_RESIZE_IMAGE_EXACT, true);
        }
        $arUsers[] = $user;
    }
    getResultJSON(
        array(
            "status" => "OK",
            "status_msg" => "ContactList",
            "contact_list" => $arUsers
        )
    );
}

//get_event_list
if($_REQUEST["mode"] == "get_event_list") {
    if(!$USER->IsAuthorized()) exit();

    $arEvents = CIBlockElement::GetList(Array(), Array("IBLOCK_ID" => 2), false, false, Array("*"));
    $events = array();
    while($obEvents = $arEvents->GetNextElement()) {
        $event["FIELDS"] = $obEvents->GetFields();
        $event["PROPERTIES"] = $obEvents->GetProperties();

        $arKpi = CIBlockElement::GetList(Array(), Array("IBLOCK_ID"=>16, "PROPERTY_EVENT_ID" => $event["FIELDS"]["ID"]), false, false, Array("*"));

        while($obKpi = $arKpi->GetNextElement()) {
            $kpi["FIELDS"]     = $obKpi->GetFields();
            $kpi["PROPERTIES"] = $obKpi->GetProperties();

            $arKpiRes = CIBlockElement::GetList(Array(), Array("IBLOCK_ID"=>17, "PROPERTY_EVENT_ID" => $event["FIELDS"]["ID"], "PROPERTY_USER_ID" => $USER->GetID()), false, false, Array("*"));
            while($obKpiRes = $arKpiRes->GetNextElement()) {
                $kpiRes["FIELDS"]     = $obKpiRes->GetFields();
                $kpiRes["PROPERTIES"] = $obKpiRes->GetProperties();
            }
        }

        if($event["PROPERTIES"]["CREATED_USER_ID"]["VALUE"] > 0)
        {
            $rsCreatedUser = CUser::GetByID($event["PROPERTIES"]["CREATED_USER_ID"]["VALUE"]);
            $arCreatedUser = $rsCreatedUser->Fetch();
        }


        $events[] = array(
            "ID"                 => $event["FIELDS"]["ID"],
            "NAME"               => addslashes($event["FIELDS"]["NAME"]),
            "DATE_EVENT"         => $event["PROPERTIES"]["START_DATE"]["VALUE"]  ? $event["PROPERTIES"]["START_DATE"]["VALUE"]            : "",
            "DATE_EVENT_END"     => $event["PROPERTIES"]["END_DATE"]["VALUE"]    ? $event["PROPERTIES"]["END_DATE"]["VALUE"]              : "",
            "OG_DESCRIPTION"     => $event["FIELDS"]["PREVIEW_TEXT"]             ? strip_tags($event["FIELDS"]["PREVIEW_TEXT"])           : "",
            "USERS"              => $event["PROPERTIES"]["USERS"]["VALUE"]       ? $event["PROPERTIES"]["USERS"]["VALUE"]                 : array(),
            "PLACE_EVENT"        => $event["PROPERTIES"]["PLACE_EVENT"]["VALUE"] ? $event["PROPERTIES"]["PLACE_EVENT"]["VALUE"]           : "",
            "CLUB_NAME"          => ($event["PROPERTIES"]["CLUB_NAME"]["VALUE"]  ? addslashes($event["PROPERTIES"]["CLUB_NAME"]["VALUE"]) : ""),


            "CREATED_USER_ID"    => $event["PROPERTIES"]["CREATED_USER_ID"]["VALUE"],
            "CREATED_USER_LOGIN" => (($event["PROPERTIES"]["CREATED_USER_ID"]["VALUE"] > 0) ? $arCreatedUser['LOGIN'] : ""),
            "LINK"               => $event["PROPERTIES"]["LINK"]["VALUE"],


            "kpi" => array(
                0 => array(
                    "type"       => 1,
                    "target_kpi" => $kpi["PROPERTIES"]["KPI_1"]["VALUE"] ? $kpi["PROPERTIES"]["KPI_1"]["VALUE"] : 0,
                    "sum"        => $kpiRes["PROPERTIES"]["KPI_1"]["VALUE"] ? $kpiRes["PROPERTIES"]["KPI_1"]["VALUE"] : 0
                ),
                1 => array(
                    "type"       => 2,
                    "target_kpi" => $kpi["PROPERTIES"]["KPI_2"]["VALUE"] ? $kpi["PROPERTIES"]["KPI_2"]["VALUE"] : 0,
                    "sum"        => $kpiRes["PROPERTIES"]["KPI_2"]["VALUE"] ? $kpiRes["PROPERTIES"]["KPI_2"]["VALUE"] : 0
                ),
                2 => array(
                    "type"       => 3,
                    "target_kpi" => $kpi["PROPERTIES"]["KPI_3"]["VALUE"] ? $kpi["PROPERTIES"]["KPI_3"]["VALUE"] : 0,
                    "sum"        => $kpiRes["PROPERTIES"]["KPI_3"]["VALUE"] ? $kpiRes["PROPERTIES"]["KPI_3"]["VALUE"] : 0
                ),
                3 => array(
                    "type"       => 4,
                    "target_kpi" => $kpi["PROPERTIES"]["KPI_4"]["VALUE"] ? $kpi["PROPERTIES"]["KPI_4"]["VALUE"] : 0,
                    "sum"        => $kpiRes["PROPERTIES"]["KPI_4"]["VALUE"] ? $kpiRes["PROPERTIES"]["KPI_4"]["VALUE"] : 0
                ),
                4 => array(
                    "type"       => 5,
                    "target_kpi" => $kpi["PROPERTIES"]["KPI_5"]["VALUE"] ? $kpi["PROPERTIES"]["KPI_5"]["VALUE"] : 0,
                    "sum"        => $kpiRes["PROPERTIES"]["KPI_5"]["VALUE"] ? $kpiRes["PROPERTIES"]["KPI_5"]["VALUE"] : 0
                )
            )
        );
    }
    getResultJSON(
        array(
            "event_list" => $events,
            "status" => "OK",
            "status_msg" => "EventList"
        )
    );
}

//get_brand_list
if($_REQUEST["mode"] == "get_brand_list") {
    if(!$USER->IsAuthorized()) exit();

    $res = CIBlockElement::GetList(Array(), Array("IBLOCK_ID" => 24), false, false, Array("*"));
    $brands = array();
    while($ob = $res->GetNextElement()) {
        $arResult["FIELDS"] = $ob->GetFields();

        $brands[] = array(
            "brand_id"   => $arResult["FIELDS"]["ID"],
            "brand_name" => $arResult["FIELDS"]["NAME"]
        );
    }
    getResultJSON(
        array(
            "brand_list" => $brands,
            "status"     => "OK",
            "status_msg" => "BrandList"
        )
    );
}

/**
    Загрузка фотографии пользователя
*/
if($_REQUEST["mode"] == "put_photo") {
    if(!$USER->IsAuthorized()) exit();

    $full_path = $_SERVER['DOCUMENT_ROOT'].'/upload/tmp_selfie/'.$_REQUEST['UF_USER'].'.jpg';
    $input = fopen("php://input", "r");
    $target = fopen($full_path, "w");
    stream_copy_to_stream($input, $target);
    fclose($input);
    fclose($target);
    CModule::IncludeModule("main");
    $arFile = CFile::MakeFileArray($full_path);
    $arFile['MODULE_ID'] = 'main';
    $fid = CFile::SaveFile($arFile, "selfie");
    $Fields = array(
        "PERSONAL_PHOTO" => CFile::MakeFileArray($fid),
        "UF_STATUS" => 32,
        "UF_EVENT" => $_REQUEST['UF_EVENT']
    );
    $userType = $USER->GetByID($_REQUEST['UF_USER'])->Fetch();
    $user = new CUser;
    $res = $user->Update($_REQUEST['UF_USER'], $Fields);
    $contact_type_ret = array(
        28 => 1,
        29 => 2,
        30 => 3,
        31 => 4,
        32 => 5,
        45 => 6
    );


    $arKpi = CIBlockElement::GetList(Array(), Array(
        "IBLOCK_ID"          => 17,
        "PROPERTY_USER_ID"   => $USER->GetID(),
        "><DATE_ACTIVE_FROM" => array(
            date(
                $DB->DateFormatToPHP(CLang::GetDateFormat("SHORT")),
                mktime(0,0,0,date("n"),1,date("Y"))
            ),
            date(
                $DB->DateFormatToPHP(CLang::GetDateFormat("SHORT")),
                mktime(0,0,0,date("n")+1,1,date("Y"))
            )
        )), false, false, Array("*"));

    while($obKpi = $arKpi->GetNextElement()) {
        $kpi = $obKpi->GetFields();
    }
    if($kpi["ID"] > 0) {
        $kpiCount = CIBlockElement::GetProperty(17, $kpi["ID"], array("sort" => "asc"), Array("CODE"=>"KPI_5"))->Fetch();
        $kpiCount["VALUE"]++;
        CIBlockElement::SetPropertyValues($kpi["ID"], 17, $kpiCount["VALUE"], "KPI_5");
    } else {
        $kpi = array(1 => 103, 2 => 104, 3 => 105, 4 => 106, 5 => 107);
        $el = new CIBlockElement;
        $PROP = array();
        $PROP[101] = $USER->GetID();
        $PROP[$kpi[5]] = 1;
        $arLoadProductArray = Array(
            "IBLOCK_ID"        => 17,
            "PROPERTY_VALUES"  => $PROP,
            "NAME"             => $USER->GetLogin(),
            "DATE_ACTIVE_FROM" => date("Y.m.d H:i")
        );
        $el->Add($arLoadProductArray);
    }

    $data = array(
        "UF_USER"        => $_REQUEST['UF_USER'],
        "UF_AMPLIFIER"   => $USER->GetID(),
        "UF_EVENT"       => $_REQUEST['UF_EVENT'] ? $_REQUEST['UF_EVENT'] : 0,
        "UF_DATE_TIME"   => date("d.m.Y H:i:s"),
        "UF_ACTION_CODE" => 103,
        "UF_ACTION_TEXT" => "change_status",
        "UF_TYPE"        => $contact_type_ret[$userType["UF_STATUS"]],
        "UF_TYPE_2"      => 5
    );
    addToHLBlock(4, $data);

    $data = array(
        'UF_AMPLIFIER' => $USER->GetID(),
        'UF_USER'      => $_REQUEST['UF_USER'],
        'UF_EVENT'     => $_REQUEST['UF_EVENT'] ? $_REQUEST['UF_EVENT'] : 0,
        'UF_IMAGE'     => $fid
    );
    addToHLBlock(3, $data);


    // Запись в лог об изменение статуса пользователя
    $logKPI::add(
        array(
            'UF_USER'        => IntVal($_REQUEST['UF_USER']),
            'UF_AMPLIFIER'   => $USER->GetID(),
            'UF_EVENT'       => $_REQUEST['UF_EVENT'] ? $_REQUEST['UF_EVENT'] : 0,
            'UF_DATE_TIME'   => date("Y-m-d H:i:s"),
            'UF_ACTION_CODE' => 103,
            'UF_ACTION_TEXT' => "change_status",
            'UF_TYPE'        => $arUserType[1][getUserType(IntVal($_REQUEST['UF_USER']))],
            'UF_TYPE_2'      => $arUserType[2][5]
        )
    );

    if($res)
        getResultJSON(
            array(
                "status"     => "OK",
                "status_msg" => "put_photo_ok"
            )
        );
    else
        getResultJSON(
            array(
                "status"     => "ERROR",
                "status_msg" => "put_photo_error"
            )
        );
}


/**
    Добавление события
*/
if($_REQUEST["mode"] == "new_event")
{
    if(!$USER->IsAuthorized()) exit();

    $json = json_decode(file_get_contents('php://input'), true);

    CEventLog::Add(array(
        "SEVERITY"      => "WARNING",
        "AUDIT_TYPE_ID" => "SEND_EVENT",
        "MODULE_ID"     => "iblock",
        "ITEM_ID"       => "",
        "DESCRIPTION"   => json_encode($json),
    ));

    if (!isValidJSON($json)) exit();

    foreach($json as $key => $val)
    {

        $el = new CIBlockElement;
        $PROP = array(
            'CREATED_USER_ID' => $USER->GetID(),         // Кем создано
            'CLUB_NAME'       => $val["CLUB_NAME"],      // Название клуба
            'OG_DESCRIPTION'  => $val["OG_DESCRIPTION"], // Описание события
            'LINK'            => $val["LINK"],           // Ссылка
            'PLACE_EVENT'     => $val["PLACE_EVENT"],    // Адрес
            'START_DATE'      => ConvertTimeStamp(MakeTimeStamp($val["DATE_EVENT"], "DD.MM.YYYY HH:MI"), "FULL") // Дата
        );

        $arEvent = Array(
            "IBLOCK_ID"      => 2,
            "PROPERTY_VALUES"=> $PROP,
            "NAME"           => $val["NAME"],
            "DATE_ACTIVE_FROM" => ConvertTimeStamp(MakeTimeStamp($val["DATE_EVENT"], "DD.MM.YYYY HH:MI"), "FULL")
        );
        $res = $el->Add($arEvent);

        if($res)
            getResultJSON(
                array(
                    "status" => "OK",
                    "status_msg" => "new_event"
                )
            );
        else
            getResultJSON(
                array(
                    "status" => "ERROR",
                    "status_msg" => "new_event ".$el->LAST_ERROR
                )
            );
    }

}


require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/epilog_after.php");
?>
