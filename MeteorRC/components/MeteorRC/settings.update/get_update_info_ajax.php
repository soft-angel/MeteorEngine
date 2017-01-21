<?require_once($_SERVER["DOCUMENT_ROOT"]."/MeteorRC/main/include/before.php");?>
<?
if($USER->IsAdmin()){
	$UPDATE = new UPDATE;
	if(!$_REQUEST["UPDATE"]){
		echo $UPDATE->GetUpdateInfo();
	}
	if($_REQUEST["UPDATE"]){
		$UPDATE->CurlDownload();
		$APPLICATION->UnzipArchive($_SERVER["DOCUMENT_ROOT"] . DS . $UPDATE->UpdateFile, $_SERVER["DOCUMENT_ROOT"]);
		$UPDATE->Finish();
	}
?>
<?}?>
