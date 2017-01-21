<?if (!defined("PROLOG_INCLUDED") || PROLOG_INCLUDED!==true) die();
return array(
	"COMPONENT" => "shop",
	"NAME" => "Способы оплаты",
	"IBLOCK" => "payment",
	"DESCRIPTION" => "Управление способами оплаты",
	"ICON" => '<i class="fa fa-money"></i>',
	"EDITOR_FILE" => "/MeteorRC/admin/editors/elements.php",
	"BD_FOLDER" => "/MeteorRC/bd/shop/",
	"CORPORATE" => "MeteorRC",
	"TEXT_ADD" => "Создать способ оплаты",
	"ADMIN" => "Y",
	'EVENTS' => array(
		"TEXT" => array(
			"ADD" => "Добавил способ оплаты",
			"EDIT" => "Изменил способ оплаты",
			"DELL" => "Удалил способ оплаты",
		),
		"FIELDS" => array(
			"NAME" => "NAME",
			"PREVIEW_TEXT" => "COMMENT",
			"PREVIEW_PICTURE" => "LOGO",
		)
	),

	'TABS' => array(
		"MAIN" => "Основное",
		"CONFIG" => "Настройки",
	),
	"FIELDS" => array(
	"ID" => array("TAB" => "MAIN", "DISPLAY" => "Y", "NAME" => "ID", "TYPE" => "DISABLED", "ICON" => '<i class="fa fa-code"></i>', "FASSET" => "Y", "MULTI" => "N", "DEFAULT_VALUE" => 1),
	"NAME" => array("TAB" => "MAIN", "DISPLAY" => "Y", "NAME" => "Название", "TYPE" => "TEXT", "ICON" => '<i class="fa fa-male"></i>', "FASSET" => "N", "DESCRIPTION" => ""),
	"DEFAULT" => array("TAB" => "MAIN", "DISPLAY" => "N", "NAME" => "По умолчанию", "TYPE" => "SELECT", "SELECT" => array("N" => "Нет", "Y" => "Да"), "ICON" => '<i class="fa fa-check-square-o"></i>', "FASSET" => "Y", "DESCRIPTION" => "Этот способ оплаты будет выбран по умолчанию"),
	"LOGO" => array("REQUIRED" => "N", "TAB" => "MAIN", "DISPLAY" => "Y", "NAME" => "Логотип", 'MAX_WIDTH' => 300, 'QUALITY' => 70, "TYPE" => "IMAGE", "ICON" => '<i class="fa fa-picture-o"></i>'),
	"FILE" => array("TAB" => "MAIN", "DISPLAY" => "N", "NAME" => "Обработчик", "TYPE" => "SELECT_FILE", "DEFAULT_VALUE" => "Не имеет обработчика", "SELECT_FILE" => "/MeteorRC/components/MeteorRC/shop.payment/payments", "ICON" => '<i class="fa fa-check-square-o"></i>', "FASSET" => "Y", "DESCRIPTION" => ""),
	"COMMENT" => array("TAB" => "MAIN", "DISPLAY" => "N", "NAME" => "Комментариий", "TYPE" => "TEXTAREA", "ICON" => '<i class="fa fa-pencil-square-o"></i>', "FASSET" => "N", "DESCRIPTION" => ""),



	"SUCCESS_URL" => array("TAB" => "CONFIG", "DISPLAY" => "N", "NAME" => "URL успешной оплаты", "TYPE" => "TEXT", "ICON" => '<i class="fa fa-male"></i>', "FASSET" => "N", "DESCRIPTION" => "URL на который перебросит покупателя после успешной оплаты"),
	"FAIL_URL" => array("TAB" => "CONFIG", "DISPLAY" => "N", "NAME" => "URL при неудачной оплате", "TYPE" => "TEXT", "ICON" => '<i class="fa fa-male"></i>', "FASSET" => "N", "DESCRIPTION" => "URL на который перебросит покупателя после неудачной оплаты"),

	"PAY_URL" => array("TAB" => "CONFIG", "DISPLAY" => "N", "NAME" => "URL платежной системы", "TYPE" => "TEXT", "ICON" => '<i class="fa fa-male"></i>', "FASSET" => "N", "DESCRIPTION" => "URL взаимодействия с платежной системой"),
	"POST_MERCHANT_ID" => array("TAB" => "CONFIG", "DISPLAY" => "N", "NAME" => "ID магазина", "TYPE" => "TEXT", "ICON" => '<i class="fa fa-male"></i>', "FASSET" => "N", "DESCRIPTION" => "Ид вашего магазина на сайте платежной системы"),
	"POST_CURRENCY_ID" => array("TAB" => "CONFIG", "DISPLAY" => "N", "NAME" => "ID валюты", "TYPE" => "TEXT", "ICON" => '<i class="fa fa-male"></i>', "FASSET" => "N", "DESCRIPTION" => "Ид валюты, передается для формирования заказа", "DEFAULT_VALUE" => 643),
	"POST_DESCRIPTION" => array("TAB" => "CONFIG", "DISPLAY" => "N", "NAME" => "Описание заказа", "TYPE" => "TEXTAREA", "ICON" => '<i class="fa fa-pencil-square-o"></i>', "FASSET" => "N", "DESCRIPTION" => "Описание заказа, будет отображено в платежной системе"),
	),

	'IMAGE_WIDTH' => '50px',
);
?>