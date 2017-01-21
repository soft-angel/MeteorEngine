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
$APPLICATION->AddHeadScript("http://api-maps.yandex.ru/2.1/?load=package.full&lang=ru-RU", false);
//p($arResult);
$arParams['WIDTH'] = isset($arParams['WIDTH'])?$arParams['WIDTH']:'100%';
$arParams['HEIGHT'] = isset($arParams['HEIGHT'])?$arParams['HEIGHT']:'400px';
?>
<?if($USER->IsAdmin()){?>
<div style="width:<?=$arParams['WIDTH']?>;height:<?=$arParams['HEIGHT']?>" id="component_<?=$componentID?>">
<?}?>
<?if($arResult){?>
<div id="map_yandex_<?=$arResult['ID']?>" style="display: inline-block;position:relative;width:<?=$arParams['WIDTH']?>;height:<?=$arParams['HEIGHT']?>"></div>

<script type="text/javascript">
	ymaps.ready(YandexMapinit_<?=$arResult['ID']?>);
    function YandexMapinit_<?=$arResult['ID']?> () {
            // Создание экземпляра карты и его привязка к контейнеру с
            // заданным id ("map")
            	myMap_<?=$arResult['ID']?> = new ymaps.Map('map_yandex_<?=$arResult['ID']?>', {
                    // При инициализации карты, обязательно нужно указать
                    // ее центр и коэффициент масштабирования
                    center: [<?=$arResult['SETTINGS']['MAP_CENTER'][0]?>, <?=$arResult['SETTINGS']['MAP_CENTER'][1]?>],
                    zoom: <?=isset($arResult['SETTINGS']['MAP_ZOOM'])?$arResult['SETTINGS']['MAP_ZOOM']:13?>,
				<?if(isset($arResult['SETTINGS']['MAP_TYPE'])){?>
                	type: '<?=$arResult['SETTINGS']['MAP_TYPE']?>',
                <?}?>
                });
				<?
				if(count($arResult['PLACEMARK']) > 0)
				foreach ($arResult['PLACEMARK'] as $id => $value) {?>
				createPlacemark_<?=$arResult['ID']?>([<?=$value['coords'][0]?>, <?=$value['coords'][1]?>], '<?=$value['preset']?>', '<?=$value['iconCaption']?>', '<?=$value['balloonContent']?>');
				<?}?>
    }
		    // Создание метки.
		    function createPlacemark_<?=$arResult['ID']?>(coords, preset, iconCaption, balloonContent) {
		        var myGeoObject =  new ymaps.Placemark(coords, {
		            iconCaption: iconCaption,
		            balloonContent: balloonContent,
		        }, {
		            preset: preset,
		            draggable: true
		        });
		        myMap_<?=$arResult['ID']?>.geoObjects.add(myGeoObject);
		    }

</script>
<style>
#map_yandex_<?=$arResult['ID']?> {
    background: url(<?=$templateFolder?>/images/yandex.png) #fafafa center no-repeat;
    background-size: 25%;
}
</style>
<?}?>
<?if($USER->IsAdmin()){?>
</div>
<?}?>