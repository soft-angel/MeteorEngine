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
?>
<div id="component_<?=$APPLICATION->GetComponentId()?>">
<?
if(isset($arResult["ELEMENTS"]) and count($arResult["ELEMENTS"]) > 0){
?>

<?CJSCore::Init(array('fancybox'));?>
<?foreach($arResult["ELEMENTS"] as $key => $arElement){?>
    <div class="well">
    <p>
        <i class="fa fa-user" aria-hidden="true"></i> <b><?=$arElement['NAME']?></b>, 
        <i class="fa fa-clock-o" aria-hidden="true"></i> <?=$arElement['DATE']?>
        <span class="pull-right">
        <?$i = 0;while($i < round($arElement['RATING'])){$i++;?><i class="fa fa-star" aria-hidden="true"></i> <?}?>
        <?$i2 = 0;while($i2 < 5-$i){$i2++;?><i class="fa fa-star-o" aria-hidden="true"></i> <?}?></p>
        </span>
        <?if(isset($arElement["PICTURE"])){?>
        <a class="fancybox" href="<?=$FILE->GetUrlFile($arElement["PICTURE"], $arParams["IBLOCK"])?>" data-fancybox-group="gallery" title="<?=$arElement["NAME"]?>"><img style="margin-right:10px" class="img-thumbnail pull-left" src="/MeteorRC/main/plugins/phpthumb/phpThumb.php?src=<?=$FILE->GetUrlFile($arElement["PICTURE"], $arParams["IBLOCK"])?>&amp;w=100&amp;h=100&amp;zc=1&amp;q=75" class="img-responsive"/></a>
        <?}?>
        <p><?=$arElement['TEXT']?></p>
    
    </div>
<?}?>
<?}?>

<form action="<?=$_SERVER['PHP_SELF']?>" method="POST">
    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <div class="input-group">
                    <input placeholder="Ваше имя" value="" required="required" class="form-control" type="text" name="REVIEWS[NAME]">
                    <span class="input-group-addon"><i class="fa fa-user"></i></span>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <div class="input-group">
                    <select id="reviews-RATING" class="form-control" name="REVIEWS[RATING]">
                        <option value="1">1</option>
                        <option value="2">2</option>
                        <option value="3">3</option>
                        <option value="4">4</option>
                        <option selected="selected" value="5">5</option>
                    </select>
                    <span class="input-group-addon"><i class="fa fa-star"></i></span>
                </div>
            </div>
        </div>
    </div>
    <div class="form-group">
        <div class="input-group">
            <textarea name="REVIEWS[TEXT]" placeholder="Текст отзыва" class="form-control"></textarea>
            <span class="input-group-addon"><i class="fa fa-comment-o"></i></span>
        </div>
    </div>
    <div class="text-center">
        <button type="submit" class="btn btn-success"><i class="fa fa-paper-plane" aria-hidden="true"></i> Отпрваить отзыв</button>
    </div>
</form>
<script type="text/javascript">
$(function() { 
    $('.fancybox').fancybox();
});
</script>
</div>