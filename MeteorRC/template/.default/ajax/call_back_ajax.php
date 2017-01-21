<?require_once($_SERVER["DOCUMENT_ROOT"]."/MeteorRC/main/include/before.php");?>
<?
if($arPost = $FIREWALL->GetArrayString("SEND")){
	$CEvent = new CEvent;
	if(!$CEvent->Send("CALL_BACK", $arPost)){
		$json["ERROR"] = 'Заявка не отправлена! Вы можете ускорить обработку позвонив нам или написав на электронную почту';
	}else{
		$json["SUCCESS"] = "Заявка успешно отправлена, мы свяжемся с Вами в ближайшее время";
	}
}else{
	$json["ERROR"] = 'Заполните поля';
}
die(json_encode($json));