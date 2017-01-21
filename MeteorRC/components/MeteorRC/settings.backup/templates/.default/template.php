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
$APPLICATION->AddHeadScript($templateFolder . "/script.js");
//p($arResult);
$APPLICATION->SetAdditionalCSS($templateFolder . "/style.css");
?>
<script type="text/javascript">
var pause = false;
<?if(isset($_SESSION["BACKUP_GO"])){
    $percent = round((($_SESSION["BACKUP_GO"]["getStepCount"] / $_SESSION["BACKUP_GO"]["countFile"]) * 100));
    ?>
var step = <?=$_SESSION["BACKUP_GO"]["step"]?$_SESSION["BACKUP_GO"]["step"]:0?>;
var percent = <?=$percent?>;
var archiveTime = <?=$_SESSION["BACKUP_GO"]["archiveTime"]?>;
var countAddFile = <?=$_SESSION["BACKUP_GO"]["countAddFile"]?>;
<?}else{?>
var step = 0;
var percent = 0;
var archiveTime = null;
var countAddFile = 0;
<?}?>
    function GoBackup(){
        pause = false;
        $("#backup_start").hide();
        $("#backup_pause").show();
        $("#backup .progress").addClass("active");
        
        if(step == 0){
            $("#result").html("");
        }

        
        $("#backup_start").html('<i class="fa fa-play"></i> Продолжить');
        $.post( "<?=$componentPath?>/go_backup_ajax.php", { step: step, archiveTime: archiveTime, countAddFile:countAddFile}).done(function( data ) {
        step = (step + 1);
        var resp = jQuery.parseJSON(data);

        percent = Math.round((resp.getStepCount / resp.countFile) * 100);
        countAddFile = resp.countAddFile;
        archiveTime = resp.archiveTime;
        $("#statusbar").width(percent + "%");
        $("#status").text(percent + "% Запаковано " + countAddFile + " из " +  resp.countFile + " файлов");
        if(step < resp.allStep){
            if(!pause)
                GoBackup();
        }else{
            $("#status").text("Завершено! " + " за " + (resp.time - resp.archiveTime) + " секунд");
            $("#result").html('<div class="alert alert-success" role="alert">Файлов в архиве: ' + countAddFile + '<br>Имя архива: ' + resp.backupName + '</div>');
            step = 0;
            percent = 0;
            countAddFile = 0;
            archiveTime = null;
            $("#backup_start").text("Запустить");
            PauseBackup();
        }
        });
    }

    function PauseBackup(){
        pause = true;
        $("#backup_start").show();
        $("#backup_pause").hide();
        $("#backup .progress").removeClass("active");
    }
</script>
<?
?>

<div id="backup">
<div class="row">
<div class="col-sm-9">
<div class="progress progress-striped">
    <div id="statusbar" class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: <?=$percent?>%">
        <span id="status">
<?if(isset($_SESSION["BACKUP_GO"])){?>
<?=$percent?>% Запаковано <?=$_SESSION["BACKUP_GO"]["countAddFile"]?> из <?=$_SESSION["BACKUP_GO"]["countFile"]?> файлов
<?}?>    
        </span>
    </div>
</div>
</div>
<div class="col-sm-3 text-right">
<button id="backup_start" class="btn btn-sm btn-success m-r-5 backup-btn" onclick="GoBackup()"><?if(isset($_SESSION["BACKUP_GO"])){?><i class="fa fa-play"></i> Продолжить<?}else{?>Запустить<?}?></button>

<button id="backup_pause" class="btn btn-sm btn-default m-r-5 backup-btn" style="display: none;" onclick="PauseBackup()"><i class="fa fa-pause"></i> Пауза</button>
</div>
</div>

<div id="result"></div>

<!--
<div class="panel panel-inverse">
    <div class="panel-heading">
        <div class="panel-heading-btn">
            <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-success" data-click="panel-expand"><i class="fa fa-expand"></i></a>
                <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-warning" data-click="panel-collapse"><i class="fa fa-minus"></i></a>
        </div>
        <h4 class="panel-title">Настройки архивирования</h4>
    </div>
    <div class="panel-body" style="display: none;">
        <div class="row">
            <div class="col-md-8">
                <div class="form-group">
                    <div class="row">
                        <label class="col-md-4 control-label">Исключать файлы размером более: <i class="text-danger">*</i></label>                                            <div class="col-md-8">
                        <div class="input-group">
                            <input autocomplete="off" value="0" class="form-control" type="text" name="BACKUP[NAME]">
                            <span class="input-group-addon"><i class="fa fa-balance-scale"></i></span>
                        </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <div class="row">
                        <label class="col-md-8 control-label">Архивировать ядро:</label>
                        <div class="col-md-4">
                                <select id="products-ACTIVE" class="form-control" name="SAVE[ACTIVE]">
                                    <option selected="selected" value="Y">Да</option>
                                    <option value="N">Нет</option>
                                </select>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-8">
                <div class="form-group">
                    <div class="row">
                        <label class="col-md-4 control-label">Удалять локальные резервные копии:</label>
                        <div class="col-md-8">
                            <div class="input-group">

                                <select class="form-control" name="BACKUP[ACTIVE]">
                                    <option selected="selected" value="CLOUD_COMPLEDET">после успешной передачи в облако</option>
                                    <option value="NONE">никогда не удалять</option>
                                    <option value="COUNT_3">если общее число копий больше 3</option>
                                    <option value="COUNT_5">если общее число копий больше 5</option>
                                    <option value="COUNT_10">если общее число копий больше 10</option>
                                    <option value="SIZE_100">если суммарный размер резервных копий больше 100 мб.</option>
                                    <option value="SIZE_200">если суммарный размер резервных копий больше 200 мб.</option>
                                    <option value="SIZE_500">если суммарный размер резервных копий больше 500 мб.</option>
                                </select>
                                <span class="input-group-addon"><i class="fa fa-trash"></i></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <div class="row">
                        <label class="col-md-6 control-label">Периодичность втозапуска:</label>
                        <div class="col-md-6">
                            <select class="form-control" name="BACKUP[ACTIVE]">
                                <option value="1">каждый день</option>
                                <option value="2">через день</option>
                                <option value="3">каждые 3 дня</option>
                                <option value="7">еженедельно</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <div class="row">
            <div class="col-md-8">
                <div class="form-group">
                    <div class="row">
                        <label class="col-md-4 control-label">Исключить из архива файлы и директории (через запятую): <i class="text-danger">*</i></label>                                            <div class="col-md-8">
                        <div class="input-group">
                            <input autocomplete="off" value="" class="form-control" type="text" name="BACKUP[NAME]">
                            <span class="success input-group-addon"><i class="fa fa-filter"></i></span>
                        </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <div class="row">
                        <label class="col-md-8 control-label">Пропускать символические ссылки на директории:</label>
                        <div class="col-md-4">
                                <select id="products-ACTIVE" class="form-control" name="SAVE[ACTIVE]">
                                    <option selected="selected" value="Y">Да</option>
                                    <option value="N">Нет</option>
                                </select>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>-->

<div class="panel panel-inverse">
                        <div class="panel-heading">
                            <div class="panel-heading-btn">
                                <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-success" data-click="panel-expand"><i class="fa fa-expand"></i></a>
                                <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-warning" data-click="panel-collapse"><i class="fa fa-minus"></i></a>
                            </div>
                            <h4 class="panel-title">
                                Список резервных копий
                            </h4>
                        </div>
                        <div class="panel-body">
<div id="backup-list">
        <table id="data-table" class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th>Имя</th>
                    <th>Время создания</th>
                    <th>Размер</th>
                    <th>Управление</th>
                </tr>
            </thead>
            <tbody>
<?foreach ($arResult as $id => $arBackup) {?>
                <tr id="element-<?=$id?>">
                    <td class="text-center">
                        <?=$arBackup["NAME"]?>
                    </td>
                    <td class="text-center">
                        <?=$arBackup["DATE"]?>
                    </td>
                    <td class="text-center">
                        <?=$arBackup["SIZE_CONVERT"]?>
                    </td>
                    <td class="text-center">
                        <div class="btn-group">
                            <a href="<?=FOLDER_BACKUPS?>/<?=$arBackup["NAME"]?>" class="btn btn-sm btn-white"><span class="btn btn-success btn-xs btn-icon btn-circle btn-xs"><i class="fa fa-download"></i></span></a>
                            <a href="" class="btn btn-sm btn-white"><span class="btn btn-xs btn-warning  btn-icon btn-circle btn-xs"><i class="fa fa-upload"></i></span></a>
                            <a href="javascript:backupDelete(this,'<?=$id?>');" class="btn btn-sm btn-white"><span class="btn btn-danger btn-xs btn-icon btn-circle btn-xs"><i class="fa fa-times"></i></span></a>
                        </div>
                    </td>
                </tr>
<?}?>
            </tbody>
        </table>
</div>
</div>
</div>
</div>
<script src="assets/jquery.dataTables.js"></script>
<script src="assets/dataTables.bootstrap.min.js"></script>
<script src="assets/dataTables.fixedHeader.min.js"></script>
<script src="assets/dataTables.responsive.min.js"></script>