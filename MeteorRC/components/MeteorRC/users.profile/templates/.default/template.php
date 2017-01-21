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
//$APPLICATION->AddHeadScript($templateFolder . "/script.js");
?>
<?if(isset($arResult) and $USER->IsAuthorized()){?>
<form id="form-<?=$arParams["IBLOCK"]?>" action="<?=$componentPath?>/save_ajax.php" enctype="multipart/form-data" method="post">
	<div class="result"></div>
	<input type="hidden" name="PARAMS[IBLOCK]" value="users">
	<input type="hidden" name="PARAMS[COMPONENT]" value="users">
	<input type="hidden" name="PARAMS[TYPE]" value="SAVE">
	<input type="hidden" name="PARAMS[OLD_KEY]" value="<?=(isset($arResult["ID"]))?$arResult["ID"]:$USER->GetID()?>">
	<div class="block-white-wrap">
		<div class="block-white-inner">
			<div class="row">
<?foreach ($arParams["FIELDS"] as $code => $arField) {
	if(isset($arField["USER_EDIT"]) and $arField["USER_EDIT"] = "Y"){?>
	<input id="<?=$arParams["IBLOCK"]?>-<?=$code?>" value="<?=(isset($arResult[$code]))?$arResult[$code]:isset($arField["DEFAULT_VALUE"])?$arField["DEFAULT_VALUE"]:false?>" type="hidden" name="SAVE[<?=$code?>]">
	<?continue;
	}
	if($arField["TYPE"] != "HIDDEN"){?>
				<div class="col-md-4 control-label">
					<?=$arField["NAME"]?>
					<?if(isset($arField["REQUIRED"]) and $arField["REQUIRED"] == "Y"){?>
					<i class="text-danger">*</i>
					<?}?>
				</div>
		<?}?>
			<div class="col-md-8">
				<div class="form-group">
					<div class="input-group">
                                    <?
                                        switch($arField["TYPE"])
                                            {
                                                case "SELECT":?>
                                                 <?CJSCore::Init(array('select'));?>
                                                    <select id="<?=$arParams["IBLOCK"]?>-<?=$code?>" <?if(isset($arField["REQUIRED"]) and $arField["REQUIRED"] == "Y"){?>required="required"<?}?> class="form-control" name="SAVE[<?=$code?>]">
                                                            <?foreach ($arField["SELECT"] as $value => $option){?>
                                                            <option <?if(isset($arResult[$code]) and $arResult[$code] == $value){?>selected="selected" <?}?>value="<?=$value?>"><?=$option?></option>
                                                            <?}?>
                                                    </select>
                                                    <span class="input-group-addon"><?=$arField["ICON"]?></span>
                                                    <?
                                                    break;
                                                case "SELECT_BD":
                                                    CJSCore::Init(array('select'));
                                                    $component = (isset($arField["COMPONENT_BD"]))?$arField["COMPONENT_BD"]:$arParams["COMPONENT"];
                                                    $select_bd = $APPLICATION->GetFileArray(FOLDER_BD . $component . DS . $arField["BD"] . SFX_BD);
                                                    ?>
                                                        <select <?if(isset($arField["MULTI"])){?>multiple<?}?> id="<?=$arParams["IBLOCK"]?>-<?=$code?>" <?if(isset($arField["REQUIRED"]) and $arField["REQUIRED"] == "Y"){?>required="required"<?}?><?if(isset($arField["DESCRIPTION"])){?> data-placement="left" data-toggle="tooltip" data-original-title="<?=$arField["DESCRIPTION"]?>"<?}?> class="form-control" name="SAVE[<?=$code?>]<?if(isset($arField["MULTI"])){?>[]<?}?>">
                                                            <option <?if(!isset($arResult[$code])){?>selected="selected" <?}?>value="">Не выбрано</option>
                                                            <?foreach ($select_bd as $id => $option){?>
                                                            <?if(!isset($arField["MULTI"])){?>
                                                            <option <?if(isset($arResult[$code]) and $arResult[$code] == $id){?>selected="selected" <?}?>value="<?=$id?>"><?=$option["NAME"]?></option>
                                                            <?}else{?>
                                                            <option <?if(isset($arResult[$code]) and in_array($id, $arResult[$code])){?>selected="selected" <?}?>value="<?=$id?>"><?=$option["NAME"]?></option>
                                                            <?}?>
                                                            <?}?>
                                                        </select>
                                                        <span class="input-group-addon"><?=$arField["ICON"]?></span>
                                                    <?
                                                    break;
                                                case "DATE_TIME":
                                                    ?>
                                                    <?CJSCore::Init(array('datetimepicker'));?>
                                                    <input id="<?=$arParams["IBLOCK"]?>-<?=$code?>" value="<?=(isset($arResult[$code]))?$arResult[$code]:date('Y-m-d H:i:s')?>" <?if(isset($arField["REQUIRED"]) and $arField["REQUIRED"] == "Y"){?>required="required"<?}?><?if(isset($arField["DESCRIPTION"])){?> data-placement="left" data-trigger="focus" data-toggle="tooltip" data-original-title="<?=$arField["DESCRIPTION"]?>"<?}?> class="form-control" type="text" name="SAVE[<?=$code?>]">
                                                    <span class="success input-group-addon"><?=$arField["ICON"]?></span>
                                                    <script type="text/javascript">
                                                        $(function () {
                                                            $('#<?=$arParams["IBLOCK"]?>-<?=$code?>').datetimepicker({locale: 'ru', format: 'L LTS'});
                                                        });
                                                    </script>
                                                    <?
                                                    break;
                                                case "TIME":
                                                    ?>
                                                    <input id="<?=$arParams["IBLOCK"]?>-<?=$code?>" value="<?=(isset($arResult[$code]))?$arResult[$code]:time()?>" <?if(isset($arField["REQUIRED"]) and $arField["REQUIRED"] == "Y"){?>required="required"<?}?><?if(isset($arField["DESCRIPTION"])){?> data-placement="left" data-trigger="focus" data-toggle="tooltip" data-original-title="<?=$arField["DESCRIPTION"]?>"<?}?> class="form-control" type="text" name="SAVE[<?=$code?>]">
                                                    <span class="success input-group-addon"><?=$arField["ICON"]?></span>
                                                    <?
                                                    break;
                                                case "IMAGE":
                                                    ?>
                                                    <div class="image_add">
                                                        <img class="img-thumbnail" src="<?=(!isset($_GET['clone_element']) and isset($arResult[$code]))?$FILE->GetUrlFile($arResult[$code], $arParams["IBLOCK"]):SITE_TEMPLATE_PATH . "images/noimage.png"?>" width="<?=$arParams["IMAGE_WIDTH"]?>">
                                                        <input id="<?=$arParams["IBLOCK"]?>-<?=$code?>" type="hidden" name="SAVE[<?=$code?>]" value="<?=(isset($arResult[$code]))?$arResult[$code]:false?>">
                                                        <span type="button" class="btn-input-file btn btn-danger">
                                                            <?=$arField["ICON"]?> Выбрать изображение
                                                            <input type="file" data-component="<?=$arParams["IBLOCK"]?>" data-id="<?=(!isset($_GET['clone_element']) and isset($arResult[$code]))?$arResult[$code]:false?>" data-quality="<?=$arField["QUALITY"]?>" data-max-width="<?=$arField["MAX_WIDTH"]?>" class="imageAdd">
                                                        </span>
                                                    </div>
                                                    <?$APPLICATION->AddHeadScript("/MeteorRC/js/plugins/ImageAdd/ImageAdd.js");?>
                                                    <?
                                                    break;
                                                case "TEXTAREA":
                                                    ?>
                                                        <textarea id="<?=$arParams["IBLOCK"]?>-<?=$code?>" <?if(isset($arField["REQUIRED"]) and $arField["REQUIRED"] == "Y"){?>required="required"<?}?><?if(isset($arField["DESCRIPTION"])){?> data-placement="left" data-trigger="focus" data-toggle="tooltip" data-original-title="<?=$arField["DESCRIPTION"]?>"<?}?> class="form-control" name="SAVE[<?=$code?>]"><?=(isset($arResult[$code]))?$arResult[$code]:false?></textarea>
                                                        <span class="input-group-addon"><?=$arField["ICON"]?></span>
                                                    <?
                                                    break;
                                                case "HIDDEN":
                                                    ?>
                                                    <input id="<?=$arParams["IBLOCK"]?>-<?=$code?>" value="<?=$arResult[$code]?$arResult[$code]:$arField["DEFAULT_VALUE"]?>" type="hidden" name="SAVE[<?=$code?>]">
                                                    <?
                                                    break;
                                                case "DISABLED":
                                                    ?>
                                                    <input id="<?=$arParams["IBLOCK"]?>-<?=$code?>" value="<?=isset($arResult[$code])?$arResult[$code]:(isset($arField["DEFAULT_VALUE"])?$arField["DEFAULT_VALUE"]:false)?>" class="form-control" type="text" disabled name="SAVE[<?=$code?>]">
                                                    <span class="success input-group-addon"><?=$arField["ICON"]?></span>
                                                    <?
                                                    break;
                                                case "PHONE":
                                                    ?>
                                                    <?CJSCore::Init(array('maskedinput'));?>
                                                     <input data-plugin="maskedinput" id="<?=$arParams["IBLOCK"]?>-<?=$code?>" value="<?=(isset($arResult[$code]))?$arResult[$code]:false?>" <?if(isset($arField["REQUIRED"]) and $arField["REQUIRED"] == "Y"){?>required="required"<?}?><?if(isset($arField["DESCRIPTION"])){?> data-placement="left" data-trigger="focus" data-toggle="tooltip" data-original-title="<?=$arField["DESCRIPTION"]?>"<?}?> class="form-control" type="tel" name="SAVE[<?=$code?>]">
                                                    <span class="success input-group-addon"><?=$arField["ICON"]?></span>
                                                    <?
                                                    break;
                                                case "PASSWORD":
                                                    ?>
                                                    <input autocomplete="off" id="<?=$arParams["IBLOCK"]?>-<?=$code?>" value="<?=(isset($arResult[$code]))?"******":false?>" <?if(isset($arField["REQUIRED"]) and $arField["REQUIRED"] == "Y"){?>required="required"<?}?><?if(isset($arField["DESCRIPTION"])){?> data-placement="left" data-trigger="focus" data-toggle="tooltip" data-original-title="<?=$arField["DESCRIPTION"]?>"<?}?> class="form-control" type="password" name="SAVE[<?=$code?>]">
                                                    <span class="success input-group-addon"><?=$arField["ICON"]?></span>
                                                    <?
                                                    break;
                                                case "TEXT":
                                                default:
                                                    ?>
                                                    <input id="<?=$arParams["IBLOCK"]?>-<?=$code?>" value="<?=(isset($arResult[$code]))?$arResult[$code]:(isset($arField["DEFAULT_VALUE"])?$arField["DEFAULT_VALUE"]:false)?>" <?if(isset($arField["REQUIRED"]) and $arField["REQUIRED"] == "Y"){?>required="required"<?}?><?if(isset($arField["DESCRIPTION"])){?> data-placement="left" data-trigger="focus" data-toggle="tooltip" data-original-title="<?=$arField["DESCRIPTION"]?>"<?}?> class="form-control" type="text" name="SAVE[<?=$code?>]">
                                                    <span class="success input-group-addon"><?=$arField["ICON"]?></span>
                                                    <?
                                            }?>
					</div>
				</div>
			</div>
<?}?>
		</div>
		<div class="row text-center">
			<button id="profile-save" type="button" class="btn btn-success m-r-5"><i class="fa fa-floppy-o"></i> Сохранить</button>
		</div>
	</div>
</div>
<input type="hidden" value="<?=$USER->GetID()?>" name="SAVE[OLD_KEY]">
</form>


<script type="text/javascript">
(function() {
  
    var app = {
        initialize : function () {  
            this.form = 'form#form-<?=$arParams["IBLOCK"]?>';
            this.submitBtn = $(this.form).find('#profile-save');
            this.status = false;
            this.setEvents();
        },

        setEvents: function () {
            $(app.submitBtn).on('click', app.submitForm);
            //$(app.form).on('submit', app.submitForm);
            $(app.form).on('keydown', '.has-error', app.removeError);
        },
        submitForm: function () {
            if ( app.validateForm($(app.form)) === false ) return false;  

            app.submitBtn.attr({disabled: 'disabled'});

            $.ajax({
                type: "POST",
                url: $(app.form).attr("action"),
                data: $(app.form).serialize()                
            }).done(function(respond) {
                var arRespond = JSON.parse(respond);
                if(arRespond.ERROR) {
                    result = '<br><div class="alert alert-danger">' + arRespond.ERROR + '<span class="close" data-dismiss="alert">×</span></div>';
                    $(app.form).children('.result').html(result);
                    app.status = false;
                } else {
                    result = '<br><div class="alert alert-success">' + arRespond.SUCCESS + '<span class="close" data-dismiss="alert">×</span></div>';
                    $(app.form).children('.result').html(result);
                    app.status = true;
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

<?}else{?>
<div class="alert alert-danger" role="alert">
Для редактирования профиля Вам необходимо авторизоваться.
</div>
<?}?>