<?php 
ini_set('display_errors', 1);
include('../../helper.php');
$Stata = new Stata;
$_GET["limit"] = $_GET["limit"]?$_GET["limit"]:7;
if (true){
?>
<script src="../js/Chart.min.js" type="text/javascript"></script>
<!--- График браузеров-->
<?php 
if($arFile = $arFileAll = glob(PATCH_USER . '/*.php')){
	if($_GET["limit"] != "all")
		$arFile = array_slice($arFile, -$_GET["limit"]);
	foreach ($arFile as $file){
		$arAllUser = $Stata->GetFileArray($file);
		foreach($arAllUser as $arUser){
			if($arUser["Q"]["NAME"]){
				$arTraffic["Переходы из поисковых систем"] = ($arTraffic["Переходы из поисковых систем"] + 1);
			}elseif(stristr($arUser["REFERER"], 'vk.com') !== false
				or stristr($arUser["REFERER"], 'odnoklassniki.ru') !== false
				or stristr($arUser["REFERER"], 'facebook.com') !== false
				or stristr($arUser["REFERER"], 'twitter.com') !== false
				or stristr($arUser["REFERER"], 'plus.google.com') !== false
				or stristr($arUser["REFERER"], 'ok.ru') !== false
				or stristr($arUser["REFERER"], 'ask.fm') !== false
				or stristr($arUser["REFERER"], 'linkedin.com') !== false
				or stristr($arUser["REFERER"], 'pinterest.com') !== false
			){
				$arTraffic["Переходы из социальных сетей"] = ($arTraffic["Переходы из социальных сетей"] + 1);
			}elseif(stristr($arUser["REFERER"], $_SERVER['SERVER_NAME']) !== false){
				$arTraffic["Внутренние переходы"] = ($arTraffic["Внутренние переходы"] + 1);
			}elseif($arUser["REFERER"]){
				$arTraffic["Переходы по ссылкам на сайтах"] = ($arTraffic["Переходы по ссылкам на сайтах"] + 1);
			}elseif(!$arUser["Q"]["NAME"]){
				$arTraffic["Прямые заходы"] = ($arTraffic["Прямые заходы"] + 1);
			}
		}
	}
	// if($arTraffic)
		// $arTrafficCount = array_count($arTraffic);
	 // print_r($arBrowserCount);
?>
<div style="margin-bottom: 10px;color: #1FBBA6;text-align: center;"><form method="get">
Источники трафика за <select name="limit" onchange="this.form.submit()">
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
	<?php $count = 15;foreach ($arTraffic as $value => $i){?>
    {
        value: <?=$i?>,
        color: colorsArray["<?=$count?>"],
        highlight: colorsArray["<?=$count+1?>"],
        label: "<?=$value?>"
    },
<?
$count++;
}?>
];
var ctx = document.getElementById("myChart").getContext("2d");
new Chart(ctx).Doughnut(data, {percentageInnerCutout : 30});
</script>
<?php }else{ ?>
	<div class="_no_data">Нет данных</div>
<?php }?>
<?php }else{?>
<div class="no_data">Нет доступа</div>
<?php }?>