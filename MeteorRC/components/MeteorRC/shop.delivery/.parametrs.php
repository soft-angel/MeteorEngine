<?if (!defined("PROLOG_INCLUDED") || PROLOG_INCLUDED!==true) die();
return array(
	"COMPONENT" => "shop",
	"NAME" => "Способы доставки",
	"IBLOCK" => "delivery",
	"DESCRIPTION" => "Управление способами доставки",
	"ICON" => '<i class="fa fa-archive"></i>',
	"EDITOR_FILE" => "/MeteorRC/admin/editors/elements.php",
	"BD_FOLDER" => "/MeteorRC/bd/shop/",
	"CORPORATE" => "MeteorRC",
	"TEXT_ADD" => "Создать способ доставки",
	"ADMIN" => "Y",
	'EVENTS' => array(
		"TEXT" => array(
			"ADD" => "Добавил способ доставки",
			"EDIT" => "Изменил способ доставки",
			"DELL" => "Удалил способ доставки",
		),
		"FIELDS" => array(
			"NAME" => "NAME",
			"PREVIEW_TEXT" => "COMMENT",
			"PREVIEW_PICTURE" => "LOGO",
		)
	),

	'TABS' => array(
		"MAIN" => "Основное",
	),
	"FIELDS" => array(
	"ID" => array("TAB" => "MAIN", "DISPLAY" => "Y", "NAME" => "ID", "TYPE" => "DISABLED", "ICON" => '<i class="fa fa-code"></i>', "FASSET" => "Y", "MULTI" => "N", "DEFAULT_VALUE" => 1),
	"NAME" => array("TAB" => "MAIN", "DISPLAY" => "Y", "NAME" => "Название", "TYPE" => "TEXT", "ICON" => '<i class="fa fa-male"></i>', "FASSET" => "N", "DESCRIPTION" => ""),
	"PRICE" => array("TAB" => "MAIN", "DISPLAY" => "Y", "NAME" => "Стоимость", "TYPE" => "TEXT", "ICON" => '<i class="fa fa-usd"></i>', "FASSET" => "N", "DESCRIPTION" => ""),
	"DEFAULT" => array("TAB" => "MAIN", "DISPLAY" => "N", "NAME" => "По умолчанию", "TYPE" => "SELECT", "SELECT" => array("N" => "Нет", "Y" => "Да"), "ICON" => '<i class="fa fa-check-square-o"></i>', "FASSET" => "Y", "DESCRIPTION" => "Этот способ оплаты будет выбран по умолчанию"),
	"LOGO" => array("REQUIRED" => "N", "TAB" => "MAIN", "DISPLAY" => "Y", "NAME" => "Логотип", 'MAX_WIDTH' => 300, 'QUALITY' => 70, "TYPE" => "IMAGE", "ICON" => '<i class="fa fa-picture-o"></i>'),
	"COMMENT" => array("TAB" => "MAIN", "DISPLAY" => "N", "NAME" => "Комментариий", "TYPE" => "TEXTAREA", "ICON" => '<i class="fa fa-pencil-square-o"></i>', "FASSET" => "N", "DESCRIPTION" => ""),
	),
	'MULTY' => 'N',
	'IMAGE_WIDTH' => '50px',
);
?>