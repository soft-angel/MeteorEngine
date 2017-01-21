<?require_once($_SERVER["DOCUMENT_ROOT"]."/MeteorRC/main/include/before.php");?>
<?
// Получаем способ оплаты
$arPayment = $APPLICATION->GetElementForField("shop", "payment", array("FILE" => "Wallet_One_ajax.php"), true);
if($order_id = $FIREWALL->GetNumber("ORDER")){
// Получаем заказ
$arOrder = $APPLICATION->GetElementForField("shop", "basket", array("ID" => $order_id), true);
// Получаем список товаров для вычисления суммы заказа
$arProducts = $APPLICATION->GetElementForField("shop", "products", array("ACTIVE" => "Y"), false);
// Вычисляем сумму заказа
$priceAll = 0;
foreach ($arOrder["PRODUCTS"] as $basketID => $productID) {
  // Обрабатываем доп поля влияющие на цену
  if(isset($arOrder["PROPS"][$basketID]) and count($arOrder["PROPS"][$basketID]) > 0){
    foreach ($arOrder["PROPS"][$basketID] as $code => $value) {
      $price = preg_replace('/[^0-9]/', '', ($arProducts[$productID]["PRICE"] + $arProducts[$productID][$code][$value]["VALUE"]));
      }
  }else{
      $price = preg_replace('/[^0-9]/', '', ($arProducts[$productID]["PRICE"]));
  }
	$priceAll = (($arOrder["QUANTITY"][$basketID] * $price) + $priceAll);
}

//p($priceAll);
//p($arOrder);

?>

<form style="display:none" name="payGo" id="payGo" method="post" action="<?=$arPayment['PAY_URL']?>">
  <input name="WMI_MERCHANT_ID" value="<?=$arPayment['POST_MERCHANT_ID']?>"/>
  <input name="WMI_PAYMENT_AMOUNT" value="<?=$priceAll?>.00"/>
  <input name="WMI_CURRENCY_ID" value="<?=isset($arPayment['POST_CURRENCY_ID'])?$arPayment['POST_CURRENCY_ID']:643?>"/>
  <input name="WMI_DESCRIPTION" value="<?=$arPayment['POST_DESCRIPTION']?><?=$arOrder["ID"]?>"/>
  <input name="WMI_SUCCESS_URL" value="<?=isset($_SERVER['HTTPS'])?'https://':'http://'?><?=$_SERVER['SERVER_NAME']?><?=$arPayment['SUCCESS_URL']?>"/>
  <input name="WMI_FAIL_URL" value="<?=isset($_SERVER['HTTPS'])?'https://':'http://'?><?=$_SERVER['SERVER_NAME']?><?=$arPayment['FAIL_URL']?>"/>
  <input name="ORDER_ID" type="hidden" value="<?=$order_id?>"/>
  <input name="submit" id="submit" type="submit"/>
</form>
<script type="text/javascript">
	document.forms["payGo"].submit.click();
</script>



	  <style>
body {
    height: 100%;
    width: 100%;
    margin: 0;
}
.loader2 {
    margin-top: -50px;
    position: absolute;
    top: 50%;
    text-align: center;
    left: 50%;
    margin-left: -50px;
}
loader2 {
    position:relative;
    width: 100px;
    height: 100px;
  }
  .loader2 i { 
    border-style:solid;
    display:inline-block;
    box-sizing:border-box;
    -moz-box-sizing:border-box;
    border-width:50px;
    border-color:#1fbba6;
    border-radius: 50px;
    -moz-animation:blink 1.5s infinite ease-in-out;
    -webkit-animation:blink 1.5s infinite ease-in-out;
    height: 100px;
    width: 100px;
  }
  @-webkit-keyframes blink{
    50%{
      border-width:0;
      border-color:rgba(255,255,255,0.5);
    }
    100%{
      border-width:0;
      border-color:rgba(255,255,255,0.5);
    }
  }
  @-moz-keyframes blink{
    50%{
      border-width:0;
      border-color:rgba(255,255,255,0.5);
    }
    100%{
      border-width:0;
      border-color:rgba(255,255,255,0.5);
    }
  }
p {
    font-family: sans-serif;
    text-align: center;
    color: red;
}
 </style>
 <div class="loader2"><i></i></div>
<?}?>
<?

// Обработка платежа
if($order_id = $FIREWALL->GetNumber("ORDER_ID")){
	if($FIREWALL->GetString("WMI_ORDER_STATE") == "Accepted" and $FIREWALL->GetNumber("WMI_MERCHANT_ID") == $arPayment["POST_MERCHANT_ID"]){
		$arOrder = $APPLICATION->GetElementForID("shop", "basket", $order_id);
		$arOrder["STATUS"] = "PAY";
		$arOrder = $APPLICATION->SaveElementForID($arOrder, "shop", "basket", $order_id);

		$CEvent->Send("ORDER_PAID", $arOrder);
		echo "WMI_RESULT=OK";
	}
}