<?if(!defined("PROLOG_INCLUDED") || PROLOG_INCLUDED!==true)die();?>
<?
global $APPLICATION;
global $USER;
global $FIREWALL;
$arResult["CAPTCHA"] = "/MeteorRC/main/captcha_ajax.php";
$arResult["REQUEST"] = $FIREWALL->GetArrayString('REGISTER');
$arResult["ERROR"] = Array();
$arResult["MESSAGE"] = Array();

$error = false;
if($arResult["REQUEST"]["GO"] and !$arResult["REQUEST"]["EMAIL"]){
	$arResult["ERROR"][] = '<i class="fa fa-exclamation-circle"></i> E-mail не указан!';
}else if($arResult["REQUEST"]["GO"] and !$APPLICATION->IsEmail($arResult["REQUEST"]["EMAIL"])){
	$arResult["ERROR"][] = '<i class="fa fa-exclamation-circle"></i> E-mail указан неверно!';
}
if($arResult["REQUEST"]["GO"] and !$arResult["REQUEST"]["PASSWORD"]){
	$arResult["ERROR"][] = '<i class="fa fa-exclamation-circle"></i> Пароль не указан!';
}
if($arResult["REQUEST"]["GO"] and !$arResult["REQUEST"]["CAPTCHA"]){
	$arResult["ERROR"][] = '<i class="fa fa-exclamation-circle"></i> Не указан код с картинки!';
}
if(empty($arResult["ERROR"]) and $arResult["REQUEST"]["GO"]){
	$UserFile =  FOLDER_USERS_BD . $arResult["REQUEST"]["EMAIL"] . SFX_BD;
	if($arParams["CAPTCHA"] == "Y" and $APPLICATION->IfCaptcha($arResult["REQUEST"]["CAPTCHA"])){
	if(!file_exists ($UserFile)){
		$APPLICATION->ArrayWriter(
			Array(
			"ACTIVE" => "Y",
			"EMAIL" => $arResult["REQUEST"]["EMAIL"],
			"PASSWORD" => $USER->Hash($arResult["REQUEST"]["PASSWORD"]),
			"USER_GROUP" => "DEFAULT",
			"BILL" => $APPLICATION->RndStr(6),
			"REGISTRATION_DATE" => time()
			),
			$UserFile
		);
		$arResult["MESSAGE"][] = '<i class="fa fa-thumbs-o-up"></i> Регистрация прошла успешно';
	}else{
		$arResult["ERROR"][] = '<i class="fa fa-exclamation-circle"></i> Этот E-mail уже занят!';
	}
	}else{
		$arResult["ERROR"][] = '<i class="fa fa-exclamation-circle"></i> Неверно введен код с картинки!';
	}
}

// $arResult["REQUEST"]["PASSWORD"]
// $arResult["REQUEST"]["CAPTCHA"]
?>