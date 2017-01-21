<?require_once($_SERVER["DOCUMENT_ROOT"]."/MeteorRC/main/include/before.php");?>
<?
$FILE = new FILE;
if($USER->IsAdmin()){
	if($dellElement = $FIREWALL->GetString("FILE")){
		if(is_file($dellElement)){
			if(unlink($_SERVER["DOCUMENT_ROOT"] . $dellElement))
				die("OK");
		}else{
			ClearDir($_SERVER["DOCUMENT_ROOT"] . $dellElement);
				die("OK");
		}
	}
}
echo "Ошибка удаления";
?>