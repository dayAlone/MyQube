<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$page_name="u_concept";
require_once 'vendor/autoload.php';
use GeoIp2\WebService\Client;
if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
    $ip = $_SERVER['HTTP_CLIENT_IP'];
} elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
    $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
} else {
    $ip = $_SERVER['REMOTE_ADDR'];
}
var_dump($ip);
$client = new Client(107700, 'QZ51sMdTQode');
$record = $client->city($ip);
echo $record->city->name . "\n"; // 'Minneapolis'

if(!$USER->IsAuthorized()) {

} else {

}
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");
?>
