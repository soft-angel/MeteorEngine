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

$componentID = $APPLICATION->GetComponentId();
$APPLICATION->AddHeadScript("http://maps.api.2gis.ru/2.0/loader.js", false);
//p($arResult);
$arParams['WIDTH'] = isset($arParams['WIDTH'])?$arParams['WIDTH']:'100%';
$arParams['HEIGHT'] = isset($arParams['HEIGHT'])?$arParams['HEIGHT']:'400px';
?>
<?if($USER->IsAdmin()){?>
<div style="width:<?=$arParams['WIDTH']?>;height:<?=$arParams['HEIGHT']?>" id="component_<?=$componentID?>">
<?}?>
<?if($arResult){?>
<div id="map2gis_<?=$arResult['ID']?>" style="display: inline-block;position:relative;width:<?=$arParams['WIDTH']?>;height:<?=$arParams['HEIGHT']?>"></div>

<script type="text/javascript">
DG.then(function() {
	myMap2Gis = DG.map('map2gis_<?=$arResult['ID']?>', {
<?if(isset($arResult['SETTINGS']['MAP_CENTER'][0]) and isset($arResult['SETTINGS']['MAP_CENTER'][1])){?>
		center: [<?=$arResult['SETTINGS']['MAP_CENTER'][0]?>, <?=$arResult['SETTINGS']['MAP_CENTER'][1]?>],
<?}else{?>
		center: [55.76, 37.64],
<?}?>
		zoom: <?=isset($arResult['SETTINGS']['MAP_ZOOM'])?$arResult['SETTINGS']['MAP_ZOOM']:10?>,
		geoclicker: true
	});
<?if(isset($arResult['PLACEMARK']))
	foreach ($arResult['PLACEMARK'] as $id => $value) {
	?>
	var coords = [<?=$value['coords'][0]?>, <?=$value['coords'][1]?>];
	DG.marker(coords).addTo(myMap2Gis).bindPopup('<?=$value['balloonContent']?>');
<?}?>
});
</script>
<style>
#map2gis_<?=$arResult['ID']?> {
    background: url(<?=$templateFolder?>/images/2gis.png) #fafafa center no-repeat;
    background-size: 25%;
}
</style>
<?}?>
<?if($USER->IsAdmin()){?>
</div>
<?}?>