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
?>
<?if(isset($arElement)){?>
<?CJSCore::Init(array('fancybox'));?>
<?//p($arResult)?>
				<div class="title-bg">
					<div class="title"><?=$arElement["NAME"]?></div>
				</div>
				<div class="row">
					<div class="col-md-6">
						<div class="dt-img">
								<?if(isset($arElement["OLD_PRICE"])){?>
								<div class="detpricetag on-sale">
									<div class="inner on-sale">
										<span class="onsale">
											<span class="oldprice"><?=$APPLICATION->PriceFormat($arElement["OLD_PRICE"])?> <small class="fa fa-rub"></small></span>
											<span id="productPrice"><?=$APPLICATION->PriceFormat($arElement["PRICE"])?></span> <small class="fa fa-rub"></small>
										</span>
									</div>
								</div>
								<?}else{?>
								<div class="gold-gradient detpricetag">
									<div class="gold-gradient inner">
										<span id="productPrice"><?=$APPLICATION->PriceFormat($arElement["PRICE"])?></span> <small class="fa fa-rub"></small>
									</div>
								</div>
								<?}?>
							<a class="fancybox" href="<?=(isset($arElement))?$FILE->GetUrlFile($arElement["DETAIL_PICTURE"], $arParams["IBLOCK"]):SITE_TEMPLATE_PATH . "images/noimage.png"?>" data-fancybox-group="gallery" title="<?=$arElement["NAME"]?>"><img src="<?=(isset($arElement))?"/MeteorRC/main/plugins/phpthumb/phpThumb.php?src=" . $FILE->GetUrlFile($arElement["DETAIL_PICTURE"], $arParams["IBLOCK"]) . "&amp;w=350&amp;h=220&amp;zc=1&amp;q=65":SITE_TEMPLATE_PATH . "images/noimage.png"?>" alt="" class="img-responsive"/></a>
						</div>
						<?if(isset($arElement["MORE_PICTURE"])){
							foreach ($arElement["MORE_PICTURE"] as $imgID) {
						?>
						<div class="thumb-img">
							<a class="fancybox" href="<?=$FILE->GetUrlFile($imgID, $arParams["IBLOCK"])?>" data-fancybox-group="gallery" title="<?=$arElement["NAME"]?>"><img src="/MeteorRC/main/plugins/phpthumb/phpThumb.php?src=<?=$FILE->GetUrlFile($imgID, $arParams["IBLOCK"])?>&amp;w=50&amp;h=50&amp;zc=1&amp;q=65" class="img-responsive"></a>
						</div>
						<?}?>
						<?}?>
					</div>
					<div class="col-md-6 det-desc">
						<div class="productdata">
							<!--<div class="infospan">Model <span>PT - 3</span></div>
							<div class="infospan">Item no <span>2522</span></div>
							<div class="infospan">Manufacturer <span>Nikon</span></div>-->
							<div class="average">
							<form role="form">
							<div class="form-group">
								<div class="rate"><span class="lbl">Средний рейтинг</span>
								</div>
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
								<div class="clearfix"></div>
							</div>
							</form>
							</div>

							<!--<h4>Available Options</h4>-->
							<?//p($_SESSION["ORDERS"])?>
							<form class="form-horizontal ava" data-addcart="minicart" action="<?=$arParams["BASKET_URL"]?>" method="POST" role="form">
								<span style="display: none;" id="productPriceDefault"><?=$arElement["PRICE"]?></span>
								<?if(isset($arElement["MATERIAL"])){?>
								<div class="form-group">
									<label for="option-MATERIAL" class="col-sm-2 control-label"><?=$arParams["FIELDS"]["MATERIAL"]["NAME"]?></label>
									<div class="col-sm-10">
										<select id="option-MATERIAL" onchange="reCalculationPrice(this)" name="BASKET[PROPS][MATERIAL]" class="form-control">
										<?foreach($arElement["MATERIAL"] as $id => $field){?>
											<option data-price="<?=$field["VALUE"]?>" value="<?=$id?>"><?=$field["NAME"]?></option>
										<?}?>
										</select>
									</div>
									<div class="clearfix"></div>
									<div class="dash"></div>
								</div>
								<?}?>
								<!--<div class="form-group">
									<label for="color" class="col-sm-2 control-label">Color</label>
									<div class="col-sm-10">
										<select class="form-control" id="color">
											<option value="Blank 2">Blank 1</option>
											<option>Blank 2</option>
											<option>Blank 3</option>
											<option>Blank 4</option>
											<option>Blank 5</option>
										</select>
									</div>
									<div class="clearfix"></div>
									<div class="dash"></div>
								</div>-->
								<div class="form-group">
									<label for="qty" class="col-sm-3 control-label">Количество</label>
									<div class="col-sm-3">
										<select name="BASKET[QUANTITY]" class="form-control" id="qty">
											<option>1</option>
											<option>2</option>
											<option>3</option>
											<option>4</option>
											<option>5</option>
										</select>
									</div>
									<div class="col-sm-6 text-right">
										<input type="hidden" name="BASKET[PRODUCT_ID]" value="<?=$arElement["ID"]?>"></input>
										<input type="hidden" name="BASKET[PRODUCT_URL]" value="<?=$APPLICATION->GetUrlPatch()?>"></input>
										
										<button type="submit" class="btn btn-default btn-red btn-sm"><span class="addchart"><?=$arParams["MESS_BTN_ADD_TO_BASKET"]?></span></button>						
									</div>
									<div class="clearfix"></div>
								</div>
							<div class="form-group">
									<div class="col-md-12 text-right">
										<button id="OneClickBtn" type="button" class="btn btn-default gold-gradient btn-sm"><span class="addchart"><?=$arParams["MESS_BTN_BUY_ONE_CLICK"]?></span></button>
									</div>
							</div>
							</form>

							<div class="sharing">
								<div class="avatock"><span>В наличии</span></div>
							</div>
							
						</div>
					</div>
				</div>

				<div class="tab-review">
					<ul id="myTab" class="nav nav-tabs shop-tab">
						<li class="active"><a href="#desc" data-toggle="tab">Описание</a></li>
						<!--<li class=""><a href="#rev" data-toggle="tab">Reviews (0)</a></li>-->
					</ul>
					<div id="myTabContent" class="tab-content shop-tab-ct">
						<div class="tab-pane fade active in" id="desc">
							<p>
							<?=htmlspecialchars_decode($arElement["DETAIL_TEXT"])?>
							</p>
						</div>
						<div class="tab-pane fade" id="rev">
							<p class="dash">
							<span>Jhon Doe</span> (11/25/2012)<br><br>
							Raw denim you probably haven't heard of them jean shorts Austin. Nesciunt tofu stumptown aliqua, retro synth master cleanse.
							</p>
							<h4>Write Review</h4>
							<form role="form">
							<div class="form-group">
								<input type="text" class="form-control" id="name">
							</div>
							<div class="form-group">
								<textarea class="form-control" id="text"></textarea>
							</div>
							<button type="submit" class="btn btn-default btn-red btn-sm">Submit</button>
						</form>
							
						</div>
					</div>
				</div>
				<?if(false){?>
				<div id="title-bg">
					<div class="title">С этим товаром покупают</div>
				</div>
				<div class="row prdct"><!--Products-->
				<?//p($APPLICATION->GetElementForIDs($arParams["COMPONENT"], $arParams["IBLOCK"], $arElement["RELATED"]))?>
				<?//foreach (null as $key => $id) {?>
					<div class="col-md-4">
						<div class="productwrap">
							<div class="pr-img">
								<div class="hot"></div>
								<a href="product.html"><img src="images/sample-4.jpg" alt="" class="img-responsive"></a>
								<div class="pricetag on-sale"><div class="inner on-sale"><span class="onsale"><span class="oldprice">$314</span>$199</span></div></div>
							</div>
							<span class="smalltitle"><a href="product.html">Lens</a></span>
							<span class="smalldesc">Item no.: 1000</span>
						</div>
					</div>
				<?//}?>
				</div><!--Products-->
				<?}?>
				<div class="spacer"></div>



<!-- Modal One Click-->
<div class="modal fade" id="OneClickModal" role="dialog">
	<div class="modal-dialog">
      <!-- Modal content-->
		<div class="modal-content">
			<div class="modal-header" style="padding:15px 45px;">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4><span class="fa fa-shopping-cart"></span> Заказать в 1 клик</h4>
			</div>
			<div class="modal-body" style="padding:40px 50px;">
				<form id="OneClickModalForm" role="form">
					<div class="result"></div>
					<div class="input-group">
						<span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
						<input type="text" name="SEND[NAME]" class="form-control" data-error="Укажите Ваше имя" placeholder="Ваше имя">
					</div><br>
					<div class="input-group">
						<span class="input-group-addon"><i class="glyphicon glyphicon-map-marker"></i></span>
						<input type="text" name="SEND[CITY]" list="countries" data-error="Укажите Ваш город" class="form-control" placeholder="Город">
					</div><br>
					<div class="input-group">
						<span class="phone input-group-addon">@</span>
						<input type="email" name="SEND[EMAIL]" class="form-control" data-error="Укажите Вашу электронную почту" placeholder="Электронная почта">
					</div><br>
					<div class="input-group">
						<span class="phone input-group-addon"><i class="glyphicon glyphicon-earphone"></i></span>
						<input type="text" name="SEND[PHONE]" class="form-control phone" data-error="Укажите Ваш телефон" placeholder="Мобильный телефон">
					</div><br>
					<div class="input-group">
						<span class="phone input-group-addon"><i class="glyphicon glyphicon-align-left"></i></span>
						<textarea id="message-text" class="form-control" placeholder="Комментарий к заказу" type="text" name="SEND[MESSEGE]"></textarea>
					</div><br>
					<button type="submit" class="btn btn-success btn-block"><span class="fa fa-shopping-cart"></span> Заказать</button>
					<input type="hidden" value="<?=$arElement["NAME"]?>" name="SEND[PRODUCT]">
					<input type="hidden" value="<?=$APPLICATION->GetFullUrl()?>" name="SEND[URL]">
				</form>
			</div>
			<div class="modal-footer" style="text-align: center">
				Отправьте заявку, в ближайшее время с Вами свяжется менеджер и уточнит детали заказа.
			</div>
		</div>
	</div>
</div>

<?}?>