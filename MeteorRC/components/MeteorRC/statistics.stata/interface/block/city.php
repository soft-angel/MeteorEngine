<?php
//error_reporting(E_ALL);
ini_set('display_errors', 1);
include('../../helper.php');
$Stata = new Stata;
$_GET["limit"] = $_GET["limit"]?$_GET["limit"]:7;
?>
<script src="../js/Chart.min.js" type="text/javascript"></script>
<?php
if(true){
	if($arFile = $arFileAll = glob(PATCH_USER . '/*.php')){
		if($_GET["limit"] != "all")
			$arFile = array_slice($arFile, -$_GET["limit"]);
		foreach ($arFile as $file){
			$arAllUser = $Stata->GetFileArray($file);
			foreach($arAllUser as $arUser){
				if($arUser["CITY"])
					$arCity[] = $arUser["CITY"];
			}
		}
	}
	if($Stata->config["diagramm"] == 'Y'){
		$arCityCount = array_count($arCity);
?>
<div style="margin-bottom: 10px;color: #1FBBA6;text-align: center;"><form method="get">
Диаграмма популярных городов за <select name="limit" onchange="this.form.submit()">
	<option <?if($_GET["limit"] == "7"){?>selected="selected" <?}?>value="7">7 дней</option>
	<option <?if($_GET["limit"] == "30"){?>selected="selected" <?}?>value="30">30 дней</option>
	<option <?if($_GET["limit"] == "91"){?>selected="selected" <?}?>value="91">квартал</option>
	<option <?if($_GET["limit"] == "all"){?>selected="selected" <?}?>value="all">все время (<?=count($arFileAll)?> <?=$Stata->format_by_count(count($arFileAll), 'день', 'дня', 'дней')?>)</option>
</select>
</form>
</div>
<canvas id="myChart" style="margin: auto;display: block;width:100%;height:270px"></canvas>
<script type="text/javascript">
var colorsArray = (['#1FBBA6', '#FFD700', '#CD5C5C', '#CD853F', '#F4A460', '#B22222', '#FFA500', '#C71585', '#DA70D6', '#C1CDC1', '#836FFF', '#0000FF', '#00E5EE', '#BCD2EE', '#76EEC6', '#00EE00', '#EEEE00', '#8B658B', '#FF6A6A', '#FF7F24', '#FF6347', '#FF3E96', '#B452CD'] );
var data = [
   	<?php $count = 0;foreach ($arCityCount as $i => $value){
		if($value > 10){?>
    {
        value: <?=$value?>,
        color: colorsArray["<?=$count?>"],
        highlight: colorsArray["<?=$count+1?>"],
        label: "<?=$i?>"
    },
		<?
		$count++;
		}
}?>
];
var ctx = document.getElementById("myChart").getContext("2d");
new Chart(ctx).Doughnut(data, {percentageInnerCutout : 30});
</script>
<?php }else{?>
<div class="no_data">Нет данных</div>
<div id="city_count"></div>
<?php }?>
<?php }else{?>
<div class="_no_data">Нет доступа</div>
<?php }?>