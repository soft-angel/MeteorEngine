<?require_once($_SERVER["DOCUMENT_ROOT"]."/MeteorRC/main/include/before.php");?>
<?
if($USER->IsAdmin()){
	$UPDATE = new UPDATE;
	sleep(1);
	$startTime = (isset($_REQUEST['startTime']) and !empty($_REQUEST['startTime']))?$_REQUEST['startTime']:time();
	$step = isset($_REQUEST['step'])?(int)$_REQUEST['step']:0;
	$countStep = 4;

	if($step == 1){
		$stepName = "Подготовка к обовлению";
	}
	if($step == 2){
		$UPDATE->CurlDownload();
		$stepName = "Загрузка обновлений";
	}
	if($step == 3){
		$zip = new ZipArchive;
		if ($zip->open($_SERVER["DOCUMENT_ROOT"] . DS . $UPDATE->UpdateFile) === true) {
		    $zip->extractTo($_SERVER["DOCUMENT_ROOT"]);
		    $zip->close();
		} else {
		    APPLICATION::AddMessage2Log("Ошибка распаковки архива", 'Update');
		}
		//$APPLICATION->UnzipArchive($_SERVER["DOCUMENT_ROOT"] . DS . $UPDATE->UpdateFile, $_SERVER["DOCUMENT_ROOT"]);
		$stepName = "Распаковка обновлений";
	}
	if($step == 4){
		$UPDATE->Finish();
		$stepName = "Завершение обновлений";
	}

	$_SESSION["UPDATE_GO"] = $respond = array(
		"countStep" => $countStep,
		"step" => $step,
		"time" => time(),
		"startTime" => $startTime,
		"stepName" => $stepName,
		"currentVersion" => $APPLICATION->version,
	);

	if($countStep <= $step){
		// Уничтожаем сохраненные параметры запуска, так как все выполнилось
		unset($_SESSION["UPDATE_GO"]);
	}
	echo json_encode ($respond);
}
?>