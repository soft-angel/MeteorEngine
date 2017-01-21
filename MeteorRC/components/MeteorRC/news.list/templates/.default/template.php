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
$APPLICATION->SetAdditionalCSS($templateFolder . "/style.css");
?>
<ul class="tweets">

<?foreach($arResult["ELEMENTS"] as $id => $arElement){?>
	<li class="lastone">
		<h5>
			<a href="<?=$arElement["DETAIL_PAGE_URL"]?>"><?=$arElement["NAME"]?></a>
		</h5>
		<?if(isset($arElement["PREVIEW_TEXT"])){?>
		<p><?=cutString($arElement["PREVIEW_TEXT"], 100)?> <a href="<?=$arElement["DETAIL_PAGE_URL"]?>" class="fa fa-align-right"></a></p>
		<?}?>
		<?if(isset($arElement["ACTIVE_TIME"])){?>
		<span><?=date("Y.m.d", $arElement["ACTIVE_TIME"])?></span>
		<?}?>
	</li>



<?}?>
</ul>
	<!--<form role="form">
		<div class="form-group">
			<label>Your Email address</label>
			<input type="email" class="form-control newstler-input" id="exampleInputEmail1" placeholder="Enter email">
			<button class="btn btn-default btn-red btn-sm">Sign Up</button>
		</div>
	</form>-->



