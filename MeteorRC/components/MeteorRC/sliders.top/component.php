<?if(!defined("PROLOG_INCLUDED") || PROLOG_INCLUDED!==true) die();?>
<?
global $APPLICATION;
global $CONFIG;
global $USER;
$FILE = new FILE;
$arResult["ELEMENTS"] = $APPLICATION->GetElementForField($arParams["COMPONENT"], $arParams["IBLOCK"], array("ACTIVE" => "Y"), false);
$arEye = array(
	array(
		"ICON" => '<i class="fa fa-pencil"></i>',
		"LINK" => "/MeteorRC/admin/?component=" . $arParams["COMPONENT"] . "&amp;iblock=" . $arParams["IBLOCK"],
	),
);
$APPLICATION->AddEyeFunction($arEye);
?>