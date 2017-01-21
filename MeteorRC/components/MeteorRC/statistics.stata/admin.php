<?
if(!defined("PROLOG_INCLUDED") || PROLOG_INCLUDED!==true)die();
include_once("get_stata.php");
$arParams = $APPLICATION->GetFileArray(__DIR__ . '/.parametrs.php');

if((int)date("H") == 0){
    $hoursPassed = declOfNum((int)date("i"), array('минуту', 'минуты', 'минут'));
}else{
    $hoursPassed = declOfNum((int)date("H"), array('час', 'часа', 'часов'));
}

?>
<?//CJSCore::Init(array("jquery-jvectormap"));?>
<?$APPLICATION->AddHeadScript("/MeteorRC/js/plugins/jquery-jvectormap/jquery-jvectormap-1.2.2.min.js");?>
<?$APPLICATION->AddHeadScript("/MeteorRC/js/plugins/jquery-jvectormap/jquery-jvectormap-world-merc-en.js");?>

        <!-- begin #content -->
        <div id="content" class="content">
            <!-- begin breadcrumb -->
            <ol class="breadcrumb pull-right">
                <li><a href="/"><i class="fa fa-home"></i></a></li>
                <li><a href="javascript:;">Панель управления</a></li>
                <li class="active"><?=$arParams["NAME"]?></li>
            </ol>
            <!-- end breadcrumb -->
            <!-- begin page-header -->
            <h1 class="page-header">Stata v2 <small>Статистика посещений сайта</small></h1>
            <!-- end page-header -->
            <!-- begin row -->
            <div class="row">
                <!-- begin col-3 -->
                <div class="col-md-3 col-sm-6">
                    <div class="widget widget-stats bg-green">
                        <div class="stats-icon stats-icon-lg"><i class="fa fa-globe fa-fw"></i></div>
                        <div class="stats-title">ПОСЕЩЕНИЙ СЕГОДНЯ</div>
                        <div class="stats-number"><?=number_format(count($arUsers))?></div>
                        <div class="stats-progress progress">
                            <div class="progress-bar" style="width: 100%;"></div>
                        </div>
                        <div class="stats-desc">за <?=$hoursPassed?></div>
                    </div>
                </div>
                <!-- end col-3 -->
                <!-- begin col-3 -->
                <div class="col-md-3 col-sm-6">
                    <div class="widget widget-stats bg-blue">
                        <div class="stats-icon stats-icon-lg"><i class="fa fa-tags fa-eye"></i></div>
                        <div class="stats-title">ПРОСМОТРОВ СЕГОДНЯ</div>
                        <div class="stats-number"><?=number_format($userDayCount)?></div>
                        <div class="stats-progress progress">
                            <div class="progress-bar" style="width: 100%;"></div>
                        </div>
                        <div class="stats-desc">за <?=$hoursPassed?></div>
                    </div>
                </div>
                <!-- end col-3 -->
                <!-- begin col-3 -->
                <div class="col-md-3 col-sm-6">
                    <div class="widget widget-stats bg-purple">
                        <div class="stats-icon stats-icon-lg"><i class="fa fa-search fa-fw"></i></div>
                        <div class="stats-title">С ПОИСКА</div>
                        <div class="stats-number"><?=number_format($arQCount)?></div>
                        <div class="stats-progress progress">
                            <div class="progress-bar" style="width: 100%;"></div>
                        </div>
                        <div class="stats-desc">за <?=$hoursPassed?></div>
                    </div>
                </div>
                <!-- end col-3 -->
                <!-- begin col-3 -->
                <div class="col-md-3 col-sm-6">
                    <div class="widget widget-stats bg-black">
                        <div class="stats-icon stats-icon-lg"><i class="fa fa-comments fa-fw"></i></div>
                        <div class="stats-title">???</div>
                        <div class="stats-number">???</div>
                        <div class="stats-progress progress">
                            <div class="progress-bar" style="width: 100%;"></div>
                        </div>
                        <div class="stats-desc">за <?=$hoursPassed?></div>
                    </div>
                </div>
                <!-- end col-3 -->
            </div>
            <!-- end row -->
            
            <!-- begin row -->
            <div class="row">
                <div class="col-md-12">
                    <div class="widget-chart with-sidebar bg-black">
                        <div class="widget-chart-content">
                            <h4 class="chart-title">
                                Аналитика посещений
                                <small>Количество посетителей и просмотров по месяцам</small>
                            </h4>
                            <div id="visitors-line-chart" class="morris-inverse" style="height: 260px;"></div>
                        </div>
                        <div class="widget-chart-sidebar bg-black-darker">
                            <div class="chart-number">
                                <?=number_format($userAllCount)?>
                                <small>Всего просмотров</small>
                            </div>
                            <div id="visitors-donut-chart" style="height: 160px"></div>
                            <ul class="chart-legend">
                                <?arsort($arBrowserCount)?>
                                <?$count = 0;foreach (array_slice($arBrowserCount,0,4) as $i => $value){?>
                                <li><i style="color:<?=$arColor[$count]?>" class="fa fa-circle-o fa-fw m-r-5"></i> <?=round(($value / $userAllVisit * 100), 2)?>% <span><?=$i?></span></li>
                                <?$count++;}?>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <!-- end row -->
            <div class="row">
                <!-- begin col-4 -->
                <div class="col-md-12">
                    <div class="widget-chart with-sidebar bg-black">
                        <div class="widget-chart-content">
                            <h4 class="chart-title">
                                Аналитика поисковых систем
                                <small>Активность посещений с поисковых систем</small>
                            </h4>
                            <div id="line-ps" class="morris-inverse" style="height: 260px;"></div>
                        </div>
                        <div class="widget-chart-sidebar bg-black-darker">
                            <div class="chart-number">
                                <?=number_format($userCount)?>
                                <small>Визитов с поисковых систем</small>
                            </div>
                            <div id="ps-donut-chart" style="height: 160px"></div>
                            <ul class="chart-legend">
                                <?$countPs = count($arPs)?>
                                <?$count = 0;
                                if($arPsCount)
                                        foreach ($arPsCount as $i => $value){?>
                                <li><i style="color:<?=$arColor[$count]?>" class="fa fa-circle-o fa-fw m-r-5"></i> <?=round(($value / $countPs * 100), 2)?>% <span><?=$i?></span></li>
                                <?$count++;}?>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <!-- begin col-4 -->
                <div class="col-md-4">
                    <div class="panel panel-inverse" data-sortable-id="index-1r443">
                        <div class="panel-heading">
                            <h4 class="panel-title">
                                Посещаемость по странам
                            </h4>
                        </div>
                        <div id="visitors-map" class="bg-black" style="height: 181px;"></div>
                        <div class="list-group">
                                <?arsort($arCountries)?>
                                <?$count = 0;foreach (array_slice($arCountries,0,4) as $i => $value){?>
                                <a href="javascript:;" class="list-group-item list-group-item-inverse text-ellipsis">
                                    <span class="badge bg-theme"><?=round(($value / $userAllCount * 100), 2)?>%</span>
                                    <span>
                                        <img style="vertical-align: text-bottom;" height="16px" width="16px" src="/MeteorRC/components/MeteorRC/statistics.stata/interface/img/country/<?=$arCountry[$i]["IMG"]?>"> <?=$arCountry[$i]["NAME"]?>
                                    </span>
                                </a>
                                <?$count++;}?>
                        </div>
                    </div>
                </div>
                <div class="col-md-8">
                    <!-- begin panel -->
                    <div class="panel panel-inverse" data-sortable-id="index-2rr5444">
                        <div class="panel-heading">
                            <h4 class="panel-title">Топ 10 городов по визитам</h4>
                        </div>
                        <div class="with-sidebar bg-black">
                             <div id="stata-bar-city" class="morris-inverse" style="height: 332px;"></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-4">
                    <!-- begin panel -->
                    <div class="panel panel-inverse" data-sortable-id="index-44r42">
                        <div class="panel-heading">
                            <h4 class="panel-title">Источники трафика</h4>
                        </div>
                        <div class="with-sidebar bg-black">
                            <div id="traffic-donut-chart" class="morris-inverse" style="height: 180px;"></div>
                        <div class="list-group">
                                <?arsort($arTraffic)?>
                                <?$count = 0;foreach (array_slice($arTraffic,0,4) as $i => $value){?>
                                <a href="javascript:;" class="list-group-item list-group-item-inverse text-ellipsis">
                                    <span style="background-color:<?=$arColor[$count]?>" class="badge"><?=round((($value / $userAllVisit) * 100), 2)?>%</span>
                                    <span><?=$i?></span>
                                </a>
                                <?$count++;}?>
                        </div>
                        </div>
                    </div>
                </div>
<div class="col-md-8">
<div class="panel panel-inverse" style="background: #242a30;" data-sortable-id="ui-widget-7">
                        <div class="panel-heading">
                            <h4 class="panel-title">Поисковые фразы</h4>
                        </div>
                        <div class="panel-body">
                            <div data-scrollbar="true" data-height="299px">
<div id="soe_key">
    <div class="list-group">
<?php 
$i = 0;
foreach ($arQlist as $q => $value){
    $i++;
    $arPS = array_unique($value["NAME"]);?>

        <a style="color: #fff" class="list-group-item list-group-item-inverse text-ellipsis">
            <div class="bg-absolute-content">
            <span class="badge badge-white">
                <span title="Количество этого запроса"><?=$value["CNT"]?></span> / <span title="Общаяя глубина просмотров"><?=$value["VIEWS"]?></span>
<?foreach($arPS as $ps){?>
                <img width="16px" height="16px" title="<?=$arSearch[$ps]["NAME"]?>" src="/MeteorRC/components/MeteorRC/statistics.stata/interface/img/search/<?=$arSearch[$ps]["IMG"]?>">
<?}?>
            </span> <?=$i?>) <?=$q?>
            </div>
            <span style="opacity: <?=$Stata->getColor($value["CNT"])?>" class="bg-theme bg-absolute"></span>
        </a> 
<?}?>
    </div>
</div>

                            </div>
                        </div>
                    </div>
</div>


            </div>

        </div>
        <!-- end #content -->
<script>
var colorsArray = (['#00acac', '#348fe2', '#CD5C5C', '#CD853F', '#F4A460', '#B22222', '#FFA500', '#C71585', '#DA70D6', '#C1CDC1', '#836FFF', '#0000FF', '#00E5EE', '#BCD2EE', '#76EEC6', '#00EE00', '#EEEE00', '#8B658B', '#FF6A6A', '#FF7F24', '#FF6347', '#FF3E96', '#B452CD'] );
var getMonthName = function(e) {
    var t = [];
    t[0] = "Январь";
    t[1] = "Февраль";
    t[2] = "Март";
    t[3] = "Апрель";
    t[4] = "Май";
    t[5] = "Июнь";
    t[6] = "Июлю";
    t[7] = "Август";
    t[8] = "Сентябрь";
    t[9] = "Октябрь";
    t[10] = "Ноябрь";
    t[11] = "Декабрь";
    return t[e]
};
var getDate = function(e) {
    var t = new Date(e);
    var n = t.getDate();
    var r = t.getMonth() + 1;
    var i = t.getFullYear();
    if (n < 10) {
        n = "0" + n
    }
    if (r < 10) {
        r = "0" + r
    }
    t = i + "-" + r + "-" + n;
    return t
};
    var e = "#0D888B";
    var t = "#fff";
    var n = "#3273B1";
    var r = "#348FE2";
    var i = "rgba(0,0,0,0.6)";
    var s = "rgba(255,255,255,0.4)";

<?arsort($arCities)?>
var handleMorrisBrowserChart = function() {
    Morris.Bar({
        element: "stata-bar-city",
        data: [<?foreach (array_slice($arCities,0,10) as $i => $value){?>
        {
            city: "<?=$i?>",
            count: <?=$value?>
        },
<?}?>],
        xkey: "city",
        ykeys: ["count"],
        labels: ["Визитов"],
        barRatio: .1,
        xLabelAngle: 50,
        hideHover: "auto",
        resize: true,
        barColors: colorsArray
    })
};

var handleVisitorsLineChart = function() {
    Morris.Line({
        element: "visitors-line-chart",
        data: [<?foreach($arUserCount as $date => $value){?>{x: "<?=$date?>", y: <?=$value["USERS"]?$value["USERS"]:0?>, z: <?=$value["COUNT"]?$value["COUNT"]:0?>},<?}?>],

        xkey: "x",
        ykeys: ["y", "z"],
        xLabelFormat: function(e) {
            e = getMonthName(e.getMonth());
            return e.toString()
        },
        labels: ["Постетителей", "Просмотров"],
        lineColors: colorsArray,
        pointFillColors: colorsArray,
        lineWidth: "2px",
        pointStrokeColors: [i, i],
        resize: true,
        gridTextFamily: "Open Sans",
        gridTextColor: s,
        gridTextWeight: "normal",
        gridTextSize: "11px",
        gridLineColor: "rgba(0,0,0,0.5)",
        hideHover: "auto"
    })
};
var handlePSLineChart = function() {
    Morris.Line({
      element: 'line-ps',
      data: [<?
            if($arPsCount)
                foreach($arPSCount as $date => $value){?>{ y: '<?=$date?>', a: <?=$value["Yandex"]?$value["Yandex"]:0?>, b: <?=$value["Google"]?$value["Google"]:0?>, c: <?=$value["Mail"]?$value["Mail"]:0?>, d: <?=$value["Yahoo"]?$value["Yahoo"]:0?>, e: <?=$value["Bing"]?$value["Bing"]:0?> },<?}?>],
        xLabelFormat: function(e) {
            e = getMonthName(e.getMonth());
            return e.toString()
        },
        lineColors: colorsArray,
        pointFillColors: colorsArray,
        lineWidth: "2px",
        pointStrokeColors: [i, i],
        resize: true,
        gridTextFamily: "Open Sans",
        gridTextColor: s,
        gridTextWeight: "normal",
        gridTextSize: "11px",
        gridLineColor: "rgba(0,0,0,0.5)",
        hideHover: "auto",
      xkey: 'y',
      ykeys: ['a', 'b', 'c', 'd', 'e'],
      labels: ['Yandex', 'Google', 'Mail', 'Yahoo', 'Bing']
    });
};
var handleVisitorsDonutChart = function() {
    Morris.Donut({
        element: "ps-donut-chart",
        data: [<?
        if($arPsCount)
                foreach ($arPsCount as $i => $value){?>
        {
            label: "<?=$i?>",
            value: <?=$value?>
        },
<?}?>],
        colors: colorsArray,
        labelFamily: "Open Sans",
        labelColor: "rgba(255,255,255,0.4)",
        labelTextSize: "12px",
        backgroundColor: "#242a30"
    })
};
var handleBrowsersDonutChart = function() {
    Morris.Donut({
        element: "visitors-donut-chart",
        data: [<?foreach ($arBrowserCount as $i => $value){?>
        {
            label: "<?=$i?>",
            value: <?=$value?>
        },
<?}?>],
        colors: colorsArray,
        labelFamily: "Open Sans",
        labelColor: "rgba(255,255,255,0.4)",
        labelTextSize: "12px",
        backgroundColor: "#242a30"
    })
};

var handleTrafficDonutChart = function() {
    Morris.Donut({
        element: "traffic-donut-chart",
        data: [<?foreach ($arTraffic as $i => $value){?>
        {
            label: "<?=$i?>",
            value: <?=$value?>
        },
<?}?>],
        resize: true,
        colors: colorsArray,
        labelFamily: "Open Sans",
        labelColor: "rgba(255,255,255,0.4)",
        labelTextSize: "12px",
        backgroundColor: "#242a30"
    })
};
var handleVisitorsVectorMap = function() {
    if ($("#visitors-map").length !== 0) {
        map = new jvm.WorldMap({
            map: "world_merc_en",
            scaleColors: ["#fff", "#000"],
            container: $("#visitors-map"),
            normalizeFunction: "linear",
            hoverOpacity: .5,
            hoverColor: false,
            markerStyle: {
                initial: {
                    fill: "#4cabc7",
                    stroke: "transparent",
                    r: 3
                }
            },
            regions: [{
                attribute: "fill"
            }],
            regionStyle: {
                initial: {
                    fill: "rgb(97,109,125)",
                    "fill-opacity": 1,
                    stroke: "none",
                    "stroke-width": .4,
                    "stroke-opacity": 1
                },
                hover: {
                    "fill-opacity": .8
                },
                selected: {
                    fill: "yellow"
                },
                selectedHover: {}
            },
            series: {
                regions: [{
                    values: {<?$count = 0;foreach ($arCountries as $key => $value) {?><?=$key?>: "#00acac",<?$count++;}?>}}]
            },
            focusOn: {
                x: .5,
                y: .5,
                scale: 2
            },
            backgroundColor: "#2d353c"
        });
    }
};
var handleDashboardGritterNotification = function() {
    $(window).load(function() {
        setTimeout(function() {
            $.gritter.add({
                title: "Welcome back, Admin!",
                text: "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed tempus lacus ut lectus rutrum placerat.",
                image: "assets/img/user-14.jpg",
                sticky: true,
                time: "",
                class_name: "my-sticky-class"
            })
        }, 1e3)
    })
};
var StataV2 = function() {
    "use strict";
    return {
        init: function() {
            handleVisitorsLineChart();
            handleVisitorsDonutChart();
            handleVisitorsVectorMap();
            handleTrafficDonutChart();
            handleBrowsersDonutChart();
            handlePSLineChart();
            handleMorrisBrowserChart();
            //handleDashboardGritterNotification()
        }
    }
}()
</script>
    <script>
        $(document).ready(function() {
            StataV2.init();
        });
    </script>
<style type="text/css">
.oldvalue_left {
    width: 79%;
    vertical-align: top;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
    display: inline-block;
    padding-left: 1%;
}
.count_right {
    display: inline-block;
    width: 19%;
    vertical-align: top;
}
div#soe_key, .box_key {
    display: inline-block;
    width: 100%;
}
.box_key {
    box-shadow: #AEAEAE 0 0 10px 0px inset;
    line-height: 22px;
}
.box_key img {
    vertical-align: text-bottom;
}
</style>