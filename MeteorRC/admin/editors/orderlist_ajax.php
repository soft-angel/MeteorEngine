<?require_once($_SERVER["DOCUMENT_ROOT"] ."/MeteorRC/main/include/before.php");?>
<?
global $APPLICATION;
global $USER;
global $CONFIG;
if($USER->IsAdmin()){
?>
<ul id="order_list">
<select class="admin_select" onChange="modalClaver('/MeteorRC/admin/editors/orderlist.php?LIMIT=' + this.value , 'Список заказов', 460, 'auto', true);">
<option <?if($_REQUEST["LIMIT"] == 5){?>selected="selected"<?}?> value="5">5</option>
<option <?if($_REQUEST["LIMIT"] == 20){?>selected="selected"<?}?> value="20">20</option>
<option <?if($_REQUEST["LIMIT"] == 50){?>selected="selected"<?}?> value="50">50</option>
<option <?if($_REQUEST["LIMIT"] == 100){?>selected="selected"<?}?> value="100">100</option>
<option <?if($_REQUEST["LIMIT"] == 500){?>selected="selected"<?}?> value="500">500</option>
<option <?if($_REQUEST["LIMIT"] == 999999){?>selected="selected"<?}?> value="999999">Все</option>
</select>
<?
if(file_exists(FOLDER_ORDER_BD))
$OrderList = scandir(FOLDER_ORDER_BD);
unset($OrderList[0], $OrderList[1]);
if($OrderList){
foreach(array_slice(array_reverse($OrderList), 0, $_REQUEST["LIMIT"]) as $key => $file){
	$order = $APPLICATION->GetFileArray(FOLDER_ORDER_BD .  $file);
	?>
<li class="order_list accordion accordion_<?=$key?>" id="order_list_<?=$key?>">
<div class="accordion_top">
<span class="order"><i class="fa fa-calendar"></i> <?=date('d.m.Y',filectime(FOLDER_ORDER_BD . $file))?></span>
<span class="order"><b>№</b> <?=$order["NUMBER"]?></span>
<?if($order["COMMENT"]){?>
<span class="order"><b>Коммент</b>: <?=$order["COMMENT"]?></span>
<?}?>
</div>
<button onclick="AccordionEdit(this, <?=$key?>)" class="button button_edit_accordion" type="button"><i class="fa fa-eye"></i></button>

<div class="accordion_edit_all">
<?=date('Дата создания заказа d.m.Y H:i:s',filectime(FOLDER_ORDER_BD . $file))?>
<p class="order"><b>Район</b>: <?=$order["AREA"]?></p>
<p class="order"><b>Город</b>: <?=$order["CITY"]?></p>
<p class="order"><b>Название товара</b>: <?=$order["NAME"]?></p>
<p class="order"><b>Цена</b>: <?=$order["PRICE"]?><i class="fa fa-rub"></i></p>
<p class="order"><b>Адрес</b>: <?=$order["ADRESS"]?></p>
</div>
</li>
	<?
}
}else{?>
<p>Нет данных</p>
<?}
?>
</ul>
<?}?>