<?require_once($_SERVER["DOCUMENT_ROOT"]."/MeteorRC/main/include/before.php");?>
<?
include("component.php");
if($USER->IsAdmin()){

	foreach ($arResult["FILES"] as $id => $fileName) {
		$filePatch = $arResult["PATCH"] . DS . $fileName;
		if(is_file($filePatch)){
			$arResult["FILES_LIST"][$id]["SIZE"] = ConvertFileSize(filesize($filePatch), $round = 2);
			$arResult["FILES_LIST"][$id]["EXT"] = $FILE->GetTypeFile($fileName);
			$arResult["FILES_LIST"][$id]["NAME"] = $fileName;
			foreach ($arExtension as $type => $arExt) {
				if(in_array(mb_strtolower($arResult["FILES_LIST"][$id]["EXT"]), $arExt)){
					$arResult["FILES_LIST"][$id]["TYPE"] = $type;
					break;
				}
			}
			if($arResult["FILES_LIST"][$id]["TYPE"] != "IMAGE"){
				if(isset($arIcon[$arResult["FILES_LIST"][$id]["TYPE"]])){
					$arResult["FILES_LIST"][$id]["PREWIEV"] = $arIcon[$arResult["FILES_LIST"][$id]["TYPE"]];
				}else{
					$arResult["FILES_LIST"][$id]["PREWIEV"] = '<i class="fa fa-file-o" aria-hidden="true"></i>';
				}
			}else{
				$arResult["FILES_LIST"][$id]["PREWIEV"] = '<img src="' . $arResult["FOLDER"] . DS . $fileName . '">';
			}
			
		}else{
			$arResult["FOLDER_LIST"][$id]["NAME"] = $fileName;
		}
	}
	?>
                <table id="data-table" class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th>Превью</th>
                            <th>Имя</th>
                            <th>Тип</th>
                            <th>Размер</th>
                            <th>Управление</th>
                        </tr>
                    </thead>
                    <tbody>

        <?
        if(isset($arResult["FOLDER_LIST"]))
            foreach ($arResult["FOLDER_LIST"] as $id => $arFolder) {?>
                        <tr id="element-<?=$id?>" ondblclick="GoFolder('<?=$FIREWALL->GetString("FOLDER")?>/<?=$arFolder["NAME"]?>')">
                            <td class="text-center file-prewiew color-theme">
                                <i class="fa fa-folder-o" aria-hidden="true"></i>
                            </td>
                            <td class="text-center">
                                <?=$arFolder["NAME"]?>
                            </td>
                            <td class="text-center">
                                папка
                            </td>
                            <td class="text-center">
                                
                            </td>
                            <td class="text-center">
                                <div class="btn-group">
                                    <?if($arFolder["NAME"] != ".."){?>
                                    <a href="javascript:fileDelete(this, '<?=$id?>', '<?=$arResult["FOLDER"]?>/<?=$arFolder["NAME"]?>');" class="btn btn-sm btn-white"><span class="btn btn-danger btn-xs btn-icon btn-circle btn-xs"><i class="fa fa-times"></i></span></a>
                                    <?}?>
                                </div>
                            </td>
                        </tr>
        <?}?>

        <?
        if(isset($arResult["FILES_LIST"]))
            foreach ($arResult["FILES_LIST"] as $id => $arFile) {?>
                        <tr id="element-<?=$id?>" ondblclick="$('#modal-editor').modal({ remote: '/MeteorRC/admin/editors/edit_file_ajax.php?FILE=<?=$arResult["FOLDER"]?>/<?=$arFile["NAME"]?>'  });">
                            <td class="text-center file-prewiew color-theme">
                                <?=$arFile["PREWIEV"]?>
                            </td>
                            <td class="text-center">
                                <?=$arFile["NAME"]?>
                            </td>
                            <td class="text-center">
                                <?=$arFile["EXT"]?>
                            </td>
                            <td class="text-center">
                                <?=$arFile["SIZE"]?>
                            </td>
                            <td class="text-center">
                                <div class="btn-group">
                                    <a data-toggle="modal" data-target="#modal-editor" href="/MeteorRC/admin/editors/edit_file_ajax.php?FILE=<?=$arResult["FOLDER"]?>/<?=$arFile["NAME"]?>" class="btn btn-sm btn-white"><span class="btn btn-success btn-xs btn-icon btn-circle btn-xs"><i class="fa fa-pencil"></i></span></a>


                                    <a href="javascript:fileDelete(this, '<?=$id?>', '<?=$arResult["FOLDER"]?>/<?=$arFile["NAME"]?>');" class="btn btn-sm btn-white"><span class="btn btn-danger btn-xs btn-icon btn-circle btn-xs"><i class="fa fa-times"></i></span></a>

                                    <a href="javascript:;" data-toggle="dropdown" class="btn btn-sm btn-white dropdown-toggle" aria-expanded="false">
                                    <span class="caret"></span>
                                    </a>
                                    <ul class="dropdown-menu pull-right">
                                        <li><a href="<?=$arResult["FOLDER"]?>/<?=$arFile["NAME"]?>"><i class="fa fa-download"></i> Скачать</a></li>
                                        <li><a data-toggle="modal" data-target="#modal-editor" href="/MeteorRC/admin/editors/desc_file_ajax.php?FILE=<?=$arResult["FOLDER"]?>/<?=$arFile["NAME"]?>"><i class="fa fa-align-left" aria-hidden="true"></i> Описание</a></li>
                                    </ul>
                                </div>
                            </td>
                        </tr>
        <?}?>
                    </tbody>
                </table>
<div class="modal fade" id="modal-editor">
    <div class="modal-dialog" style="padding-left: 15px;width: 100%;padding-right: 15px;">
        <div style="border-radius: 0;background-color: #3A4248;" class="modal-content">
            <div class="modal-body">                   
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
var closeBtn = false;
var editor = null;
function closeModalEvent(e) {
    if (closeBtn != true) {
        e.preventDefault();
        return false;
    }else{
        $(this).removeData('bs.modal');
        closeBtn = false;
        return true;
    }
}
$(function() {
    $('#modal-editor').on('hide.bs.modal', closeModalEvent);
});


$('#modal-editor').on('shown.bs.modal', function () {
  CodeMirror.modeURL = "/MeteorRC/admin/editors/codemirror/mode/%N/%N.js";
  editor = CodeMirror.fromTextArea(document.getElementById("managerCode"), {
  //mode: "application/x-httpd-php",
  //mode: {name: "javascript", globalVars: true},
  //mode: "scheme",
  lineNumbers: true,
  //autoCloseTags: true,
  //scrollbarStyle: "simple",
  keyMap: "sublime",
  lineWrapping: true,
  tabSize: 2,
  styleActiveLine: true,
  //extraKeys: {"Ctrl-Space": "autocomplete"},
  showCursorWhenSelecting: true,
  autoCloseBrackets: true,
  theme: "monokai",
  onCursorActivity: function() {
    //editor.setLineClass(hlLine, null, null);
    //hlLine = editor.setLineClass(editor.getCursor().line, null, "monokai");
  }
});
});
</script>
<?}?>