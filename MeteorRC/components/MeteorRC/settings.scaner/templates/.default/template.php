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
var step = 0;
var percent = 0;
var detected = 0;
    function GoScan(stp){
        if(stp == 0)
            $("#result").html("");
        step = (step + 1);
        $.post( "<?=$componentPath?>/go_scaner_ajax.php", { step: stp}).done(function( data ) {
        var resp = jQuery.parseJSON(data);
        $("#status").text(percent + "% Просканировано " + resp.getStepCount + " из " + resp.countFile + " файлов");
        percent = Math.round((resp.getStepCount / resp.countFile) * 100);
        $("#statusbar").width(percent + "%");
        $.each(resp.result, function(i, val) {
            detected++;
            $("#result").append('<a onclick="openLst(this);" href="#" class="list-group-item text-ellipsis"><span class="badge badge-' + val.color + '"><i class="fa fa-bug"></i></span> ' + val.desc + '<ul id="pre_' + detected + '"></ul></a>');
            $.each(val.matches, function(index, value) {
                var li = document.createElement("li");
                $("ul#pre_" + detected).append(li);
                $(li).text(value);
            });
        });
        if(percent <= 99){
                GoScan(step);
        }else{
            $("#status").text("Завершено! Найдено " + detected);
            step = 0;
            percent = 0;
            detected = 0;
        }
        });
    }
</script>
<?
?>

<div id="scaner">
<div class="row">
<div class="col-sm-9">
<div class="progress">
    <div id="statusbar" class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%">
        <span id="status"></span>
    </div>
</div>
</div>
<div class="col-sm-3 text-right">
<button id="scan_start" class="btn btn-sm btn-success m-r-5" onclick="GoScan(step)">Запустить сканирование</button>
</div>
</div>

<ul id="result"></ul>
</div>