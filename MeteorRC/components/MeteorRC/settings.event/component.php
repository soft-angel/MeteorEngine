<?if(!defined("PROLOG_INCLUDED") || PROLOG_INCLUDED!==true) die();?>
<?
if(!isset($arParams["FILTER"]))
	$arParams["FILTER"] = array("ACTIVE" => "Y");

$arResult["SECTIONS"] = $APPLICATION->GetElementForField($arParams["COMPONENT"], $arParams["IBLOCK"], $arParams["FILTER"], false);


foreach ($arResult["SECTIONS"] as $key => $section) {
	$arResult["SECTIONS"][$key]["DETAIL_PAGE_URL"] = strtr($arParams["SEF_URL_TEMPLATES"]["SEF_URL_SECTION"], array("#SECTION_ALIAS#" => $section["ALIAS"]));
}
// вызываем функцию и передаем ей наш массив
$arResult["SECTIONS_MAP"] = mapTree($arResult["SECTIONS"], 'SECTION');
