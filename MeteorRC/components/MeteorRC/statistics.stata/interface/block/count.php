<?php
include('../../helper.php');
$Stata = new Stata;
$_GET["limit"] = $_GET["limit"]?$_GET["limit"]:7;
?>
<script src="../js/Chart.min.js" type="text/javascript"></script>
<?php
if (true){
	if($arFile = $arFileAll = glob(PATCH_USER . '/*.php')){
		if($_GET["limit"] != "all")
			$arFile = array_slice($arFile, -$_GET["limit"]);
		foreach ($arFile as $file){
			$arAllUser = $Stata->GetFileArray($file);
			foreach($arAllUser as $arUser){
				$date = $Stata->russian_date($arUser["TIME"]);
				if($arUser["Q"]["NAME"])
					$arQ[$date] = ($arQ[$date] + 1);
					$arUser["CNT"] = $arUser["CNT"]?$arUser["CNT"]:1;
					$userViews[$date] = ($userViews[$date] + $arUser["CNT"]);
			}
			$one = array_shift($arAllUser);
			$userCount[$Stata->russian_date($one["TIME"])] = count($arAllUser);
		}
		if($arBotsCount)
			$arBotsCount = array_count($arBots);
		// print_r($userCount);
?>
<div style="margin-bottom: 10px;color: #1FBBA6;text-align: center;">
<form method="get">
График посещений и просмотров за <select name="limit" onchange="this.form.submit()">
	<option <?if($_GET["limit"] == "7"){?>selected="selected" <?}?>value="7">7 дней</option>
	<option <?if($_GET["limit"] == "30"){?>selected="selected" <?}?>value="30">30 дней</option>
	<option <?if($_GET["limit"] == "91"){?>selected="selected" <?}?>value="91">квартал</option>
	<option <?if($_GET["limit"] == "all"){?>selected="selected" <?}?>value="all">все время (<?=count($arFileAll)?> <?=$Stata->format_by_count(count($arFileAll), 'день', 'дня', 'дней')?>)</option>
</select>
</form>
</div>

<canvas id="myChart" style="margin: auto;display: block;width:100%;height:270px"></canvas>
<script type="text/javascript">
var data = {
    labels: [<?foreach($userViews as $date => $value){?>"<?=$date?>", <?}?>],
    datasets: [
        {
            label: "My First dataset",
            fillColor: "rgba(220,220,220,0.2)",
            strokeColor: "rgba(220,220,220,1)",
            pointColor: "#1FBBA6",
            pointStrokeColor: "#fff",
            pointHighlightFill: "#fff",
            pointHighlightStroke: "rgba(220,220,220,1)",
            data: [<?=implode(', ', $userViews);?>]
        },
        {
            label: "My Second dataset",
            fillColor: "rgba(151,187,205,0.2)",
            strokeColor: "rgba(151,187,205,1)",
            pointColor: "rgba(151,187,205,1)",
            pointStrokeColor: "#fff",
            pointHighlightFill: "#fff",
            pointHighlightStroke: "rgba(151,187,205,1)",
            data: [<?=implode(', ', $userCount);?>]
        }
    ]
};
var ctx = document.getElementById("myChart").getContext("2d");
new Chart(ctx).Line(data, {
    scaleGridLineWidth : 1,
    bezierCurveTension : 0.4,
    scaleShowLabels : true,
    pointDotRadius : 4,
    pointDotStrokeWidth : 4,
    pointHitDetectionRadius : 4,
    datasetStroke : true,
    tooltipFillColor : "#1FBBA6",
	scaleLabel: "<%=value%>",
    //Number - Pixel width of dataset stroke
    datasetStrokeWidth : 2,
	multiTooltipTemplate: "<%= value %>",
});
</script>

<?php }else{?>
<div style="margin-bottom: 10px;color: #848484;text-align: center;">Нет данных</div>
<div id="chardiv"></div>
<?php }?>
<?php }else{?>
<div style="margin-bottom: 10px;color: #848484;text-align: center;">Нет доступа</div>
<?php }?>
<!-- Конец диаграмма городов-->