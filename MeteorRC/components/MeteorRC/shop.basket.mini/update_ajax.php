<?require_once($_SERVER["DOCUMENT_ROOT"]."/MeteorRC/main/include/before.php");?>

<?$APPLICATION->IncludeComponent("MeteorRC:shop.basket.mini", "", Array(
		"COMPONENT" => "shop",
		"IBLOCK" => "products",	// Инфоблок
		"BASKET_URL" => "/personal/basket/",
	),
	false
);?>