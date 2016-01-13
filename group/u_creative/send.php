<?
    require_once($_SERVER["DOCUMENT_ROOT"].'/group/u_creative/vendor/autoload.php');
    $mail = new PHPMailer;
    $mail->isHTML(true);
    $mail->CharSet = "UTF-8";
    $mail->setFrom('mail@myqube.ru', 'Сайт MyQube.ru');
    $mail->addAddress($_GET['email'], 'Менеджер');
    $mail->Subject = "Тестовое письмо";
    $mail->Body = file_get_contents($_SERVER["DOCUMENT_ROOT"].'/group/u_creative/mail-'.($_GET['v'] ? $_GET['v'] : 1).'.html');
    $mail->send();
?>
