<?if(!defined("PROLOG_INCLUDED") || PROLOG_INCLUDED!==true) die();
/** @var array $arParams */
/** @global class $APPLICATION */
/** @global class $USER */
/** @global class $CONFIG */
/** @global class $CACHE */
/** @global class $FILE */
/** @var string $templateName - Имя шаблона */
/** @var string $templateFile - файл шаблона */
/** @var string $templateFolder - папка шаблона относительно корня сайта */
/** @var string $componentPath - папка компонента относительно корня сайта */
?>
<?
if(!isset($arParams["FILTER"]))
	$arParams["FILTER"] = array("ACTIVE" => "Y");
if(!isset($arParams["SORT"]))
	$arParams["SORT"] = false;

$arParamsComponent = $APPLICATION->GetComponentsParams($arParams["COMPONENT"], $arParams["IBLOCK"]);
$arParams = array_merge($arParams, $arParamsComponent);
// -------------------  ЧПУ ------------------
$subject = $APPLICATION->GetArUrlPatch();

// Разбираем для элементовs
$arPatternElement =  explode("/", $arParams["SEF_URL_TEMPLATES"]["SEF_URL_DETAIL"]);
$arUrlRewriteElement = UrlToPattern($arPatternElement, $subject);

// Разбираем для разделов
$arPatternSection =  explode("/", $arParams["SEF_URL_TEMPLATES"]["SEF_URL_SECTION"]);
$arUrlRewriteSection = UrlToPattern($arPatternSection, $subject);


if($arParams["SEF_URL_TEMPLATES"]["SEF_URL_PAGE"] == $APPLICATION->GetUrlPatch()){
	$APPLICATION->httpResponseCode(200);
	// Если урл это корень компонета то это раздел со всеми элементами
	$arResult["tmpl"] = "/section.php";
	$arEye = array(
		array(
			"ICON" => '<i class="fa fa-pencil"></i>',
			"LINK" => "/MeteorRC/admin/?component=" . $arParams["COMPONENT"] . "&amp;iblock=" . $arParams["IBLOCK"],
		),
	);
	$arElements = $APPLICATION->GetElementForField($arParams["COMPONENT"], $arParams["IBLOCK"], $arParams["FILTER"], false, $arParams["SORT"]);
}elseif(count($arUrlRewriteSection) < count($arUrlRewriteElement)){
	$arParams["FILTER"]["ALIAS"] = $arUrlRewriteElement["ALIAS"];
	$arResult["tmpl"] = "/element.php";
	$arElement = $APPLICATION->GetElementForField($arParams["COMPONENT"], $arParams["IBLOCK"], $arParams["FILTER"], true);
	$arEye = array(
		array(
			"ICON" => '<i class="fa fa-pencil"></i>',
			"LINK" => "/MeteorRC/admin/?component=" . $arParams["COMPONENT"] . "&amp;iblock=" . $arParams["IBLOCK"] . "&amp;edit_element=" . $arElement["ID"],
		),
	);
	// --------------------- Счетчики ---------------------
	$bdFile = STATA_PATCH . DS . $arParams["COMPONENT"] . DS . $arParams["IBLOCK"] . DS . date("Y.m") . SFX_BD;
	$arCount = $APPLICATION->GetFileArray($bdFile);
	if(defined("STATA_IS_USER") and $arElement["ID"]){
		// Добавляем +1 просмотр
		$arElement["STATA_COUNT"] = isset($arElement["STATA_COUNT"])?($arElement["STATA_COUNT"] + 1):1;
		$APPLICATION->SaveElementForID($arElement, $arParams["COMPONENT"], $arParams["IBLOCK"], $arElement["ID"]);
		// Сохраняем просмотр в статистику
		$arCount[$arElement["ID"]][date("Y-m-d")]["WIEWS"] = isset($arCount[$arElement["ID"]][date("Y-m-d")]["WIEWS"])?($arCount[$arElement["ID"]][date("Y-m-d")]["WIEWS"] + 1):1;
	}
	if(defined("STATA_IS_USER_UNIQ_PAGE") and $arElement["ID"]){
		// Сохраняем уникальное посещение в статистику
		$arCount[$arElement["ID"]][date("Y-m-d")]["VISIT"] = isset($arCount[$arElement["ID"]][date("Y-m-d")]["VISIT"])?($arCount[$arElement["ID"]][date("Y-m-d")]["VISIT"] + 1):1;	
	}

	$APPLICATION->ArrayWriter($arCount, $bdFile);
	unset($arCount);
	// --------------------- Конец счетчики ---------------------


	if(!empty($arElement)){
		$APPLICATION->httpResponseCode(200);
		if(isset($arElement["NAME"]))
			$APPLICATION->arrayParam["PageName"] = $arElement["NAME"];
		if(isset($arElement["META-DESCRIPTION"]))
			$APPLICATION->arrayParam["MetaDescription"] = $arElement["META-DESCRIPTION"];
		if(isset($arElement["META-KEYWORDS"]))
			$APPLICATION->arrayParam["MetaKeyWords"] = $arElement["META-KEYWORDS"];
	}else{
		$APPLICATION->httpResponseCode(404);
		$arResult["tmpl"] = "/404.php";
	}

}else{
	// Если обнаружилось совпадений больше
	// Перебираем обнаруженные
	foreach ($arUrlRewriteSection as $code => $value) {
		$fieldParams = explode("|", $code);
		if(count($fieldParams) > 1){
			$getField = $fieldParams[1];
			$field = $fieldParams[0];
			$arFieldParams = $arParams["FIELDS"][$field];
			$arSection = $APPLICATION->GetElementForField($arParams["COMPONENT"], $arFieldParams["BD"], array($getField => $value), true);
			$arParams["FILTER"][$field] = $arSection["ID"];
		}

	}
	//Если раздел существует
	if(isset($arSection["ID"])){
		$arResult["tmpl"] = "/section.php";
		$arEye = array(
			array(
				"ICON" => '<i class="fa fa-pencil"></i>',
				"LINK" => "/MeteorRC/admin/?component=" . $arParams["COMPONENT"] . "&amp;iblock=" . $arParams["IBLOCK"],
			),
		);
		$APPLICATION->arrayParam["PageName"] = $arSection["NAME"];
		if(isset($arSection["META-DESCRIPTION"]))
			$APPLICATION->arrayParam["MetaDescription"] = $arSection["META-DESCRIPTION"];
		if(isset($arSection["META-KEYWORDS"]))
			$APPLICATION->arrayParam["MetaKeyWords"] = $arSection["META-KEYWORDS"];
		$arElements = $APPLICATION->GetElementForField($arParams["COMPONENT"], $arParams["IBLOCK"], $arParams["FILTER"], false, $arParams["SORT"]);
		$APPLICATION->httpResponseCode(200);
	}else{
		$APPLICATION->httpResponseCode(404);
		$arResult["tmpl"] = "/404.php";
	}
}

// Генерируем ссылки на детальный просмотр товарам
if(isset($arElements) and !empty($arElements)){
	// Получаем все разделы
	$arResult["SECTIONS"] = $APPLICATION->GetElementForField($arParams["COMPONENT"], 'categories', false, false);
	foreach ($arElements as $key => $value) {
		$sectionID = (is_array($arElements[$key]["SECTION"]))?$arElements[$key]["SECTION"][0]:$arElements[$key]["SECTION"];
		$arElements[$key]["DETAIL_PAGE_URL"] = strtr($arParams["SEF_URL_TEMPLATES"]["SEF_URL_DETAIL"], array("#SECTION|ALIAS#" => $arResult["SECTIONS"][$sectionID]["ALIAS"], "#ALIAS#" => $arElements[$key]["ALIAS"]));
	}
}else{
	// Если урл не пригодился и нет разделов либо товаров то отдаем 404
	if(!isset($arElement)){
		$arResult["tmpl"] = "/404.php";
		$APPLICATION->httpResponseCode(404);
	}
}
// -------------------  Навигация ------------------
// Получаем Ид компонента
$arResult["COMPONENT_ID"] = $APPLICATION->ComponentCount;

if(isset($arElements)){
	// Получаем активный элемент из $_GET
	$arResult["PAGENAVIGATION"]["ACTIVE"] = $FIREWALL->GetNumber("PAGEN_" . $arResult["COMPONENT_ID"]);
	if(!$arResult["PAGENAVIGATION"]["ACTIVE"])
		$arResult["PAGENAVIGATION"]["ACTIVE"] = 1;
	// Получаем количество элементов
	$arResult["PAGENAVIGATION"]["COUNT"] = count($arElements);

	// Проверяем есть ли необходимость в навигации
	if($arParams["PAGE_ELEMENT_COUNT"] < $arResult["PAGENAVIGATION"]["COUNT"]){
		$arResult["PAGENAVIGATION"]["SHOW"] = "Y";
		// Вычисляем количество страниц
		$arResult["PAGENAVIGATION"]["PAGES"] = $arResult["PAGENAVIGATION"]["COUNT"] / $arParams["PAGE_ELEMENT_COUNT"];
		$arElements = array_slice($arElements, (($arResult["PAGENAVIGATION"]["ACTIVE"] - 1) * $arParams["PAGE_ELEMENT_COUNT"]), $arParams["PAGE_ELEMENT_COUNT"], TRUE);
	}
}
if(isset($arEye)){
	$APPLICATION->AddEyeFunction($arEye);
}
