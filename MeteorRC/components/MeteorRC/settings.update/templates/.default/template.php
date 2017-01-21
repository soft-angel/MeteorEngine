<?if(!defined("PROLOG_INCLUDED") || PROLOG_INCLUDED!==true)die();
/** @var array $arParams */
/** @var array $arResult */
/** @global class $APPLICATION */
/** @global class $USER */
/** @global class $CONFIG */
/** @global class $CACHE */
/** @global class $FILE */
/** @var string $templateName - Имя шаблона */
/** @var string $templateFile - файл шаблона */
/** @var string $templateFolder - папка шаблона относительно корня сайта */
/** @var string $componentPath - папка компонента относительно корня сайта */
//$APPLICATION->AddHeadScript($templateFolder . "/script.js");
//p($arResult);
//$APPLICATION->SetAdditionalCSS($templateFolder . "/style.css");
?>
<script type="text/javascript">
    var pause = false;
    var step = 1;
    var percent = 0;
    var startTime = null;
    function GoUpdate(){
        pause = false;
        $("#update .progress").addClass("active");
        if(step == 1){
            $("#updateStart").attr("disabled", "disabled");
            $("#updateStart span").text("Подождите");
        }

        $.post( "<?=$componentPath?>/go_update_ajax.php", { step: step, startTime:startTime}).done(function( data ) {
        var resp = jQuery.parseJSON(data);
        percent = Math.round((step / resp.countStep) * 100);
        startTime = resp.startTime;
        $("#statusbar").width(percent + "%");
        $("#status").text(percent + "% " + resp.stepName);
        if(step < resp.countStep){
            if(!pause)
                step = (step + 1);
                GoUpdate();
        }else{
            $("#status").text("Обновление завершено! " + " за " + (resp.time - resp.startTime) + ' сек.');
            step = 1;
            percent = 0;
            startTime = null;
            $("#updateStart").removeAttr("disabled");
            $("#updateStart span").text("Обновить");
            $("#update .progress").removeClass("active");
            $("#currentVersion b").text(resp.currentVersion)
            CheckUpdate();
        }
        });
    }
</script>
<?
?>

<div id="update">
<div class="row">
<div class="col-sm-9">
<div class="progress progress-striped" style="height: 30px;">
    <div id="statusbar" class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%">
        <span id="status" style="line-height: 30px;">
        </span>
    </div>
</div>
</div>
<div class="col-sm-3 text-right">
<button id="updateStart" style="width: 100%" class="btn btn-sm btn-success m-r-5 sitemap-btn" onclick="GoUpdate()"><i class="fa fa-refresh"></i> <span>Обновить</span></button>
</div>
</div>

<div class="panel panel-inverse" data-sortable-id="ui-general-2">
    <div class="panel-heading">
        <div class="panel-heading-btn">
            <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-success" data-click="panel-expand"><i class="fa fa-expand"></i></a>
            <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-warning" data-click="panel-collapse"><i class="fa fa-minus"></i></a>
            <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-danger" data-click="panel-remove"><i class="fa fa-times"></i></a>
        </div>
        <h4 class="panel-title">Информация о обновлениях</h4>
    </div>
    <div class="panel-body">
        <p id="updateVersion"><i class="fa fa-refresh"></i> Последняя версия ядра: <b>?</b></p>
        <p id="currentVersion"><i class="fa fa-flag-checkered"></i> Текущя версия ядра: <b><?=$APPLICATION->version?></b></p>
        <p id="updateServer"><i class="fa fa-server"></i> Сервер обновлений: <b><?=UPDATE::SERVER?></b></p>
        <p id="updateKey"><i class="fa fa-key"></i> Лицензионный ключ: <b><?=$FIREWALL->GetLicenseKey()?></b></p>
    </div>
</div>
<script type="text/javascript">
function CheckUpdate() {
    $.post( "<?=$componentPath?>/get_update_ajax.php", {GET:'Y'}).done(function( version ){
        var oldVersion = $("#currentVersion b").text();
        $("#updateVersion b").text(version);
        if(oldVersion != version){
            $("#updateVersion").addClass('text-danger');
            $.post( "<?=$componentPath?>/get_update_info_ajax.php", {}).done(function( info ){
                $(".updateInfo").html(info);
                $("#uiUpdateInfo").show();
            });
        }else{
            $("#updateVersion").addClass('text-success');
            $("#uiUpdateInfo").hide();
        }
    });
}

$(function() {
    CheckUpdate();
});
</script>


<div style="display: none;" id="uiUpdateInfo" class="panel panel-inverse" data-sortable-id="ui-general-update-info">
    <div class="panel-heading">
        <div class="panel-heading-btn">
            <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-success" data-click="panel-expand"><i class="fa fa-expand"></i></a>
            <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-warning" data-click="panel-collapse"><i class="fa fa-minus"></i></a>
            <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-danger" data-click="panel-remove"><i class="fa fa-times"></i></a>
        </div>
        <h4 class="panel-title">Нововведения в новом обновлении</h4>
    </div>
    <div class="panel-body">
        <div class="updateInfo"></div>
    </div>
</div>
</div>