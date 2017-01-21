<?if(!defined("PROLOG_INCLUDED") || PROLOG_INCLUDED!==true) die();?>
<?
global $FIREWALL;
global $FILE;
if(!isset($arParams["FILTER"]))
	$arParams["FILTER"] = false;
// Получаем параметры компонента заказов
//$arParamsComponent = $APPLICATION->GetComponentsParams("shop", "basket");
//p($arParamsComponent);
// Добавление заказа
function ShopOrderAdd($arFields){
	global $APPLICATION;
	global $USER;
	global $arParams;
	$json["message"] = "<p>Ваш заказ успешно создан и в ближайшее время будет обработан</p>";
	$arParamsComponent = $APPLICATION->GetComponentsParams("shop", "basket");
	$APPLICATION->RestartBuffer();
	if(!isset($_SESSION["ORDERS"]["PRODUCTS"])){
		$json = array(
			"respond" => "ERROR",
			"message" => 'Нет товаров в корзине',
		);
		die(json_encode($json));
	}
	$bd_file = FOLDER_BD . $arParamsComponent["COMPONENT"] . DS . $arParamsComponent["IBLOCK"] . SFX_BD;
	$arOrders = $APPLICATION->GetFileArray($bd_file);
	// Формируем массив для добавления
	$arOrder = array(
		"PRODUCTS" => $_SESSION["ORDERS"]["PRODUCTS"],
		"QUANTITY" => $_SESSION["ORDERS"]["QUANTITY"],
		"PROPS" => $_SESSION["ORDERS"]["PROPS"],
		"USER_ID" => $USER->GetID(),
		"DATE" => date('d.m.Y H:i:s'),
		"STATUS" => "CREATED",
		"ID" => (!empty($arOrders))?(max(array_keys($arOrders)) + 1):1,
		"PAY_SYSTEM_ID" => (int)$arFields["PAY_SYSTEM_ID"],
		"DELIVERY_SYSTEM_ID" => (int)$arFields["DELIVERY_SYSTEM_ID"],
		"TIME" => time(),
	);

	if(isset($arFields["DELIVERY_SYSTEM_ID"])){
		$arDelivery = $APPLICATION->GetElementForID("shop", "delivery", $arOrder["DELIVERY_SYSTEM_ID"]);
		$arOrder["DELIVERY_NAME"] = $arDelivery["NAME"];
	}
	if(isset($arOrder["PAY_SYSTEM_ID"])){
		$arPayment = $APPLICATION->GetElementForID("shop", "payment", $arOrder["PAY_SYSTEM_ID"]);
		$arOrder["PAY_NAME"] = $arPayment["NAME"];
		if(isset($arPayment["LOGO"])){
			$FILE = new FILE;
			$json["message"] .= '<img width="100px" src="' . $FILE->GetUrlFile($arPayment["LOGO"], "payment") . '">';
		}
		if(isset($arPayment["FILE"])){
				$json["message"] .= '<a style="margin-left: 15px;" target="_blank" class="btn btn-lg btn-success" href="/MeteorRC/components/MeteorRC/shop.payment/payments/' . $arPayment["FILE"] . '?ORDER=' . $arOrder["ID"] . '">Оплатить</a>';
		}
	}

	$arOrders[$arOrder["ID"]] = array_merge($arOrder, $arFields);
	// Сохраняем заказы
	$save = $APPLICATION->ArrayWriter($arOrders, $bd_file);
	// Генерируем фассеты заказов
	$APPLICATION->FassetGenerate($arParamsComponent["COMPONENT"], $arParamsComponent["IBLOCK"], $arOrders, $arParamsComponent["FIELDS"]);
	unset($_SESSION["ORDERS"]);
	$CEvent = new CEvent;
	//p($arOrders[$arOrder["ID"]]);

	$json["respond"] = "OK";
	
	if(!$CEvent->Send("NEW_ORDER", $arOrders[$arOrder["ID"]])){
		$json["respond"] = "WARNING";
		$json["message"] .= '<p>Сообщение не отправлено! Вы можете ускорить обработку заказа позвонив нам или написав на электронную почту</p>';
	}
	die(json_encode($json));
}

if($arPostOrder = $FIREWALL->GetArrayString("ORDER")){
	ShopOrderAdd($arPostOrder);
}

// Функция добавления в корзину
function AddBasketByProductID($COMPONENT, $IBLOCK, $PRODUCT_ID, $QUANTITY = 1, $PRODUCT_URL, $arProductParams = array()){
	$unicID = $PRODUCT_ID . arrayToUnicID($arProductParams);
	if(isset($_SESSION["ORDERS"]["PRODUCTS"]))
		foreach ($_SESSION["ORDERS"]["PRODUCTS"] as $product) {
			if(isset($_SESSION["ORDERS"]["PRODUCTS"][$unicID])){
				$_SESSION["ORDERS"]["QUANTITY"][$unicID] = (isset($_SESSION["ORDERS"]["QUANTITY"][$unicID]))?($_SESSION["ORDERS"]["QUANTITY"][$unicID] + 1):1;
				return;
			}
		}

	// Формируем массив для добавления
	$_SESSION["ORDERS"]["PRODUCTS"][$unicID] = (int) $PRODUCT_ID;
	$_SESSION["ORDERS"]["QUANTITY"][$unicID] = (int) $QUANTITY;
	if($PRODUCT_URL)
		$_SESSION["ORDERS"]["URLS"][$unicID] = (string) $PRODUCT_URL;
	$_SESSION["ORDERS"]["PROPS"][$unicID] =  $arProductParams;
	$_SESSION["ORDERS"]["DATE"] = date('d.m.Y H:i:s');
	$_SESSION["ORDERS"]["STATUS"] = "BASKET";
}

if($arPostAdd = $FIREWALL->GetArrayString("BASKET")){
	AddBasketByProductID($arParams["COMPONENT"], $arParams["IBLOCK"], $arPostAdd["PRODUCT_ID"], $arPostAdd["QUANTITY"], (isset($arPostAdd["PRODUCT_URL"]))?$arPostAdd["PRODUCT_URL"]:null, (isset($arPostAdd["PROPS"]))?$arPostAdd["PROPS"]:array());
	$arResult["MESSAGE"][] = '<i class="fa fa-cart-plus"></i> Товар успешно добавлен';
}
// Получаем список элментов
$arResult["ELEMENTS"] = $APPLICATION->GetElementForField($arParams["COMPONENT"], $arParams["IBLOCK"], $arParams["FILTER"], false);


$arResult["TOTAL_PRICE"] = 0;
if(isset($_SESSION["ORDERS"]["PRODUCTS"]))
	foreach ($_SESSION["ORDERS"]["PRODUCTS"] as $basketID => $productID) {
		$arResult["ELEMENTS"][$productID]["ID"] = $productID;
		$arOrders[$basketID]["ELEMENT"] = $arResult["ELEMENTS"][$productID];
		// Обрабатываем доп поля влияющие на цену
		if(isset($_SESSION["ORDERS"]["PROPS"][$basketID]) and is_array($_SESSION["ORDERS"]["PROPS"][$basketID]))
			// Высчитываем цену плюсуя поля от которых зависит цена
			foreach ($_SESSION["ORDERS"]["PROPS"][$basketID] as $code => $value) {
				if(is_numeric($value)){
					$arOrders[$basketID]["ELEMENT"]["PROPS"][] = $arResult["ELEMENTS"][$productID][$code][$value]["NAME"];
					$arOrders[$basketID]["ELEMENT"]["PRICE"] = ($arResult["ELEMENTS"][$productID]["PRICE"] + $arResult["ELEMENTS"][$productID][$code][$value]["VALUE"]);
				}else{
					$arOrders[$basketID]["ELEMENT"]["PROPS"][] = $value;
				}
			}
			// Получаем ссылку на товар
			$arOrders[$basketID]["URL"] = $_SESSION["ORDERS"]["URLS"][$basketID];
			// Получаем количество товара в корзине
			$arOrders[$basketID]["QUANTITY"] = $_SESSION["ORDERS"]["QUANTITY"][$basketID];
			// Получаем цену товара умноженную на количество в корзине
			$arOrders[$basketID]["QUANTITY_TOTAL"] = (preg_replace('/[^0-9]/', '', $arOrders[$basketID]["ELEMENT"]["PRICE"]) * $arOrders[$basketID]["QUANTITY"]); 
			// Получаем окончательную сумму товаров в корзине
			$arResult["TOTAL_PRICE"] = ($arOrders[$basketID]["QUANTITY_TOTAL"] + $arResult["TOTAL_PRICE"]);
	}
	//p($arOrders);
?>