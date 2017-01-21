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
if(isset($arResult["ACTIVE"]) and $arResult["ACTIVE"] == "Y"){
?>
<ul class="social-icons list-soc">
<?if(isset($arResult["VK"])){?>
	<li><a rel="nofollow" target="_blank" href="<?=$arResult["VK"]?>"><i class="fa fa-vk"></i></a></li>
<?}?>
<?if(isset($arResult["FACEBOOK"])){?>
	<li><a rel="nofollow" target="_blank" href="<?=$arResult["FACEBOOK"]?>"><i class="fa fa-facebook"></i></a></li>
<?}?>
<?if(isset($arResult["TWITTER"])){?>
	<li><a rel="nofollow" target="_blank" href="<?=$arResult["TWITTER"]?>"><i class="fa fa-twitter"></i></a></li>
<?}?>
<?if(isset($arResult["INSTAGRAMM"])){?>
	<li><a rel="nofollow" target="_blank" href="<?=$arResult["INSTAGRAMM"]?>"><i class="fa fa-instagram"></i></a></li>
<?}?>
<?if(isset($arResult["GOOGLE+"])){?>
	<li><a rel="nofollow" target="_blank" href="<?=$arResult["GOOGLE+"]?>"><i class="fa fa-google-plus"></i></a></li>
<?}?>
</ul>
<?}?>