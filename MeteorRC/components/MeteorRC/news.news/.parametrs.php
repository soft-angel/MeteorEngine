<?if (!defined("PROLOG_INCLUDED") || PROLOG_INCLUDED!==true) die();

return array(

	"COMPONENT" => "news",

	"NAME" => "Услуги",

	"IBLOCK" => "news",

	"DESCRIPTION" => "Управление услугами",

	"ICON" => '<i class="fa fa-file-text-o"></i>',

	"EDITOR_FILE" => "/MeteorRC/admin/editors/elements.php",

	"BD_FOLDER" => "/MeteorRC/bd/news/",

	"CORPORATE" => "MeteorRC",

	"TEXT_ADD" => "Добавить услугу",

	"WINDOW_WIDTH" => 470,

	'EVENTS' => array(

		"TEXT" => array(

			"ADD" => "Добавил услугу",

			"EDIT" => "Изменил услугу",

			"DELL" => "Удалил услугу",

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

		"SEO" => "SEO",

	),

	"ADMIN" => "Y",

	"FIELDS" => array(

		"NAME" => array("TAB" => "MAIN", "DISPLAY" => "Y", "NAME" => "Название", "TYPE" => "TRANSLIT", "ICON" => '<i class="fa fa-shopping-bag"></i>', "REQUIRED" => "Y", "TRANSLIT_FOR" => "ALIAS", "FASSET" => "Y"),

		"ACTIVE" => array("TAB" => "MAIN", "DISPLAY" => "Y", "NAME" => "Активность", "TYPE" => "SELECT", "SELECT" => array("Y" => "Да", "N" => "Нет"), "ICON" => '<i class="fa fa-power-off"></i>', "FASSET" => "Y"),

		"ALIAS" => array("TAB" => "MAIN", "DISPLAY" => "Y", "NAME" => "Алиас", "TYPE" => "TEXT", "ICON" => '<i class="fa fa-link"></i>', "DESCRIPTION" => "Допустимые символы: цифры [0-9], латиница в нижнем регистре [a-z], слеш [/], дефис [-], нижнее подчеркивание [_]", "REQUIRED" => "Y", "FASSET" => "Y", "UNIQUE" => "Y"),



		"DETAIL_PICTURE" => array("TAB" => "DETAIL", "DISPLAY" => "N", "NAME" => "Детальная картинка", "TYPE" => "IMAGE", 'MAX_WIDTH' => 500, 'QUALITY' => 70, "ICON" => '<i class="fa fa-picture-o"></i>'),

		"PREVIEW_PICTURE" => array("TAB" => "PREVIEW", "DISPLAY" => "Y", "NAME" => "Картинка для анонса", 'MAX_WIDTH' => 200, 'QUALITY' => 70, "TYPE" => "IMAGE", "ICON" => '<i class="fa fa-picture-o"></i>'),

		"PREVIEW_TEXT" => array("TAB" => "PREVIEW", "DISPLAY" => "N", "NAME" => "Описание для анонса", "TYPE" => "HTML", "ICON" => '<i class="fa fa-align-justify"></i>'),
		"MORE_PICTURE" => array("TAB" => "DETAIL", "DISPLAY" => "N", "NAME" => "Дополнительные картинки", 'MAX_WIDTH' => 1024, 'QUALITY' => 70, "TYPE" => "IMAGE", "MULTI" => "Y", "ICON" => '<i class="fa fa-picture-o"></i>'),

		"DETAIL_TEXT" => array("TAB" => "DETAIL", "DISPLAY" => "N", "NAME" => "Описание", "TYPE" => "HTML", "ICON" => '<i class="fa fa-align-justify"></i>'),

		"META-DESCRIPTION" => array("TAB" => "SEO", "DISPLAY" => "N", "NAME" => "Meta description", "TYPE" => "TEXTAREA", "ICON" => '<i class="fa fa-align-justify"></i>', "DESCRIPTION" => 'Содержание данного тега может использоваться в сниппетах (описаниях сайтов на странице результатов поиска)'),

		"META-KEYWORDS" => array("TAB" => "SEO", "DISPLAY" => "N", "NAME" => "Meta keywords", "TYPE" => "TEXTAREA", "ICON" => '<i class="fa fa-key"></i>', "DESCRIPTION" => 'Может учитываться при определении соответствия страницы поисковым запросам'),

	),

	'IMAGE_WIDTH' => '50px',

	'STATA_TRACKING' => 'Y',

);

?>