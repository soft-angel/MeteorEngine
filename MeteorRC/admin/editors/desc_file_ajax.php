<?require_once($_SERVER["DOCUMENT_ROOT"]."/MeteorRC/main/include/before.php");
if($USER->IsAdmin()){
	$arRespound = array();
	$fileUrl = $FIREWALL->GetString("FILE");
	if($fileUrl){
		$filePatch = $_SERVER["DOCUMENT_ROOT"] . dirname($fileUrl) . DS . ".description.php";
		$fileName = basename($fileUrl);
		if($textSave = $FIREWALL->GetString("TEXT")){
			$arSave = $APPLICATION->GetFileArray($filePatch);
			$arSave[$fileName] = $textSave;
			if(!$APPLICATION->ArrayWriter($arSave, $filePatch)){
				$arRespound["ERROR"] = "Ошибка сохранения";
			}else{
				$arRespound["SUCCESS"] = "Описание успешно сохранено";
			}
			echo json_encode($arRespound);
		}else{
		?>
<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    <h4 style="color: #fff;" class="modal-title">Описание файла: <?=$fileUrl?></h4>
</div>
<textarea style="width: 100%;height: 350px;" id="managerDesc"><?
  if(file_exists($filePatch)){
  	$arDesc = $APPLICATION->GetFileArray($filePatch);
    echo isset($arDesc[$fileName])?$arDesc[$fileName]:null;
  }?></textarea>
<div class="text-center" style="padding: 10px 0">
  <button id="file-save" type="button" class="btn btn-success m-r-5">
    <i class="fa fa-spinner fa-pulse fa-fw margin-bottom"></i>
    <i class="fa fa-floppy-o"></i> Сохранить</button>
  <button id="file-apply" type="button" class="btn btn-white m-r-5">
    <i class="fa fa-spinner fa-pulse fa-fw margin-bottom"></i>
    <i class="fa fa-check"></i> Применить</button>
</div>
<style type="text/css">
  button .fa-spinner, button.load i {
    display: none;
  }
  button.load .fa-spinner {
    display: inline-block;
  }
</style>
<script>
$("#modal-editor .close").click(function() {
  closeBtn = true;
  $('#modal-editor').modal("hide");
});

$("#file-save").click(function(e) {
  $(this).addClass("load");
  SaveFile(this, '<?=$fileUrl?>', $("#managerDesc").val(), true)
});

$("#file-apply").click(function(e) {
  $(this).addClass("load");
  SaveFile(this, '<?=$fileUrl?>', $("#managerDesc").val());
});

function SaveFile(btn, file, code, close = false) {
    $.post( "<?=$_SERVER["SCRIPT_NAME"]?>", {FILE:file, TEXT:code}).done(function( respond ){
      var arRespond = JSON.parse(respond);
      setTimeout(function() {
        $(btn).removeClass("load");
      }, 300);
      if(arRespond.ERROR) {
        alert(arRespond.ERROR);
        return false;
      }else{
        if(close){
		  closeBtn = true;
		  $('#modal-editor').modal("hide");
        }
        return true;
      }
    });
}
</script>
	<?
		}
	}
}
