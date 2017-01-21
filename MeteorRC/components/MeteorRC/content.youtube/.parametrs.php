<?if (!defined("PROLOG_INCLUDED") || PROLOG_INCLUDED!==true) die();
return array(
	"COMPONENT" => "content",
	"NAME" => "Видео YouTube",
	"IBLOCK" => "youtube",
	"DESCRIPTION" => "Управление видео",
	"ICON" => '<i class="fa fa-youtube"></i>',
	"EDITOR_FILE" => "/MeteorRC/admin/editors/elements.php",
	"BD_FOLDER" => "/MeteorRC/bd/content/",
	"CORPORATE" => "MeteorRC",
	"TEXT_ADD" => "Добавить видео",
	"WINDOW_WIDTH" => 470,
	'EVENTS' => array(
		"TEXT" => array(
			"ADD" => "Добавил видео",
			"EDIT" => "Изменил видео",
			"DELL" => "Удалил видео",
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
		"IS_HOME" => array("TAB" => "MAIN", "DISPLAY" => "Y", "NAME" => "тображать на главной", "TYPE" => "SELECT", "SELECT" => array("Y" => "Да", "N" => "Нет"), "ICON" => '<i class="fa fa-home"></i>', "FASSET" => "Y"),
		"URL" => array("TAB" => "MAIN", "DISPLAY" => "Y", "NAME" => "Ссылка на видео YouTube", "TYPE" => "TEXT", "ICON" => '<i class="fa fa-youtube"></i>', "REQUIRED" => "Y", "FASSET" => "Y"),
		"DETAIL_PICTURE" => array("TAB" => "MAIN", "DISPLAY" => "N", "NAME" => "Фото к видео", "TYPE" => "IMAGE", 'MAX_WIDTH' => 1366, 'QUALITY' => 70, "ICON" => '<i class="fa fa-picture-o"></i>'),
	),
	'IMAGE_WIDTH' => '50px',
);
?>