<?if(!defined("PROLOG_INCLUDED") || PROLOG_INCLUDED!==true)die();?>
<?
if($_GET["edit_element"])
    $arElement = $arElements[$_GET["edit_element"]];
//p($arElements);
$arTabs = array();
foreach ($arParams["FIELDS"] as $id => $field) {
    $arTabs[$field["TAB"]][$id] = $field;
}
?>
                    <div class="row panel panel-inverse panel-with-tabs" data-sortable-id="ui-unlimited-tabs-2" data-init="true">
                        <div class="panel-heading p-0">

                            <!-- begin nav-tabs -->
                            <div class="tab-overflow overflow-right">
                                <ul class="nav nav-tabs nav-tabs-inverse">
                                    <li class="prev-button"><a href="javascript:;" data-click="prev-tab" class="text-inverse"><i class="fa fa-arrow-left"></i></a></li>
                                    <?$count = 0;foreach ($arParams["TABS"] as $id => $tab) {?>
                                        <li <?if(empty($count)){?>class="active"<?}?>><a href="#nav-tab-<?=$id?>" data-toggle="tab"><?=$tab?></a></li>
                                    <?$count++;}?>
                                    <li class="next-button"><a href="javascript:;" data-click="next-tab" class="text-success"><i class="fa fa-arrow-right"></i></a></li>
                                </ul>
                            </div>
                        </div>
                        <form id="form-<?=$arParams["IBLOCK"]?>" action="/MeteorRC/admin/editors/save_ajax.php" enctype="multipart/form-data" method="post">
                            <div class="result"></div>
                            <input type="hidden" name="PARAMS[IBLOCK]" value="<?=$arParams["IBLOCK"]?>">
                            <input type="hidden" name="PARAMS[COMPONENT]" value="<?=$arParams["COMPONENT"]?>">
                            <input type="hidden" name="PARAMS[TYPE]" value="SAVE">
                            <input type="hidden" id="<?=$arParams["IBLOCK"]?>-OLD_KEY" name="PARAMS[OLD_KEY]" value="<?=(isset($_GET["clone_element"]))?false:$_GET["edit_element"]?>">
                        <div class="tab-content">
                            <?$count = 0;foreach ($arTabs as $id => $tabs) {?>
                            <div class="<?if(empty($count)){?>active in <?}else{?>fade <?}?>tab-pane" id="nav-tab-<?=$id?>">
                                    <?
                                    foreach ($tabs as $code => $field) {?>
                                   <div class="form-group">
                                        <div class="row">
                                            <?if($field["TYPE"] != "HIDDEN"){?><label class="col-md-4 control-label"><?=$field["NAME"]?><?if(isset($field["REQUIRED"]) and $field["REQUIRED"] == "Y"){?><i class="text-danger">*</i><?}?></label><?}?>
                                            <div class="col-md-8">
                                    <?
                                        switch($field["TYPE"])
                                            {
                                                case "SELECT":?>
                                                <div class="input-group">
                                                 <?CJSCore::Init(array('select'));?>
                                                    <select <?if(isset($field["MULTI"])){?>multiple<?}?> id="<?=$arParams["IBLOCK"]?>-<?=$code?>" <?if(isset($field["REQUIRED"]) and $field["REQUIRED"] == "Y"){?>required="required"<?}?> class="form-control selectpicker" name="SAVE[<?=$code?>]<?if(isset($field["MULTI"])){?>[]<?}?>">
                                                            <?foreach ($field["SELECT"] as $id => $option){?>
                                                            <?if(!isset($field["MULTI"])){?>
                                                            <option <?if(isset($arElement[$code]) and $arElement[$code] == $id){?>selected="selected" <?}?>value="<?=$id?>"><?=$option?></option>
                                                            <?}else{?>
                                                            <option <?if(isset($arElement[$code]) and in_array($id, $arElement[$code])){?>selected="selected" <?}?>value="<?=$id?>"><?=$option?></option>
                                                            <?}?>
                                                            <?}?>
                                                    </select>
                                                    <span class="input-group-addon"><?=$field["ICON"]?></span>
                                                    </div>
                                                    <?
                                                    break;
                                                case "SELECT_FILE":?>
                                                <div class="input-group">
                                                 <?$fileList = glob($_SERVER["DOCUMENT_ROOT"] . $field["SELECT_FILE"] . '/*');?>
                                                    <select id="<?=$arParams["IBLOCK"]?>-<?=$code?>" <?if(isset($field["REQUIRED"]) and $field["REQUIRED"] == "Y"){?>required="required"<?}?> class="form-control selectpicker" name="SAVE[<?=$code?>]">
                                                            <option <?if(!isset($arElement[$code])){?>selected="selected" <?}?>value=""><?=isset($field["DEFAULT_VALUE"])?$field["DEFAULT_VALUE"]:'Не выбрано'?></option>
                                                            <?foreach ($fileList as $option){
                                                                $value = basename($option)?>
                                                            <option <?if(isset($arElement[$code]) and $arElement[$code] == $value){?>selected="selected" <?}?>value="<?=$value?>"><?=$value?></option>
                                                            <?}?>
                                                    </select>
                                                    <span class="input-group-addon"><?=$field["ICON"]?></span>
                                                    </div>
                                                    <?
                                                    break;
                                                case "SELECT_BD":
                                                    CJSCore::Init(array('select'));
                                                    $component = (isset($field["COMPONENT_BD"]))?$field["COMPONENT_BD"]:$arParams["COMPONENT"];
                                                    $select_bd = $APPLICATION->GetFileArray(FOLDER_BD . $component . DS . $field["BD"] . SFX_BD);
                                                    ?>
                                                    <div class="input-group">
                                                        <select <?if(isset($field["MULTI"])){?>multiple<?}?> id="<?=$arParams["IBLOCK"]?>-<?=$code?>" <?if(isset($field["REQUIRED"]) and $field["REQUIRED"] == "Y"){?>required="required"<?}?><?if(isset($field["DESCRIPTION"])){?> data-placement="left" data-toggle="tooltip" data-original-title="<?=$field["DESCRIPTION"]?>"<?}?> class="form-control selectpicker" name="SAVE[<?=$code?>]<?if(isset($field["MULTI"])){?>[]<?}?>">
                                                            <option <?if(!isset($arElement[$code])){?>selected="selected" <?}?>value="">Не выбрано</option>
                                                            <?foreach ($select_bd as $id => $option){?>
                                                            <?if(!isset($field["MULTI"])){?>
                                                            <option <?if(isset($arElement[$code]) and $arElement[$code] == $id){?>selected="selected" <?}?>value="<?=$id?>"><?=$option["NAME"]?></option>
                                                            <?}else{?>
                                                            <option <?if(isset($arElement[$code]) and in_array($id, $arElement[$code])){?>selected="selected" <?}?>value="<?=$id?>"><?=$option["NAME"]?></option>
                                                            <?}?>
                                                            <?}?>
                                                        </select>
                                                        <span class="input-group-addon"><?=$field["ICON"]?></span>
                                                    </div>
                                                    <?
                                                    break;
                                                case "PRODUCT_TABLE":
                                                    $component = (isset($field["COMPONENT_BD"]))?$field["COMPONENT_BD"]:$arParams["COMPONENT"];
                                                    $products = $APPLICATION->GetFileArray(FOLDER_BD . $component . DS . $field["BD"] . SFX_BD);
                                                    ?>
                                                    <div class="input-group">
                                                    <table class="table table-striped">
                                                        <thead>
                                                            <tr>
                                                                <th>#</th>
                                                                <th>Название</th>
                                                                <th>Цена</th>
                                                                <?foreach ($field["COMBINATE"] as $fieldComb => $comb) {?>
                                                                <th><?=$fieldComb?></th>
                                                                <?}?>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                    <?
                                                    $i = $priceFull = 0;
                                                    foreach ($arElement[$code] as $id) {
                                                        $priceFull = ($priceFull + (IntOnly($products[$id]["PRICE"]) * (int)$arElement["QUANTITY"][$id]));
                                                        $i++;
                                                    ?>
                                                            <tr>
                                                                <th scope="row"><?=$i?></th>
                                                                <td>
                                                                    <input id="<?=$arParams["IBLOCK"]?>-<?=$code?>-<?=$id?>" value="<?=$id?>" type="hidden" name="SAVE[<?=$code?>][<?=$id?>]">
                                                                    <a href="?component=<?=$component?>&iblock=<?=$field["BD"]?>&&edit_element=<?=$id?>"><?=$products[$id]["NAME"]?> [<?=$id?>]</a>
                                                                </td>
                                                                <td><?=$APPLICATION->PriceFormat($products[$id]["PRICE"])?> <small class="fa fa-rub"></small></td>
                                                                <?foreach ($field["COMBINATE"] as $fieldComb) {?>
                                                                <input id="<?=$arParams["IBLOCK"]?>-<?=$code?>-<?=$id?>" value="<?=(string)$arElement[$fieldComb][$id]?>" type="hidden" name="SAVE[<?=$fieldComb?>][<?=$id?>]">
                                                                <td><?=(string)$arElement[$fieldComb][$id]?></td>
                                                                <?}?>
                                                            </tr>
                                                    <?}?>

                                                        </tbody>
                                                    </table>
                                                    <h4 class="text-right">
                                                        <span class="label label-info">Итого: <?=$APPLICATION->PriceFormat($priceFull)?> <i class="fa fa-rub"></i></span>
                                                    </h4>
                                                    <span class="input-group-addon"><?=$field["ICON"]?></span>
                                                    </div>
                                                    <?
                                                    break;
                                                case "PRICE":
                                                    ?>
                                                    <div class="input-group">
                                                    <input id="<?=$arParams["IBLOCK"]?>-<?=$code?>" value="<?=(isset($arElement[$code]))?$arElement[$code]:false?>" <?if(isset($field["REQUIRED"]) and $field["REQUIRED"] == "Y"){?>required="required"<?}?><?if(isset($field["DESCRIPTION"])){?> data-placement="left" data-trigger="focus" data-toggle="tooltip" data-original-title="<?=$field["DESCRIPTION"]?>"<?}?> name="SAVE[<?=$code?>]" type="text" class="form-control">
                                                    <span class="input-group-addon"><?=$field["ICON"]?></span>
                                                    </div>
                                                    <?
                                                    break;
                                                case "DATE_TIME":
                                                    ?>
                                                    <div class="input-group">
                                                    <?CJSCore::Init(array('datetimepicker'));?>
                                                    <input id="<?=$arParams["IBLOCK"]?>-<?=$code?>" value="<?=(isset($arElement[$code]))?$arElement[$code]:date('Y-m-d H:i:s')?>" <?if(isset($field["REQUIRED"]) and $field["REQUIRED"] == "Y"){?>required="required"<?}?><?if(isset($field["DESCRIPTION"])){?> data-placement="left" data-trigger="focus" data-toggle="tooltip" data-original-title="<?=$field["DESCRIPTION"]?>"<?}?> class="form-control" type="text" name="SAVE[<?=$code?>]">
                                                    <span class="success input-group-addon"><?=$field["ICON"]?></span>
                                                    <script type="text/javascript">
                                                        $(function () {
                                                            $('#<?=$arParams["IBLOCK"]?>-<?=$code?>').datetimepicker({locale: 'ru', format: 'L LTS'});
                                                        });
                                                    </script>
                                                    </div>
                                                    <?
                                                    break;
                                                case "TIME":
                                                    ?>
                                                    <div class="input-group">
                                                    <input id="<?=$arParams["IBLOCK"]?>-<?=$code?>" value="<?=(isset($arElement[$code]))?$arElement[$code]:time()?>" <?if(isset($field["REQUIRED"]) and $field["REQUIRED"] == "Y"){?>required="required"<?}?><?if(isset($field["DESCRIPTION"])){?> data-placement="left" data-trigger="focus" data-toggle="tooltip" data-original-title="<?=$field["DESCRIPTION"]?>"<?}?> class="form-control" type="text" name="SAVE[<?=$code?>]">
                                                    <span class="success input-group-addon"><?=$field["ICON"]?></span>
                                                    </div>
                                                    <?
                                                    break;
                                                case "IMAGE":
                                                    if(!isset($field["MULTI"]) or $field["MULTI"] != "Y"){
                                                    ?>
                                                    <div class="input-group">
                                                    <div class="image_add">
                                                        <img class="img-thumbnail" src="<?=(!isset($_GET['clone_element']) and isset($arElement[$code]))?$FILE->GetUrlFile($arElement[$code], $arParams["IBLOCK"]):SITE_TEMPLATE_PATH . "images/noimage.png"?>" width="<?=$arParams["IMAGE_WIDTH"]?>">
                                                        <input id="<?=$arParams["IBLOCK"]?>-<?=$code?>" type="hidden" name="SAVE[<?=$code?>]" value="<?=(isset($arElement[$code]))?$arElement[$code]:false?>">
                                                        <span type="button" class="btn-input-file btn btn-white">
                                                            <?=$field["ICON"]?> Выбрать изображение
                                                            <input type="file" data-change="need" data-iblock="<?=$arParams["IBLOCK"]?>" data-id="<?=(!isset($_GET['clone_element']) and isset($arElement[$code]))?$arElement[$code]:false?>" data-quality="<?=$field["QUALITY"]?>" data-max-width="<?=$field["MAX_WIDTH"]?>" class="imageAdd">
                                                        </span>
                                                    </div>
                                                    </div>
                                                    <?}else{
                                                        $arMultyImg = (isset($arElement[$code]))?$arElement[$code]:(isset($field["DEFAULT_VALUE"])?$field["DEFAULT_VALUE"]:array());
                                                        ?>
                                                    <div class="MultyImgFields multiFields" id="MultyImgFields-<?=$code?>">
                                                    
                                                    <div class="form-group" id="multyImgFields-<?=$code?>">
<?foreach ($arMultyImg as $imageKey => $imageID) {?>
<input id="<?=$arParams["IBLOCK"]?>-<?=$code?>-<?=$imageID?>" name="SAVE[<?=$code?>][<?=$imageKey?>]" value="<?=$imageID?>" type="hidden">
<?}?>
<?CJSCore::Init(array('fileinput'));?>
<script type="text/javascript">
$(document).on("ready", function() {
    $("#fileinput-<?=$arParams["IBLOCK"]?>-<?=$code?>").fileinput({
        initialPreview: [
            <?foreach ($arMultyImg as $imageKey => $imageID) {?>
            '<img class="img-responsive" style="max-height:160px;" src="<?=$FILE->GetUrlFile($imageID, $arParams["IBLOCK"])?>">',
            <?}?>
        ],
        initialPreviewAsData: true,
        initialPreviewConfig: [
            <?foreach ($arMultyImg as $imageKey => $imageID) {?>
            {caption: "id: <?=$imageID?>", key: <?=$imageID?>},
            <?}?>
        ],
        overwriteInitial: false,
        uploadAsync: false,
        //showUpload: false,
        deleteUrl: "/MeteorRC/admin/ajax/delete_image_ajax.php?iblock=<?=$arParams["IBLOCK"]?>",
        maxFileSize: 10000,
        uploadUrl: "/MeteorRC/admin/ajax/uplod_image_ajax.php",
        uploadExtraData: function() {
            return {
                patch: '/MeteorRC/upload/tmp/<?=$arParams["IBLOCK"]?>/<?=$code?>/<?=(isset($_GET["clone_element"]) or !isset($_GET["edit_element"]))?'new':$_GET["edit_element"]?>',
            };
        }
    }).on('filedeleted', function(event, id) {
        $('#<?=$arParams["IBLOCK"]?>-<?=$code?>-' + id).remove();
    });
});
</script>
<input id="fileinput-<?=$arParams["IBLOCK"]?>-<?=$code?>" name="FILES[]" type="file" multiple>
                                                    </div>
                                                    </div>
                                                    <?}?>
                                                    <?$APPLICATION->AddHeadScript("/MeteorRC/js/plugins/ImageAdd/ImageAdd.js", false);?>
                                                    <?
                                                    break;
                                                case "FILE":
                                                    ?>
                                                    <div class="input-group">
                                                    <div class="file_add">
                                                        <a class="field-file-name" href="<?=(!isset($_GET['clone_element']) and isset($arElement[$code]))?$FILE->GetUrlFile($arElement[$code], $arParams["IBLOCK"]):false?>">Скачать</a>
                                                        <input id="<?=$arParams["IBLOCK"]?>-<?=$code?>" type="hidden" name="SAVE[<?=$code?>]" value="<?=(isset($arElement[$code]))?$arElement[$code]:false?>">
                                                        <span type="button" class="btn-input-file btn btn-white">
                                                            <?=$field["ICON"]?> Выбрать файл
                                                            <input type="file" data-change="need" data-iblock="<?=$arParams["IBLOCK"]?>" data-id="<?=(!isset($_GET['clone_element']) and isset($arElement[$code]))?$arElement[$code]:false?>" class="FileAdd">
                                                        </span>
                                                    </div>
                                                    </div>
                                                    <?$APPLICATION->AddHeadScript("/MeteorRC/js/plugins/FileAdd/FileAdd.js");?>
                                                    <?
                                                    break;
                                                case "HTML":
                                                    ?>
                                                        <textarea id="<?=$arParams["IBLOCK"]?>-<?=$code?>" <?if(isset($field["REQUIRED"]) and $field["REQUIRED"] == "Y"){?>required="required"<?}?> class="ckeditor form-control" id="editor-<?=$code?>" name="SAVE[<?=$code?>]"><?=(isset($arElement[$code]))?$arElement[$code]:false?></textarea>
                                                        <script src="/MeteorRC/admin/editors/ckeditor/ckeditor.js"></script>
                                                        <?$ckeditor = true;?>
                                                    <?
                                                    break;
                                                case "TEXTAREA":
                                                    ?>
                                                    <div class="input-group">
                                                        <textarea id="<?=$arParams["IBLOCK"]?>-<?=$code?>" <?if(isset($field["REQUIRED"]) and $field["REQUIRED"] == "Y"){?>required="required"<?}?><?if(isset($field["DESCRIPTION"])){?> data-placement="left" data-trigger="focus" data-toggle="tooltip" data-original-title="<?=$field["DESCRIPTION"]?>"<?}?> class="form-control" name="SAVE[<?=$code?>]"><?=(isset($arElement[$code]))?$arElement[$code]:false?></textarea>
                                                        <span class="input-group-addon"><?=$field["ICON"]?></span>
                                                    </div>
                                                    <?
                                                    break;
                                                case "HIDDEN":
                                                    ?>
                                                    <input id="<?=$arParams["IBLOCK"]?>-<?=$code?>" value="<?=$arElement[$code]?$arElement[$code]:$field["DEFAULT_VALUE"]?>" type="hidden" name="SAVE[<?=$code?>]">
                                                    <?
                                                    break;
                                                case "DISABLED":
                                                    ?>
                                                    <div class="input-group">
                                                    <input id="<?=$arParams["IBLOCK"]?>-<?=$code?>" value="<?=isset($arElement[$code])?$arElement[$code]:(isset($field["DEFAULT_VALUE"])?$field["DEFAULT_VALUE"]:false)?>" class="form-control" type="text" disabled name="SAVE[<?=$code?>]">
                                                    <span class="success input-group-addon"><?=$field["ICON"]?></span>
                                                    </div>
                                                    <?
                                                    break;
                                                case "TRANSLIT":
                                                    //if($APPLICATION->IsCyrillicDomain()){
                                                        $onkeypTranslit = "$(this).liTranslit({elAlias: $('#" . $arParams["IBLOCK"] . "-" . $field["TRANSLIT_FOR"] . "')});";
                                                    //}else{
                                                        //$onkeypTranslit = "$('#" . $arParams["IBLOCK"] . "-" . $field["TRANSLIT_FOR"] . "').val($(this).val());";
                                                    //}
                                                    ?>
                                                    <div class="input-group">
                                                    <input autocomplete="off" onkeyup="<?=$onkeypTranslit?>" id="<?=$arParams["IBLOCK"]?>-<?=$code?>" value="<?=(isset($arElement[$code]))?$arElement[$code]:false?>" <?if(isset($field["REQUIRED"]) and $field["REQUIRED"] == "Y"){?>required="required"<?}?><?if(isset($field["DESCRIPTION"])){?> data-placement="left" data-trigger="focus" data-toggle="tooltip" data-original-title="<?=$field["DESCRIPTION"]?>"<?}?> class="form-control" type="text" name="SAVE[<?=$code?>]">
                                                    <span class="success input-group-addon"><?=$field["ICON"]?></span>
                                                    <?$APPLICATION->AddHeadScript("/MeteorRC/js/plugins/liTranslit/jquery.liTranslit.js");?>
                                                    </div>
                                                    <?
                                                    break;
                                                case "PHONE":
                                                    ?>
                                                    <div class="input-group">
                                                    <?CJSCore::Init(array('maskedinput'));?>
                                                     <input data-plugin="maskedinput" id="<?=$arParams["IBLOCK"]?>-<?=$code?>" value="<?=(isset($arElement[$code]))?$arElement[$code]:false?>" <?if(isset($field["REQUIRED"]) and $field["REQUIRED"] == "Y"){?>required="required"<?}?><?if(isset($field["DESCRIPTION"])){?> data-placement="left" data-trigger="focus" data-toggle="tooltip" data-original-title="<?=$field["DESCRIPTION"]?>"<?}?> class="form-control" type="tel" name="SAVE[<?=$code?>]">
                                                    <span class="success input-group-addon"><?=$field["ICON"]?></span>
                                                    </div>
                                                    <?
                                                    break;
                                                case "EMAIL":
                                                    ?>
                                                    <div class="input-group">
                                                     <input id="<?=$arParams["IBLOCK"]?>-<?=$code?>" value="<?=(isset($arElement[$code]))?$arElement[$code]:false?>" <?if(isset($field["REQUIRED"]) and $field["REQUIRED"] == "Y"){?>required="required"<?}?><?if(isset($field["DESCRIPTION"])){?> data-placement="left" data-trigger="focus" data-toggle="tooltip" data-original-title="<?=$field["DESCRIPTION"]?>"<?}?> class="form-control" type="email" name="SAVE[<?=$code?>]">
                                                    <span class="success input-group-addon"><?=$field["ICON"]?></span>
                                                    </div>
                                                    <?
                                                    break;
                                                case "PASSWORD":
                                                    ?>
                                                    <div class="input-group">
                                                    <input autocomplete="off" id="<?=$arParams["IBLOCK"]?>-<?=$code?>" value="<?=(isset($arElement[$code]))?"******":false?>" <?if(isset($field["REQUIRED"]) and $field["REQUIRED"] == "Y"){?>required="required"<?}?><?if(isset($field["DESCRIPTION"])){?> data-placement="left" data-trigger="focus" data-toggle="tooltip" data-original-title="<?=$field["DESCRIPTION"]?>"<?}?> class="form-control" type="password" name="SAVE[<?=$code?>]">
                                                    <span class="success input-group-addon"><?=$field["ICON"]?></span>
                                                    </div>
                                                    <?
                                                    break;
                                               case "DOUBLE_TEXT":
                                                    $arDoubleValue = (isset($arElement[$code]))?$arElement[$code]:(isset($field["DEFAULT_VALUE"])?$field["DEFAULT_VALUE"]:array(array('NAME' => '', 'VALUE' => '')));
                                                    ?>
                                                    <div class="doubleFields multiFields" id="doubleFields-<?=$code?>">
                                                    <?foreach ($arDoubleValue as $doubleID => $doubleValue) {?>
                                                    <div class="form-group" id="doubleField-<?=$code?>-<?=$doubleID?>">
                                                        <div class="input-group">
                                                            <span class="success input-group-addon">Название</span>
                                                            <input id="<?=$arParams["IBLOCK"]?>-<?=$code?>-<?=$doubleID?>-NAME" value="<?=(isset($doubleValue["NAME"]))?$doubleValue["NAME"]:false?>" <?if(isset($field["REQUIRED"]) and $field["REQUIRED"] == "Y"){?>required="required"<?}?><?if(isset($field["DESCRIPTION"])){?> data-placement="left" data-trigger="focus" data-toggle="tooltip" data-original-title="<?=$field["DESCRIPTION"]?>"<?}?> class="form-control" type="text" name="SAVE[<?=$code?>][<?=$doubleID?>][NAME]">
                                                                    
                                                            <span class="success input-group-addon">Значение</span>
                                                            <input id="<?=$arParams["IBLOCK"]?>-<?=$code?>-<?=$doubleID?>-VALUE" value="<?=(isset($doubleValue["VALUE"]))?$doubleValue["VALUE"]:false?>" <?if(isset($field["REQUIRED"]) and $field["REQUIRED"] == "Y"){?>required="required"<?}?><?if(isset($field["DESCRIPTION"])){?> data-placement="left" data-trigger="focus" data-toggle="tooltip" data-original-title="<?=$field["DESCRIPTION"]?>"<?}?> class="form-control" type="text" name="SAVE[<?=$code?>][<?=$doubleID?>][VALUE]">
                                                            <div class="input-group-btn">
                                                                <a href="javascript:doubleFieldDelete(this, '<?=$code?>', <?=$doubleID?>);" class="btn btn-white"><span class="btn btn-danger btn-xs btn-icon btn-circle btn-xs"><i class="fa fa-times"></i></span></a>
                                                                <a href="javascript:doubleFieldAdd(this, '<?=$code?>', <?=$doubleID?>);" class="addFields btn btn-white"><span class="btn btn-xs btn-info btn-icon btn-circle btn-xs"><i class="fa fa-plus"></i></span></a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <?}?>
                                                    </div>
                                                <?
                                                break;
                                                case "TEXT":
                                                default:
                                                    ?>
                                                    <div class="input-group">
                                                    <input id="<?=$arParams["IBLOCK"]?>-<?=$code?>" value="<?=(isset($arElement[$code]))?$arElement[$code]:(isset($field["DEFAULT_VALUE"])?$field["DEFAULT_VALUE"]:false)?>" <?if(isset($field["REQUIRED"]) and $field["REQUIRED"] == "Y"){?>required="required"<?}?><?if(isset($field["DESCRIPTION"])){?> data-placement="left" data-trigger="focus" data-toggle="tooltip" data-original-title="<?=$field["DESCRIPTION"]?>"<?}?> class="form-control" type="text" name="SAVE[<?=$code?>]">
                                                    <span class="success input-group-addon"><?=$field["ICON"]?></span>
                                                    </div>
                                                    <?
                                            }?>
                                        </div>
                                    </div>
                                </div>
                                            <?
                                        }
                                        ?>
                            </div>
                            <?$count++;}?>
                            <div class="row">
                                <div class="col-xs-8 text-left">
                                    <button id="element-save" type="button" class="btn btn-success m-r-5"><i class="fa fa-floppy-o"></i> Сохранить</button>
                                    <button id="element-apply" type="button" class="btn btn-white m-r-5"><i class="fa fa-check"></i> Применить</button>
                                </div>
                                <div class="col-xs-4 text-right">
                                    <button id="element-save-add" type="button" class="btn btn-white m-r-5"><i class="fa fa-plus"></i> Сохранить и добавить</button>
                                </div>
                            </div>
                        </div>
                        </form>
                    </div>


<script>
function doubleFieldDelete(button, field, id){
    $('#doubleField-' + field + '-' + id).detach();
}
function doubleFieldAdd(button, field, id){
    var newID = (id + 1);
    var newField = '<div class="form-group" id="doubleField-' + field + '-' + newID + '">' +
'                    <div class="input-group">' +
'                        <span class="success input-group-addon">Название</span>' +
'                        <input id="products-' + field + '-' + newID + '-NAME" class="form-control" type="text" name="SAVE[' + field + '][' + newID + '][NAME]">' +
'                        <span class="success input-group-addon">Значение</span>' +
'                        <input id="products-' + field + '-' + newID + '-VALUE" class="form-control" type="text" name="SAVE[' + field + '][' + newID + '][VALUE]">' +
'                        <div class="input-group-btn">' +
'                           <a href="javascript:doubleFieldDelete(this, \'' + field + '\', ' + newID + ');" class="btn btn-white"><span class="btn btn-danger btn-xs btn-icon btn-circle btn-xs"><i class="fa fa-times"></i></span></a>' +
'                           <a href="javascript:doubleFieldAdd(this, \'' + field + '\', ' + newID + ');" class="addFields btn btn-white"><span class="btn btn-xs btn-info btn-icon btn-circle btn-xs"><i class="fa fa-plus"></i></span></a>' +
'                       </div>' +
'                   </div>' +
'                  </div>';
    $('#doubleFields-' + field).append( newField );
}


function multyImgFieldDelete(button, field, id){
    var imageID = $('#<?=$arParams["IBLOCK"]?>-' + field + '-' + id).val();
    $.post( "/MeteorRC/admin/ajax/image_ajax.php", { DELETE_FILE_ID: imageID, IBLOCK: '<?=$arParams["IBLOCK"]?>' })
        .done(function( data ) {
        $('#multyImgFields-' + field + '-' + id).detach();
    });
}
function multyImgFieldAdd(button, field, id){
    var newID = (id + 1);
    var newField = '<div class="form-group" id="multyImgFields-' + field + '-' + newID + '">' +
'        <div class="row">' +
'            <div class="col-sm-9">' +
'                <div class="image_add">' +
'                    <img class="img-thumbnail" src="<?=SITE_TEMPLATE_PATH?>images/noimage.png" width="50px">' +
'                    <input id="<?=$arParams["IBLOCK"]?>-' + field + '-' + newID + '" type="hidden" name="SAVE[' + field + '][' + newID + ']" value="">' +
'                    <span type="button" class="btn-input-file btn btn-white">' +
'                        <i class="fa fa-picture-o"></i> Выбрать изображение' +
'                        <input type="file" data-change="need" data-iblock="<?=$arParams["IBLOCK"]?>" data-id="" data-quality="70" data-max-width="1024" class="imageAdd">' +
'                    </span>' +
'                </div>' +
'            </div>' +
'            <div class="col-sm-3 text-right">' +
'                <a href="javascript:multyImgFieldDelete(this, \'' + field + '\', ' + newID + ');" class="btn btn-white"><span class="btn btn-danger btn-xs btn-icon btn-circle btn-xs"><i class="fa fa-times"></i></span></a>' +
'                <a href="javascript:multyImgFieldAdd(this, \'' + field + '\', ' + newID + ');" class="addFields btn btn-white"><span class="btn btn-xs btn-info btn-icon btn-circle btn-xs"><i class="fa fa-plus"></i></span></a>' +
'            </div>' +
'        </div>' +
'    </div>';
    $('#MultyImgFields-' + field).append( newField );
    OnchacgeImageFields();
}



function CKEupdate() {
  for ( instance in CKEDITOR.instances )
    CKEDITOR.instances[instance].updateElement();
}
(function() {
  
    var app = {
        initialize : function () {  
            this.form = 'form#form-<?=$arParams["IBLOCK"]?>';
            this.saveBtn = 'button#element-save';
            this.saveAddBtn = 'button#element-save-add';
            this.submitBtn = $(this.form).find('#element-apply');
            this.status = false;
            this.setEvents();
        },

        setEvents: function () {
            $(app.saveBtn).on('click', app.elementSave);
            $(app.saveAddBtn).on('click', app.elementSaveAdd);
            $(app.submitBtn).on('click', app.submitForm);
            //$(app.form).on('submit', app.submitForm);
            $(app.form).on('keydown', '.has-error', app.removeError);
        },
        elementSave: function() {
            app.submitForm();
            $( document ).ajaxComplete(function() {
                if (app.status === false) return false;
                window.location.replace('?component=<?=$arParams["COMPONENT"]?>&iblock=<?=$arParams["IBLOCK"]?>');
            });
        },
        elementSaveAdd: function() {
            app.submitForm();
            $( document ).ajaxComplete(function() {
                if (app.status === false) return false;
                window.location.replace('?component=<?=$arParams["COMPONENT"]?>&iblock=<?=$arParams["IBLOCK"]?>&edit_element');
            });

        },
        submitForm: function () {
            <?if(isset($ckeditor)){?>
            CKEupdate();
            <?}?>
            //e.preventDefault();
            if ( app.validateForm($(app.form)) === false ) return false;  

            app.submitBtn.attr({disabled: 'disabled'});

            $.ajax({
                type: "POST",
                url: $(app.form).attr("action"),
                data: $(app.form).serialize()                
            }).done(function(respond) {
                var isJson = true, msgHTML;
                try {
                    var arRespond = window.JSON.parse(respond);
                }catch (e) {
                    isJson = false 
                }
                if(isJson){
                    if(arRespond.ERROR) {
                        msgHTML = '<br><div class="alert alert-danger">' + arRespond.ERROR + '<span class="close" data-dismiss="alert">×</span></div>';
                        $(app.form).children('.result').html(msgHTML);
                        app.status = false;
                    }else{
                        msgHTML = '<br><div class="alert alert-success">' + arRespond.SUCCESS + '<span class="close" data-dismiss="alert">×</span></div>';
                        $(app.form).children('.result').html(msgHTML);
                        app.status = true;
                    }
                    if(arRespond.OLD_KEY) {
                        $('#<?=$arParams["IBLOCK"]?>-OLD_KEY').val(arRespond.OLD_KEY);
                    }
                }else if(!respond == 'OK'){
                  alert(respond);
                  success = false;
                }
            }).always(function(){
                app.submitBtn.removeAttr("disabled");
            })
            
        },

        validateForm: function (form){
            var inputs = form.find('input'),
                valid = true;
            
            //inputs.tooltip('destroy');

            $.each(inputs, function(index, val) {
                var input = $(val),
                    val = input.val(),
                    formGrout = input.parents('.input-group'),
                    textError = input.attr("data-error");
                if(input.attr("required") == "required"){
                    if(val.length === 0){
                        formGrout.addClass('has-error').removeClass('has-success'); 
                        input.tooltip({
                            trigger: 'manual',
                            placement: 'right',
                            title: textError
                        }).tooltip('show');     
                        valid = false;      
                    }else{

                        if(input.attr("type") == "email"){
                            formGrout.addClass('has-error').removeClass('has-success'); 
                            var pattern = new RegExp(/^(("[\w-\s]+")|([\w-]+(?:\.[\w-]+)*)|("[\w-\s]+")([\w-]+(?:\.[\w-]+)*))(@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$)|(@\[?((25[0-5]\.|2[0-4][0-9]\.|1[0-9]{2}\.|[0-9]{1,2}\.))((25[0-5]|2[0-4][0-9]|1[0-9]{2}|[0-9]{1,2})\.){2}(25[0-5]|2[0-4][0-9]|1[0-9]{2}|[0-9]{1,2})\]?$)/i);
                            if (!pattern.test(val)) {
                                input.tooltip({
                                    trigger: 'manual',
                                    placement: 'right',
                                    title: "Введите e-mail правильно"
                                }).tooltip('show');     
                                valid = false;  
                            }else{
                                formGrout.removeClass('has-error').addClass('has-success');
                                input.tooltip('hide');
                            }
                        }else{
                            formGrout.removeClass('has-error').addClass('has-success');
                            input.tooltip('hide');
                        }
                    }
                }
            });

            return valid;
            
        },

        removeError: function() {
            $(this).removeClass('has-error').find('input').tooltip('destroy');
        }
        
    }

    app.initialize();

}());

$(function () {
  $('[data-toggle="tooltip"]').tooltip()
})
</script>