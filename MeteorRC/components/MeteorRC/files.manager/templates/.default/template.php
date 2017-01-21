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
<?CJSCore::Init(array('fileinput'));?>
<script type="text/javascript">
$(document).on("ready", function() {
    $("#fileinput").fileinput({
        uploadAsync: false,
        uploadUrl: "<?=$componentPath?>/uplod_file_ajax.php",
        uploadExtraData: function() {
            return {
                patch: '<?=$arResult["FOLDER"]?>',
            };
        }
    });
});
</script>
<?

?>
<div id="filemanager">
<div class="panel panel-inverse" data-sortable-id="ui-general-2">
    <div class="panel-heading">
        <div class="panel-heading-btn">
            <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-success" data-click="panel-expand"><i class="fa fa-expand"></i></a>
            <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-warning" data-click="panel-collapse"><i class="fa fa-minus"></i></a>
            <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-danger" data-click="panel-remove"><i class="fa fa-times"></i></a>
        </div>

        <div class="input-group input-group-sm" style="width: 85%">
            <span class="input-group-addon"><i class="fa fa-folder-open-o" aria-hidden="true"></i></span>
            <input id="manager-folder" style="color: #000;width: 50%;border-radius: 0" type="text" value="<?=!empty($arResult["FOLDER"])?$arResult["FOLDER"]:false?>" placeholder="/" class="input-sm" placeholder="Папка">
            
        <div id="files-control" class="btn-group" role="group" aria-label="...">
          <button onclick="GoFolder($('#manager-folder').val());" style="border-radius: 0;" class="btn btn-sm btn-default"><i class="fa fa-check" aria-hidden="true"></i></button>

          <div class="btn-group" role="group">
            <button type="button" class="btn btn-sm dropdown-toggle btn-success" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              <i class="fa fa-plus" aria-hidden="true"></i> Добавить <span class="caret"></span>
            </button>
            <ul class="dropdown-menu">
              <li><a href="javascript:showUpload();"><i class="fa fa-upload" aria-hidden="true"></i> Загразить файлы</a></li>
              <li><a href="#"><i class="fa fa-file-o" aria-hidden="true"></i> Создать файл</a></li>
            </ul>
          </div>
        </div>
    </div>
    </div>
    <div class="panel-body">
        <div id="files-list-upload">
            <input id="fileinput" name="FILES[]" type="file" multiple>
        </div>
        <div id="files-list">

        </div>
    </div>
</div>
<script type="text/javascript">
function GoFolder(patch) {
    $.post( "<?=$componentPath?>/get_folder_ajax.php", {FOLDER:patch}).done(function( table ){
        $("#files-list").html(table);
        if(!patch)
            patch = "/";
        $("#manager-folder").val(patch);
    });
}

$(function() {
    GoFolder($('#manager-folder').val());
});
</script>
</div>