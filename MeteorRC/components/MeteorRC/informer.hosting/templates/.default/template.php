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
<div class="panel panel-inverse" id="meteor_hosting" data-sortable-id="hosting">
                        <div class="panel-heading">
                            <div class="panel-heading-btn">
                                <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-success" data-click="panel-expand"><i class="fa fa-expand"></i></a>
                                <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-warning" data-click="panel-collapse"><i class="fa fa-minus"></i></a>
                                <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-danger" data-click="panel-remove"><i class="fa fa-times"></i></a>
                            </div>
                            <h4 class="panel-title">Хостинг</h4>
                        </div>
                        <div class="panel-body">
<?
if($arResult){
$APPLICATION->AddHeadScript($templateFolder . "/script.js");
$APPLICATION->SetAdditionalCSS($templateFolder . "/style.css");
?>
							<p>
								<i class="fa fa-shopping-basket"></i> Баланс: <b <?if($arResult["PRICE_DAY"] < 14){?>style="color:red"<?}?>><?=$arResult["BALANS"]?round($arResult["BALANS"], 2):'?'?> <i class="fa fa-rub"></i></b>
								<span class="btn btn-xs btn-success" onclick="GoBalans(this)">Пополнить</span>
							</p>
							<div style="display: none;" id="pay">
							<form action="//hosting.soft-angel.ru/pay/" method="POST">
								Пополнить на сумму: <div>
								<div class="input-group">
									<input name="MONEY" class="pay_input form-control" type="text" value="<?=round($arResult["PRICE_YEAR"])?>">
									<span class="input-group-btn">
									<button type="submit" class="btn btn-success">Оплатить</button>
									</span>
								</div>
								<input name="DOMAIN" type="hidden" value="<?=$_SERVER['HTTP_HOST']?>">
								</div>
							</form>
							</div>
							<p><i class="fa fa-clock-o"></i> Осталось оплаченных дней: <b <?if($arResult["PRICE_DAY"] < 14){?>style="color:red"<?}?>><?=round(($arResult["PRICE_DAY"] <= 0)?0:$arResult["PRICE_DAY"])?></b></p>
							<p><i class="fa fa-calendar"></i> Цена в месяц (31 день): <b><?=$arResult["MONEY"]?> <i class="fa fa-rub"></i></b></p>
							<p><i class="fa fa-calendar-check-o"></i> Цена в год (<?=decl(round(date('L')?366:365), array('день', 'дня', 'дней'))?>): <b><?=round($arResult["PRICE_YEAR"], 2)?> <i class="fa fa-rub"></i></b></p>
							<p><i class="fa fa-hdd-o"></i> Использовано/квота: <b><?=$arResult["DRIVE"]?ConvertFileSize(($arResult["DRIVE"] + $arResult["MYSQL"]["SIZE"]), 2):"?"?>/<?=ConvertFileSize($arResult["DRIVE_LIMIT"], 0)?></b></p>
							<?if($arResult["DOMAIN"] == 'Y'){?>
                        	<p>Домен: <?=$_SERVER['SERVER_NAME']?> Тиц: <?=$arResult["TIC"]?></p>
                        	<p>Продлен до: <?=$arResult["WHIOS"]["PAID_TILL"]?></p>
                        	<?}?>

<?}else{?>
	                        <div class="text-center ">
	                        	<img width="80px" src="<?=$templateFolder?>/images/logo.svg">
	                        </div>
	                        <div style="margin-top:10px" class="note note-danger">Обращаем внимание, что система работает на стороннем хостинге. Мы настоятельно рекомендуем переехать на специализированный для CSM MeteorEngine хостинг. <br>Обратитесь: <a href="mailto:hello@soft-angel.ru">hello@soft-angel.ru</a>
	                        <br>
	                        <b>Стоимость 80р за 31 день.</b><br>
	                        После чего Вам будет доступна мини панель управления хостингом и пополнение баланса прямо тут!
	                        </div>
	                        
<?}?>
                        </div>
                    </div>
                </div>