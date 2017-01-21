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
$arParams["FILTER"]["USER_ID"] = $USER->GetID();
$arPayment = $APPLICATION->GetElementForField("shop", "payment", false, false);

$arParamsComponent = $APPLICATION->GetComponentsParams("shop", "basket");

if(!isset($arParams["SORT"]))
	$arParams["SORT"] = false;
// Получаем все разделы
$arResult["SECTIONS"] = $APPLICATION->GetElementForField($arParams["COMPONENT"], 'sections', false, false);

// -------------------  ЧПУ ------------------
$subject = $APPLICATION->GetArUrlPatch();

if(isset($arParams["SEF_URL_TEMPLATES"]["SEF_URL_DETAIL"])){
	$arPatternElement =  explode("/", $arParams["SEF_URL_TEMPLATES"]["SEF_URL_DETAIL"]);
	// Разбираем для элементов
	foreach (array_filter($arPatternElement) as $key => $value) {
		$otherParam = preg_replace ("/#(.*)#/" ,"", $value);
		$cleanParam = str_replace($otherParam, "", $value);
		if(isset($subject[$key]))
			$arUrlRewriteElement[str_replace("#", "", $cleanParam)] = str_replace($otherParam, "", $subject[$key]);
	}
}
if(isset($arParams["SEF_URL_TEMPLATES"]["SEF_URL_SECTION"])){
	$arPatternSection =  explode("/", $arParams["SEF_URL_TEMPLATES"]["SEF_URL_SECTION"]);
	// Разбираем для разделов
	foreach (array_filter($arPatternSection) as $key => $value) {
		$otherParam = preg_replace ("/#(.*)#/" ,"", $value);
		$cleanParam = str_replace($otherParam, "", $value);
		if(isset($subject[$key]))
			$arUrlRewriteSection[str_replace("#", "", $cleanParam)] = str_replace($otherParam, "", $subject[$key]);
	}
}
// Если определился алиас то это элемент детально
if(isset($arUrlRewriteElement["ID"]) and !empty($arUrlRewriteElement["ID"])){
	$arParams["FILTER"]["ID"] = $arUrlRewriteElement["ID"];
	$arResult["tmpl"] = "/element.php";
	$arElement = $APPLICATION->GetElementForField($arParams["COMPONENT"], $arParams["IBLOCK"], $arParams["FILTER"], true);
	if(isset($arElement["NAME"]))
		$APPLICATION->arrayParam["PageName"] = $arElement["NAME"];
	if(isset($arElement["META-DESCRIPTION"]))
		$APPLICATION->arrayParam["MetaDescription"] = $arElement["META-DESCRIPTION"];
	if(isset($arElement["META-KEYWORDS"]))
		$APPLICATION->arrayParam["MetaKeyWords"] = $arElement["META-KEYWORDS"];
	if(!empty($arElement)){
		$APPLICATION->httpResponseCode(200);
	}else{
		$APPLICATION->httpResponseCode(404);
		$arResult["tmpl"] = "/404.php";
	}

}elseif(isset($arUrlRewriteSection["SECTION_ALIAS"]) and !empty($arUrlRewriteSection["SECTION_ALIAS"])){
	// Если есть алиас раздела то это раздел
	$arResult["tmpl"] = "/section.php";
	$arSection = $APPLICATION->GetElementForField($arParams["COMPONENT"], 'sections', array("ALIAS" => $arUrlRewriteSection["SECTION_ALIAS"]), true, $arParams["SORT"]);
	if(isset($arSection["ID"])){
		$arParams["FILTER"]["SECTION"] = $arSection["ID"];
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
}elseif($arParams["SEF_URL_TEMPLATES"]["SEF_URL_PAGE"] == $APPLICATION->GetUrlPatch()){
	$APPLICATION->httpResponseCode(200);
	// Если урл это корень компонет а то это раздел со всеми элементами
	$arResult["tmpl"] = "/section.php";
	$arElements = $APPLICATION->GetElementForField($arParams["COMPONENT"], $arParams["IBLOCK"], $arParams["FILTER"], false, $arParams["SORT"]);
}else{
	// Если урл не пригодился и нет разделов либо товаров то отдаем 404
	if(isset($arParams["MESSAGE_404"]))
		echo $arParams["MESSAGE_404"];
	if(isset($arParams["SHOW_404"]))
		$APPLICATION->httpResponseCode(404);
}

// Генерируем ссылки на детальный просмотр товарам
if(isset($arElements))
	foreach ($arElements as $key => $value) {
		$arElements[$key]["DETAIL_PAGE_URL"] = strtr($arParams["SEF_URL_TEMPLATES"]["SEF_URL_DETAIL"], array("#ID#" => $arElements[$key]["ID"]));
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
?>
