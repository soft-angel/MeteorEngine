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
//$APPLICATION->AddHeadScript($templateFolder . "/script.js");
?>

<?if(isset($arResult)){?>
<?//p($arResult)?>
<?foreach ($arResult as $id => $payment) {?>
				<div class="radio">
					<label>
						<input type="radio" name="ORDER[PAY_SYSTEM_ID]" id="optionsRadios<?=$payment["ID"]?>" value="<?=$payment["ID"]?>" <?if(isset($payment["DEFAULT"]) and $payment["DEFAULT"] == "Y"){?>checked=""<?}?>>
						<?=$payment["NAME"]?>
					</label>
				</div>
<?}?>
<?}?>