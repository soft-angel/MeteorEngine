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
//$APPLICATION->AddHeadScript($templateFolder . "/element.js");
?>
<?if(isset($arResult)){?>
			    <div class="col-md-3 col-sm-6">
			        <div class="widget widget-stats bg-purple">
			            <div class="stats-icon stats-icon-lg"><i class="fa fa-shopping-cart fa-fw"></i></div>
			            <div class="stats-title">ЗАКАЗОВ</div>
			            <div class="stats-number"><?=number_format($arResult["COUNT"])?></div>
			            <div class="stats-progress progress">
                            <div class="progress-bar" style="width: <?=$arResult["PERCENT"]?>%;"></div>
                        </div>
                        <div class="stats-desc"><?=$arResult["PAY_CNT"]?> из <?=$arResult["COUNT"]?> заказов оплачены</div>
			        </div>
			    </div>
<?}?>