<?require_once($_SERVER["DOCUMENT_ROOT"]."/MeteorRC/main/include/before.php");?>
<?
if($arPost = $FIREWALL->GetArrayString("SEND")){
	$CEvent = new CEvent;
	if(!$CEvent->Send("BUY_ONE_CLICK", $arPost)){
		$json["ERROR"] = 'Сообщение не отправлено! Вы можете ускорить обработку заказа позвонив нам или написав на электронную почту';
	}else{
		$json["SUCCESS"] = "Заявка успешно отправлена, заказ обрабатывается.<br>Менеджер свяжется с Вами для уточнения деталей заказа.";
	}
}else{
	$json["ERROR"] = 'Заполните поля';
}
die(json_encode($json));