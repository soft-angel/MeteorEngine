<?if(!defined("PROLOG_INCLUDED") || PROLOG_INCLUDED!==true) die();
/** @var array $arParams */
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
<?
$arOrders = $APPLICATION->GetElementForField($arParams["COMPONENT"], $arParams["IBLOCK"], false, false);
$arResult["PAY_CNT"] = 0;
foreach ($arOrders as $id => $arOrder) {
	if(isset($arOrder["STATUS"]) and $arOrder["STATUS"] == "PAY"){
		$arResult["PAY_CNT"]++;
	}
}

$arResult["COUNT"] = count($arOrders);
if($arResult["COUNT"] > 0)
	$arResult["PERCENT"] = (($arResult["PAY_CNT"] / $arResult["COUNT"]) * 100);
unset($arOrders)
?>
