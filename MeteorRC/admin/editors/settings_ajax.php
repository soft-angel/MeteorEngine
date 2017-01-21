<?require_once($_SERVER["DOCUMENT_ROOT"]."/MeteorRC/main/include/before.php");?>
<?
if($USER->IsAdmin()){
if(!isset($_REQUEST["SAVE_SETTINGS"]["ARRAY"])){
?>
<form id="meteorrc_save_settings" action="<?=$_SERVER["PHP_SELF"]?>" onsubmit="return SaveFormToModal(this, '<?=$_SERVER["PHP_SELF"]?>', true, true)">
	<fieldset class="form-group">
		<div class="row">
			<div class="col-sm-6">
				<label>Название сайта:
					<div class="input-group">
						<span class="input-group-addon"><i class="fa fa-chain"></i></span>
						<input type="text" value="<?=$CONFIG["SITE_NAME"]?>" name="SAVE_SETTINGS[ARRAY][SITE_NAME]" class="form-control input-sm" placeholder="Название сайта">
					</div>
				</label>
			</div>
			<div class="col-sm-6">
				<label>Email:
					<div class="input-group">
						<span class="input-group-addon"><i class="fa fa-envelope-o"></i></span>
						<input type="text" value="<?=$CONFIG["DEFAULT_EMAIL_FROM"]?>" name="SAVE_SETTINGS[ARRAY][DEFAULT_EMAIL_FROM]" class="form-control input-sm" placeholder="Email">
					</div>
				</label>
			</div>
		</div>
	</fieldset>

	<fieldset class="form-group">
		<div class="row">
			<div class="col-xs-4">
				<label>Включить кеширование:
					<div class="input-group">
						<span class="input-group-addon"><i class="fa fa-database"></i></span>
						<select class="form-control input-sm" name="SAVE_SETTINGS[ARRAY][CACHE]">
							<option <?if($CONFIG['CACHE'] == "Y"){?>selected="selected"<?}?> value="Y">Да</option>
							<option <?if($CONFIG['CACHE'] != "Y"){?>selected="selected"<?}?> value="N">Нет</option>
						</select>
					</div>
				</label>
			</div>
			<div class="col-xs-4">
				<label>Сжимать HTML:
					<div class="input-group">
						<span class="input-group-addon"><i class="fa fa-file-code-o"></i></span>
						<select class="form-control input-sm" name="SAVE_SETTINGS[ARRAY][COMPRESS][HTML]">
							<option <?if($CONFIG['COMPRESS']['HTML'] == "Y"){?>selected="selected"<?}?> value="Y">Да</option>
							<option <?if($CONFIG['COMPRESS']['HTML'] != "Y"){?>selected="selected"<?}?> value="N">Нет</option>
						</select>
					</div>
				</label>
			</div>
			<div class="col-xs-4">
				<label>Объединять JavaScript:
					<div class="input-group">
						<span class="input-group-addon"><i class="fa fa-code"></i></span>
						<select class="form-control input-sm" name="SAVE_SETTINGS[ARRAY][COMPRESS][JS]">
							<option <?if($CONFIG['COMPRESS']['JS'] == "Y"){?>selected="selected"<?}?> value="Y">Да</option>
							<option <?if($CONFIG['COMPRESS']['JS'] != "Y"){?>selected="selected"<?}?> value="N">Нет</option>
						</select>
					</div>
				</label>
			</div>
		</div>
	</fieldset>

	<fieldset class="form-group">
		<div class="row">
			<div class="col-xs-4">
				<label>Режим отладки:
					<div class="input-group">
						<span class="input-group-addon"><i class="fa fa-database"></i></span>
						<select class="form-control input-sm" name="SAVE_SETTINGS[ARRAY][DEBUG]">
							<option <?if($CONFIG['DEBUG'] == "Y"){?>selected="selected"<?}?> value="Y">Да</option>
							<option <?if($CONFIG['DEBUG'] != "Y"){?>selected="selected"<?}?> value="N">Нет</option>
						</select>
					</div>
				</label>
			</div>
		</div>
	</fieldset>
	<button class="btn_admin button_save" type="submit">Cохранить <i class="fa fa-floppy-o"></i></button>
	<input autocomplete="off" value="Y" name="SAVE_SETTINGS[GO]" type="hidden">
</form>
<?}else{?>
<?
$arSave = array_merge($CONFIG, $_REQUEST["SAVE_SETTINGS"]["ARRAY"]);
$APPLICATION->ArrayWriter($arSave, CONFIG_FILE);
?>
<?}?>
<?}?>