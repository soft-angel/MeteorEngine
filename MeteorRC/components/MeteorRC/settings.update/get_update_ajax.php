<?require_once($_SERVER["DOCUMENT_ROOT"]."/MeteorRC/main/include/before.php");?>
<?
if($USER->IsAdmin()){
	$UPDATE = new UPDATE;
	$NewVersion = $UPDATE->GetUpdateVersion();

	if($_POST["GET"] == "Y"){
		echo $NewVersion;
	}else{
		if($NewVersion != $APPLICATION->version){
			echo $NewVersion;
		}
	}
}
?>
