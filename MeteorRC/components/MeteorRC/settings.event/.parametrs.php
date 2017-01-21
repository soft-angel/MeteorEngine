<?if (!defined("PROLOG_INCLUDED") || PROLOG_INCLUDED!==true) die();
return array(
	"COMPONENT" => "settings",
	"NAME" => "Тип почтовых событий",
	"IBLOCK" => "event",
	"DESCRIPTION" => "Управление типоми почтовых событий",
	"ICON" => '<i class="fa fa-envelope"></i>',
	"EDITOR_FILE" => "/MeteorRC/admin/editors/elements.php",
	"BD_FOLDER" => "/MeteorRC/bd/settings/",
	"CORPORATE" => "MeteorRC",
	"TEXT_ADD" => "Добавить почтовое событие",
	"TEXT_SAVE" => "Почтовое событие успешно сохранен",
	'EVENTS' => array(
		"TEXT" => array(
			"ADD" => "Добавил почтовое событие",
			"EDIT" => "Изменил почтовое событие",
			"DELL" => "Удалил почтовое событие",
		),
		"FIELDS" => array(
			"NAME" => "EVENT_NAME",
			"PREVIEW_TEXT" => "NAME",
		)
	),
	'TABS' => array(
		"MAIN" => "Параметры",
	),
	"ADMIN" => "Y",
	"FIELDS" => array(
		"ID" => array("TAB" => "MAIN", "DISPLAY" => "N", "NAME" => "ID", "TYPE" => "HIDDEN", "ICON" => '<i class="fa fa-shopping-bag"></i>'),
		"ACTIVE" => array("TAB" => "MAIN", "DISPLAY" => "Y", "NAME" => "Активность", "TYPE" => "SELECT", "SELECT" => array("Y" => "Да", "N" => "Нет"), "ICON" => '<i class="fa fa-power-off"></i>', "FASSET" => "Y"),
		"EVENT_NAME" => array("TAB" => "MAIN", "DISPLAY" => "Y", "NAME" => "ID почтового события", "TYPE" => "TEXT", "ICON" => '<i class="fa fa-envelope"></i>', "REQUIRED" => "Y", "FASSET" => "Y"),
		"NAME" => array("TAB" => "MAIN", "DISPLAY" => "Y", "NAME" => "Название", "TYPE" => "TEXT", "ICON" => '<i class="fa fa-envelope"></i>', "REQUIRED" => "Y"),
		"DESCRIPTION" => array("TAB" => "MAIN", "DISPLAY" => "N", "NAME" => "Описание", "TYPE" => "TEXTAREA", "ICON" => '<i class="fa fa-pencil-square-o"></i>'),
	),
);
?>