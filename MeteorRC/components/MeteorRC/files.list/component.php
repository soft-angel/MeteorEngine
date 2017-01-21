<?if(!defined("PROLOG_INCLUDED") || PROLOG_INCLUDED!==true) die();?>
<?
$listPatch = $_SERVER["DOCUMENT_ROOT"] . DS . $arParams["LIST_FOLDER"];
$FILE->fileList = array();
$FILE->GenerateFileList($listPatch);
$arResult["ELEMENTS"] =  $FILE->fileList;
$arResult["DESCRIPTIONS"] = $APPLICATION->GetFileArray($listPatch . DS . ".description.php");

if($arResult["ELEMENTS"]){
	foreach ($arResult["ELEMENTS"] as $id => $arElement) {
		$fileName = basename($arElement["patch"]);
		if($fileName == ".description.php"){
			unset($arResult["ELEMENTS"][$id]);
			continue;
		}
		$arResult["ELEMENTS"][$id]["patch"] = str_replace($_SERVER["DOCUMENT_ROOT"] . DS, "", $arElement["patch"]);
		if(isset($arResult["DESCRIPTIONS"][$fileName]))
			$arResult["ELEMENTS"][$id]["desc"] = $arResult["DESCRIPTIONS"][$fileName];
	}
}

if($arParams["SORT"] and is_array($arResult["ELEMENTS"])){
	$GLOBALS["SORT"] = $arParams["SORT"];
	uasort($arResult["ELEMENTS"], "SortForField");
	unset($GLOBALS["SORT"]);
}


$arEye = array(
	array(
		"ICON" => '<i class="fa fa-pencil"></i>',
		"LINK" => "/MeteorRC/admin/?component=files&amp;iblock=manager&amp;FOLDER=" . $arParams["LIST_FOLDER"]. "&amp;TYPE=" . "FOLDER",
	),
);
$APPLICATION->AddEyeFunction($arEye);
?>