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


foreach ($arResult["ELEMENTS"] as $key => $value) {
	$arResult["ELEMENTS"][$key]["DETAIL_PAGE_URL"] = strtr($arParams["SEF_URL_TEMPLATES"]["SEF_URL_DETAIL"], array("#ALIAS#" => $arResult["ELEMENTS"][$key]["ALIAS"]));
}

$arEye = array(
	array(
		"ICON" => '<i class="fa fa-pencil"></i>',
		"LINK" => "/MeteorRC/admin/?component=" . $arParams["COMPONENT"] . "&amp;iblock=" . $arParams["IBLOCK"],
	),
	//array(
		//"ICON" => '<i class="fa fa-file-code-o"></i>',
		//"EDITOR" => "/MeteorRC/admin/editors/edit_file_ajax.php?FILE=" . $templateFolder . $tmplFileName,
	//),
);
$APPLICATION->AddEyeFunction($arEye);
?>