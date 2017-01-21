<?require_once($_SERVER["DOCUMENT_ROOT"]."/MeteorRC/main/include/before.php");
if($USER->IsAdmin()){
	if(!isset($_REQUEST["SAVE_MENU"]["ARRAY"])){
		$arMenu = $APPLICATION->GetFileArray($FIREWALL->GetString("FILE"));
		if(!$arMenu){
			$arMenu = array(array("Новая страница", "/"));
		}
		$maxKey = 0;
		function fieldRender($key, $link, $name){
			ob_start();
			global $maxKey;
			if($maxKey < $key){
				$maxKey = $key;
			}
			?>
	<fieldset data-id="<?=$key?>" class="form-group">
		<div class="row">
			<div class="col-sm-12">
				<div class="input-group">
					<span class="input-group-addon"><i class="fa fa-link"></i></span>
					<input type="text" value="<?=$link?>" name="SAVE_MENU[ARRAY][<?=$key?>][URL]" class="form-control input-sm" placeholder="Ссылка">
					<span class="input-group-addon"><i class="fa fa-mouse-pointer"></i></span>
					<input type="text" value="<?=$name?>" name="SAVE_MENU[ARRAY][<?=$key?>][NAME]" class="form-control input-sm" placeholder="Имя страницы">
					<span class="input-group-btn">
						<button onclick="dellMenu(this)" class="btn btn-danger btn-sm" type="button"><i class="fa fa-trash" aria-hidden="true"></i></button>
					</span>
					<span class="input-group-btn">
						<button class="btn btn-success drag-handle btn-sm" type="button"><i class="fa fa-bars" aria-hidden="true"></i></button>
					</span>
				</div>
			</div>
		</div>
	</fieldset>
		<?
			$out = ob_get_contents();
			ob_end_clean();
			return $out;
	}
?>
<form id="meteorSaveMenu" action="<?=$_SERVER["PHP_SELF"]?>" onsubmit="return SaveFormToModal(this, '<?=$_SERVER["PHP_SELF"]?>', true, true)">
	<div class="result"></div>
	<div id="menuFields">
<?
foreach ($arMenu as $key => $menu){
	echo fieldRender($key, $menu['URL'], $menu['NAME']);
}
?>
	</div>
	<button onclick="addMenu(this)" class="btn btn-success buttonMenuAdd pull-right btn-sm" type="button"><i class="fa fa-plus"></i></button>
	<button class="btn_admin button_save" type="submit">Cохранить <i class="fa fa-floppy-o"></i></button>
	<input autocomplete="off" value="<?=$FIREWALL->GetString("FILE")?>" name="SAVE_MENU[FILE]" type="hidden">
	<input autocomplete="off" id="SortMenuValues" name="SAVE_MENU[SORT]" type="hidden">
</form>

<script type="text/javascript">
var MaxMenuKey = <?=$maxKey?>;
function dellMenu(btn){
	$(btn).parents('fieldset').remove();
}
function addMenu(btn){
	var clearField = <?=json_encode(fieldRender('#NEW_ID#', '/', 'Новая страница'))?>;
	MaxMenuKey = (MaxMenuKey + 1);
	$('#menuFields').append(clearField.replace(/\#NEW_ID#/g, MaxMenuKey));
}
$.getScript( "/MeteorRC/js/plugins/Sortable/Sortable.min.js" ).done(function( script, textStatus ) {
	var byId = function (id) { return document.getElementById(id); };
	'use strict';
	Sortable.create(byId('menuFields'), {
		handle: '.drag-handle',
		animation: 150,
		onUpdate:function(evt){
			var SortMenuValues = [];
			//console.log('onStart.foo:', [evt.item, evt.from]);
			$("#menuFields fieldset").each(function( index ) {
				SortMenuValues[index] = $(this).attr('data-id');
			});
			$('#SortMenuValues').val(SortMenuValues);
		},
	});
});
</script>
<?
	}else{
		if(isset($_REQUEST["SAVE_MENU"]["SORT"]) and $_REQUEST["SAVE_MENU"]["SORT"]){
			$arSort = explode(',', $_REQUEST["SAVE_MENU"]["SORT"]);
			foreach($arSort as $sortID){
				$aMenuLinks[] =  $_REQUEST["SAVE_MENU"]['ARRAY'][$sortID];
			}
			//p($aMenuLinks);
		}else{
			$aMenuLinks = $_REQUEST["SAVE_MENU"]['ARRAY'];
		}
		if($APPLICATION->ArrayWriter($aMenuLinks, $_REQUEST["SAVE_MENU"]["FILE"])){
			$arResult["SUCCESS"] = 'Меню успешно обновлено';
		}else{
			$arResult["ERROR"][] = 'Ошибка сохранения';
		}
		echo json_encode($arResult);
	}
}else{
	echo json_encode(array("ERROR" => 'Ошибка доступа'));
}
?>