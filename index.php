<?php require_once($_SERVER["DOCUMENT_ROOT"]."/MeteorRC/header.php");?>
<?$APPLICATION->IncludeComponent("MeteorRC:sliders.top", "", Array(
        "COMPONENT" => "sliders",
        "IBLOCK" => "top",  // Инфоблок
        "SECTION_ID" => false,  // ID раздела
        "SET_TITLE" => "N", // Устанавливать заголовок страницы
        "SET_BROWSER_TITLE" => "N", // Устанавливать заголовок окна браузера
        "BROWSER_TITLE" => "",  // Установить заголовок окна браузера из свойства
        "SET_META_KEYWORDS" => "Y", // Устанавливать ключевые слова страницы
        "META_KEYWORDS" => "",  // Установить ключевые слова страницы из свойства
        "SET_STATUS_404" => "N",    // Устанавливать статус 404, если не найдены элемент или раздел
        "CACHE_TYPE" => "A",    // Тип кеширования
        "CACHE_TIME" => "36000000", // Время кеширования (сек.)
        "CACHE_FILTER" => "Y",  // Кешировать при установленном фильтре
        "CACHE_GROUPS" => "Y",  // Учитывать права доступа
        "SHOW_404" => "N",
        "MESSAGE_404" => "",
    ),
    false
);?>

<?$APPLICATION->IncludeComponent("MeteorRC:news.list", "", Array(
        "SORT" => array(
        	"BY" => "ACTIVE_TIME",
        	"ORDER" => "DESC",
        	"TYPE" => "INT",
        ),
        "FILTER" => array("ACTIVE" => "Y"),
		"MESS_BTN_DETAIL" => "Подробнее",	// Текст кнопки "Подробнее"
		"COMPONENT" => "news",
		"IBLOCK" => "news",	// Инфоблок
		"SET_TITLE" => "N",	// Устанавливать заголовок страницы
		"SET_BROWSER_TITLE" => "N",	// Устанавливать заголовок окна браузера
		"BROWSER_TITLE" => "-",	// Установить заголовок окна браузера из свойства
		"SET_META_KEYWORDS" => "Y",	// Устанавливать ключевые слова страницы
		"META_KEYWORDS" => "",	// Установить ключевые слова страницы из свойства
		"COUNT" => "9",	// Количество элементов
		"CACHE_TYPE" => "A",	// Тип кеширования
		"CACHE_TIME" => "36000000",	// Время кеширования (сек.)
		"SEF_URL_TEMPLATES" => array(
			"SEF_URL_PAGE" => "/news/",
			"SEF_URL_DETAIL" => "/news/#ALIAS#.html",
		),
	),
	false
);?>

<?$APPLICATION->IncludeComponent("MeteorRC:main.include","",Array(
    "CACHE_TYPE" => "H",    // Тип кеширования
    "CACHE_TIME" => "36000000", // Время кеширования (сек.)
    "PATH" => "/MeteorRC/include/text.php",
    //"TYPE" => "HTML" // Тип редактора (HTML|TEXT)
),
false
);?>

<?$APPLICATION->IncludeComponent("MeteorRC:shop.products", "", Array(
        "SORT" => array(
            "BY" => "SORT",
            "ORDER" => "ASC",
            "TYPE" => "INT",
        ),
        "FILTER" => array("ACTIVE" => "Y"),
        "COUNT" => 9,
        "MESS_BTN_BUY" => "Купить", // Текст кнопки "Купить"
        "MESS_BTN_ADD_TO_BASKET" => "В корзину",    // Текст кнопки "Добавить в корзину"
        "MESS_BTN_SUBSCRIBE" => "Подписаться",  // Текст кнопки "Уведомить о поступлении"
        "MESS_BTN_DETAIL" => "Подробнее",   // Текст кнопки "Подробнее"
        "MESS_NOT_AVAILABLE" => "Нет в наличии",    // Сообщение об отсутствии товара
        "COMPONENT" => "shop",
        "IBLOCK" => "products", // Инфоблок
        "SECTION_ID" => false,  // ID раздела
        "SET_TITLE" => "N", // Устанавливать заголовок страницы
        "SET_BROWSER_TITLE" => "N", // Устанавливать заголовок окна браузера
        "BROWSER_TITLE" => "-", // Установить заголовок окна браузера из свойства
        "SET_META_KEYWORDS" => "Y", // Устанавливать ключевые слова страницы
        "META_KEYWORDS" => "",  // Установить ключевые слова страницы из свойства
        "SET_STATUS_404" => "Y",    // Устанавливать статус 404, если не найдены элемент или раздел
        "PAGE_ELEMENT_COUNT" => "", // Количество элементов на странице
        "USE_PRODUCT_QUANTITY" => "Y",  // Разрешить указание количества товара
        "CACHE_TYPE" => "A",    // Тип кеширования
        "CACHE_TIME" => "36000000", // Время кеширования (сек.)
        "DISPLAY_TOP_PAGER" => "N", // Выводить над списком
        "DISPLAY_BOTTOM_PAGER" => "Y",  // Выводить под списком
        "CURRENCY_ID" => "RUB", // Валюта, в которую будут сконвертированы цены
        "SHOW_404" => "Y",
        "MESSAGE_404" => "",
        "PAGER_BASE_LINK" => "",
        "BASKET_URL" => "/personal/basket/",
        "SEF_URL_TEMPLATES" => array(
            "SEF_URL_PAGE" => "/catalog/",
            "SEF_URL_SECTION" => "/catalog/#SECTION_ALIAS#/",
            "SEF_URL_DETAIL" => "/catalog/#SECTION_ALIAS#/#ALIAS#.html",
        ),
    ),
    false
);?>

<?$APPLICATION->IncludeComponent("MeteorRC:content.gallery", "", Array(
        "SORT" => array(
            "BY" => "SORT",
            "ORDER" => "ASC",
            "TYPE" => "INT",
        ),
        "FILTER" => array("ACTIVE" => "Y"),
        "COMPONENT" => "content",
        "IBLOCK" => "gallery", // Инфоблок
        "COUNT" => "12", // Количество элементов
        "CACHE_TYPE" => "H",    // Тип кеширования
        "CACHE_TIME" => "36000000", // Время кеширования (сек.)
    ),
    false
);?>
<?require($_SERVER["DOCUMENT_ROOT"]."/MeteorRC/footer.php");?>