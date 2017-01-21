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
<?
//p($_SESSION["SITEMAP_GO"]);
if(isset($_SESSION["SITEMAP_GO"])){
    $percent = round((($_SESSION["SITEMAP_GO"]["step"] / $_SESSION["SITEMAP_GO"]["countIblocks"]) * 100));
    ?>
var step = <?=$_SESSION["SITEMAP_GO"]["step"]?$_SESSION["SITEMAP_GO"]["step"]:0?>;
var percent = <?=$percent?>;
var startTime = <?=$_SESSION["SITEMAP_GO"]["startTime"]?$_SESSION["SITEMAP_GO"]["startTime"]:'null'?>;
var countUrl = <?=isset($_SESSION["SITEMAP_GO"]["countUrl"])?$_SESSION["SITEMAP_GO"]["countUrl"]:0?>;
<?}else{?>
var step = 0;
var percent = 0;
var startTime = null;
var countUrl = 0;
<?}?>
    function GoSitemap(){
        pause = false;
        $("#backup_start").hide();
        $("#backup_pause").show();
        $("#sitemap .progress").addClass("active");
        
        if(step == 0){
            $("#result").hide();
        }

        $("#backup_start").html('<i class="fa fa-play"></i> Продолжить');
        $.post( "<?=$componentPath?>/go_sitemap_ajax.php", { step: step, startTime: startTime}).done(function( data ) {
        var resp = jQuery.parseJSON(data);
        countUrl = (resp.countUrl + countUrl);
        percent = Math.round((step / resp.countIblocks) * 100);
        startTime = resp.startTime;
        $("#statusbar").width(percent + "%");
        $("#status").text(percent + "% Сгенерировано " + " из " +  resp.countIblocks + " компонентов");
        if(step < resp.countIblocks){
            if(!pause)
                step = (step + 1);
                GoSitemap();
        }else{
            $("#status").text("Завершено! " + " за " + (resp.time - resp.startTime) + " секунд, найдено URL: " + countUrl);
            //$("#result").html('<div class="alert alert-success" role="alert">URL в карте: ' + countUrl + '<br><a target="_blank" href="' + resp.sitemapUrl + '">' + resp.sitemapUrl + '</a></div>');
            $("#sitemapUrl").attr("href", resp.sitemapUrl).text(resp.sitemapUrl);
            $("#result").show();
            step = 0;
            percent = 0;
            startTime = null;
            countUrl = 0;
            $("#backup_start").text("Запустить");
            PauseBackup();
        }
        });
    }

    function PauseBackup(){
        pause = true;
        $("#backup_start").show();
        $("#sitemap .progress").removeClass("active");
        $("#backup_pause").hide();
    }
</script>
<?
?>

<div id="sitemap">
<div class="row">
<div class="col-sm-9">
<div class="progress progress-striped">
    <div id="statusbar" class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: <?=$percent?>%">
        <span id="status">
<?if(isset($_SESSION["SITEMAP_GO"])){?>
<?=$percent?>% Запаковано <?=$_SESSION["SITEMAP_GO"]["countAddFile"]?> из <?=$_SESSION["SITEMAP_GO"]["countIblocks"]?> файлов
<?}?>    
        </span>
    </div>
</div>
</div>
<div class="col-sm-3 text-right">
<button id="backup_start" class="btn btn-sm btn-success m-r-5 sitemap-btn" onclick="GoSitemap()"><?if(isset($_SESSION["SITEMAP_GO"])){?><i class="fa fa-play"></i> Продолжить<?}else{?>Запустить<?}?></button>

<button id="backup_pause" class="btn btn-sm btn-default m-r-5 sitemap-btn" style="display: none;" onclick="PauseBackup()"><i class="fa fa-pause"></i> Пауза</button>
</div>
</div>
<div id="result" style="display: none;" class="alert alert-info" role="alert">
            <p>Файл индекса Sitemap создан и доступен по адресу: <b><a id="sitemapUrl" href="">http://rusinfo24.ru/sitemap_index.xml</a></b></p>
            <h5>Как сообщить Гуглу о файле Sitemap?</h5>
            <p>Если вы еще не зарегистрированы в программе Google Sitemaps, необходимо выполнить следующие шаги:</p>
            <ol>
                <li>
                    Зарегистрируйтесь в <a href="https://www.google.com/webmasters/tools/home">Google Sitemaps</a>
                    с использованием вашей <a href="https://www.google.com/accounts/ManageAccount">учетной записи Google</a>
                </li>
                <li>
                    Перейдите по ссылке <strong>"Добавьте первую карту сайта"</strong>.
                </li>
                <li>
                    Введите в поле <strong>"URL"</strong> адрес вашего файла индекса Sitemap и нажмите кнопку <strong>"Передать URL"</strong>.
                </li>
            </ol>
            <p>Если вы уже добавляли файл индекса, то можете обновить ссылку на файл в интерфейсе Google Sitemaps</p>

            <h5>Как сообщить Яндексу о файле Sitemap?</h5>

            <p>Вы можете сообщить Яндексу о наличии файла Sitemap для своего сайта следующими способами:</p>
            <p>Указать URL файла в сервисе Яндекс.Вебмастере (<b>Настройка индексирования</b> → <b>Файлы Sitemap</b>).</p>
        <span class="close" data-dismiss="alert">×</span>
    </div>

<div class="panel panel-inverse" data-sortable-id="ui-general-2">
    <div class="panel-heading">
        <div class="panel-heading-btn">
            <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-success" data-click="panel-expand"><i class="fa fa-expand"></i></a>
            <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-warning" data-click="panel-collapse"><i class="fa fa-minus"></i></a>
            <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-danger" data-click="panel-remove"><i class="fa fa-times"></i></a>
        </div>
        <h4 class="panel-title">Информация</h4>
    </div>
    <div class="panel-body">
        <h2>Что такое файл Sitemap?</h2>
        <p>Файл <span class="tag">Sitemap</span> — это файл с информацией о страницах сайта, подлежащих индексированию. Разместив этот файл на сайте, вы можете:</p>
        <ul>
            <li>сообщить поисковым системам, какие страницы вашего сайта нужно индексировать;</li>
            <li>как часто обновляется информация на страницах;</li>
            <li>индексирование каких страниц наиболее важно.</li>
          </ul>
        <p>Файл <span class="tag">Sitemap</span> учитывается при индексировании сайта роботом, однако не гарантируется, что все URL, указанные в файле, будут добавлены в поисковые индексы систем.</p>
        <h2>Нужно ли создавать файл Sitemap?</h2>
        <p>Обычно роботы поисковых систем узнает о страницах сайта, переходя по ссылкам со страницы на страницу. В большинстве случаев этого достаточно для полного индексирования сайтов. Однако робот может не найти некоторые страницы или неверно определить их важность: проблемными обычно становятся динамически создаваемые страницы или страницы, на которые можно попасть только пройдя по длинной цепочке ссылок. Файл <span class="tag">Sitemap</span> помогает решить эти проблемы.
        </p>

    </div>
</div>

<div class="panel panel-inverse">
    <div class="panel-heading">
        <div class="panel-heading-btn">
            <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-success" data-click="panel-expand"><i class="fa fa-expand"></i></a>
                <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-warning" data-click="panel-collapse"><i class="fa fa-minus"></i></a>
        </div>
        <h4 class="panel-title">Настройки Генерации Sitemap</h4>
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
</div>

</div>