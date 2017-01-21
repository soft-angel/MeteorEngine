<?if (!defined("PROLOG_INCLUDED") || PROLOG_INCLUDED!==true) die();
return array(
	"COMPONENT" => "shop",
	"NAME" => "Товары",
	"IBLOCK" => "products",
	"DESCRIPTION" => "Управление товарами",
	"ICON" => '<i class="fa fa-shopping-cart"></i>',
	"EDITOR_FILE" => "/MeteorRC/admin/editors/elements.php",
	"BD_FOLDER" => "/MeteorRC/bd/shop/",
	"CORPORATE" => "MeteorRC",
	"TEXT_ADD" => "Добавить товар",
	"WINDOW_WIDTH" => 470,
	"ACCESS" => array(
		"NAME" => "Доступ к товарам",
		"KEY" => "PRODUCT",
		"TYPE" => array(
			"A" => "Только чтение",
			"N" => "Без доступа",
			"Y" => "Полный доступ",
		)
	),
	'EVENTS' => array(
		"TEXT" => array(
			"ADD" => "Добавил товар",
			"EDIT" => "Изменил товар",
			"DELL" => "Удалил товар",
		),
		"FIELDS" => array(
			"NAME" => "NAME",
			"PREVIEW_TEXT" => "PREVIEW_TEXT",
			"PREVIEW_PICTURE" => "PREVIEW_PICTURE",
		)
	),
	'TABS' => array(
		"MAIN" => "Основное",
		"PREVIEW" => "Анонс",
		"DETAIL" => "Подробно",
		"ADDITIONALY" => "Дополнительное",
		"SEO" => "SEO",
	),
	"ADMIN" => "Y",
	"FIELDS" => array(
		"NAME" => array("TAB" => "MAIN", "DISPLAY" => "Y", "NAME" => "Название", "TYPE" => "TRANSLIT", "ICON" => '<i class="fa fa-shopping-bag"></i>', "REQUIRED" => "Y", "TRANSLIT_FOR" => "ALIAS", "FASSET" => "Y"),
		"ACTIVE" => array("TAB" => "MAIN", "DISPLAY" => "Y", "NAME" => "Активность", "TYPE" => "SELECT", "SELECT" => array("Y" => "Да", "N" => "Нет"), "ICON" => '<i class="fa fa-power-off"></i>', "FASSET" => "Y"),
		"ALIAS" => array("TAB" => "MAIN", "DISPLAY" => "N", "NAME" => "Алиас", "TYPE" => "TEXT", "ICON" => '<i class="fa fa-link"></i>', "DESCRIPTION" => "Допустимые символы: цифры [0-9], латиница в нижнем регистре [a-z], слеш [/], дефис [-], нижнее подчеркивание [_]", "REQUIRED" => "Y", "FASSET" => "Y", "UNIQUE" => "Y"),
		"PRICE" => array("TAB" => "MAIN", "DISPLAY" => "N", "NAME" => "Цена", "TYPE" => "PRICE", "ICON" => '<i class="fa fa-rub"></i>', "DESCRIPTION" => "", "REQUIRED" => "Y", "FASSET" => "Y"),
		"OLD_PRICE" => array("TAB" => "MAIN", "DISPLAY" => "N", "NAME" => "Старая цена", "TYPE" => "PRICE", "ICON" => '<i class="fa fa-rub"></i>', "DESCRIPTION" => "", "REQUIRED" => "N", "FASSET" => "Y"),
		"FEATURED" => array("TAB" => "MAIN", "DISPLAY" => "N", "NAME" => "Рекомендуемый", "TYPE" => "SELECT", "SELECT" => array("Y" => "Да", "N" => "Нет"), "ICON" => '<i class="fa fa-power-off"></i>', "FASSET" => "Y"),
		"SECTION" => array("TAB" => "MAIN", "DISPLAY" => "Y", "NAME" => "Раздел", "TYPE" => "SELECT_BD", "BD" => "sections", "ICON" => '<i class="fa fa-folder-open-o"></i>', "FASSET" => "Y"),

		//"MATERIAL" => array("TAB" => "MAIN", "DISPLAY" => "N", "NAME" => "Материал", 'DESCRIPTION' => 'В поле название вписывается имя значения, в поле значение указывается действие над ценой товара. Например: Синий => -100.', "TYPE" => "DOUBLE_TEXT", "MULTI" => "Y", "FASSET" => "N"),


		//"BONUS" => array("TAB" => "ADDITIONALY", "DISPLAY" => "N", "NAME" => "Бонус от покупки", "TYPE" => "TEXT", "ICON" => '<i class="fa fa-cart-plus"></i>'),
		//"RELATED" => array("TAB" => "ADDITIONALY", "DISPLAY" => "N", "NAME" => "Похожие товары", "TYPE" => "SELECT_BD", "BD" => "products", "ICON" => '<i class="fa fa-folder-open-o"></i>', "FASSET" => "N", "MULTI" => "Y", "DESCRIPTION" => "Похожие товары"),
		
		"PREVIEW_PICTURE" => array("TAB" => "PREVIEW", "DISPLAY" => "Y", "NAME" => "Картинка для анонса", 'MAX_WIDTH' => 200, 'QUALITY' => 70, "TYPE" => "IMAGE", "ICON" => '<i class="fa fa-picture-o"></i>'),
		"PREVIEW_TEXT" => array("TAB" => "PREVIEW", "DISPLAY" => "N", "NAME" => "Описание для анонса", "TYPE" => "HTML", "ICON" => '<i class="fa fa-align-justify"></i>'),

		"DETAIL_PICTURE" => array("TAB" => "DETAIL", "DISPLAY" => "N", "NAME" => "Детальная картинка", "TYPE" => "IMAGE", 'MAX_WIDTH' => 1024, 'QUALITY' => 70, "ICON" => '<i class="fa fa-picture-o"></i>'),
		"MORE_PICTURE" => array("TAB" => "DETAIL", "DISPLAY" => "N", "NAME" => "Дополнительные картинки", 'MAX_WIDTH' => 1024, 'QUALITY' => 70, "TYPE" => "IMAGE", "MULTI" => "Y", "ICON" => '<i class="fa fa-picture-o"></i>'),
		"DETAIL_TEXT" => array("TAB" => "DETAIL", "DISPLAY" => "N", "NAME" => "Описание", "TYPE" => "HTML", "ICON" => '<i class="fa fa-align-justify"></i>'),
		"META-DESCRIPTION" => array("TAB" => "SEO", "DISPLAY" => "N", "NAME" => "Meta description", "TYPE" => "TEXTAREA", "ICON" => '<i class="fa fa-align-justify"></i>', "DESCRIPTION" => 'Содержание данного тега может использоваться в сниппетах (описаниях сайтов на странице результатов поиска)'),
		"META-KEYWORDS" => array("TAB" => "SEO", "DISPLAY" => "N", "NAME" => "Meta keywords", "TYPE" => "TEXTAREA", "ICON" => '<i class="fa fa-key"></i>', "DESCRIPTION" => 'Может учитываться при определении соответствия страницы поисковым запросам'),
	),
	"SEF_URL_TEMPLATES" => array(
		"SEF_URL_PAGE" => "/catalog/",
		"SEF_URL_SECTION" => "/catalog/#SECTION|ALIAS#/",
		"SEF_URL_DETAIL" => "/catalog/#SECTION|ALIAS#/#ALIAS#.html",
	),
	'IMAGE_WIDTH' => '50px',
	'STATA_TRACKING' => 'Y',
);
?>