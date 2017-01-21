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
$APPLICATION->AddHeadScript($templateFolder . "/script.js");
$APPLICATION->SetAdditionalCSS($templateFolder . "/style.css");
CJSCore::Init(array('font-awesome', 'jquery.cookie'));
?>
<div class="musicbackround" id="component_<?=$APPLICATION->GetComponentId()?>">
	<button id="startPlay" style="display:none;" onclick="startPlay()"><i class="fa fa-play-circle-o" aria-hidden="true"></i></button>
	<button id="pausePlay" onclick="pausePlay()"><i class="fa fa-pause-circle-o" aria-hidden="true"></i></button>
	<audio style="left:-9999px;position:absolute" autoplay id="musicBackround" controls>
<?foreach($arResult["ELEMENTS"] as $id => $arElement){?>
		<source src="<?=$FILE->GetUrlFile($arElement["FILE"], $arParams["IBLOCK"])?>" type="audio/mp3" controls="controls"/>
<?}?>
	</audio>
</div>