<?require_once($_SERVER["DOCUMENT_ROOT"]."/MeteorRC/main/include/before.php");?>
<?
global $APPLICATION;
global $USER;
if($USER->IsAdmin()){
	if(!isset($_REQUEST["SAVE_FILE"]["GO"])){
?>
<form style="min-height: 350px;" id="meteorrc_save_file" action="/" onsubmit="return SaveFormToModal(this, '<?=$_SERVER["PHP_SELF"]?>', false, true)">
<textarea style="width: 100%;min-height: 350px;" id="editor" name="SAVE_FILE[TEXT]">
<?
if($_REQUEST["FILE"])
	echo file_get_contents($_REQUEST["FILE"]);
?>
</textarea>
<?if(isset($_REQUEST["TYPE"]) and $_REQUEST["TYPE"] != "HTML"){?>
<script>
CKEDITOR.config.height = 250;
CKEDITOR.config.width = 'auto';
//CKEDITOR.config.filebrowserBrowseUrl = '/MeteorRC/admin/editors/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Images';
//CKEDITOR.config.filebrowserUploadUrl = '/MeteorRC/admin/editors/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Files';
if(editor = CKEDITOR.replace( 'editor' )){
	editor.config.height = 250;
}

function CKEupdate() {
  for ( instance in CKEDITOR.instances )
    CKEDITOR.instances[instance].updateElement();
}
</script>
<?}?>
<div style="clear:both"></div>
<button onclick="CKEupdate()" class="btn_admin button_save" type="submit">Cохранить <i class="fa fa-floppy-o"></i></button>
<input autocomplete="off" value="Y" name="SAVE_FILE[GO]" type="hidden">
<input autocomplete="off" value="<?=$_REQUEST["FILE"]?>" name="SAVE_FILE[FILE]" type="hidden">
</form>
<?
	}else{
		sleep(1);
		if($_REQUEST["SAVE_FILE"]["TEXT"] !== null){
			if (is_writable($_REQUEST["SAVE_FILE"]["FILE"])) {
  				file_put_contents($_REQUEST["SAVE_FILE"]["FILE"], stripcslashes($_REQUEST["SAVE_FILE"]["TEXT"]));
			} else {
				$APPLICATION->AddMessage2Log('Файл недоступен для записи!', "main.include");
			}
		}
	}
}
?>