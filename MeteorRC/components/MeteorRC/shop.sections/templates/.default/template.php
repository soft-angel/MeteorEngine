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
<?
if (!function_exists('view_cat')) {
	function view_cat ($dataset) {
		foreach ($dataset as $menu) {?>
		<li><a href="<?=$menu["DETAIL_PAGE_URL"]?>"><?=$menu["NAME"]?></a>
<?if(isset($menu['CHILDS'])) {?>
			<ul class="submenu">
<?view_cat($menu['CHILDS'])?>
			</ul>
<? }?>
		</li>
<?
		}
	}
}
?>
				<div id="component_<?=$APPLICATION->GetComponentId()?>" class="categorybox">
					<ul>
<?view_cat($arResult["SECTIONS_MAP"]);?>
					</ul>
				</div>