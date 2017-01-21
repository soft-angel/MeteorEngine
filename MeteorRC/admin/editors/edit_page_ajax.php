<?require_once($_SERVER["DOCUMENT_ROOT"]."/MeteorRC/main/include/before.php");?>
<?
if($USER->IsAdmin()){
  if($PagePatch = $FIREWALL->GetString('PATCH')){
    $APPLICATION->GetPageParam($PagePatch);
    $arParam = $APPLICATION->GetArrayPageParam($PagePatch);
    if(!isset($_REQUEST["EDIT_PAGE"]["GO"])){
?>
<form id="meteor_edit_page" action="<?=$_SERVER["PHP_SELF"]?>" onsubmit="return SaveFormToModal(this, '<?=$_SERVER["PHP_SELF"]?>', true, true)">
<div class="result"></div>
<div class="form-group">
<div class="row">
  <div class="col-sm-6">
    <div class="input-group">
      <span class="input-group-addon">
        <i class="fa fa-file-o"></i>
      </span>
      <input placeholder="Имя страницы" name="EDIT_PAGE[ARRAY][NAME]" value="<?=$arParam["PageName"]?>" type="text" class="form-control">
    </div><!-- /input-group -->
  </div><!-- /.col-sm-6 -->
  <div class="col-sm-6">
    <div class="input-group">
      <span class="input-group-addon">
        <i class="fa fa-link"></i>
      </span>
      <input placeholder="Алиас" name="EDIT_PAGE[ARRAY][ALIAS]" value="<?=$arParam["PageAlias"]?>" type="text" class="form-control">
    </div>
  </div>
</div>
</div>
<div class="form-group">
<div class="row">
  <div class="col-sm-6">
    <div class="input-group">
      <span class="input-group-addon">
        <i class="fa fa-info-circle"></i>
      </span>
      <textarea placeholder="Мета описание" name="EDIT_PAGE[ARRAY][META]" class="form-control"><?=$arParam["MetaDescription"]?></textarea>
    </div><!-- /input-group -->
  </div><!-- /.col-sm-6 -->
  <div class="col-sm-6">
    <div class="input-group">
      <span class="input-group-addon">
        <i class="fa fa-info-circle"></i>
      </span>
      <textarea placeholder="Ключевые слова" name="EDIT_PAGE[ARRAY][KEY]" class="form-control"><?=$arParam["MetaKeyWords"]?></textarea>
    </div><!-- /input-group -->
  </div><!-- /.col-sm-6 -->
</div><!-- /.row -->
</div>
<button class="btn_admin button_save" type="submit">Сохранить <i class="fa fa-floppy-o"></i></button>
<input autocomplete="off" value="Y" name="EDIT_PAGE[GO]" type="hidden">
<input autocomplete="off" value="<?=$PagePatch?>" name="PATCH" type="hidden">
</form>
<?}else{
      $arPage = $FIREWALL->GetArrayString('EDIT_PAGE');

      if(!isset($arPage["ARRAY"]["ALIAS"]))
        $arResult["ERROR"][] = 'Поле "Алиас" не заполнено!';
      if(!isset($arPage["ARRAY"]["NAME"]))
        $arResult["ERROR"][] = 'Поле "Имя страницы" не заполнено!';
      if($arPage["ARRAY"] and !$arResult["ERROR"]){
        $APPLICATION->ArrayWriter($arPage["ARRAY"], $arParam["ParamFile"]);
        $arResult["SUCCESS"] = 'Параметры страницы успешно обновлены.';
      }
      echo json_encode($arResult);
    }
  }
}
?>