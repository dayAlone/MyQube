<?
    require_once($_SERVER['DOCUMENT_ROOT']."/bitrix/modules/main/include.php");
    require_once($_SERVER["DOCUMENT_ROOT"].'/group/u_contest/include/check.php');
    require_once($_SERVER["DOCUMENT_ROOT"].'/group/u_contest/vendor/autoload.php');
    define("MANAGER", "ak@radia.ru");
	define("NO_KEEP_STATISTIC", true);
	define("NOT_CHECK_PERMISSIONS", true);
    CModule::IncludeModule("iblock");
    $labels = array(
        'type'    => 'Тип',
        'size'    => 'Размер',
        'address' => 'Адрес',
        'phone'   => 'Телефон',
        'email'   => 'Эл. почта'
    );
    $answers = array(
        1 => 0,
        2 => 1,
        3 => 2
    );
    function getNumber($h, $v) {
        switch ($h) {
            case 1:
                switch ($v) {
                    case 1:
                        return 1;
                    case 2:
                        return 2;
                    case 3:
                        return 3;
                }
            case 2:
                switch ($v) {
                    case 1:
                        return 4;
                    case 2:
                        return 5;
                    case 3:
                        return 6;
                }
            case 3:
                switch ($v) {
                    case 1:
                        return 7;
                    case 2:
                        return 8;
                    case 3:
                        return 9;
                }
        }
    }

    function getSections() {
        CModule::IncludeModule("iblock");
        $obCache  = new CPHPCache;
        $lifeTime = 60 * 60 * 2;
        $cacheId  = 'u_contest_sections';
        if($obCache->InitCache($lifeTime, $cacheId, "/")) {
            $vars = $obCache->GetVars();
            return $vars["SECTIONS"];
        } else {
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
    }

    if($USER->IsAuthorized()) {
        $user = $USER->GetID();
        $email = $USER->GetEmail();
        $sections = getSections();
        $current = checkExist($user, $email);
        $result = 'success';
        if (intval($current['ID']) > 0) {
            $ID = $current['ID'];
            $props = array();
            $fields = json_decode($_COOKIE['fields'], true);
            for ($i=1; $i < 4; $i++) {
                if (!isset($fields['q'.$i])) {
                    $fields['q'.$i] = 'N';
                }
                else if (intval($fields['q'.$i]) !== $answers[$i]) {
                    $result = 'error';
                    $fields['q'.$i] = 'N';
                }
                else {
                    $fields['q'.$i] = 'Y';
                }
            }
            if ($_REQUEST['debug']) var_dump($fields);

            foreach ($fields as $key => $field) {
                $props[strtoupper($key)] = $field;
            }

            if ($fields['type'] && $fields['horizont'] && $fields['vertical']) {
                $number = getNumber($fields['horizont'], $fields['vertical']);
                $props['NUMBER'] = $number;
                $src = $_SERVER["DOCUMENT_ROOT"].'/group/u_contest/images/email/'.$fields['type'].'/'.$fields['type'].'_design_dev_'.$fields['horizont'].'_'.$fields['vertical'].'.jpg';
                $raw = new CIBlockElement;
                $raw->Update($current['ID'], array('PREVIEW_PICTURE' => CFile::MakeFileArray($src)));
            }
            CIBlockElement::SetPropertyValuesEx($current['ID'], false, $props);

			if ($fields['email'] && $fields['phone'] && $fields['address']) {

                // Для отладки
                //CIBlockElement::Delete($ID);
                $raw = new CIBlockElement;
                $raw->Update($current['ID'], array("IBLOCK_SECTION_ID" => $sections['success']));

                $str = date("d.m.Y H:i:s").";".$ID.";".$number.";".$fields['size'].";".$fields['type'].";".$USER->GetFullName().";+7".preg_replace('/[^0-9]/', '', $fields['phone']).";доставка;".$fields['address'].";new;\n";
                $dir = $_SERVER["DOCUMENT_ROOT"].'/group/u_contest/orders/';
                $file = $dir.$ID.'.csv';

                // Письмо менеджеру
                if (!file_exists($dir)) mkdir($dir, 0777);
                file_put_contents($file, $str);
                $mail = new PHPMailer;
                $mail->isHTML(true);
                $mail->CharSet = "UTF-8";
                $mail->addAttachment($file);
                $mail->addAttachment($src, 'preview.png');
                $mail->setFrom('mail@myqube.ru', 'MyQube.ru');
                $mail->addAddress(MANAGER, 'Менеджер');
                $mail->Subject = "Новый заказ: ".$ID.'. '.$USER->GetFullName();
                $body = "<h1>Новый заказ</h1>";
                $body .= "<strong>Получатель</strong>: ".$USER->GetFullName()."<br/>";
                foreach ($fields as $key => $field) {
                    if ($labels[$key]) {
                        $body .= "<strong>".$labels[$key]."</strong>: ".$field."<br/>";
                    }
                }
                $body .= "<strong>Номер макета</strong>: ".$number."<br/>";
                $mail->Body = $body.'<br/><br/>';
                $mail->send();

                // Письмо клиенту
                $body = file_get_contents($_SERVER["DOCUMENT_ROOT"].'/group/u_contest/mail-3.html');
                $body = str_replace('#NAME#', $USER->GetFullName(), $body);
                $body = str_replace('#EMAIL#', $fields['email'], $body);
                $body = str_replace('#H#', $fields['horizont'], $body);
                $body = str_replace('#V#', $fields['vertical'], $body);
                $body = str_replace('#G#', $fields['type'], $body);
                $body = str_replace('#ID#', $ID, $body);
                $mail = new PHPMailer;
                $mail->isHTML(true);
                $mail->CharSet = "UTF-8";
                $mail->setFrom('mail@myqube.ru', 'MyQube.ru');
                $mail->addAddress($fields['email'], $USER->GetFullName());
                $mail->Subject = "Ваш свитшот от Kent";
                $mail->Body = $body;
                $mail->send();

                echo 'success';
            }
        } else {
            $props = array();
            $props['USER'] = $user;

            $array = Array(
				"ACTIVE"            => "Y",
                "NAME"              => "Заказ: ".$USER->GetFullName(),
				"IBLOCK_ID"         => IBLOCK_ID,
                "PROPERTY_VALUES"   => $props,
                "IBLOCK_SECTION_ID" => $sections['inprocess']
			);
            $raw = new CIBlockElement;
            $ID = $raw->Add($array);
        }

        echo $result;
    }
?>
