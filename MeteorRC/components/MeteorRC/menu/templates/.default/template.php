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
<div id="component_<?=$APPLICATION->GetComponentId()?>">
	<ul id="menu">
<?
	// p($arResult);
	foreach($arResult as $key => $arItem){?>
		<li <?if(isset($arItem["ACTIVE"])){?>class="activ"<?}?> id="menu_<?=$key?>"><a title="<?=$arItem['NAME']?>" href="<?=$arItem['URL']?>"><?=$arItem['NAME']?></a></li>
<?
	}?>
	</ul>
</div>