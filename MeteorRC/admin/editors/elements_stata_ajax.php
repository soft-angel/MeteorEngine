<?require_once($_SERVER["DOCUMENT_ROOT"]."/MeteorRC/main/include/before.php");?>
<?
if($USER->IsAdmin()){
    if($component = $FIREWALL->GetString('component') and $iblock = $FIREWALL->GetString('iblock') and $id = $FIREWALL->GetNumber('id')){
        $bdFolder = STATA_PATCH . DS . $component . DS . $iblock . DS;
        if($FIREWALL->GetString('data'))
                $bdFile = $bdFolder . $FIREWALL->GetString('data') . SFX_BD;
            else
                $bdFile = $bdFolder . date("Y.m") . SFX_BD;
        $arCount = $APPLICATION->GetFileArray($bdFile);
        $arStataElement = $arCount[$id];
        unset($arCount);
        //p($arStataElement);
    
?>
<div class="modal-header">
        <button style="color: #fff;" type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        <h4 style="color: #fff;" class="modal-title">Статистика просмотров элемента за 
        <select name="data" onchange="GetContentToModal('/MeteorRC/admin/editors/elements_stata_ajax.php?component=<?=$component?>&amp;iblock=<?=$iblock?>&amp;id=<?=$id?>&amp;data=' + $(this).val(), 'modal-stata-element')" class="select-transparent">
            <?foreach (array_reverse(glob($bdFolder . "*" . SFX_BD)) as $file) {
                $optionValue = str_replace(SFX_BD, "", basename($file));?>
                
                <option <?if($FIREWALL->GetString('data') == $optionValue){?>selected="selected"<?}?>><?=$optionValue?></option>
                
            <?}?>   
        </select>
       
        </h4>
</div>
<?
if(count($arStataElement) >= 1){
?>
<?foreach ($arStataElement as $date => $value) {
    if(isset($value["WIEWS"]))
        $allWiews = ($allWiews + $value["WIEWS"]);
    if(isset($value["VISIT"]))
        $allVisit = ($allVisit + $value["VISIT"]);
}?>

<div class="widget-chart with-sidebar bg-black">
    <div class="widget-chart-content">
        <div style="width: 100%;height: 400px" id="morris-area-chart" class="morris-inverse height-sm"></div>
    </div>
    <div class="widget-chart-sidebar bg-black-darker">
        <div class="chart-number"><small>Соотношение визитов и просмотров</small></div>
        <div id="visitors-donut-chart" style="height: 160px"></div>
        <ul class="chart-legend">
            <li><i style="color:#00acac" class="fa fa-circle-o fa-fw m-r-5"></i> <?=round(($allVisit * 100) / ($allVisit + $allWiews), 2)?>% <span>Уникальные визиты</span></li>
            <li><i style="color:#348fe2" class="fa fa-circle-o fa-fw m-r-5"></i> <?=round(($allWiews * 100) / ($allVisit + $allWiews), 2)?>% <span>Просмотры</span></li>
        </ul>
    </div>
</div>
<style type="text/css">
#visitors-donut-chart svg {
    max-width: 100%;
    max-height: 100%;
}
</style>





<script type="text/javascript">
    var e = "#0D888B";
    var t = "#fff";
    var n = "#3273B1";
    var r = "#348FE2";
    var i = "rgba(0,0,0,0.6)";
    var s = "rgba(255,255,255,0.4)";

function MorrisAreaChart() {
    Morris.Line({
        element: "morris-area-chart",
        data: [
<?foreach ($arStataElement as $date => $value) {?>
        {
            periods: "<?=$date?>",
            wiews: <?=isset($value["WIEWS"])?$value["WIEWS"]:0?>,
            vizit: <?=isset($value["VISIT"])?$value["VISIT"]:0?>,
        },
<?}?>
        ],
        xkey: "periods",
        //parseTime: false,
        dateFormat: function (x) {
            var month = new Date(x).toLocaleString(navigator.language || navigator.userLanguage, {
                year: 'numeric',
                month: 'long',
                day: 'numeric'
            });
        return month;
        },
        xLabels: "day",
        xLabelFormat: function (x) {
            var month = new Date(x).toLocaleString(navigator.language || navigator.userLanguage, {
                month: 'long',
                day: 'numeric'
            });
        return month;
        },
        ykeys: ["wiews", "vizit"],
        labels: ["Просмотры", "Уникальные визиты"],
        pointSize: 2,
        hideHover: "auto",
        resize: true,
        lineColors: ["#348fe2", "#00acac"],
        pointStrokeColors: [i, i],
        gridLineColor: "rgba(0,0,0,0.5)",
        lineWidth: "2px",
        gridTextFamily: "Open Sans",
        gridTextColor: s,

    })
};

function CountDonutChart() {
    Morris.Donut({
        element: "visitors-donut-chart",
        data: [
            {
                label: "Уникальные визиты",
                value: <?=$allVisit?>
            },
            {
                label: "Просмотры",
                value: <?=$allWiews?>
            },
        ],
        colors: ["#348fe2", "#00acac"],
        labelFamily: "Open Sans",
        labelColor: "rgba(255,255,255,0.4)",
        labelTextSize: "12px",
        backgroundColor: "#242a30"
    })
};





$('#modal-stata-element').on('shown.bs.modal', function () {
    MorrisAreaChart();
    CountDonutChart();
});
</script>

<?}else{?>
<div style="border-radius: 0;" class="alert alert-warning" role="alert">
        <p>Элемент еще не набрал достаточное количество посещений, для построения графика.</p>
</div>
<?}?>
<?}else{?>
<div style="border-radius: 0;" class="alert alert-warning" role="alert">
        <p>Не верный запрос!</p>
</div>
<?}?>
<?}else{?>
<div style="border-radius: 0;" class="alert alert-warning" role="alert">
        <p>Ошибка доступа!</p>
</div>
<?}?>