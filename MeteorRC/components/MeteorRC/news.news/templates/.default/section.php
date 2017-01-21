<?if(!defined("PROLOG_INCLUDED") || PROLOG_INCLUDED!==true)die();
/** @var array $arParams */
/** @var array $arResult */

/** @var array $arSection - массив раздела если мы в разделе */
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
<div class="title-bg">
	<div class="title"><?$APPLICATION->ShowTitle()?></div>
</div>

<?if(isset($arElements)){?>
<div class="row">
<ul class="gridlist" style="margin: 0">
<?foreach($arElements as $id => $arElement){?>
					<li class="gridlist-inner">
						<div class="white">
						<div class="row clearfix">
							<div class="col-md-4">
								<div class="pr-img">
									<a href="<?=$arElement["DETAIL_PAGE_URL"]?>"><img src="<?=(isset($arElement["PREVIEW_PICTURE"]))?"/MeteorRC/main/plugins/phpthumb/phpThumb.php?src=" . $FILE->GetUrlFile($arElement["PREVIEW_PICTURE"], $arParams["IBLOCK"]) . "&amp;w=200&amp;h=200&zc=1&amp;q=65":SITE_TEMPLATE_PATH . "images/noimage.png"?>" alt="" class="img-responsive"/></a>
								</div>
							</div>
							<div class="col-md-8">
								<div class="gridlisttitle"><a href="<?=$arElement["DETAIL_PAGE_URL"]?>"><?=$arElement["NAME"]?></a> <span>Статья №: <?=$arElement["ID"]?></span></div>
								<p class="gridlist-desc">
									<?=htmlspecialchars_decode($arElement["PREVIEW_TEXT"])?>
								</p>
							</div>
						</div>
						</div>
						<div class="gridlist-act">
								<a href="<?=$arElement["DETAIL_PAGE_URL"]?>" class="btn btn-danger"><i class="fa fa-newspaper-o"></i>&nbsp;<?=$arParams["MESS_BTN_DETAIL"]?></a>
						</div>
					</li>
<?}?>
				</ul>
</div>
				<?}?>

				<?if(isset($arResult["PAGENAVIGATION"]["SHOW"]) and $arResult["PAGENAVIGATION"]["SHOW"] == "Y" and $arParams["DISPLAY_BOTTOM_PAGER"] == "Y"){?>
				<ul class="pagination shop-pag">
					<?if($arResult["PAGENAVIGATION"]["ACTIVE"] > 1){?>
					<li><a href="?PAGEN_<?=$arResult["COMPONENT_ID"]?>=<?=($arResult["PAGENAVIGATION"]["ACTIVE"] - 1)?>"><i class="fa fa-caret-left"></i></a></li>
					<?}?>
					<?
					$i = 0;
					while($arResult["PAGENAVIGATION"]["PAGES"] > $i){
						$i++;
					?>
					<li><a <?if($arResult["PAGENAVIGATION"]["ACTIVE"] == $i){?>class="active"<?}?> href="?PAGEN_<?=$arResult["COMPONENT_ID"]?>=<?=$i?>"><?=$i?></a></li>
					<?}?>
					<?if($arResult["PAGENAVIGATION"]["ACTIVE"] < $i){?>
					<li><a href="?PAGEN_<?=$arResult["COMPONENT_ID"]?>=<?=($arResult["PAGENAVIGATION"]["ACTIVE"] + 1)?>"><i class="fa fa-caret-right"></i></a></li>
					<?}?>
				</ul>
<?}?>