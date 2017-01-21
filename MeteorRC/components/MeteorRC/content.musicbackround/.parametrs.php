<?if (!defined("PROLOG_INCLUDED") || PROLOG_INCLUDED!==true) die();
return array(
	"COMPONENT" => "content",
	"NAME" => "Фоновая музыка",
	"IBLOCK" => "musicbackround",
	"DESCRIPTION" => "Управление фоновой музыкой",
	"ICON" => '<i class="fa fa-music"></i>',
	"EDITOR_FILE" => "/MeteorRC/admin/editors/elements.php",
	"BD_FOLDER" => "/MeteorRC/bd/content/",
	"CORPORATE" => "MeteorRC",
	"TEXT_ADD" => "Добавить фоновую музыку",
	"WINDOW_WIDTH" => 470,
	'EVENTS' => array(
		"TEXT" => array(
			"ADD" => "Добавил фоновую музыку",
			"EDIT" => "Изменил фоновую музыку",
			"DELL" => "Удалил фоновую музыку",
		),
		"FIELDS" => array(
			"NAME" => "NAME",
			"DETAIL_PICTURE" => "PREVIEW_PICTURE",
		)
	),
	'TABS' => array(
		"MAIN" => "Основное",
	),
	"ADMIN" => "Y",
	"FIELDS" => array(
		"NAME" => array("TAB" => "MAIN", "DISPLAY" => "Y", "NAME" => "Название", "TYPE" => "TEXT", "ICON" => '<i class="fa fa-shopping-bag"></i>', "REQUIRED" => "Y", "FASSET" => "Y"),
		"ACTIVE" => array("TAB" => "MAIN", "DISPLAY" => "Y", "NAME" => "Активность", "TYPE" => "SELECT", "SELECT" => array("Y" => "Да", "N" => "Нет"), "ICON" => '<i class="fa fa-power-off"></i>', "FASSET" => "Y"),
		"FILE" => array("TAB" => "MAIN", "DISPLAY" => "Y", "NAME" => "Файл Mp3", "TYPE" => "FILE", "ICON" => '<i class="fa fa-music"></i>', "REQUIRED" => "Y", "FASSET" => "Y"),
	),
);
?>