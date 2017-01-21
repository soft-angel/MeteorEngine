<?if (!defined("PROLOG_INCLUDED") || PROLOG_INCLUDED!==true) die();
return array(
	"COMPONENT" => "shop",
	"NAME" => "Импорт",
	"IBLOCK" => "import",
	"DESCRIPTION" => "Импорт",
	"ICON" => '<i class="fa fa-download"></i>',
	"BD_FOLDER" => "/MeteorRC/bd/shop/",
	"CORPORATE" => "MeteorRC",
	"TEXT_SAVE" => "Импорт успешно завершен",
	"WINDOW_WIDTH" => 470,
	"ACCESS" => array(
		"NAME" => "Доступ к импорту",
		"KEY" => "IMPORT",
		"TYPE" => array(
			"A" => "Только чтение",
			"N" => "Без доступа",
			"Y" => "Полный доступ",
		)
	),
	"ADMIN" => "Y",
	'IMAGE_WIDTH' => '50px',
);
?>