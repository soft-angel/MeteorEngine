<?php
include('../../helper.php');
$Stata = new Stata;
$_GET["limit"] = $_GET["limit"]?$_GET["limit"]:7;
?>
<script src="../js/Chart.min.js" type="text/javascript"></script>
<?php
if (true){
	if($arFile = $arFileAll = glob(PATCH_BOT . '/*.php')){
		if($_GET["limit"] != "all")
			$arFile = array_slice($arFile, -$_GET["limit"]);
		foreach ($arFile as $file){
			$arAllBot = $Stata->GetFileArray($file);
			foreach($arAllBot as $arBot){
				$date = $Stata->russian_date($arBot["TIME"]);
				if($arBot["U_A"])
					$arBotCount[$date] = ($arBotCount[$date] + 1);
				if($arBot["U_A"] == "Yandex")
					$arYandex[$date] = ($arYandex[$date] + 1);
				if($arBot["U_A"] == "Google")
					$arGoogle[$date] = ($arGoogle[$date] + 1);
				if($arBot["U_A"] == "Mail")
					$arMail[$date] = ($arMail[$date] + 1);
				if($arBot["U_A"] == "Bing")
					$arBing[$date] = ($arBing[$date] + 1);
			}
			$arBotCount[$date] = $arBotCount[$date]?$arBotCount[$date]:0;
			$arYandex[$date] = $arYandex[$date]?$arYandex[$date]:0;
			$arGoogle[$date] = $arGoogle[$date]?$arGoogle[$date]:0;
			$arMail[$date] = $arMail[$date]?$arMail[$date]:0;
			$arBing[$date] = $arBing[$date]?$arBing[$date]:0;
		}
		// print_r($arBotCount);
?>
<div style="margin-bottom: 10px;color: #1FBBA6;text-align: center;"><form method="get">
График индексирующих роботов за <select name="limit" onchange="this.form.submit()">
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
    labels: [<?foreach($arBotCount as $date => $value){?>"<?=$date?>", <?}?>],
    datasets: [
        {
            label: "Все",
            fillColor: "rgba(31,187,166,0.2)",
            strokeColor: "#1fbba6",
            pointColor: "#1fbba6",
            pointStrokeColor: "#fff",
            pointHighlightFill: "#fff",
            pointHighlightStroke: "#1fbba6",
            data: [<?=implode(', ', $arBotCount);?>]
        },
        {
            label: "Yandex",
            fillColor: "rgba(234,67,53,0.2)",
            strokeColor: "#f00",
            pointColor: "#f00",
            pointStrokeColor: "#fff",
            pointHighlightFill: "#fff",
            pointHighlightStroke: "#f00",
            data: [<?=implode(', ', $arYandex);?>]
        },
        {
            label: "Google",
            fillColor: "rgba(66,133,244,0.2)",
            strokeColor: "#4285f4",
            pointColor: "#4285f4",
            pointStrokeColor: "#fff",
            pointHighlightFill: "#fff",
            pointHighlightStroke: "rgba(66,133,244,1)",
            data: [<?=implode(', ', $arGoogle);?>]
        },
        {
            label: "Mail",
            fillColor: "rgba(255,169,48,0.2)",
            strokeColor: "#ffa930",
            pointColor: "#ffa930",
            pointStrokeColor: "#fff",
            pointHighlightFill: "#fff",
            pointHighlightStroke: "#ffa930",
            data: [<?=implode(', ', $arMail);?>]
        },
        {
            label: "Bing",
            fillColor: "rgba(65,1,175,0.2)",
            strokeColor: "#4101af",
            pointColor: "#4101af",
            pointStrokeColor: "#fff",
            pointHighlightFill: "#fff",
            pointHighlightStroke: "#4101af",
            data: [<?=implode(', ', $arBing);?>]
        }
    ]
};
var ctx = document.getElementById("myChart").getContext("2d");
new Chart(ctx).Line(data,{
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