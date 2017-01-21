<?php 
ini_set('display_errors', 1);
include('../../helper.php');
$Stata = new Stata;
?>
<link rel="stylesheet" type="text/css" href="../css/tracking.css">
<script src="//code.jquery.com/jquery-2.1.4.min.js"></script>
<script type='text/javascript' src="../js/jquery.qtip.js"></script>
<!-- Диаграмма ссылок -->
<script src="../js/amcharts.js" type="text/javascript"></script>
<script src="../js/pie.js" type="text/javascript"></script>
<script>
$(document).ready(function () {
	$('div[title]').qtip({position:{ my: 'bottom center', at: 'top center'}});
});
</script>
<?php
if (true){
if($arFile = glob(PATCH_USER . '/*.php')){
	foreach ($arFile as $file){
		$arAllUser = $Stata->GetFileArray($file);
		foreach($arAllUser as $arUser){
			if($arUser["URL"])
				$arUrl[] = $arUser["URL"];
		}
	}
	$arUrlCount = array_count($arUrl);
	// print_r($arBrowserCount);
?>
<script type="text/javascript">
            var chart;

            var chartDatass = [

<?php
	foreach ($arUrlCount as $i => $value){
		if($value > 10){
			echo '{"country": "' . $Stata->cut_text($i,30) .'","visits": '. $value ."},";
		}
	}
	foreach ($arUrlCount as $i => $value){
		if($value > 10){
			$url_list_echo .= '<div';
			if($value > 1){if($value <= 10){$url_list_echo .= ' style="background: #92E298;"';}}
			if($value >= 10){if($value <= 50){$url_list_echo .= ' style="background: #78E75C;"';}}
			if($value > 50){if($value <= 100){$url_list_echo .= ' style="background: #00FF13;"';}}
			if($value == 1){$url_list_echo .= ' style="background: #fff;"';}
			if($value > 100){$url_list_echo .= ' style="background: #f00;"';}
			$url_list_echo .= ' class="box_key"><div title="'.$i.'" class="oldvalue_left" > ' . $Stata->cut_text($i,70) . '</div><div class="count_right" > '. $value .' </div></div>';
		}
	}
?>
            ];
 AmCharts.ready(function () {
                chart = new AmCharts.AmPieChart();
                chart.dataProvider = chartDatass;
                chart.titleField = "country";
                chart.valueField = "visits";
                chart.sequencedAnimation = true;
                chart.startEffect = "elastic";
                chart.innerRadius = "30%";
                chart.startDuration = 1;
                chart.labelRadius = 10;
                chart.balloonText = "[[title]]<br><span style='font-size:14px'><b>[[value]]</b> ([[percents]]%)</span>";
                chart.depth3D = 10;
                chart.angle = 15;
                          
                chart.write("link_count");
            });
        </script>
<!-- Конец диаграмма ссылок-->
<div class="day">Диаграмма переходов с сайтов за <?php echo count($arFile);?> суток.</div>
<div id="soe_key" >
<div id="link_count" style="width: 100%; height: 300px;"></div>
<?php 
echo $url_list_echo;
?>
<?php }else{ ?>
<div id="link_count"></div>
<div class="no_data">Нет данных</div>
<?php }?>
</div>
<?php }else{?>
<div class="no_data">Нет доступа</div>
<?php }?>