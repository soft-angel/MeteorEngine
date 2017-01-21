<?require_once($_SERVER["DOCUMENT_ROOT"] ."/MeteorRC/main/include/before.php");?>
<?
global $APPLICATION;
global $USER;
global $CONFIG;
if($USER->IsAdmin()){
?>
<?
if(file_exists(FOLDER_ORDER_BD))
$OrderList = scandir(FOLDER_ORDER_BD);
unset($OrderList[0], $OrderList[1]);
if($OrderList)
foreach(array_slice($OrderList, 0, $_REQUEST["LIMIT"]) as $key => $file){
	$order = $APPLICATION->GetFileArray(FOLDER_ORDER_BD .  $file);
	$arCity[] = $order["CITY"];
	$arProduct[] = $order["NAME"];
}
?>
<div class="pie_order pie_city">
<span>Продаваемость в городах</span>
<?if(!$arCity){?><p>Нет данных</p><?}?>
<canvas id="chart-city" width="250" height="250"/>
</div>
<div class="pie_order pie_product">
<span>Продаваемость товаров</span>
<?if(!$arProduct){?><p>Нет данных</p><?}?>
<canvas id="chart-product" width="250" height="250"/>
</div>
<script>
		var pieData = [
		<?
		$i = 0;
		if($arCity)
		foreach (array_count_values($arCity) as $key => $city){ 
		$i++
		?>
				{
					value: "<?=$city?>",
					color: "#008c00",
					highlight: "#008c00",
					label: "<?=$APPLICATION->GetRusCity($key)?>"
				},
		<?}?>
			];
				var ctx = document.getElementById("chart-city").getContext("2d");
				window.myPie = new Chart(ctx).Pie(pieData, {
					animationSteps : 30,
					animationEasing : 'easeOutBounce',
				});

</script>
<script>
		var pieData = [
		<?
		$i = 0;
		if($arProduct)
		foreach (array_count_values($arProduct) as $key => $product){
		$i++	
		?>
				{
					value: "<?=$product?>",
					color: "#f74c55",
					highlight: "#f74c55",
					label: "<?=$key?>"
				},
		<?}?>
			];
				var ctx = document.getElementById("chart-product").getContext("2d");
				window.myPie = new Chart(ctx).Pie(pieData, {
					animationSteps : 30,
					animationEasing : 'easeOutBounce',
				});
</script>

<? }?>