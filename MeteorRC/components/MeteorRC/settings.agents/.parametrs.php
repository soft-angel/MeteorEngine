<?if (!defined("PROLOG_INCLUDED") || PROLOG_INCLUDED!==true) die();
return array(
	"COMPONENT" => "settings",
	"NAME" => "Агенты",
	"IBLOCK" => "agents",
	"DESCRIPTION" => "Управление агентами",
	"ICON" => '<i class="fa fa-circle-o"></i>',
	"EDITOR_FILE" => "/MeteorRC/admin/editors/elements.php",
	"BD_FOLDER" => "/MeteorRC/bd/settings/",
	"CORPORATE" => "MeteorRC",
	"TEXT_ADD" => "Новый агент",
	"TEXT_SAVE" => "Агент успешно сохранен",

	'EVENTS' => array(
		"TEXT" => array(
			"ADD" => "Добавил агента",
			"EDIT" => "Изменил агента",
			"DELL" => "Удалил агента",
		),
		"FIELDS" => array(
			"NAME" => "FILE",
			"PREVIEW_TEXT" => "DESCRIPTION",
		)
	),

	'TABS' => array(
		"MAIN" => "Параметры",
	),
	"ADMIN" => "Y",
	"FIELDS" => array(
		"ACTIVE" => array("TAB" => "MAIN", "DISPLAY" => "Y", "NAME" => "Активность", "TYPE" => "SELECT", "SELECT" => array("Y" => "Да", "N" => "Нет"), "ICON" => '<i class="fa fa-power-off"></i>'),
		"FILE" => array("TAB" => "MAIN", "DISPLAY" => "Y", "NAME" => "Путь к запускаемому скрипту от корня сайта", "TYPE" => "TEXT", "ICON" => '<i class="fa fa-file-code-o"></i>', "REQUIRED" => "Y"),
		"AGENT_INTERVAL" => array("TAB" => "MAIN", "DISPLAY" => "Y", "NAME" => "Промежуток между запусками в сек.", "TYPE" => "TEXT", "ICON" => '<i class="fa fa-clock-o"></i>', "REQUIRED" => "Y", "DEFAULT_VALUE" => 86400),
		"LAST_EXEC" => array("TAB" => "MAIN", "DISPLAY" => "Y", "NAME" => "Последний запуск", "TYPE" => "TIME", "ICON" => '<i class="fa fa-clock-o"></i>',),

		"DESCRIPTION" => array("TAB" => "MAIN", "DISPLAY" => "N", "NAME" => "Описание", "TYPE" => "TEXTAREA", "ICON" => '<i class="fa fa-pencil-square-o"></i>'),
	),
);
?>