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
<?if(isset($arElement)){?>
				<div class="title-bg">
					<div class="title">Заказ №<?=$arElement["ID"]?></div>
				</div>
				<div class="block-white-wrap">
					<div class="block-white-inner">
<?
foreach($arParamsComponent["FIELDS"] as $code => $arField){
	if(isset($arElement[$code])){?>
	<p><?=$arField["NAME"]?>: 
<?
		switch($arField["TYPE"])
                                                {
                                                case "SELECT":
                                                    echo $arField["SELECT"][$arElement[$code]];
                                                    break;
                                                case "SELECT_BD":
                                                    $component = (isset($arField["COMPONENT_BD"]))?$arField["COMPONENT_BD"]:$arParams["COMPONENT"];
                                                    $select_bd = $APPLICATION->GetFileArray(FOLDER_BD . $component . DS . $arField["BD"] . SFX_BD);
                                                    ?>
                                                    <?=(isset($arElement[$code]))?$select_bd[$arElement[$code]]["NAME"]:false?>
                                                    <?
                                                    break;
                                                case "PRICE":
                                                    echo $APPLICATION->PriceFormat($arElement[$code]) . ' <i class="fa fa-rub"></i>';
                                                    break;
                                                case "IMAGE":
                                                    ?>
                                                    <img class="img-thumbnail" width="<?=$arParams["IMAGE_WIDTH"]?>" src="<?=(isset($arElement[$code]))?$FILE->GetUrlFile($arElement[$code], $arParams["IBLOCK"]):SITE_TEMPLATE_PATH . "images/noimage.png"?>">
                                                    <?
                                                    break;
                                                case "PRODUCT_TABLE":
                                                    $component = (isset($arField["COMPONENT_BD"]))?$arField["COMPONENT_BD"]:$arParams["COMPONENT"];
                                                    $products = $APPLICATION->GetFileArray(FOLDER_BD . $component . DS . $arField["BD"] . SFX_BD);
                                                    ?>
                                                    <table class="table table-striped">
                                                        <thead>
                                                            <tr>
                                                                <th>#</th>
                                                                <th>Название</th>
                                                                <th>Цена</th>
                                                                <?foreach ($arField["COMBINATE"] as $fieldComb => $comb) {?>
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
                                                                    <?=$products[$id]["NAME"]?>
                                                                </td>
                                                                <td><?=$APPLICATION->PriceFormat($products[$id]["PRICE"])?> <small class="fa fa-rub"></small></td>
                                                                <?foreach ($arField["COMBINATE"] as $fieldComb) {?>
                                                                <td><?=(string)$arElement[$fieldComb][$id]?></td>
                                                                <?}?>
                                                            </tr>
                                                    <?}?>

                                                        </tbody>
                                                    </table>
                                                    <h4 class="text-right">
                                                        <span class="label label-info">Итого: <?=$APPLICATION->PriceFormat($priceFull)?> <i class="fa fa-rub"></i></span>
                                                    </h4>
                                                    <?
                                                    break;
                                                case "TEXT":
                                                default:
                                                    echo (isset($arElement[$code]))?$arElement[$code]:false;
                                                }?>
</p>
<?}
}
?>
	</div>
</div>
<?}?>