<?require_once($_SERVER["DOCUMENT_ROOT"]."/MeteorRC/main/include/before.php");?>
<?
if($USER->IsAdmin()){
	if(!$FIREWALL->GetString("YANDEX_MAP_ID")){
		$bd_map = FOLDER_BD . 'map/yandex/' . $FIREWALL->GetString("MAP_ID") . SFX_BD;
		$arResult = $APPLICATION->GetFileArray($bd_map);
		//p($arResult);
?>
<div id="mapYandexConstruct">
<form id="menuYandexConstruct" class="col-md-4 col-sm-6 col-xs-8">
<h3><i class="fa fa-map-marker" aria-hidden="true"></i> Редактирование метки</h3>
	<div class="row">
		<div class="col-sm-6">
			<div class="form-group">
				<div class="input-group">
					<span class="input-group-addon"><i class="fa fa-map-marker"></i></span>
					<input type="text" name="yandex_icon_caption" class="form-control input-sm" placeholder="Название метки">
				</div>
			</div>
		</div>
		<div class="col-sm-6">
			<div class="form-group">
				<div class="input-group">
					<span class="input-group-addon"><i class="fa fa-mouse-pointer"></i></span>
					<input type="text" name="yandex_hint_text" class="form-control input-sm" placeholder="Подсказка">
				</div>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-sm-12">
			<div class="form-group">
				<div class="input-group">
					<span class="input-group-addon"><i class="fa fa-align-left"></i></span>
					<textarea height="120px" name="yandex_balloon_text" class="form-control input-sm" placeholder="Содеримое метки"></textarea>
				</div>
			</div>
		</div>
	</div>

	<div class="col-sm-12 text-center">
	<div class="btn-group" role="group">
	<button type="button" id="save_placemark" class="btn btn-sm btn-success"><span class="fa fa-floppy-o"></span> Сохранить метку</button>
	<button type="button" id="delete_placemark" class="btn btn-sm btn-danger"><span class="fa fa-trash"></span> Удалить метку</button>
	</div>
	</div>
</form>
</div>



<div style="clear:both"></div>
<button onclick="SaveMap()" class="btn_admin button_save">Cохранить <i class="fa fa-floppy-o"></i></button>

<script type="text/javascript">
		$.getScript( "http://api-maps.yandex.ru/2.1/?load=package.full&lang=ru-RU" ).done(function( script, textStatus ) {
			// Как только будет загружен API и готов DOM, выполняем инициализацию
			ymaps.ready(init);
		});
        var myPlacemark = [];
        var myMap;
        var coords_edit;
        function init () {
            // Создание экземпляра карты и его привязка к контейнеру с

            myMap = new ymaps.Map('mapYandexConstruct', {
                    // При инициализации карты, обязательно нужно указать
                    // ее центр и коэффициент масштабирования
            	<?if(isset($arResult['SETTINGS']['MAP_CENTER'][0]) and isset($arResult['SETTINGS']['MAP_CENTER'][1])){?>
                    center: [<?=$arResult['SETTINGS']['MAP_CENTER'][0]?>, <?=$arResult['SETTINGS']['MAP_CENTER'][1]?>],
                <?}else{?>
					center: [55.76, 37.64],
                <?}?>
				<?if(isset($arResult['SETTINGS']['MAP_TYPE'])){?>
                	type: '<?=$arResult['SETTINGS']['MAP_TYPE']?>',
                <?}?>
                    zoom: <?=isset($arResult['SETTINGS']['MAP_ZOOM'])?$arResult['SETTINGS']['MAP_ZOOM']:10?>,
                });
            	<?
				if(!isset($arResult['SETTINGS']['MAP_CENTER'][0]) or !isset($arResult['SETTINGS']['MAP_CENTER'][1])){?>
				SetMapCityUser ();
				<?
				}
				if(isset($arResult['PLACEMARK']))
					foreach ($arResult['PLACEMARK'] as $id => $value) {
				?>
				var coords = [<?=$value['coords'][0]?>, <?=$value['coords'][1]?>];
				myPlacemark[coords] = createPlacemark(coords, '<?=$value['preset']?>', '<?=$value['iconCaption']?>', '<?=$value['balloonContent']?>');
				myMap.geoObjects.add(myPlacemark[coords]);
				createEditEvent(coords);
				<?}?>

		    // Слушаем клик на карте.
		    myMap.events.add('click', function (e) {
		        var coords = e.get('coords');
		        coords_edit = coords;
		        // Если метка уже создана – просто передвигаем ее.
		        if (myPlacemark[coords]) {
		            //myPlacemark[coords].geometry.setCoordinates(coords);
		            return true;
		        }
		        else {
		        	//alert(coords);
		            myPlacemark[coords] = createPlacemark(coords);
		            createEditEvent(coords);
		            myMap.geoObjects.add(myPlacemark[coords]);
		            // Слушаем событие окончания перетаскивания на метке.
		            myPlacemark[coords].events.add('dragend', function () {
		                getAddress(myPlacemark[coords].geometry.getCoordinates());
		            });
		        }
		        getAddress(coords);
		    	ShowEdit(coords, e);
		    });
    	}
    	function SetMapCityUser (){
			ymaps.geolocation.get({
			    provider: 'yandex',
			    mapStateAutoApply: true,
			}).then(function (result) {
			     myMap.geoObjects.add(result.geoObjects);
			});
    	}
		    // Определяем адрес по координатам (обратное геокодирование).
		    function getAddress(coords) {
		        myPlacemark[coords].properties.set('iconCaption', 'поиск...');
		        ymaps.geocode(coords).then(function (res) {
		            var firstGeoObject = res.geoObjects.get(0);
		            var geoName = firstGeoObject.properties.get('name');
		            var geoText = firstGeoObject.properties.get('text');
		            myPlacemark[coords].properties
		                .set({
		                    iconCaption: geoName,
		                    balloonContent: geoText
		                });
		                $('#menuYandexConstruct input[name="yandex_icon_caption"]').val(geoName);
		                $('#menuYandexConstruct textarea[name="yandex_balloon_text"]').val(geoText);
		        });

		    }
		    // Создание метки.
		    function createPlacemark(coords, preset = 'islands#violetDotIconWithCaption', iconCaption = 'поиск...', balloonContent = null) {
		        return new ymaps.Placemark(coords, {
		            iconCaption: iconCaption,
		            balloonContent: balloonContent,
		        }, {
		            preset: preset,
		            draggable: true
		        });
		    }
    		function ShowEdit(coords, e) {
    				myMap.setCenter(coords, myMap.getZoom(), {duration:1000});
			    	$('#menuYandexConstruct').css('right', 0);
			        // Заполняем поля контекстного меню текущими значениями свойств метки.
			        $('#menuYandexConstruct input[name="yandex_icon_caption"]').val(myPlacemark[coords].properties.get('iconCaption'));
			        $('#menuYandexConstruct input[name="yandex_hint_text"]').val(myPlacemark[coords].properties.get('hintContent'));
			        $('#menuYandexConstruct textarea[name="yandex_balloon_text"]').val(myPlacemark[coords].properties.get('balloonContent'));

			        // При нажатии на кнопку "Сохранить" изменяем свойства метки
			        // значениями, введенными в форме контекстного меню.
			        $('#save_placemark').click(function () {
				                myPlacemark[coords_edit].properties.set({
				                    iconCaption: $('input[name="yandex_icon_caption"]').val(),
				                    hintContent: $('input[name="yandex_hint_text"]').val(),
				                    balloonContent: $('textarea[name="yandex_balloon_text"]').val()
				                });
				                // Удаляем контекстное меню.
				                $('#menuYandexConstruct').css('right', '-200%');
			        });


			        $('#delete_placemark').click(function () {
							myMap.geoObjects.remove(myPlacemark[coords_edit]);
							$('#menuYandexConstruct').css('right', '-200%');
							myPlacemark[coords_edit] = null;
			        });
        	}
    		function createEditEvent(coords) {
			    // Контекстное меню, позволяющее изменить параметры метки.
			    // Вызывается при нажатии правой кнопкой мыши на метке.
			    myPlacemark[coords].events.add('click', function (e) {
			    	e.preventDefault();
			    	coords_edit = coords;
			    	ShowEdit(coords, e);

			    });
        	}
        	function SaveMap() {
        		var i = 0;
        		var arPlaceMarks = new Array;
				for (var key in myPlacemark) {
					if(myPlacemark[key] != null)
					arPlaceMarks[i] = {
						'coords': myPlacemark[key].geometry.getCoordinates(),
						'preset': myPlacemark[key].options.get('preset'),
						'iconCaption': myPlacemark[key].properties.get('iconCaption'),
						'hintContent': myPlacemark[key].properties.get('hintContent'),
						'balloonContent': myPlacemark[key].properties.get('balloonContent'),
					};
					i++;
				};
				console.log(arPlaceMarks)
				var arSettings = {
					'MAP_CENTER': myMap.getCenter(),
					'MAP_ZOOM': myMap.getZoom(),
					'MAP_TYPE': myMap.getType(),
					
				}
				$.post( '<?=$_SERVER["PHP_SELF"]?>',  {YANDEX_MAP_ID: '<?=$FIREWALL->GetString("MAP_ID")?>', PLACEMARK: arPlaceMarks, SETTINGS: arSettings}, function( data ) {
					if(data == 'OK'){
						$('#modal-meteor').modal('hide');
						location.reload();
					}else{
						console.log(data);
					}
				});
        	}
    </script>
    <style type="text/css">
#menuYandexConstruct {
    z-index: 2;
    position: absolute;
    transition: all .7s;
    top: 0px;
    right: -200%;
    height: 199%;
    padding: 15px;
    background-color: rgba(0, 0, 0, 0.7);
}
#mapYandexConstruct {
    background: url(/MeteorRC/components/MeteorRC/map.yandex/templates/.default/images/yandex.png) #fafafa center no-repeat;
    background-size: 25%;
    overflow: hidden;
    position:relative;
    width:100%;
    height:400px
}
#menuYandexConstruct h3 {
    font-size: 20px;
    font-weight: normal;
    margin-bottom: 30px;
}
    </style>
<?
	}else{
		if($mapID = $FIREWALL->GetString("YANDEX_MAP_ID")){
			$arMap = array(
				'ID' => $mapID,
				'PLACEMARK' => $FIREWALL->GetArrayString("PLACEMARK"),
				'SETTINGS' => $FIREWALL->GetArrayString("SETTINGS"),
			);
  			$APPLICATION->ArrayWriter($arMap, FOLDER_BD . 'map/yandex/' . $mapID . SFX_BD);
  			echo 'OK';
		}
	}
}
?>