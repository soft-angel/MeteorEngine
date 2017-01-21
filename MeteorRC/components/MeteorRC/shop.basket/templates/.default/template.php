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
<?CJSCore::Init(array('maskedinput'));?>
<?if(isset($arResult["MESSAGE"])){?>
<div class="alert alert-success" role="alert">
<?
foreach ($arResult["MESSAGE"] as $key => $value) {
	echo $value;
}
?>
</div>
<?}?>


<?if(isset($arOrders)){?>
<form action="<?=$_SERVER['PHP_SELF']?>" method="POST" id="basket-form" class="form-horizontal checkout" role="form">
<div class="table-responsive">
			<table class="table table-bordered chart text-center">
				<thead>
					<tr>
						<th>Удалить</th>
						<th>Изображение</th>
						<th>Название</th>
						<th>Item No.</th>
						<th>Количество</th>
						<th>Цена за единицу</th>
						<th>Итого</th>
					</tr>
				</thead>
				<tbody>
<?
foreach ($arOrders as $id => $order) {?>
					<tr>
						<td><a href="<?=$arParams["BASKET_URL"]?>?DELETE=<?=$id?>"><i class="text-danger fa fa-trash"></i></a></td>
						<td>
						<?if(isset($order["URL"])){?>
							<a href="<?=$order["URL"]?>"><?}?>
								<img src="<?=(isset($order["ELEMENT"]["PREVIEW_PICTURE"]))?"/MeteorRC/main/plugins/phpthumb/phpThumb.php?src=" . $FILE->GetUrlFile($order["ELEMENT"]["PREVIEW_PICTURE"], $arParams["IBLOCK"]) . "&w=100&h=100&zc=1&q=65":SITE_TEMPLATE_PATH . "images/noimage.png"?>" width="100" alt="">
						<?if(isset($order["URL"])){?>
							</a>
						<?}?>
						</td>
						<td>
							<?=$order["ELEMENT"]["NAME"]?>
							<?
							if(isset($order["ELEMENT"]["PROPS"])){?>
								(<?=implode(', ', $order["ELEMENT"]["PROPS"])?>)
							<?}?>
						</td>
						<td><?=$order["ELEMENT"]["ID"]?></td>
						<td>
							<input name="ORDER[QUANTITY][<?=$id?>]" type="text" value="<?=$order["QUANTITY"]?>" data-price="<?=$order["ELEMENT"]["PRICE"]?>" data-price-product-total="<?=$order["QUANTITY_TOTAL"]?>" data-id="<?=$order["ELEMENT"]["ID"]?>" class="form-control quantity quantityControl">
						</td>
						<td><?=$APPLICATION->PriceFormat($order["ELEMENT"]["PRICE"])?> <small class="fa fa-rub"></small></td>
						<td>
						<span id="quanityTotal-<?=$order["ELEMENT"]["ID"]?>"><?
						echo $APPLICATION->PriceFormat($order["QUANTITY_TOTAL"]);
						?></span> <small class="fa fa-rub"></small></td>
					</tr>
<?}?>
				</tbody>
			</table>
		</div>

			<div class="row">
				<div class="col-md-12 bill">
					<div class="title-bg">
						<div class="title">Адрес доставки</div>
					</div>
						<div class="form-group dob">
							<div class="col-sm-6">
								<input type="text" name="ORDER[NAME]" value="<?=$USER->GetField("NAME")?>" class="validate form-control" data-error="Укажите Ваше имя" placeholder="Имя">
							</div>
							<div class="col-sm-6">
								<input type="text" name="ORDER[LAST_NAME]" value="<?=$USER->GetField("LAST_NAME")?>" class="validate form-control" data-error="Укажите Вашу фамилию" placeholder="Фамилия">
							</div>
						</div>
						<div class="form-group">
							<div class="col-sm-12">
								<input type="text" name="ORDER[ADDRES]" class="validate form-control" data-error="Укажите Ваш адрес" placeholder="Адрес: г.<?
								$arCity = $USER->GetCity();
								echo $arCity["CITY"]["NAME"];
								?>, улица, дом, корпус, квартира">
							</div>
						</div>
						<!--
						<div class="form-group dob">
							<div class="col-sm-6">
								<input type="text" name="ORDER[CITY]" class="validate form-control" data-error="Укажите город" value="" placeholder="Город">
							</div>
							<div class="col-sm-6">
								<input type="text" name="ORDER[POST_CODE]" class="form-control" placeholder="Почтовый индекс">
							</div>
						</div>-->
						<div class="form-group dob">
							<div class="col-sm-6">
								<input type="text" name="ORDER[EMAIL]" value="<?=$USER->GetField("EMAIL")?>" class="validate form-control" data-error="Укажите Ваш E-mail" placeholder="E-mail">
							</div>
							<div class="col-sm-6">
								<input data-plugin="maskedinput" name="ORDER[PHONE]" type="text" value="<?=$USER->GetField("PERSONAL_PHONE")?>" class="validate form-control" data-error="Укажите Ваш телефон" placeholder="Номер телефона">
							</div>
						</div>
				</div>
			</div>
			<div class="title-bg">
				<div class="title">Комментариий</div>
			</div>
			<p>Примечания о порядке, например, инструкции по доставке.</p>
			<div class="form-group ">
				<div class="col-sm-12">
					<textarea name="ORDER[COMMENT]" class="form-control"></textarea>
				</div>
			</div>
			<div id="title-bg">
				<div class="title">Способ доставки</div>
			</div>
<?
include("delivery.php");
?>
			
			<div id="title-bg">
				<div class="title">Способ оплаты</div>
			</div>
<?
include("payment.php");
?>
			<div class="row">
				<div class="col-md-6">
				</div>
				<div class="col-md-3 col-md-offset-3">
				<div class="subtotal-wrap text-right">
					<div class="total">Итого : <span class="bigprice" data-total-price="<?=$arResult["TOTAL_PRICE"]?>"><?=$APPLICATION->PriceFormat($arResult["TOTAL_PRICE"])?></span> <small class="fa fa-rub"></small></div>
					<div class="clearfix"></div>
					<button type="submit" class="btn btn-default btn-danger">Создать заказ</button>
				</div>
				<div class="clearfix"></div>
				</div>
			</div>
</form>
<?}else{?>
<div class="alert alert-warning" role="alert">
        Вы еще не добавляли товары в корзину.
</div>
<?}?>
