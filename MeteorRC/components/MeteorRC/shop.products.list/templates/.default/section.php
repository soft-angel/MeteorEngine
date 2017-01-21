<?if(!defined("PROLOG_INCLUDED") || PROLOG_INCLUDED!==true)die();
/** @var array $arParams */
/** @var array $arResult */

/** @var array $arSection - массив раздела если мы в разделе */
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
<?
if($wiew = $FIREWALL->GetString("view")){
	$_SESSION["view"] = $wiew;
}
//p($arResult);
?>
<?if(isset($arElements)){?>
				<div class="title-bg">
					<div class="title"><?=isset($arSection["NAME"])?$arSection["NAME"]:$APPLICATION->ShowTitle()?></div>
					<div class="title-nav">
						<a href="?view=grid"><i class="fa fa-th-large"></i>Сетка</a>
						<a href="?view=list"><i class="fa fa-bars"></i>Список</a>
						<div class="clearfix"></div>
					</div>
				</div>

				<?if(isset($_SESSION["view"]) and $_SESSION["view"] == "grid"){

					?>
				<div class="row prdct">
<?foreach($arElements as $id => $arElement){?>
					<div class="col-md-4">
						<div class="productwrap">
							<div class="pr-img">
							<?if(isset($arElement["FEATURED"])){?>
								<div class="hot"></div>
							<?}?>
									<a href="<?=$arElement["DETAIL_PAGE_URL"]?>"><img  width="100%" src="<?=(isset($arElement["PREVIEW_PICTURE"]))?"/MeteorRC/main/plugins/phpthumb/phpThumb.php?src=" . $FILE->GetUrlFile($arElement["PREVIEW_PICTURE"], $arParams["IBLOCK"]) . "&amp;w=250&amp;h=250&amp;zc=1&amp;q=65":SITE_TEMPLATE_PATH . "images/noimage.png"?>" alt="" class="img-responsive"/></a>
								<?if(isset($arElement["OLD_PRICE"])){?>
								<div class="pricetag on-sale">
									<div class="inner on-sale">
										<span class="onsale">
											<span class="oldprice"><?=$APPLICATION->PriceFormat($arElement["OLD_PRICE"])?> <small class="fa fa-rub"></small></span>
											<?=$APPLICATION->PriceFormat($arElement["PRICE"])?> <small class="fa fa-rub"></small>
										</span>
									</div>
								</div>
								<?}else{?>
								<div class="pricetag">
									<div class="inner">
										<?=$APPLICATION->PriceFormat($arElement["PRICE"])?> <small class="fa fa-rub"></small>
									</div>
								</div>
								<?}?>
							</div>
							<span class="smalltitle"><a href="<?=$arElement["DETAIL_PAGE_URL"]?>"><?=$arElement["NAME"]?></a></span>
							<span class="smalldesc">Товар №: <?=$arElement["ID"]?></span>
						</div>
					</div>
				
<?}?>
				</div>
				<?}else{?>

				<ul class="gridlist">
<?foreach($arElements as $id => $arElement){?>
					<li class="gridlist-inner">
						<div class="white">
						<div class="row clearfix">
							<div class="col-md-4">
								<div class="pr-img">
									<a href="<?=$arElement["DETAIL_PAGE_URL"]?>"><img src="<?=(isset($arElement["PREVIEW_PICTURE"]))?"/MeteorRC/main/plugins/phpthumb/phpThumb.php?src=" . $FILE->GetUrlFile($arElement["PREVIEW_PICTURE"], $arParams["IBLOCK"]) . "&amp;w=200&amp;h=200&zc=1&amp;q=65":SITE_TEMPLATE_PATH . "images/noimage.png"?>" alt="" class="img-responsive"/></a>
								</div>
							</div>
							<div class="col-md-6">
								<div class="gridlisttitle"><?=$arElement["NAME"]?> <span>Товар №: <?=$arElement["ID"]?></span></div>
								<p class="gridlist-desc">
									<?=htmlspecialchars_decode($arElement["PREVIEW_TEXT"])?>
								</p>
							</div>
							<div class="col-md-2">
								<?if(isset($arElement["OLD_PRICE"])){?>
								<div class="gridlist-pricetag on-sale">
									<div class="inner on-sale">
										<span class="onsale">
											<span class="oldprice"><?=$APPLICATION->PriceFormat($arElement["OLD_PRICE"])?> <small class="fa fa-rub"></small></span>
											<?=$APPLICATION->PriceFormat($arElement["PRICE"])?> <small class="fa fa-rub"></small>
										</span>
									</div>
								</div>
								<?}else{?>
								<div class="gridlist-pricetag blue">
									<div class="inner">
										<?=$APPLICATION->PriceFormat($arElement["PRICE"])?> <small class="fa fa-rub"></small>
									</div>
								</div>
								<?}?>
							</div>
						</div>
						</div>
						<div class="gridlist-act">
							<form data-addcart="minicart" action="<?=$arParams["BASKET_URL"]?>" method="POST">
								<input type="hidden" name="BASKET[PRODUCT_ID]" value="<?=$arElement["ID"]?>"></input>
								<input type="hidden" name="BASKET[QUANTITY]" value="1"></input>
								<input type="hidden" name="BASKET[PRODUCT_URL]" value="<?=$arElement["DETAIL_PAGE_URL"]?>"></input>
								<button type="submit" class="btn btn-danger"><span class="trolly">&nbsp;</span><?=$arParams["MESS_BTN_BUY"]?></a></button>
								<!--<a href="#"><i class="fa fa-plus"></i>Добавить в список сравнения</a>-->
							</form>
						</div>
					</li>
<?}?>
				</ul>
				<?}?>

				<?if(isset($arResult["PAGENAVIGATION"]["SHOW"]) and $arResult["PAGENAVIGATION"]["SHOW"] == "Y" and $arParams["DISPLAY_BOTTOM_PAGER"] == "Y"){?>
				<ul class="pagination shop-pag">
					<?if($arResult["PAGENAVIGATION"]["ACTIVE"] > 1){?>
					<li><a href="?PAGEN_<?=$arResult["COMPONENT_ID"]?>=<?=($arResult["PAGENAVIGATION"]["ACTIVE"] - 1)?>"><i class="fa fa-caret-left"></i></a></li>
					<?}?>
					<?
					$i = 0;
					while($arResult["PAGENAVIGATION"]["PAGES"] > $i){
						$i++;
					?>
					<li><a <?if($arResult["PAGENAVIGATION"]["ACTIVE"] == $i){?>class="active"<?}?> href="?PAGEN_<?=$arResult["COMPONENT_ID"]?>=<?=$i?>"><?=$i?></a></li>
					<?}?>
					<?if($arResult["PAGENAVIGATION"]["ACTIVE"] < $i){?>
					<li><a href="?PAGEN_<?=$arResult["COMPONENT_ID"]?>=<?=($arResult["PAGENAVIGATION"]["ACTIVE"] + 1)?>"><i class="fa fa-caret-right"></i></a></li>
					<?}?>
				</ul>
				<?}?>
<?}?>