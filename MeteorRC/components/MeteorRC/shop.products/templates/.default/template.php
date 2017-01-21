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
$APPLICATION->SetAdditionalCSS($templateFolder . "/styles.css");
?>
<div id="component_<?=$APPLICATION->GetComponentId()?>">
<div class="row">
<?foreach($arResult["ELEMENTS"] as $id => $arElement){?>
  <div class="col-sm-6 col-md-4">
    <div class="thumbnail">
      <img src="<?=(isset($arElement["PREVIEW_PICTURE"]))?$FILE->IblockResizeImageGet($arElement["PREVIEW_PICTURE"], $arParams["IBLOCK"], 200, 200, 75, 'crop'):SITE_TEMPLATE_PATH . "images/noimage.png"?>" alt="<?=$arElement["NAME"]?>">
      <div class="caption">
        <h3><?=$arElement["NAME"]?></h3>
        <p><?=$APPLICATION->PriceFormat($arElement["PRICE"])?> <small class="fa fa-rub"></small></p>
      </div>
	<form data-addcart="minicart" action="<?=$arParams["BASKET_URL"]?>" method="POST">
		<input type="hidden" name="BASKET[PRODUCT_ID]" value="<?=$arElement["ID"]?>"></input>
		<input type="hidden" name="BASKET[QUANTITY]" value="1"></input>
		<input type="hidden" name="BASKET[PRODUCT_URL]" value="<?=$arElement["DETAIL_PAGE_URL"]?>"></input>
		<button type="submit" class="btn btn-group-justified btn-primary"><?=$arParams["MESS_BTN_BUY"]?></button>
		<a class="btn btn-group-justified btn-default" href="<?=$arElement["DETAIL_PAGE_URL"]?>"><?=$arParams["MESS_BTN_DETAIL"]?></a>
	</form>
	</div>
  </div>
<?}?>
</div>
</div>
