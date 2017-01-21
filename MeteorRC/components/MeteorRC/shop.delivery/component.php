<?if(!defined("PROLOG_INCLUDED") || PROLOG_INCLUDED!==true) die();?>
<?
global $FIREWALL;
if(!isset($arParams["FILTER"]))
	$arParams["FILTER"] = false;
$arParamsComponnts = $APPLICATION->GetComponentsParams($arParams["COMPONENT"], $arParams["IBLOCK"]);
$arParams = (array_merge($arParams, $arParamsComponnts));

// Получаем список элментов
$arResult = $APPLICATION->GetElementForField($arParams["COMPONENT"], $arParams["IBLOCK"], $arParams["FILTER"], false);

?>