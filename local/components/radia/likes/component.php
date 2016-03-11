<?php

if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
CJSCore::Init(array("jquery"));
require_once($_SERVER['DOCUMENT_ROOT'].'/local/components/radia/likes/getList.php');

$data = getLikesList($arParams['ELEMENT'], false, $arParams['PHOTOS']);

$arResult['total'] = count($data['rows']);
$arResult['rows'] = $data['rows'];
$arResult['fields'] = $data['fields'];
$arResult['tableColumns'] = $data['columns'];
$arResult['liked'] = $data['liked'];
$arResult['userLike'] = $data['userLike'];


$this->IncludeComponentTemplate();
