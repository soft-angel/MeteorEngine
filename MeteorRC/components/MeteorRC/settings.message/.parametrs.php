<?if (!defined("PROLOG_INCLUDED") || PROLOG_INCLUDED!==true) die();
return array(
	"COMPONENT" => "settings",
	"NAME" => "Почтовые шаблоны",
	"IBLOCK" => "message",
	"DESCRIPTION" => "Управление почтовыми шаблонами",
	"ICON" => '<i class="fa fa-envelope-o"></i>',
	"EDITOR_FILE" => "/MeteorRC/admin/editors/elements.php",
	"BD_FOLDER" => "/MeteorRC/bd/settings/",
	"CORPORATE" => "MeteorRC",
	"TEXT_ADD" => "Добавить почтовый шаблон",
	"TEXT_SAVE" => "Почтовый шаблон успешно сохранен",
	'TABS' => array(
		"MAIN" => "Параметры",
	),
	"ADMIN" => "Y",
	'EVENTS' => array(
		"TEXT" => array(
			"ADD" => "Добавил почтовый шаблон",
			"EDIT" => "Изменил почтовый шаблон",
			"DELL" => "Удалил почтовый шаблон",
		),
		"FIELDS" => array(
			"NAME" => "ID",
			"PREVIEW_TEXT" => "SUBJECT",
		)
	),

	"FIELDS" => array(
		"ID" => array("TAB" => "MAIN", "DISPLAY" => "N", "NAME" => "ID", "TYPE" => "HIDDEN", "ICON" => '<i class="fa fa-shopping-bag"></i>'),
		"ACTIVE" => array("TAB" => "MAIN", "DISPLAY" => "Y", "NAME" => "Активность", "TYPE" => "SELECT", "SELECT" => array("Y" => "Да", "N" => "Нет"), "ICON" => '<i class="fa fa-power-off"></i>', "FASSET" => "Y"),
		"SUBJECT" => array("TAB" => "MAIN", "DISPLAY" => "Y", "NAME" => "Тема", "TYPE" => "TEXT", "ICON" => '<i class="fa fa-share"></i>', "REQUIRED" => "Y"),
		"EVENT_ID" => array("TAB" => "MAIN", "DISPLAY" => "Y", "NAME" => "Тип почтового события", "TYPE" => "SELECT_BD", "BD" => "event", "ICON" => '<i class="fa fa-envelope"></i>', "REQUIRED" => "Y", "FASSET" => "Y"),

		"EMAIL_FROM" => array("TAB" => "MAIN", "DISPLAY" => "N", "NAME" => "От кого", "TYPE" => "TEXT", "ICON" => '<i class="fa fa-user"></i>', "REQUIRED" => "Y", "DEFAULT_VALUE" => "#DEFAULT_EMAIL_FROM#"),
		"EMAIL_TO" => array("TAB" => "MAIN", "DISPLAY" => "N", "NAME" => "Кому", "TYPE" => "TEXT", "ICON" => '<i class="fa fa-user"></i>', "REQUIRED" => "Y", "DEFAULT_VALUE" => "#DEFAULT_EMAIL_FROM#"),

		"BODY_TYPE" => array("TAB" => "MAIN", "DISPLAY" => "N", "NAME" => "Тип сообщения", "TYPE" => "SELECT", "SELECT" => array("text/plain" => "Текст", "text/html" => "HTML"), "ICON" => '<i class="fa fa-code"></i>'),
		"MESSAGE" => array("TAB" => "MAIN", "DISPLAY" => "N", "NAME" => "Сообщение", "TYPE" => "TEXTAREA", "ICON" => '<i class="fa fa-pencil-square-o"></i>', "REQUIRED" => "Y"),
	),
);
?>