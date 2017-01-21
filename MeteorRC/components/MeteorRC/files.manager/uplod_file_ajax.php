<?require_once($_SERVER["DOCUMENT_ROOT"]."/MeteorRC/main/include/before.php");?>
<?
if($USER->IsAdmin()){
	if (empty($_FILES['FILES'])) {
	    echo json_encode(array('error' => 'No files found for upload.')); 
	    return;
	}
	$savePath = empty($_POST['patch'])?false:$_POST['patch'];
	$arFiles = $_FILES['FILES'];
	$success = null;
	$paths= array();
	$filenames = $arFiles['name'];

	for($i=0; $i < count($filenames); $i++){
	    $target = $_SERVER["DOCUMENT_ROOT"] . $savePath . DS . $filenames[$i];
		if(!file_exists($_SERVER["DOCUMENT_ROOT"] . $savePath))
			mkdir($savePath, 0777, true);
	    if(move_uploaded_file($arFiles['tmp_name'][$i], $target)) {
	        $success = true;
	        $paths[] = $target;
	    } else {
	        $success = false;
	        break;
	    }
	}
	if ($success === true) {
	    
	    $output = array();
	} elseif ($success === false) {
	    $output = array('error'=>'Error while uploading images. Contact the system administrator');
	    // delete any uploaded files
	    foreach ($paths as $file) {
	        unlink($file);
	    }
	} else {
	    $output = array('error'=>'No files were processed.');
	}

	echo json_encode($output);
}
?>