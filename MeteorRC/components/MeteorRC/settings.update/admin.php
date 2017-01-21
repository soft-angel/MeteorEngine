<?
if(!defined("PROLOG_INCLUDED") || PROLOG_INCLUDED!==true)die();
$arParams = $APPLICATION->GetComponentsParams("settings", "update");
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
            <h1 class="page-header"><?=$arParams["ICON"]?> <?=$arParams["NAME"]?> <small><?=$arParams["DESCRIPTION"]?></small></h1>
            <!-- end page-header -->
            
<?$APPLICATION->IncludeComponent("MeteorRC:settings.update", "", Array(
        "COMPONENT" => "settings",
        "IBLOCK" => "update",  // Инфоблок
    ),
    false
);?>
        </div>
        <!-- end #content -->