<?if(!defined("PROLOG_INCLUDED") || PROLOG_INCLUDED!==true)die();?>
<?
 // p($arParams);
global $APPLICATION;
global $USER;
global $CONFIG;
if(isset($arParams["PATH"])){
	$arResult["FILE"] = $_SERVER["DOCUMENT_ROOT"] . $arParams["PATH"];
}else{
	if(!isset($arParams["AREA_FILE_SHOW"]))
		$arParams["AREA_FILE_SHOW"] = "section";
	$arResult["THIS_DIR"] = $APPLICATION->GetSectionFolder();
	$arResult["FILE_NAME"] = $arParams["AREA_FILE_SHOW"] . "." . $arParams["AREA_FILE_SUFFIX"] . SFX_BD;
	$arResult["FILE"] = $arResult["THIS_DIR"] . DS . $arResult["FILE_NAME"];
	if($arParams["AREA_FILE_RECURSIVE"] == "Y" and !file_exists($arResult["FILE"])){
		for($i=0;$arResult["THIS_DIR"] !== DR;$i++){
			$arResult["THIS_DIR"] = realpath($arResult["THIS_DIR"] . '/../');
			$arResult["FILE"] = $arResult["THIS_DIR"] . DS . $arResult["FILE_NAME"];
			if(file_exists($arResult["FILE"]) or $i > 10){
				break;
			}
		}
	}

}
if(!file_exists($arResult["FILE"])){
	$this->AddMessage2Log("Подключаемый файл не найден!", $component_name);
	file_put_contents($arResult["FILE"], "Включите визуальное редактирование и кликните на облать, для изменения содержимого");	
}
$arEye = array(
	array(
		"ICON" => '<i class="fa fa-pencil"></i>',
		"EDITOR" => $componentPath . "/editor_ajax.php?FILE=" . $arResult["FILE"]. "&amp;TYPE=" . $arParams["TYPE"],
		"TITLE" => "Редактирование (" . basename($arResult["FILE"]) . ")",
	),	
	//array(
	//	"ICON" => '<i class="fa fa-cogs"></i>',
	//	"EDITOR" => "",
	//	"TITLE" => "Настройки " . basename($arResult["FILE"]),
	//),
);
$APPLICATION->AddEyeFunction($arEye);
?>