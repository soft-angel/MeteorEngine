<?require_once($_SERVER["DOCUMENT_ROOT"] ."/MeteorRC/main/include/before.php");

global $APPLICATION;
global $USER;
$output = array();
if($USER->IsAdmin()){
	if($iblock = $FIREWALL->GetString("iblock")){
		if($id = $FIREWALL->GetNumber("id")){
			$output = "OK";
		}else{
			$id = $FIREWALL->GetNumber("key");
		}
		if(!is_numeric($id)){
			$output = array('error'=>'Не найден ID файла');
			die(json_encode($output));
		}
		if(!$FILE->DellFile($id, $iblock)){
			$output = array('error'=>'Ошибка удаления');
		}
		
	}
}else{
	$output = array('error'=>'Ошибка доступа, авторизуйтесь!');
}
echo json_encode($output);
