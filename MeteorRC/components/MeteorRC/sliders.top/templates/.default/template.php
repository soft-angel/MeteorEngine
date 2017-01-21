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
<div id="product_list" <?=$APPLICATION->AddEyeFunction(FOLDER_PRODUCT_BD . "product" . SFX_BD, "PRODUCT_ALL",  $CONFIG)?>>

<div class="container">
<ul class="product_list">
<?foreach($arResult["SECTIONS"] as $key => $section){?>
<li <?if($section["ACTIVE_FILTER"] == "Y"){?>style="display:none" <?}?>class="product_grid col-xs-3 filter_<?=$section["CITY"]?> filter_<?=$APPLICATION->ClearСhar($section["ALIAS"])?>">
<div <?//=$APPLICATION->AddEyeFunction(FOLDER_PRODUCT_BD . "product" . SFX_BD, "PRODUCT",  $CONFIG, $key)?>>
<div class="bant"></div>
<a data-filter=".filter_<?=$APPLICATION->ClearСhar($section["ALIAS"])?>" class="product_name" title="<?=$section["NAME"]?>" href="javascript:void(0)"><?=$section["NAME"]?></a>
<?if(count($section["ADRESS"])){?>
<span class="product_areas"><?=implode(", ", $section["AREA_FULL"])?></span>
<?}?>
<span class="count_adress">В наличии: <?=count($section["ADRESS"])?> шт</span>

<span class="price">ЦЕНА: <?=$APPLICATION->PriceFormat($section["PRICE"])?><i class="fa fa-rub"></i></span>
<button onclick="AddToCart('<?=$key?>'<?if($USER->IsAuthorized()){?>, true<?}?>)" class="button button_buy" type="button"><i class="fa fa-cart-plus"></i> Купить</button>
</div>
</li>
<?}?>
</ul>
</div>

</div>