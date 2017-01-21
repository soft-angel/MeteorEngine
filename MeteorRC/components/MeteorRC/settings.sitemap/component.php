<?if(!defined("PROLOG_INCLUDED") || PROLOG_INCLUDED!==true) die();?>
<?
$FILE = new FILE;
$FILE->GenerateFileList(PATCH_BACKUPS);
$arResult = $FILE->fileList;
foreach ($arResult as $id => $arBackup) {
	$arResult[$id]["SIZE_CONVERT"] = ConvertFileSize($arBackup['size'], 2);
	$arResult[$id]["NAME"] = basename($arBackup['patch']);
	$arResult[$id]["DATE"] = date('d.m.Y H:i:s', filectime($arBackup['patch']));
	$arResult[$id]["LINK"] = basename($arBackup['patch']);
}