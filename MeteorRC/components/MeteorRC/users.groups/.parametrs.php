<?if (!defined("PROLOG_INCLUDED") || PROLOG_INCLUDED!==true) die();
return array(
	"COMPONENT" => "users",
	"NAME" => "Группы пользователей",
	"DESCRIPTION" => "Управление группами",
	"TEXT_ADD" => "Добавить группу",
	"TEXT_SAVE" => "Группа пользователей успешно сохранена",
	"ICON" => '<i class="fa fa-folder-open"></i>',
	"EDITOR_FILE" => "/MeteorRC/admin/editors/elements.php",
	"IBLOCK" => "groups",
	"CORPORATE" => "MeteorRC",
	"WINDOW_WIDTH" => 470,
	"ACCESS" => array(
		"NAME" => "Доступ к группам пользователей",
		"KEY" => "USERS",
		"TYPE" => array(
			"A" => "Только чтение",
			"N" => "Без доступа",
			"Y" => "Полный доступ",
		)
	),

	'EVENTS' => array(
		"TEXT" => array(
			"ADD" => "Добавил группу пользователей",
			"EDIT" => "Отредактировал группу пользователей",
			"DELL" => "Удалил группу пользователей",
		),
		"FIELDS" => array(
			"NAME" => "NAME",
			"PREVIEW_TEXT" => "ALIAS",
			"PREVIEW_PICTURE" => "PICTURE",
		)
	),

	'TABS' => array(
		"MAIN" => "Основное",
		"ACCESS" => "Доступ"
	),
	"ADMIN" => "Y",
	"FIELDS" => array(
		"ACTIVE" => array("TAB" => "MAIN", "DISPLAY" => "Y", "NAME" => "Активность", "TYPE" => "SELECT", "SELECT" => array("Y" => "Да", "N" => "Нет"), "ICON" => '<i class="fa fa-power-off"></i>', "FASSET" => "Y"),
		"NAME" => array("TAB" => "MAIN", "DISPLAY" => "Y", "NAME" => "Название группы", "TYPE" => "TEXT", "ICON" => '<i class="fa fa-shopping-bag"></i>', "REQUIRED" => "Y", "TRANSLIT_FOR" => "ALIAS", "FASSET" => "Y"),
		"ALIAS" => array("TAB" => "MAIN", "DISPLAY" => "N", "NAME" => "Алиас", "TYPE" => "TEXT", "ICON" => '<i class="fa fa-link"></i>', "DESCRIPTION" => "", "REQUIRED" => "Y", "FASSET" => "Y"),
		"ACCESS" => array("TAB" => "ACCESS", "DISPLAY" => "Y", "NAME" => "Доступы", "TYPE" => "SELECT", "SELECT" => array("Y" => "Да", "N" => "Нет"), "ICON" => '<i class="fa fa-shopping-bag"></i>'),
	),
	'IMAGE_WIDTH' => '50px',
	'KEY_BY' => "ID",
);
?>