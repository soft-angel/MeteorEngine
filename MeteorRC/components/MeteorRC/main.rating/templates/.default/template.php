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
<?$APPLICATION->AddHeadScript($templateFolder . "/jquery.raty.js")?>
	<div class="starwrap">
		<div id="score" title="regular" style="width: 100px;">

		</div>
	</div>

<script type="text/javascript">
	$(function() {
		$.fn.raty.defaults.path = '<?=$templateFolder?>/images/';
		$.fn.raty.defaults.onClick = function() { alert('clicked!'); };
		$('#score').raty({
			<?if(!isset($_SESSION["RATING"][$arParams["COMPONENT"]][$arParams["IBLOCK"]][$arParams["ELEMENT_ID"]])){?>
			readOnly: false, 
			<?}else{?>
			readOnly: true, 
			<?}?>
			score: <?=(isset($arResult[$arParams["FIELD_VOTE"]]))?$arResult[$arParams["FIELD_VOTE"]]:0?>, 
		}).click(function() {
			<?if(!isset($_SESSION["RATING"][$arParams["COMPONENT"]][$arParams["IBLOCK"]][$arParams["ELEMENT_ID"]])){?>
			$.post("<?=$templateFolder?>/rating_ajax.php",  { 
				ELEMENT_ID: "<?=$arParams["ELEMENT_ID"]?>",
				COMPONENT: "<?=$arParams["COMPONENT"]?>",
				IBLOCK: "<?=$arParams["IBLOCK"]?>",
				FIELD_VOTE: "<?=$arParams["FIELD_VOTE"]?>",
				FIELD_VOTE_COUNT: "<?=$arParams["FIELD_VOTE_COUNT"]?>",
				FIELD_VOTE_SUMM: "<?=$arParams["FIELD_VOTE_SUMM"]?>",
				VOTE: $("#score input ").val() 
			}, function( data ) {
			  //alert( data );
			});
  			<?}?>
		});

	});
</script>