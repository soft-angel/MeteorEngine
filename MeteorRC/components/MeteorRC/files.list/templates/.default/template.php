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
<div class="img-lst row" id="component_<?=$APPLICATION->GetComponentId()?>">
<?foreach($arResult["ELEMENTS"] as $id => $arElement){?>
	<div class="col-sm-2 col-xs-3">
		<img src="<?=$arElement['patch']?>" class="" />
	</div>
<?}?>
</div>