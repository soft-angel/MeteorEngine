<?if(!defined("PROLOG_INCLUDED") || PROLOG_INCLUDED!==true)die();?>
<?
$bd_map = FOLDER_BD . 'map/2gis/' . $arParams["MAP_ID"] . SFX_BD;
$arResult = $APPLICATION->GetFileArray($bd_map);

$arEye = array(
	array(
		"ICON" => '<i class="fa fa-pencil"></i>',
		"EDITOR" => $componentPath . "/editor_ajax.php?MAP_ID=" . $arParams["MAP_ID"],
		"TITLE" => "Редактирование карты с ID: " . $arParams["MAP_ID"],
	),	
);
$APPLICATION->AddEyeFunction($arEye);
?>