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
//p($arResult['FIELDS']);
?>
<?CJSCore::Init(array('bootstrap-slider'));?>
<div id="component_<?=$APPLICATION->GetComponentId()?>">

<form action="" method="GET">
    <?foreach ($arResult['FIELDS'] as $field => $value) {?>
    <p><?=$value['NAME']?>:</p>
    <?    switch ($value['TYPE']) {
            case 'PRICE':
            case 'INT':
                ?>
    <div class="form-group">
            <input class="hidden" id="<?=$arParams['FILTER_NAME']?>-<?=$field?>" type="text" value="" data-slider-min="<?=$value['VALUE_MIN']?>" data-slider-max="<?=$value['VALUE_MAX']?>" data-slider-step="5" data-slider-value="[<?=$value['SET_VALUE_MIN']?>,<?=$value['SET_VALUE_MAX']?>]"/>
    </div>
    <div class="form-group">
        <div class="input-group">

            <input id="<?=$arParams['FILTER_NAME']?>-<?=$field?>-min" placeholder="от" value="<?=$value['SET_VALUE_MIN']?>" class="form-control" type="text" name="<?=$arParams['FILTER_NAME']?>[><?=$field?>]">
            <span class="input-group-addon"><?=$value['ICON']?></span>
            <input id="<?=$arParams['FILTER_NAME']?>-<?=$field?>-max" placeholder="до" value="<?=$value['SET_VALUE_MAX']?>" class="form-control" type="text" name="<?=$arParams['FILTER_NAME']?>[<<?=$field?>]">
        </div>
    </div>
    <script type="text/javascript">
    $(function() {
        var slider = new Slider('#<?=$arParams['FILTER_NAME']?>-<?=$field?>', {});
        slider.on('slide', function(value){
            var arPriceValue = String(value).split(",");
            $('#<?=$arParams['FILTER_NAME']?>-<?=$field?>-min').val(arPriceValue[0]);
            $('#<?=$arParams['FILTER_NAME']?>-<?=$field?>-max').val(arPriceValue[1]);
        });
    });
    </script>
                <?
                break;
            
            default:
                ?>
                <hr size="1"></hr>
    <div class="form-group">
        <div class="input-group">
            <input value="" class="form-control" type="text" name="<?=$arParams['FILTER_NAME']?>[<?=$field?>]>
            <span class="input-group-addon"><?=$value['ICON']?></span>
        </div>
    </div>
                <?
                break;
        }
        ?>

    <?} ?>
    <div class="text-center">
        <div class="btn-group" role="group" aria-label="...">
            <button type="submit" name="filter_clear" value="Y" class="btn btn-default">Сбросить</button>
            <button type="submit" name="filter_clear" value="N" class="btn btn-theme-reverce"><i class="fa fa-filter" aria-hidden="true"></i> Фильтровать</button>
        </div>
    </div>
</form>
</div>
