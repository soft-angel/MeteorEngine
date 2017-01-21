<?if(!defined("PROLOG_INCLUDED") || PROLOG_INCLUDED!==true)die();
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
//p($arParams);
$menuFileName = '.' . $arParams["ROOT_MENU_TYPE"] . '.menu.php';
$menuFolderPage = $APPLICATION->GetSectionFolder();
$menuPatchPage = $menuFolderPage . DS . $menuFileName;
$menuRoot = DR  . DS . $menuFileName;
if(file_exists($menuPatchPage)){
	$arFile = $menuPatchPage;
}else if(file_exists($menuRoot)){
	$arFile = $menuRoot;
}else{
	for($i=0;$menuFolderPage != DR;$i++){
		$arFile = $menuFolderPage . DS . $menuFileName;
		if(file_exists($arFile)){
			break;
		}
		$menuFolderPage = realpath($menuFolderPage . '/..');
		if($i > 10)break;
	}
}
$aMenuLinks = $APPLICATION->GetFileArray($arFile);
foreach ($aMenuLinks as $key => $menu){
	if(str_replace("/", "", $menu['URL']) == str_replace("/", "", $APPLICATION->GetCurDir())){
		$aMenuLinks[$key]["ACTIVE"] = "Y";
	}
}
$arResult = $aMenuLinks;


$APPLICATION->arMenuInclude[$menuFileName] = $arFile;

$arEye = array(
	array(
		"ICON" => '<i class="fa fa-pencil"></i>',
		"EDITOR" => $componentPath . "/editor_ajax.php?FILE=" . $arFile,
		"TITLE" => "Редактирование (" . basename($arFile) . ")",
	),	
);
$APPLICATION->AddEyeFunction($arEye);
?>