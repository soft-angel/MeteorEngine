<?if(!defined("PROLOG_INCLUDED") || PROLOG_INCLUDED!==true) die();?>
<?
//$arParamsComponnts = $APPLICATION->GetComponentsParams($arParams["COMPONENT"], $arParams["IBLOCK"]);
//$arParams = (array_merge($arParams, $arParamsComponnts));
if(!isset($arParams["FILTER"]))
	$arParams["FILTER"] = array("ACTIVE" => "Y");
if(!isset($arParams["SORT"]))
	$arParams["SORT"] = false;

if($q = $arResult["SEARCH"] = $FIREWALL->GetString('q')){
	$arResult["ELEMENTS"] = array();

	foreach ($arParams["IBLOCKS"] as $iblock => $component) {

		$arComponentParams = $APPLICATION->GetComponentsParams($component, $iblock);
		$arPatternElement =  array_filter(explode("/", $arComponentParams["SEF_URL_TEMPLATES"]["SEF_URL_DETAIL"]));
		$arElements = $APPLICATION->GetElementForField($component, $iblock, $arParams["FILTER"], false, $arParams["SORT"]);
		foreach ($arElements as $id => $arElement) {
			$add = false;
			foreach ($arParams["SEARCH_FIELDS"] as $field) {
				if(isset($arElement[$field]) and stristr($arElement[$field], $_GET["q"]) !== FALSE){
					$add = true;
					$arResult["ELEMENTS"][$id] = $arElement;
					$arResult["ELEMENTS"][$id]["COMPONENT"] = $component;
					$arResult["ELEMENTS"][$id]["IBLOCK"] = $iblock;
					continue;
				}
			}
			if($add)
				foreach ($arComponentParams["FIELDS"] as $code => $field) {
					if($field["TYPE"] == "IMAGE" and isset($arElement[$code])){
						$arResult["ELEMENTS"][$id]["IMAGE"] = $arElement[$code];
						break;
					}
				if(!empty($arResult["ELEMENTS"]) and isset($arComponentParams["SEF_URL_TEMPLATES"]["SEF_URL_DETAIL"])){
			  		foreach ($arPatternElement as $key => $value) {
				        $otherParam = preg_replace ("/#(.*)#/" ,"", $value);
				        $cleanParam = str_replace($otherParam, "", $value);
				        $fulCleanParam = str_replace("#", "", $cleanParam);
				        $fieldParams = explode("|", $fulCleanParam);
				        if(count($fieldParams) > 1){
				          	$field = $fieldParams[0];
				          	$getField = $fieldParams[1];
				          	$arFieldParams = $arComponentParams["FIELDS"][$field];
				          	$arComponentElements = $APPLICATION->GetElementForID($component, $arFieldParams["BD"], $arElement[$field]);
				          	$arUrlRewrite[$cleanParam] = $arComponentElements[$getField];
				        }elseif(isset($arElement[$fulCleanParam]))
				         	$arUrlRewrite[$cleanParam] = $arElement[$fulCleanParam];
				    }
			        $arResult["ELEMENTS"][$id]["DETAIL_PAGE_URL"] = strtr($arComponentParams["SEF_URL_TEMPLATES"]["SEF_URL_DETAIL"], $arUrlRewrite);
			   		}
				}
			
		}
		unset($arElements);
	}
	foreach ($arResult["ELEMENTS"] as $id => $arElement) {
		//$arResult["ELEMENTS"][$key]["DETAIL_PAGE_URL"] = strtr($arParams["SEF_URL_TEMPLATES"]["SEF_URL_DETAIL"], array("#SECTION_ALIAS#" => $arResult["SECTIONS"][$arResult["ELEMENTS"][$key]["SECTION"]]["ALIAS"], "#ALIAS#" => $arResult["ELEMENTS"][$key]["ALIAS"]));

	}

	$arResult["SEARCH_COUNT"] = count($arResult["ELEMENTS"]);


	// -------------------  Навигация ------------------
	// Получаем Ид компонента
	$arResult["COMPONENT_ID"] = $APPLICATION->ComponentCount;

	if(isset($arResult["ELEMENTS"])){
		// Получаем активный элемент из $_GET
		$arResult["PAGENAVIGATION"]["ACTIVE"] = $FIREWALL->GetNumber("PAGEN_" . $arResult["COMPONENT_ID"]);
		if(!$arResult["PAGENAVIGATION"]["ACTIVE"])
			$arResult["PAGENAVIGATION"]["ACTIVE"] = 1;
		// Получаем количество элементов
		$arResult["PAGENAVIGATION"]["COUNT"] = count($arResult["ELEMENTS"]);

		// Проверяем есть ли необходимость в навигации
		if($arParams["PAGE_ELEMENT_COUNT"] < $arResult["PAGENAVIGATION"]["COUNT"]){
			$arResult["PAGENAVIGATION"]["SHOW"] = "Y";
			// Вычисляем количество страниц
			$arResult["PAGENAVIGATION"]["PAGES"] = $arResult["PAGENAVIGATION"]["COUNT"] / $arParams["PAGE_ELEMENT_COUNT"];
			$arResult["ELEMENTS"] = array_slice($arResult["ELEMENTS"], (($arResult["PAGENAVIGATION"]["ACTIVE"] - 1) * $arParams["PAGE_ELEMENT_COUNT"]), $arParams["PAGE_ELEMENT_COUNT"], TRUE);
		}
	}
}
?>