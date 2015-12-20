<?
    require_once($_SERVER['DOCUMENT_ROOT']."/bitrix/modules/main/include.php");
    require_once($_SERVER["DOCUMENT_ROOT"].'/group/u_contest/include/check.php');
    require_once($_SERVER["DOCUMENT_ROOT"].'/group/u_contest/vendor/autoload.php');
    define("MANAGER", "dp@radia.ru");
	define("NO_KEEP_STATISTIC", true);
	define("NOT_CHECK_PERMISSIONS", true);
    $labels = array(
        'type' => 'Тип',
        'size' => 'Размер',
        'address' => 'Адрес',
        'phone' => 'Телефон',
        'email' => 'Эл. почта'
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

    if($USER->IsAuthorized()) {
        $user = $USER->GetID();
        CModule::IncludeModule("iblock");

        if (!checkExist($user)) {
            $props = array();
            $props['USER'] = $user;
            $fields = json_decode($_COOKIE['fields'], true);
            foreach ($fields as $key => $field) {
                $props[strtoupper($key)] = $field;
            }
            $src = $_SERVER["DOCUMENT_ROOT"].'/group/u_contest/images/design_dev_'.$fields['horizont'].'_'.$fields['vertical'].'.png';
            $raw   = new CIBlockElement;
			$array = Array(
				"ACTIVE"    => "Y",
                "NAME"      => "Заказ: ".$USER->GetFullName(),
				"IBLOCK_ID" => IBLOCK_ID,
                "PROPERTY_VALUES" => $props,
                "PREVIEW_PICTURE" => CFile::MakeFileArray($src)
			);

            $ID = $raw->Add($array);
			if (intval($ID) > 0) {
                //CIBlockElement::Delete($ID);

                $str = date("d.m.Y H:i:s").";".$ID.";".getNumber($fields['horizont'], $fields['vertical']).";".$fields['size'].";".$fields['type'].";".$USER->GetFullName().";+7".preg_replace('/[^0-9]/', '', $fields['phone']).";доставка;".$fields['address'].";new;\n";
                $dir = $_SERVER["DOCUMENT_ROOT"].'/group/u_contest/orders/';
                $file = $dir.$ID.'.csv';
                if (!file_exists($dir)) mkdir($dir, 0777);
                file_put_contents($file, $str);
                $mail = new PHPMailer;
                $mail->isHTML(true);
                $mail->CharSet = "UTF-8";
                $mail->addAttachment($file);
                $mail->addAttachment($src, 'preview.png');
                $mail->setFrom('mail@myqube.ru', 'Сайт MyQube.ru');
                $mail->addAddress(MANAGER, 'Менеджер');
                $mail->Subject = "Новый заказ: ".$ID.'. '.$USER->GetFullName();
                $body = "<h1>Новый заказ</h1>";
                $body .= "<strong>Получатель</strong>: ".$USER->GetFullName()."<br/>";
                foreach ($fields as $key => $field) {
                    if ($labels[$key]) {
                        $body .= "<strong>".$labels[$key]."</strong>: ".$field."<br/>";
                    }
                }
                $mail->Body = $body.'<br/><br/>';
                $mail->send();
                echo 'success';
            }
        } else {
            echo 'exist';
        }
    }
?>