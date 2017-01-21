		<!-- begin #content -->
		<div id="content" class="content">
<?
include($_SERVER["DOCUMENT_ROOT"] . '/MeteorRC/components/MeteorRC/statistics.stata/helper.php');
$arUserStats = $APPLICATION->GetFileArray(PATCH_USER . '/' . date("Y-m-d") . '.php');


if((int)date("H") == 0){
    $hoursPassed = declOfNum((int)date("i"), array('минуту', 'минуты', 'минут'));
}else{
    $hoursPassed = declOfNum((int)date("H"), array('час', 'часа', 'часов'));
}

?>
			<!-- begin breadcrumb -->
            <ol class="breadcrumb pull-right">
                <li><a href="/"><i class="fa fa-home"></i></a></li>
                <li><a href="javascript:;">Панель управления</a></li>
                <li class="active">Рабочий стол</li>
            </ol>
			<!-- end breadcrumb -->
			<!-- begin page-header -->
			<h1 class="page-header">Рабочий стол<small> Начините работу от сюда</small></h1>
			<!-- end page-header -->
			<!-- begin row -->
			<div class="row">
			    <!-- begin col-3 -->
			    <div class="col-md-3 col-sm-6">
			        <div class="widget widget-stats bg-green">
			            <div class="stats-icon stats-icon-lg"><i class="fa fa-globe fa-fw"></i></div>
			            <div class="stats-title">ПОСТИТЕЛЕЙ СЕГОДНЯ</div>
			            <div class="stats-number"><?=number_format(count($arUserStats))?></div>
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
			            <div class="stats-icon stats-icon-lg"><i class="fa fa-tags fa-fw"></i></div>
			            <div class="stats-title">ПРИБЫЛЬ</div>
			            <div class="stats-number">???</div>
			            <div class="stats-progress progress">
                            <div class="progress-bar" style="width: 100%;"></div>
                        </div>
                        <div class="stats-desc">???</div>
			        </div>
			    </div>
			    <!-- end col-3 -->
			    <!-- begin col-3 -->
<?$APPLICATION->IncludeComponent("MeteorRC:informer.orders","",Array(
    "COMPONENT" => "shop",
    "IBLOCK" => "basket",  // Инфоблок
     )
);?>
			    <!-- end col-3 -->
			    <!-- begin col-3 -->
			    <div class="col-md-3 col-sm-6">
			        <div class="widget widget-stats bg-black">
			            <div class="stats-icon stats-icon-lg"><i class="fa fa-comments fa-fw"></i></div>
			            <div class="stats-title">НОВЫХ КОММЕНТАРИЕВ</div>
			            <div class="stats-number">???</div>
			            <div class="stats-progress progress">
                            <div class="progress-bar" style="width: 100%;"></div>
                        </div>
                        <div class="stats-desc">???</div>
			        </div>
			    </div>
			    <!-- end col-3 -->
			</div>
			<!-- begin row -->
			<div class="row">
			    <!-- begin col-4 -->
			    <div class="col-md-4">
			        <!-- begin panel -->
<?$APPLICATION->IncludeComponent("MeteorRC:main.chat","admin",Array(
    "COMPONENT" => "chat",
    "IBLOCK" => "history",  // Инфоблок
    "ELEMENT_COUNT" => 50,
    "SHOW_ERRORS" => "Y" 
     )
);?>

			        <!-- end panel -->
			    </div>
			    <!-- end col-4 -->
			    <!-- begin col-4 -->
			    <div class="col-md-4">
			        <!-- begin panel -->
<?$APPLICATION->IncludeComponent("MeteorRC:users.users","admin",Array(
    "COMPONENT" => "users",
    "IBLOCK" => "users",  // Инфоблок
    "ELEMENT_COUNT" => 8,
    "SHOW_ERRORS" => "Y" 
     )
);?>

			        <!-- end panel -->
			    </div>
			    <!-- end col-4 -->
			    <div class="col-md-4">
			        <!-- begin panel -->
<?$APPLICATION->IncludeComponent("MeteorRC:informer.hosting","",Array(
    "COMPONENT" => "informer",
    "IBLOCK" => "hosting",  // Инфоблок
    "SHOW_ERRORS" => "Y" 
     )
);?>

			    </div>
			</div>
			<!-- end row -->
		</div>
		<!-- end #content -->