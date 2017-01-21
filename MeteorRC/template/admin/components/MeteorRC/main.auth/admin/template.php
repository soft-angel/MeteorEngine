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
?>
	    <!-- begin login -->
        <div class="login bg-black animated fadeInDown">
            <!-- begin brand -->
            <div class="login-header">
                <div class="brand">
                    <span class="logo"></span>
                    <small>Не смотри что мускул нет, я духом сильный.</small>
                </div>
                <div class="icon">
                    <i class="fa fa-sign-in"></i>
                </div>
            </div>
            <!-- end brand -->
            <div class="login-content">
            	<?if($arResult["ERROR"]){?>
            	<div class="alert alert-danger" role="alert">
            		<?foreach ($arResult["ERROR"] as $key => $value) {?><p><?=$value?></p><?}?>
                    <?if(!$USER->IsAdmin() and $USER->IsAuthorized()){?>
                    <i class="fa fa-exclamation-circle"></i> Доступ запрещен!
                    <?}?>
     			</div>
     			<?}?>
                <?if($arResult["MESSAGE"]){?>
                <div class="alert alert-success" role="alert">
                    <?foreach ($arResult["MESSAGE"] as $key => $value) {?><p><?=$value?></p><?}?>
                </div>
                <?}?>
                <form action="" method="POST" class="margin-bottom-0">
                	<input name="AUTHORIZE[GO]" type="hidden" value="Y" />
                    <div class="form-group m-b-20">
                        <input name="AUTHORIZE[EMAIL]" value="<?=(isset($arResult["REQUEST"]["EMAIL"]))?$arResult["REQUEST"]["EMAIL"]:false?>" type="text" class="form-control input-lg" placeholder="Логин" />
                    </div>
                    <div class="form-group m-b-20">
                        <input name="AUTHORIZE[PASSWORD]" value="<?=(isset($arResult["REQUEST"]["PASSWORD"]))?$arResult["REQUEST"]["PASSWORD"]:false?>" type="password" class="form-control input-lg" placeholder="Пароль" />
                    </div>
                    <div class="login-buttons">
                        <button type="submit" class="btn btn-success btn-block btn-lg">Войти</button>
                    </div>
                </form>
            </div>
        </div>
        <!-- end login -->