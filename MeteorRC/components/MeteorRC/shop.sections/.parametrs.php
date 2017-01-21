<?if (!defined("PROLOG_INCLUDED") || PROLOG_INCLUDED!==true) die();

return array(
	"COMPONENT" => "shop",
	"NAME" => "Разделы",
	"IBLOCK" => "sections",
	"DESCRIPTION" => "Управление разделами",
	"ICON" => '<i class="fa fa-shopping-cart"></i>',
	"EDITOR_FILE" => "/MeteorRC/admin/editors/elements.php",
	"BD_FOLDER" => "/MeteorRC/bd/shop/",
	"CORPORATE" => "MeteorRC",
	"TEXT_ADD" => "Добавить раздел",
	"TEXT_SAVE" => "Раздел успешно сохранен",
	"WINDOW_WIDTH" => 470,
	"ACCESS" => array(
		"NAME" => "Доступ к разделам",
		"KEY" => "PRODUCT",
		"TYPE" => array(
			"A" => "Только чтение",
			"N" => "Без доступа",
			"Y" => "Полный доступ",
		)
	),
	'EVENTS' => array(
		"TEXT" => array(
			"ADD" => "Добавил раздел",
			"EDIT" => "Изменил раздел",
			"DELL" => "Удалил раздел",
		),
		"FIELDS" => array(
			"NAME" => "NAME",
			"PREVIEW_TEXT" => "PREVIEW_TEXT",
			"PREVIEW_PICTURE" => "PICTURE",
		)
	),
	'TABS' => array(
		"MAIN" => "Основное",
		"SEO" => "SEO",
	),
	"ADMIN" => "Y",
	"FIELDS" => array(
		"ID" => array("TAB" => "MAIN", "DISPLAY" => "N", "NAME" => "ID", "TYPE" => "HIDDEN", "ICON" => '<i class="fa fa-shopping-bag"></i>'),
		"NAME" => array("TAB" => "MAIN", "DISPLAY" => "Y", "NAME" => "Название", "TYPE" => "TRANSLIT", "ICON" => '<i class="fa fa-shopping-bag"></i>', "REQUIRED" => "Y", "TRANSLIT_FOR" => "ALIAS", "FASSET" => "Y"),
		"ACTIVE" => array("TAB" => "MAIN", "DISPLAY" => "Y", "NAME" => "Активность", "TYPE" => "SELECT", "SELECT" => array("Y" => "Да", "N" => "Нет"), "ICON" => '<i class="fa fa-power-off"></i>', "FASSET" => "Y"),
		"ALIAS" => array("TAB" => "MAIN", "DISPLAY" => "N", "NAME" => "Алиас", "TYPE" => "TEXT", "ICON" => '<i class="fa fa-link"></i>', "DESCRIPTION" => "Допустимые символы: цифры [0-9], латиница в нижнем регистре [a-z], слеш [/], дефис [-], нижнее подчеркивание [_]", "REQUIRED" => "Y", "FASSET" => "Y", "UNIQUE" => "Y"),
		"SECTION" => array("TAB" => "MAIN", "DISPLAY" => "Y", "NAME" => "Раздел", "TYPE" => "SELECT_BD", "BD" => "sections", "ICON" => '<i class="fa fa-folder-open-o"></i>', "FASSET" => "Y"),
		"PICTURE" => array("TAB" => "MAIN", "DISPLAY" => "Y", "NAME" => "Изображение раздела", 'MAX_WIDTH' => 200, 'QUALITY' => 70, "TYPE" => "IMAGE", "ICON" => '<i class="fa fa-picture-o"></i>'),
		"PREVIEW_TEXT" => array("TAB" => "MAIN", "DISPLAY" => "N", "NAME" => "Описание для анонса", "TYPE" => "HTML", "ICON" => '<i class="fa fa-align-justify"></i>'),
		"META-DESCRIPTION" => array("TAB" => "SEO", "DISPLAY" => "N", "NAME" => "Meta description", "TYPE" => "TEXTAREA", "ICON" => '<i class="fa fa-align-justify"></i>', "DESCRIPTION" => 'Содержание данного тега может использоваться в сниппетах (описаниях сайтов на странице результатов поиска)'),
		"META-KEYWORDS" => array("TAB" => "SEO", "DISPLAY" => "N", "NAME" => "Meta keywords", "TYPE" => "TEXTAREA", "ICON" => '<i class="fa fa-key"></i>', "DESCRIPTION" => 'Может учитываться при определении соответствия страницы поисковым запросам'),
	),
	"SEF_URL_TEMPLATES" => array(
		"SEF_URL_DETAIL" => "/catalog/#ALIAS#/",
	),
	'IMAGE_WIDTH' => '50px',
);

?>