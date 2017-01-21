<?require_once($_SERVER["DOCUMENT_ROOT"]."/MeteorRC/main/include/before.php");
global $APPLICATION;
global $USER;
//p($_REQUEST);
if($USER->IsAdmin()){
if(!isset($_REQUEST["ADD_PAGE"]["GO"])){
  $arMenu = json_decode(base64_decode($FIREWALL->GetString('MENU')), true);
?>
<form id="meteorAddPage" action="<?=$_SERVER["PHP_SELF"]?>" onsubmit="return SaveFormToModal(this, '<?=$_SERVER["PHP_SELF"]?>', true, false)">
<div class="result"></div>
<div class="form-group">
<div class="row">
  <div class="col-sm-6">
    <div class="input-group">
      <span class="input-group-addon">
        <i class="fa fa-file-o"></i>
      </span>
      <input placeholder="Имя страницы" name="ADD_PAGE[ARRAY][NAME]" type="text" class="form-control">
    </div><!-- /input-group -->
  </div><!-- /.col-sm-6 -->
  <div class="col-sm-6">
    <div class="input-group">
      <span class="input-group-addon">
        <i class="fa fa-link"></i>
      </span>
      <input placeholder="Алиас" name="ADD_PAGE[ARRAY][ALIAS]" type="text" class="form-control">
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
      <textarea placeholder="Мета описание" name="ADD_PAGE[ARRAY][META]" class="form-control"></textarea>
    </div><!-- /input-group -->
  </div><!-- /.col-sm-6 -->
  <div class="col-sm-6">
    <div class="input-group">
      <span class="input-group-addon">
        <i class="fa fa-info-circle"></i>
      </span>
      <textarea placeholder="Ключевые слова" name="ADD_PAGE[ARRAY][KEY]" class="form-control"></textarea>
    </div><!-- /input-group -->
  </div><!-- /.col-sm-6 -->
</div><!-- /.row -->
</div>

<div class="form-group">
<div class="row">
  <div class="col-sm-6">
  <label>Добавить в меню:
    <div class="input-group">
      <span class="input-group-addon">
        <i class="fa fa-bars"></i>
      </span>
      
      <select name="ADD_PAGE[MENU]" class="form-control">
          <option>не добавлять</option>
      <?
      if($arMenu)
          foreach ($arMenu as $file => $patch) {?>
          <option value="<?=$patch?>"><?=str_replace('.menu' . SFX_BD, "", $file)?></option>
      <?}?>
      </select>
    </div><!-- /input-group -->
    <label>
  </div><!-- /.col-sm-6 -->
  <div class="col-sm-6">
  <label>Содержимое страницы:
    <div class="input-group">
      <span class="input-group-addon">
        <i class="fa fa-file-text-o"></i>
      </span>
      <select name="ADD_PAGE[CONTENT]" class="form-control">
          <option>Текст</option>
      </select>
    </div><!-- /input-group -->
    <label>
  </div><!-- /.col-sm-6 -->
</div><!-- /.row -->
</div>

<button class="btn_admin button_save" type="submit">Добавить <i class="fa fa-floppy-o"></i></button>
<input autocomplete="off" value="Y" name="ADD_PAGE[GO]" type="hidden">
<input autocomplete="off" value="<?=$FIREWALL->GetString('PATCH')?>" name="ADD_PAGE[PATCH]" type="hidden">
</form>
<?
  }else{
    
    $arPage = $FIREWALL->GetArrayString('ADD_PAGE');
    // p($arPage["ARRAY"]);
    if(!isset($arPage["ARRAY"]["ALIAS"]))
      $arResult["ERROR"][] = 'Поле "Алиас" не заполнено!';
    if(!isset($arPage["ARRAY"]["NAME"]))
      $arResult["ERROR"][] = 'Поле "Имя страницы" не заполнено!';

    if($arPage["ARRAY"] and !$arResult["ERROR"]){
      $patch = $arPage["PATCH"] . $arPage["ARRAY"]["ALIAS"];
      $section = $arPage["PATCH"] . $arPage["ARRAY"]["ALIAS"] . '/.section.php';
      $index = $arPage["PATCH"] . $arPage["ARRAY"]["ALIAS"] . '/index.php';
      $content = '<?require_once($_SERVER["DOCUMENT_ROOT"]."/MeteorRC/header.php");?>' . PHP_EOL;
      
      $content .= '<div class="container">' . PHP_EOL;
      $content .= '<?$APPLICATION->IncludeComponent("MeteorRC:main.include","", Array(' . PHP_EOL;
      $content .= ' "PATH" => "/MeteorRC/include/' . $arPage["ARRAY"]["ALIAS"] . rand(10000, 99999) . '_page.php"' . PHP_EOL;
        $content .= ')' . PHP_EOL;
      $content .= ');?>' . PHP_EOL;
      $content .= '</div>' . PHP_EOL;
      
      $content .= '<?require_once($_SERVER["DOCUMENT_ROOT"]."/MeteorRC/footer.php");?>' . PHP_EOL;
      if(!file_exists($patch)){
        if(!$APPLICATION->CreateDir($patch)){
          $arResult["ERROR"][] = 'Не удалось создать папку!';
        }else{
          $APPLICATION->ArrayWriter($arPage["ARRAY"], $section);
          if($arPage["MENU"] and file_exists($arPage["MENU"])){
              $arMenu = $APPLICATION->GetFileArray($arPage["MENU"]);
              $arMenu[] = array($arPage["ARRAY"]['NAME'], $arPage["ARRAY"]["ALIAS"] . DS);
              $APPLICATION->ArrayWriter($arMenu, $arPage["MENU"]);
          }
          file_put_contents($index, stripcslashes($content));
          //LocalRedirect($arPage["ARRAY"]["ALIAS"] . '/');
          $arResult["SUCCESS"] = 'Страница успешно создана, перенаправление...<script>setTimeout(location.href = "' . $arPage["ARRAY"]["ALIAS"] . '/", 10000)</script>';
        }
      }else{
        $arResult["ERROR"][] = 'Раздел с таким алиасом уже существует!';
      }
    }
    echo json_encode($arResult);
  }
}
