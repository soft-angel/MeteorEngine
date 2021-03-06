<?if (!defined("PROLOG_INCLUDED") || PROLOG_INCLUDED!==true) die();
return array(
	"COMPONENT" => "social",
	"NAME" => "Ссылки",
	"IBLOCK" => "links",
	"DESCRIPTION" => "Управление ссылками на соцсети",
	"ICON" => '<i class="fa fa-link"></i>',
	"BD_FOLDER" => "/MeteorRC/bd/social/",
	"CORPORATE" => "MeteorRC",
	"WINDOW_WIDTH" => 470,
	'EVENTS' => array(
		"TEXT" => array(
			"ADD" => "Изменил социальные ссылки",
			"EDIT" => "Изменил социальные ссылки",
		),
		"FIELDS" => array(
			"NAME" => "NAME",
			"PREVIEW_TEXT" => "PREVIEW_TEXT",
			"PREVIEW_PICTURE" => "PREVIEW_PICTURE",
		)
	),
	'TABS' => array(
		"MAIN" => "Основное",
	),
	"ADMIN" => "Y",
	"FIELDS" => array(
		"ACTIVE" => array("TAB" => "MAIN", "DISPLAY" => "Y", "NAME" => "Активность", "TYPE" => "SELECT", "SELECT" => array("Y" => "Да", "N" => "Нет"), "ICON" => '<i class="fa fa-power-off"></i>', "FASSET" => "Y"),
		"VK" => array("TAB" => "MAIN", "DISPLAY" => "N", "NAME" => "сылка на страницу VK", "TYPE" => "TEXT", "ICON" => '<i class="fa fa-vk"></i>'),
		"INSTAGRAMM" => array("TAB" => "MAIN", "DISPLAY" => "N", "NAME" => "сылка на страницу Instagram", "TYPE" => "TEXT", "ICON" => '<i class="fa fa-instagram"></i>'),
		"FACEBOOK" => array("TAB" => "MAIN", "DISPLAY" => "N", "NAME" => "сылка на страницу Facebook", "TYPE" => "TEXT", "ICON" => '<i class="fa fa-facebook"></i>'),
		"TWITTER" => array("TAB" => "MAIN", "DISPLAY" => "N", "NAME" => "сылка на страницу Twitter", "TYPE" => "TEXT", "ICON" => '<i class="fa fa-twitter"></i>'),
		"GOOGLE+" => array("TAB" => "MAIN", "DISPLAY" => "N", "NAME" => "сылка на страницу Google+", "TYPE" => "TEXT", "ICON" => '<i class="fa fa-google-plus"></i>'),

	),
	'IMAGE_WIDTH' => '50px',
);
?>