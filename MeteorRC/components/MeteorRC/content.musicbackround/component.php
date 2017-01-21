<?if(!defined("PROLOG_INCLUDED") || PROLOG_INCLUDED!==true) die();?>
<?
//$arParamsComponnts = $APPLICATION->GetComponentsParams($arParams["COMPONENT"], $arParams["IBLOCK"]);
//$arParams = (array_merge($arParams, $arParamsComponnts));
if(!isset($arParams["FILTER"]))
	$arParams["FILTER"] = array("ACTIVE" => "Y");
if(!isset($arParams["SORT"]))
	$arParams["SORT"] = false;

$arResult["ELEMENTS"] = $APPLICATION->GetElementForField($arParams["COMPONENT"], $arParams["IBLOCK"], $arParams["FILTER"], false, $arParams["SORT"]);

if(isset($arParams["COUNT"]) and $arParams["COUNT"])
	$arResult["ELEMENTS"] = array_slice($arResult["ELEMENTS"], 0, $arParams["COUNT"]); 
$arEye = array(
	array(
		"ICON" => '<i class="fa fa-pencil"></i>',
		"LINK" => "/MeteorRC/admin/?component=" . $arParams["COMPONENT"] . "&amp;iblock=" . $arParams["IBLOCK"],
	),
);
$APPLICATION->AddEyeFunction($arEye);
?>