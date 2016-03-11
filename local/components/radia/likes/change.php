<?php
require_once($_SERVER['DOCUMENT_ROOT'].'/bitrix/modules/main/include/prolog_before.php');
require($_SERVER['DOCUMENT_ROOT'].'/local/components/radia/likes/getList.php');
global $USER;
global $CACHE_MANAGER;
use Bitrix\Highloadblock as HL;
use Bitrix\Main\Entity;
CModule::IncludeModule("highloadblock");

if ($_GET['id']) {
    $data = getLikesList($_GET['id'], $USER->GetID());
    $hbLike     = HL\HighloadBlockTable::getById(1)->fetch();
    $entityLike = HL\HighloadBlockTable::compileEntity($hbLike);
    $logLike    = $entityLike->getDataClass();

    $CACHE_MANAGER->ClearByTag('likes_'.$_GET['id']);

    if ($data['liked']) {
        $logLike::Delete($data['userLike']['ID']);
    } else {

        $logLike::add(
    			array(
    				'UF_USER_ID'    => $USER->GetID(),
    				'UF_TIME'       => ConvertTimeStamp(time(), 'FULL'),
    				'UF_ELEMENT_ID' => $_GET['id']
    			)
    		);
    }

}
?>
