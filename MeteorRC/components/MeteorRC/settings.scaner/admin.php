<?
if(!defined("PROLOG_INCLUDED") || PROLOG_INCLUDED!==true)die();
$FILE = new FILE;
$arParams = $APPLICATION->GetFileArray(__DIR__ . '/.parametrs.php');
?>
<div id="content" class="content">
            <!-- begin breadcrumb -->
            <ol class="breadcrumb pull-right">
                <li><a href="/"><i class="fa fa-home"></i></a></li>
                <li><a href="javascript:;">Панель управления</a></li>
                <li class="active"><?=$arParams["NAME"]?></li>
            </ol>
            <!-- end breadcrumb -->
            <!-- begin page-header -->
            <h1 class="page-header"><?=$arParams["NAME"]?> <small><?=$arParams["DESCRIPTION"]?></small></h1>
            <!-- end page-header -->
            
            <!-- begin timeline -->
<?$APPLICATION->IncludeComponent("MeteorRC:settings.scaner", "", Array(
        "COMPONENT" => "settings",
        "IBLOCK" => "scaner",  // Инфоблок
    ),
    false
);?>
            <!-- end timeline -->
        </div>
        <!-- end #content -->