<?if (!defined("PROLOG_INCLUDED") || PROLOG_INCLUDED!==true) die();

return array(

	"COMPONENT" => "sliders",

	"NAME" => "Слайды в шапке",

	"IBLOCK" => "top",

	"DESCRIPTION" => "Управление слайдами",

	"ICON" => '<i class="fa fa-picture-o"></i>',

	"EDITOR_FILE" => "/MeteorRC/admin/editors/elements.php",

	"BD_FOLDER" => "/MeteorRC/bd/sliders/",

	"CORPORATE" => "MeteorRC",

	"TEXT_ADD" => "Добавить слайд",

	"TEXT_SAVE" => "Слайд успешно сохранен",

	"WINDOW_WIDTH" => 470,

	"ACCESS" => array(

		"NAME" => "Доступ к слайдам",

		"KEY" => "SLIDERS",

		"TYPE" => array(

			"A" => "Только чтение",

			"N" => "Без доступа",

			"Y" => "Полный доступ",

		)

	),

	'TABS' => array(

		"MAIN" => "Основное",

	),

	"ADMIN" => "Y",

	"FIELDS" => array(

		"NAME" => array("TAB" => "MAIN", "DISPLAY" => "Y", "NAME" => "Название", "TYPE" => "TEXT", "ICON" => '<i class="fa fa-shopping-bag"></i>', "REQUIRED" => "Y", "TRANSLIT_FOR" => "ALIAS"),

		"LINK" => array("TAB" => "MAIN", "DISPLAY" => "Y", "NAME" => "Ссылка", "TYPE" => "TEXT", "ICON" => '<i class="fa fa-link"></i>'),

		"ACTIVE" => array("TAB" => "MAIN", "DISPLAY" => "Y", "NAME" => "Активность", "TYPE" => "SELECT", "SELECT" => array("Y" => "Да", "N" => "Нет"), "ICON" => '<i class="fa fa-power-off"></i>', 'FASSET' => 'Y'),

		"PICTURE" => array("TAB" => "MAIN", "DISPLAY" => "Y", "NAME" => "Изображение слайда", 'MAX_WIDTH' => 1024, 'QUALITY' => 70, "TYPE" => "IMAGE", "ICON" => '<i class="fa fa-picture-o"></i>'),

		"PREVIEW_TEXT" => array("TAB" => "MAIN", "DISPLAY" => "N", "NAME" => "Текст для анонса слайда", "TYPE" => "TEXT", "ICON" => '<i class="fa fa-align-justify"></i>'),

		"DETAIL_TEXT" => array("TAB" => "MAIN", "DISPLAY" => "N", "NAME" => "Полный текст слайда", "TYPE" => "HTML", "ICON" => '<i class="fa fa-align-justify"></i>'),

	),

	'IMAGE_WIDTH' => '50px',

);

?>