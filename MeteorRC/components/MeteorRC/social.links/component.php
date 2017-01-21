<?if(!defined("PROLOG_INCLUDED") || PROLOG_INCLUDED!==true) die();?>
<?
$arResult = $APPLICATION->GetElementForID($arParams["COMPONENT"], $arParams["IBLOCK"], 1);

$arEye = array(
	array(
		"ICON" => '<i class="fa fa-pencil"></i>',
		"LINK" => "/MeteorRC/admin/?component=" . $arParams["COMPONENT"] . "&amp;iblock=" . $arParams["IBLOCK"],
	),
);
$APPLICATION->AddEyeFunction($arEye);
?>