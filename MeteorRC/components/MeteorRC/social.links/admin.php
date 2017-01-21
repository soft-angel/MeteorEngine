<?if(!defined("PROLOG_INCLUDED") || PROLOG_INCLUDED!==true)die();?>
<?
$FILE = new FILE;

$newUrl = $APPLICATION->AddUrlQuery("edit_element=1");

if(!$_GET["edit_element"] == 1)
	$APPLICATION->LocalRedirect($newUrl);

$arParams = $APPLICATION->GetComponentsParams($component["COMPONENT"], $component["IBLOCK"]);
$arElements = $APPLICATION->GetFileArray(FOLDER_BD . $arParams["COMPONENT"] . DS . $arParams["IBLOCK"] . SFX_BD);
?>
<?
include($_SERVER["DOCUMENT_ROOT"]. '/MeteorRC/admin/editors/elements.php');
?>