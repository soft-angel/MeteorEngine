<?if(!defined("PROLOG_INCLUDED") || PROLOG_INCLUDED!==true)die();
/** @var array $arParams */
/** @var array $arResult */
/** @global class $APPLICATION */
/** @global class $USER */
/** @global class $CONFIG */
/** @global class $CACHE */
/** @global class $FILE */
/** @var string $templateName - Имя шаблона */
/** @var string $templateFile - файл шаблона */
/** @var string $templateFolder - папка шаблона относительно корня сайта */
/** @var string $componentPath - папка компонента относительно корня сайта */
?>
<?if($USER->IsAdmin()){?>
<span id="component_<?=$APPLICATION->GetComponentId()?>">
<?
if($arResult["FILE"])
	include($arResult["FILE"]);
?>
</span>
<?}else{?>
<?
if($arResult["FILE"])
	include($arResult["FILE"]);
?>
<?}?>