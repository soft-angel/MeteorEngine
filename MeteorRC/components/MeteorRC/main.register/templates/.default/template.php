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
<form autocomplete="off" id="meteorrc_reg" action="/" onsubmit="return RegisterForm()">

<label for="meteorrc_reg_name">E-mail:</label>
<div style="clear:both"></div>
<span class="input_left"><i class="fa fa-envelope"></i></span><input class="field_reg" id="meteorrc_reg_name" autocomplete="off" name="REGISTER[EMAIL]" type="email">
<div style="clear:both"></div>

<label for="meteorrc_reg_pass">Пароль:</label>
<div style="clear:both"></div>
<span class="input_left"><i class="fa fa-key"></i></span><input class="field_reg" id="meteorrc_reg_pass" autocomplete="off" name="REGISTER[PASSWORD]" type="password">
<div style="clear:both"></div>


<label for="meteorrc_captcha_reg_input">Текст на картинке:</label>
<div class="meteorrc_captcha_all">
<div class="meteorrc_captcha_left">
<img onclick="return CaptchaReload(this)" src="<?=$arResult["CAPTCHA"]?>" alt="captcha" id="meteorrc_reg_captcha"/>
</div>
<div class="meteorrc_captcha_right">
<div style="clear:both"></div>
<span class="input_left"><i class="fa fa-arrow-circle-o-right"></i></span><input type="text" name="REGISTER[CAPTCHA]" id="meteorrc_captcha_reg_input"/>
</div>
</div>

<div style="clear:both"></div>
<button class="button button_reg" type="submit">Регистрация <i class="fa fa-arrow-circle-right"></i></button>
<input autocomplete="off" value="Y" name="REGISTER[GO]" type="hidden">
</form>