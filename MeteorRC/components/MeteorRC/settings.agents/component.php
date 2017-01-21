<?if(!defined("PROLOG_INCLUDED") || PROLOG_INCLUDED!==true) die();?>
<?
if(!isset($arParams["FILTER"]))
	$arParams["FILTER"] = array("ACTIVE" => "Y");
// Получаем массив с кронами
$arCron = $APPLICATION->GetElementForField($arParams["COMPONENT"], $arParams["IBLOCK"], false, false);
//p($arCron);
// Если есть кроны
if($arCron){
	$save = false;
	// Перебираем кроны циклом
	foreach($arCron as $key => $agent){
		// Если пора опять запускать файл,
		$last_exec = isset($agent["LAST_EXEC"])?$agent["LAST_EXEC"]:0;
		if($agent["ACTIVE"] == "Y" and $last_exec < (time() - $agent["AGENT_INTERVAL"])){
			$save = true;
			// то обновляем тайм
			$arCron[$key]["LAST_EXEC"] = time();
			// Если файл крона существует
			if(file_exists($_SERVER["DOCUMENT_ROOT"] . $agent["FILE"])){
				// то инклюдим его
				include($_SERVER["DOCUMENT_ROOT"] . $agent["FILE"]);
			}else{
				// Если же нет на сервере, то выдаем ошибку и пишем ее в лог
				$APPLICATION->ShowError('Файл крона не найден :' . $agent["FILE"], 'Cron', true);
			}
		}
	}
	// и пишем новый тайм в бд
	if($save)
		$APPLICATION->SaveElementForIblock($arCron, $arParams["COMPONENT"], $arParams["IBLOCK"]);
}
?>