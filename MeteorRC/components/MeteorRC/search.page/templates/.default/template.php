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
$APPLICATION->AddHeadScript($templateFolder . "/script.js");
?>
<div class="title-bg">
	<div class="title">
	<?if($FIREWALL->GetString('q')){?>
	Найдено: <?=$arResult["SEARCH_COUNT"]?>
	<?}else{?>
	<?$APPLICATION->ShowTitle()?>
	<?}?>
	</div>
</div>

<form action="<?=$_SERVER["PHP_SELF"]?>" method="GET">
<div class="row">
 <div class="col-lg-12">
    <div class="input-group">
      <input value="<?=$FIREWALL->GetString('q')?>" name="q" type="text" class="form-control" placeholder="Введите фразу для поиска...">
      <span class="input-group-btn">
        <button class="btn btn-default gold-gradient" type="submit"><i class="fa fa-search"></i> Найти!</button>
      </span>
    </div><!-- /input-group -->
  </div><!-- /.col-lg-6 -->
</div>
</form>

<?if(isset($arResult["ELEMENTS"])){?>
<div class="row">
	<div class="col-lg-12">
		<ul class="gridlist" style="margin: 0;padding: 0;">
<?foreach($arResult["ELEMENTS"] as $id => $arElement){?>
					<li class="gridlist-inner">
						<div class="white">
						<div class="row clearfix">
							<div class="col-md-3">
								<div class="pr-img">
									<a href="<?=$arElement["DETAIL_PAGE_URL"]?>"><img src="<?=(isset($arElement["IMAGE"]))?"/MeteorRC/main/plugins/phpthumb/phpThumb.php?src=" . $FILE->GetUrlFile($arElement["IMAGE"], $arElement["IBLOCK"]) . "&amp;w=200&amp;h=200&zc=1&amp;q=65":SITE_TEMPLATE_PATH . "images/noimage.png"?>" alt="" class="img-responsive"/></a>
								</div>
							</div>
							<div class="col-md-9">
								<div class="gridlisttitle"><a href="<?=$arElement["DETAIL_PAGE_URL"]?>"><?=$arElement["NAME"]?></a> </div>
								<p class="gridlist-desc">
									<?=htmlspecialchars_decode($arElement["PREVIEW_TEXT"])?>
								</p>
							</div>
						</div>
						</div>
						<div class="gridlist-act">
								<a href="<?=$arElement["DETAIL_PAGE_URL"]?>" class="btn btn-danger"><i class="fa fa-newspaper-o"></i>&nbsp;Подробно</a>
						</div>
					</li>
<?}?>
		</ul>
	</div>
</div>
				<?}?>


				<?if(isset($arResult["PAGENAVIGATION"]["SHOW"]) and $arResult["PAGENAVIGATION"]["SHOW"] == "Y" and $arParams["DISPLAY_BOTTOM_PAGER"] == "Y"){?>
				<ul class="pagination shop-pag">
					<?if($arResult["PAGENAVIGATION"]["ACTIVE"] > 1){?>
					<li><a href="<?=$APPLICATION->UrlQuery("PAGEN_" . $arResult["COMPONENT_ID"], ($arResult["PAGENAVIGATION"]["ACTIVE"] - 1))?>"><i class="fa fa-caret-left"></i></a></li>
					<?}?>
					<?
					$i = 0;
					while($arResult["PAGENAVIGATION"]["PAGES"] > $i){
						$i++;
					?>
					<li><a <?if($arResult["PAGENAVIGATION"]["ACTIVE"] == $i){?>class="active"<?}?> href="<?=$APPLICATION->UrlQuery("PAGEN_" . $arResult["COMPONENT_ID"], $i)?>"><?=$i?></a></li>
					<?}?>
					<?if($arResult["PAGENAVIGATION"]["ACTIVE"] < $i){?>
					<li><a href="<?=$APPLICATION->UrlQuery("PAGEN_" . $arResult["COMPONENT_ID"], ($arResult["PAGENAVIGATION"]["ACTIVE"] + 1))?>"><i class="fa fa-caret-right"></i></a></li>
					<?}?>
				</ul>
				<?}?>