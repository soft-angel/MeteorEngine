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
$APPLICATION->AddHeadScript($templateFolder . "/element.js");
$APPLICATION->SetAdditionalCSS($templateFolder . "/element.css");
?>
<?if(isset($arElement)){?>
<div class="row">
	<div class="col-sm-12">	
<div class="title-bg">
	<div class="title"><?=$arElement["NAME"]?></div>
</div>
<div class="block-white-wrap">
	<div class="block-white-inner">			
<?if(isset($arElement["ID"])){?>
<?$APPLICATION->IncludeComponent("MeteorRC:main.rating", "", Array(
		"COMPONENT" => $arParams["COMPONENT"],
		"IBLOCK" => $arParams["IBLOCK"],	// Инфоблок
		"ELEMENT_ID" => $arElement["ID"],	// Ид элемента
		"FIELD_VOTE" => "VOTE",	// Ид элемента
		"FIELD_VOTE_COUNT" => "VOTE_COUNT",
		"FIELD_VOTE_SUMM" => "VOTE_VOTE_SUMM",
	),
	false
);?>
<?}?>
<?if(isset($arElement["DETAIL_TEXT"]) or isset($arElement["PREVIEW_TEXT"])){?>
<?=htmlspecialchars_decode(isset($arElement["DETAIL_TEXT"])?$arElement["DETAIL_TEXT"]:$arElement["PREVIEW_TEXT"])?>
	</div>
</div>
<?}?>

	</div>
</div>
<br><br>
<?}?>