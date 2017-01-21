<?if(!defined("PROLOG_INCLUDED") || PROLOG_INCLUDED!==true)die();?>
<?
global $FIREWALL;
if(isset($_GET["logout"])){
	$USER->Logout();
	if(isset($arParams["LOGOUT_URL"]))
		$APPLICATION->LocalRedirect($arParams["LOGOUT_URL"]);
}
$arResult["REQUEST"] = $FIREWALL->GetArrayString('AUTHORIZE');
$arResult["ERROR"] = Array();
$arResult["MESSAGE"] = Array();
// p($arParams);
if(isset($arResult["REQUEST"]["GO"]) and !isset($arResult["REQUEST"]["EMAIL"])){
	$arResult["ERROR"][] = '<i class="fa fa-exclamation-circle"></i> Логин не указан!';
}else if(isset($arResult["REQUEST"]["GO"]) and !isset($arResult["REQUEST"]["PASSWORD"])){
	$arResult["ERROR"][] = '<i class="fa fa-exclamation-circle"></i> Пароль не указан!';
}
if(isset($arResult["REQUEST"]["GO"]) and $USER->IsAuthorized()){
	$arResult["ERROR"][] = '<i class="fa fa-exclamation-circle"></i> Вы уже авторизованы!';
}

if(empty($arResult["ERROR"]) and isset($arResult["REQUEST"]["GO"])){
	if($USER->ExistUser($arResult["REQUEST"]["EMAIL"])){
		if($USER->Login($arResult["REQUEST"]["EMAIL"], $arResult["REQUEST"]["PASSWORD"])){
			$arResult["MESSAGE"][] = '<script>setTimeout(location.reload(), 1000)</script><i class="fa fa-thumbs-o-up"></i> Вы успешно авторизованы';
		}else{
			$arResult["ERROR"][] = '<i class="fa fa-exclamation-circle"></i> Введенный пароль не правильный!';
		}
	}else{
		$arResult["ERROR"][] = '<i class="fa fa-exclamation-circle"></i> Логин не существует!';
	}
}
?>