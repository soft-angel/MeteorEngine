<?
require_once($_SERVER["DOCUMENT_ROOT"]."/MeteorRC/main/include/before.php");
if($USER->IsAdmin()){
	// Удаление старого файла
	if(isset($_REQUEST["ID"]) and isset($_REQUEST["IBLOCK"])){
		$FILE->DellFile((int)$_REQUEST["ID"], $_REQUEST["IBLOCK"]);
	}

	// Добавление нового файла
	if(isset($_FILES["IMAGE"])){
		if(!isset($_REQUEST["IBLOCK"])){
			echo json_encode(array('ERROR' => 'Инфоблок не указан!'));
			exit;
		}
		$ImageID = $FILE->SaveImage($_FILES["IMAGE"], $_REQUEST["IBLOCK"]);
		if(is_numeric($ImageID)){
			$imagePatch = $FILE->lastSaveFileUri;
			$img = $_SERVER["DOCUMENT_ROOT"] . $imagePatch;
			if(isset($_REQUEST["MAX_WIDTH"]) and $_REQUEST["MAX_WIDTH"] > 0){
				$quality = isset($_REQUEST["QUALITY"])?$_REQUEST["QUALITY"]:80;
				$FILE->ImageResize($img, $_REQUEST["MAX_WIDTH"], false, $quality);
			}
			echo json_encode(array('SRC' => $imagePatch, 'ID' => $ImageID));
		}else{
			echo json_encode(array('ERROR' => $ImageID));
			exit;
		}
	}
}else{
	echo json_encode(array('ERROR' => 'Ошибка доступа'));
}
?>