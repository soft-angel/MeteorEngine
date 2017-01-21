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
$APPLICATION->AddHeadScript($templateFolder . "/script.js");
?>
<div id="component_<?=$APPLICATION->GetComponentId()?>">
<form id="formSendReviews" action="<?=$_SERVER['PHP_SELF']?>" method="POST">
    <div class="result"></div>
    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <div class="input-group">
                    <input placeholder="Ваше имя" value="" class="form-control required" type="text" name="REVIEWS[NAME]">
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
            <textarea name="REVIEWS[TEXT]" placeholder="Текст отзыва" class="form-control required"></textarea>
            <span class="input-group-addon"><i class="fa fa-comment-o"></i></span>
        </div>
    </div>
    <div class="text-center">
        <button type="submit" class="btn btn-success"><i class="fa fa-paper-plane" aria-hidden="true"></i> Отпрваить отзыв</button>
    </div>
</form>

<?
if(isset($arResult["ELEMENTS"]) and count($arResult["ELEMENTS"]) > 0){
?>

<?CJSCore::Init(array('fancybox'));?>


  <ul style="margin-top:30px;" class="list-group">
  <?foreach($arResult["ELEMENTS"] as $key => $arElement){?>
    <li class="list-group-item">
        <span class="badge"><i class="fa fa-clock-o" aria-hidden="true"></i> <?=$arElement['DATE']?>
            <b>
            <?$i = 0;while($i < round($arElement['RATING'])){$i++;?><i class="fa fa-star" aria-hidden="true"></i> <?}?>
            <?$i2 = 0;while($i2 < 5-$i){$i2++;?><i class="fa fa-star-o" aria-hidden="true"></i> <?}?>
            </b>
        </span>
        <h5 class="list-group-item-heading"><i class="fa fa-user" aria-hidden="true"></i> <?=$arElement['NAME']?></h5>
        <?if(isset($arElement["PICTURE"])){?>
        <a class="fancybox" href="<?=$FILE->GetUrlFile($arElement["PICTURE"], $arParams["IBLOCK"])?>" data-fancybox-group="gallery" title="<?=$arElement["NAME"]?>"><img style="margin-right:10px" class="img-thumbnail pull-left" src="/MeteorRC/main/plugins/phpthumb/phpThumb.php?src=<?=$FILE->GetUrlFile($arElement["PICTURE"], $arParams["IBLOCK"])?>&amp;w=100&amp;h=100&amp;zc=1&amp;q=75" class="img-responsive"/></a>
        <?}?>
        <div><?=$arElement['TEXT']?></div>

    </li>
    <?}?>
  </ul>

<?}?>


<script type="text/javascript">
$(function() { 
    $('.fancybox').fancybox();
});
</script>
</div>