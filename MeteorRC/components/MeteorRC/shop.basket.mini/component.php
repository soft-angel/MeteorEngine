<?if(!defined("PROLOG_INCLUDED") || PROLOG_INCLUDED!==true) die();?>
<?
global $FIREWALL;
if(!isset($arParams["FILTER"]))
	$arParams["FILTER"] = false;
// Получаем параметры компонента заказов
$arParamsComponent = $APPLICATION->GetFileArray(__DIR__ . "/.parametrs.php");
$arParams["FILTER"] = false;
$arResult["ELEMENTS"] = $APPLICATION->GetElementForField($arParams["COMPONENT"], $arParams["IBLOCK"], $arParams["FILTER"], false);
	
// Удаление из корзины
if($delProduct = $FIREWALL->GetNumber("DELETE")){
	unset($_SESSION["ORDERS"]["PRODUCTS"][$delProduct]);
	unset($_SESSION["ORDERS"]["QUANTITY"][$delProduct]);
	unset($_SESSION["ORDERS"]["PROPS"][$delProduct]);
}

if(isset($_SESSION["ORDERS"]["PRODUCTS"]))
	foreach ($_SESSION["ORDERS"]["PRODUCTS"] as $basketID => $productID) {
		$arResult["ELEMENTS"][$productID]["ID"] = $productID;
		$arOrders[$basketID]["ELEMENT"] = $arResult["ELEMENTS"][$productID];
		// Обрабатываем доп поля влияющие на цену
		if(isset($_SESSION["ORDERS"]["PROPS"][$basketID]) and is_array($_SESSION["ORDERS"]["PROPS"][$basketID]))
			foreach ($_SESSION["ORDERS"]["PROPS"][$basketID] as $code => $value) {
				if(is_numeric($value)){
					$arOrders[$basketID]["ELEMENT"]["PROPS"][] = $arResult["ELEMENTS"][$productID][$code][$value]["NAME"];
					$arOrders[$basketID]["ELEMENT"]["PRICE"] = ($arResult["ELEMENTS"][$productID]["PRICE"] + $arResult["ELEMENTS"][$productID][$code][$value]["VALUE"]);
				}else{
					$arOrders[$basketID]["ELEMENT"]["PROPS"][] = $value;
				}
			}
		
		$arOrders[$basketID]["ORDER"] = $_SESSION["ORDERS"];
	}
	//p($arOrders);
?>