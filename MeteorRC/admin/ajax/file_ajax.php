<?
require_once($_SERVER["DOCUMENT_ROOT"]."/MeteorRC/main/include/before.php");
if(isset($_FILES["FILE"])){
	$FILE = new FILE;
	if(!isset($_REQUEST["IBLOCK"])){
		echo json_encode(array('ERROR' => 'Компонент не указан!'));
		exit;
	}
	$FileID = $FILE->SaveFile($_FILES["FILE"], $_REQUEST["IBLOCK"]);
	if(is_numeric($FileID)){
		$FilePatch = $FILE->GetUrlFile($FileID, $_REQUEST["IBLOCK"]);
		$img = $_SERVER["DOCUMENT_ROOT"] . $FilePatch;
		
		if(isset($_REQUEST["ID"])){
			$FILE->DellFile($_REQUEST["ID"], $_REQUEST["IBLOCK"]);
		}
		echo json_encode(array('HREF' => $FilePatch, 'ID' => $FileID));
	}else{
		echo json_encode(array('ERROR' => $FileID));
		exit;
	}
}elseif(isset($_REQUEST["DELETE_FILE_ID"]) and isset($_REQUEST["IBLOCK"])){
	$FILE->DellFile((int)$_REQUEST["DELETE_FILE_ID"], $_REQUEST["IBLOCK"]);
}else{
	echo json_encode(array('ERROR' => 'Файл не найден!'));
}
?>