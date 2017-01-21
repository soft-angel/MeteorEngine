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
?>
<div id="popcart-wrap">

						<button id="popcart" class="btn btn-default btn-chart btn-sm "><span class="mychart">Корзина</span>|<span class="allprice">0</span> <small class="fa fa-rub"></small></button>
						<div class="popcart text-left">
						<?if(isset($arOrders)){?>
							<table class="table table-condensed popcart-inner">
								<tbody>
<?
$totalPrice = 0;
foreach ($arOrders as $id => $order) {?>
									<tr>
										<td>
										<a href=""><img src="<?=(isset($order["ELEMENT"]["PREVIEW_PICTURE"]))?"/MeteorRC/main/plugins/phpthumb/phpThumb.php?src=" . $FILE->GetUrlFile($order["ELEMENT"]["PREVIEW_PICTURE"], $arParams["IBLOCK"]) . "&w=100&h=100&zc=1&q=65":SITE_TEMPLATE_PATH . "images/noimage.png"?>" width="100" alt=""></a>
										</td>
										<td style="width: 40%;">
											<?if(isset($order["ORDER"]["URLS"][$id])){?>
											<a href="<?=$order["ORDER"]["URLS"][$id]?>">
											<?}?>
											<?=$order["ELEMENT"]["NAME"]?>
											<?
											if(isset($order["ELEMENT"]["PROPS"])){?>
												(<?=implode(', ', $order["ELEMENT"]["PROPS"])?>)
											<?}?>
											<?if(isset($order["ORDER"]["URLS"][$id])){?>
											</a>
											<?}?>
										<!--<br/><span>Color: green</span>-->
										</td>
										<td><?=$order["ORDER"]["QUANTITY"][$id]?>X</td>
										<td><?
											$price = (preg_replace('/[^0-9]/', '', $order["ELEMENT"]["PRICE"]) * $order["ORDER"]["QUANTITY"][$id]);
											$totalPrice = ($price + $totalPrice);
											echo $APPLICATION->PriceFormat($price);
											?> <small class="fa fa-rub"></small>
										</td>
										<td><a data-cart-id="<?=$id?>" href="<?=$arParams["BASKET_URL"]?>?DELETE=<?=$id?>"><i class="fa fa-times-circle fa-2x"></i></a></td>
									</tr>
<?}?>
								</tbody>
							</table>
							<br/>
							<div class="btn-popcart">
								<a href="/personal/basket/" class="btn btn-default btn-red btn-sm">Перейти в корзину</a>
							</div>
							<div class="popcart-tot">
								<p>
									Итого<br/>
									<span><?=$APPLICATION->PriceFormat($totalPrice)?> <small class="fa fa-rub"></small></span>
								</p>
							</div>
							<div class="clearfix"></div>
<script type="text/javascript">
	$(".allprice").text("<?=$APPLICATION->PriceFormat($totalPrice)?>");
</script>
<?}else{?>
<div class="alert alert-warning" role="alert">
        Вы еще не добавляли товары в корзину.
</div>
<?}?>
						</div>
</div>