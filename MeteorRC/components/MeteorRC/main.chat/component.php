<?if(!defined("PROLOG_INCLUDED") || PROLOG_INCLUDED!==true) die();?>
<?
global $APPLICATION;
global $CONFIG;
global $USER;
$FILE = new FILE;
$arResult["ELEMENTS"] = $APPLICATION->GetElementForField($arParams["COMPONENT"], $arParams["IBLOCK"], array(), false);
$arResult["USERS"] = $APPLICATION->GetFileArray(FOLDER_BD . "users" . DS . "users" . SFX_BD);
?>