<?if(!defined("PROLOG_INCLUDED") || PROLOG_INCLUDED!==true) die();?>
<?
global $APPLICATION;
global $CONFIG;
global $USER;
if($USER->IsAuthorized()){
$FILE = new FILE;
$arResult = $APPLICATION->GetElementForID($arParams["COMPONENT"], $arParams["IBLOCK"], $USER->GetID());
$arParamsComponents = $APPLICATION->GetComponentsParams($arParams["COMPONENT"], $arParams["IBLOCK"]);
$arParams = (array_merge($arParams, $arParamsComponents));
}
?>