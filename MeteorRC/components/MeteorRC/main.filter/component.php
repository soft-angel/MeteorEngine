<?if(!defined("PROLOG_INCLUDED") || PROLOG_INCLUDED!==true) die();?>
<?
$arParamsComponent = $APPLICATION->GetComponentsParams($arParams["COMPONENT"], $arParams["IBLOCK"]);

if(!isset($arParams["FIELDS"]))
	$arParams["FIELDS"] = array();

if($arSetValue = $FIREWALL->GetArrayString($arParams['FILTER_NAME'])){
	$_SESSION['FILTER'][$arParams['FILTER_NAME']] = $arSetValue;
}

if($FIREWALL->GetString('filter_clear') == "Y"){
	unset($_SESSION['FILTER'][$arParams['FILTER_NAME']]);
}

foreach ($arParams['FIELDS'] as $field) {
	$arResult['FIELDS'][$field] = $arParamsComponent["FIELDS"][$field];

	$arFassetField = $APPLICATION->GetFileArray(FOLDER_BD . $arParams["COMPONENT"] . DS . "fasset" . DS . $arParams["IBLOCK"] . DS . $field . SFX_BD);
	foreach ($arFassetField as $key => $value) {
		$arResult['FIELDS'][$field]['COUNTS'][$key] = count($value);
	}

	$arResult['FIELDS'][$field]['VALUES'] = array_keys($arResult['FIELDS'][$field]['COUNTS']);

	if($arParamsComponent["FIELDS"][$field]['TYPE'] == 'PRICE' or $arParamsComponent["FIELDS"][$field]['TYPE'] == 'INT'){
		$arResult['FIELDS'][$field]['VALUE_MIN'] = min($arResult['FIELDS'][$field]['VALUES']);
		$arResult['FIELDS'][$field]['VALUE_MAX'] = max($arResult['FIELDS'][$field]['VALUES']);
		if(isset($_SESSION['FILTER'][$arParams['FILTER_NAME']]['<' . $field])){
			$arResult['FIELDS'][$field]['SET_VALUE_MAX'] = $_SESSION['FILTER'][$arParams['FILTER_NAME']]['<' . $field];
		}else{
			$arResult['FIELDS'][$field]['SET_VALUE_MAX'] = $arResult['FIELDS'][$field]['VALUE_MAX'];
		}
		if(isset($_SESSION['FILTER'][$arParams['FILTER_NAME']]['>' . $field])){
			$arResult['FIELDS'][$field]['SET_VALUE_MIN'] = $_SESSION['FILTER'][$arParams['FILTER_NAME']]['>' . $field];
		}else{
			$arResult['FIELDS'][$field]['SET_VALUE_MIN'] = $arResult['FIELDS'][$field]['VALUE_MIN'];
		}
	}


}


$arEye = array(
	array(
		"ICON" => '<i class="fa fa-pencil"></i>',
		"LINK" => "/MeteorRC/admin/?component=" . $arParams["COMPONENT"] . "&amp;iblock=" . $arParams["IBLOCK"],
	),
);
//$APPLICATION->AddEyeFunction($arEye);
