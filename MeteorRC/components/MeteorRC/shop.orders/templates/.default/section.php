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
<?if(isset($arElements)){?>
			<div class="title-bg">
				<div class="title">Список заказов</div>
			</div>
<div class="table-responsive">
			<table class="table table-bordered chart">
				<thead>
					<tr>
						<th>Номер заказа</th>
						<th>Дата создания</th>
						<th>Способ оплаты</th>
						<th>Статус</th>
						<th></th>
					</tr>
				</thead>
				<tbody>
<?foreach($arElements as $id => $arElement){?>
					<tr>
						<td><?=$arElement["ID"]?></td>
						<td><?=(isset($arElement["DATE"]))?$arElement["DATE"]:rus_date("d M Y", $arElement["TIME"])?></td>
						<td><?=$arPayment[$arElement["PAY_SYSTEM_ID"]]["NAME"]?>
						</td>
						<td>
						<?if($arElement["STATUS"] == "CREATED"){?>
						<span class="text-danger">
						<i class="fa fa-exclamation-circle"></i> <?=$arParamsComponent["FIELDS"]["STATUS"]["SELECT"][$arElement["STATUS"]]?>
						</span> 
						(
						<a href="/MeteorRC/components/MeteorRC/shop.payment/payments/<?=$arPayment[$arElement["PAY_SYSTEM_ID"]]["FILE"]?>?ORDER=<?=$arElement["ID"]?>">Оплатить</a>
						)<?}else{?>
						<span class="text-success">
						<i class="fa fa-check"></i> <?=$arParamsComponent["FIELDS"]["STATUS"]["SELECT"][$arElement["STATUS"]]?>
						</span> 
						<?}?>
						</td>
						<td><a class="btn btn-sm btn-success" href="<?=$arElement["DETAIL_PAGE_URL"]?>"><i class="fa fa-eye"></i> Подробнее</a></td>
					</tr>
<?}?>
				</tbody>
			</table>
		</div>
<?}?>