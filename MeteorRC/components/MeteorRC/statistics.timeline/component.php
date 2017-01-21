<?if(!defined("PROLOG_INCLUDED") || PROLOG_INCLUDED!==true) die();?>
<?

$arResult = array_reverse($APPLICATION->GetElementForField($arParams["COMPONENT"], $arParams["IBLOCK"], false, false));
foreach ($arResult as $id => $arElement) {
	if(isset($arElement["USER_ID"])){
		$arResult[$id]["USER"] = $APPLICATION->GetElementForID("users", "users", $arElement["USER_ID"]);
	}
	if(isset($arElement["ELEMENT_ID"])){
		$arResult[$id]["ELEMENT_BD"] = $APPLICATION->GetElementForID($arElement["COMPONENT"], $arElement["IBLOCK"], $arElement["ELEMENT_ID"]);
	}
	// Полчаем параметры компонента
	if(!isset($arParams[$arElement["COMPONENT"]][$arElement["IBLOCK"]])){
			$arParams[$arElement["COMPONENT"]][$arElement["IBLOCK"]] = $APPLICATION->GetComponentsParams($arElement["COMPONENT"], $arElement["IBLOCK"]);
	}
}