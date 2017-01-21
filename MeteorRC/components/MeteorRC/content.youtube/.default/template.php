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
//$APPLICATION->SetAdditionalCSS($templateFolder . "/style.css");
?>
<div class="video-home" id="component_<?=$APPLICATION->GetComponentId()?>">
<?foreach($arResult["ELEMENTS"] as $id => $arElement){?>
    <div class="titl"><i class="fa fa-video-camera" aria-hidden="true"></i> <?=$arElement["NAME"]?></div>
	<div class="video-wrap" id="videoID_<?=$id?>" style="background-image: url(<?=$FILE->GetUrlFile($arElement["DETAIL_PICTURE"], $arParams["IBLOCK"])?>);height:500px" onclick="playVideo(<?=$id?>, '<?=$arElement["VIDEO_ID"]?>')" style="background-image: url(<?=$arElement["DETAIL_PICTURE"]?>);">
	<i class="fa fa-youtube-play play" aria-hidden="true"></i>
	<iframe style="display:none;" width="100%" height="500" frameborder="0" allowfullscreen></iframe>
	</div>
<?}?>
</div>
<script type="text/javascript">
function playVideo(id, videoID) {
	$('#videoID_' + id + ' iframe').attr('src', 'https://www.youtube.com/embed/' + videoID + '?autoplay=1').show();
	$('#videoID_' + id + ' i').hide();
}
</script>