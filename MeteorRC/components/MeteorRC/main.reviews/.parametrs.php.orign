<?if (!defined("PROLOG_INCLUDED") || PROLOG_INCLUDED!==true) die();
return array(
	"COMPONENT" => "main",
	"NAME" => "Отзывы",
	"IBLOCK" => "reviews",
	"DESCRIPTION" => "Управление отзывами",
	"ICON" => '<i class="fa fa-comment-o"></i>',
	"EDITOR_FILE" => "/MeteorRC/admin/editors/elements.php",
	"BD_FOLDER" => "/MeteorRC/bd/shop/",
	"CORPORATE" => "MeteorRC",
	"TEXT_ADD" => "Добавить отзыв",
	"WINDOW_WIDTH" => 470,
	'TABS' => array(
		"MAIN" => "Основное",
	),
	"ADMIN" => "Y",
	"FIELDS" => array(
		"ACTIVE" => array("TAB" => "MAIN", "DISPLAY" => "Y", "NAME" => "Активность", "TYPE" => "SELECT", "SELECT" => array("Y" => "Да", "N" => "Нет"), "ICON" => '<i class="fa fa-power-off"></i>', "FASSET" => "Y"),
		"RATING" => array("TAB" => "MAIN", "DISPLAY" => "Y", "NAME" => "Оценка", "TYPE" => "SELECT", "SELECT" => array("1" => "1", "2" => "2", "3" => "3", "4" => "4", "5" => "5"), "ICON" => '<i class="fa fa-star"></i>', "FASSET" => "Y"),
		"NAME" => array("TAB" => "MAIN", "DISPLAY" => "Y", "NAME" => "Имя", "ICON" => '<i class="fa fa-comment-o"></i>', "REQUIRED" => "Y", "FASSET" => "Y", "LIST_EDIT" => "Y"),
		'DATE' => array("TAB" => "MAIN", "TYPE" => "DATE_TIME", "DISPLAY" => "Y", "NAME" => "Дата добавления", "ICON" => '<i class="fa fa-clock-o"></i>', "REQUIRED" => "Y", "FASSET" => "Y"),
		"PICTURE" => array("TAB" => "MAIN", "DISPLAY" => "Y", "NAME" => "Фото к отзыву", 'MAX_WIDTH' => 200, 'QUALITY' => 70, "TYPE" => "IMAGE", "ICON" => '<i class="fa fa-picture-o"></i>'),
		//"ELEMENT_ID" => array("TAB" => "MAIN", "DISPLAY" => "Y", "NAME" => "Элемент", "TYPE" => "SELECT_BD", "BD" => "products", 'COMPONENT_BD' => 'shop', "ICON" => '<i class="fa fa-shopping-bag"></i>', "MULTI" => "N", "FASSET" => "Y", "LIST_EDIT" => "Y"),
		"TEXT" => array("TAB" => "MAIN", "DISPLAY" => "N", "NAME" => "Текст отзыва", "TYPE" => "HTML", "ICON" => '<i class="fa fa-align-justify"></i>'),
	),
	'IMAGE_WIDTH' => '50px',
);
?>