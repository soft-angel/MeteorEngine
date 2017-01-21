<?require_once($_SERVER["DOCUMENT_ROOT"]."/MeteorRC/main/include/before.php");
if($USER->IsAdmin() and $arSave = $FIREWALL->GetArrayString("SAVE")){
	$arSave = MergeArrays($CONFIG, $arSave);
	$APPLICATION->ArrayWriter($arSave, CONFIG_FILE);
	$arRespond["SUCCESS"] = "Успешно сохранено";
}else{
	$arRespond["ERROR"] = "Ошибка доступа!";
	
}
echo json_encode($arRespond);