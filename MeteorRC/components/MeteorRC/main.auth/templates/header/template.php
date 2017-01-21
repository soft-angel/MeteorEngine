<?if(!defined("PROLOG_INCLUDED") || PROLOG_INCLUDED!==true)die();
/** @var array $arParams */
/** @var array $arResult */
/** @global class $APPLICATION */
/** @global class $USER */
/** @global class $CONFIG */
/** @global class $CACHE */
/** @global class $FILE */
/** @var string $templateName - Имя шаблона */
/** @var string $templateFile - файл шаблона */
/** @var string $templateFolder - папка шаблона относительно корня сайта */
/** @var string $componentPath - папка компонента относительно корня сайта */


$APPLICATION->AddHeadScript($templateFolder . "/script.js");
if(!$USER->IsAuthorized()){
?>
<a href="#" id="reg" class="btn btn-default btn-dark">Войти<span>-- или --</span>Зарегистрироваться</a>
<div class="regwrap">
	<div class="row">
		<div class="col-md-6 regform">
			<div class="title-widget-bg">
				<div class="title-widget">Авторизация</div>
			</div>
			<form action="<?=$componentPath?>/auth_ajax.php"  onsubmit="return AuthorizeForm(this, '<?=$APPLICATION->GetComponentId()?>')" method="POST" class="margin-bottom-0" role="form">
				<div class="result"></div>
				<div class="form-group">
					<input type="text" class="form-control" name="AUTHORIZE[EMAIL]" value="<?=(isset($arResult["REQUEST"]["EMAIL"]))?$arResult["REQUEST"]["EMAIL"]:false?>" placeholder="Логин">
				</div>
				<div class="form-group">
					<input type="password" class="form-control" name="AUTHORIZE[PASSWORD]" value="<?=(isset($arResult["REQUEST"]["PASSWORD"]))?$arResult["REQUEST"]["PASSWORD"]:false?>" placeholder="Пароль">
				</div>
				<div class="form-group">
					<button class="btn btn-default btn-red btn-sm">
						<i class="default-login-<?=$APPLICATION->GetComponentId()?> fa fa-sign-in"></i>
						<i style="display: none;" class="load-login-<?=$APPLICATION->GetComponentId()?> fa fa-spinner fa-pulse fa-fw margin-bottom"></i>
						<span>Войти</span>
					</button>
				</div>
				<input autocomplete="off" value="Y" name="AUTHORIZE[GO]" type="hidden">
			</form>
		</div>
		<div class="col-md-6">
			<div class="title-widget-bg">
				<div class="title-widget">Регистрация</div>
			</div>
			<p>New User? By creating an account you be able to shop faster, be up to date on an order's status...</p>
			<a href="<?=$arParams["REGISTER_URL"]?>" class="btn btn-default btn-yellow">Зарегистрироваться</a>
		</div>
	</div>
</div>
<?}else{?>
<a href="?logout" id="reg" class="btn btn-default btn-dark"><i class="fa fa-sign-out"></i> Выйти</a>
<?}?>