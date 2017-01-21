<?if(!defined("PROLOG_INCLUDED") || PROLOG_INCLUDED!==true) die();?>
<?
global $APPLICATION;
global $USER;
global $CONFIG;
$FILE = new FILE;
//p($APPLICATION->arMenuInclude);
CJSCore::Init(array("jquery", "bootstrap", "switchery", "font-awesome", "liTranslit", 'jquery.scrollbar'));
$APPLICATION->SetAdditionalCSS("/MeteorRC/admin/css/panel.css");
$APPLICATION->AddHeadScript("/MeteorRC/admin/js/panel.js", false);


if($CONFIG["EYE_EDITOR"] == "Y"){
	$APPLICATION->AddHeadScript("/MeteorRC/admin/editors/ckeditor/ckeditor.js", false);
}

//$arComponent = $APPLICATION->GetComponents();
// p($arComponent);
?>
<div class="modal fade" id="modal-meteor">
    <div class="modal-dialog" style="padding-left: 15px;width: 100%;padding-right: 15px;">
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			<h4 class="modal-title"></h4>
	    </div>
        <div class="modal-content">

            <div class="modal-body">                
            </div>
        </div>
    </div>
</div>

<div id="meteor_panel" <?if($CONFIG['PANEL_FIXED'] != "N"){?>class="panel-fixed"<?}?>>

<div id="meteor_panel_top" class="bg-gragient-panel">
	<a href="/" class="btn active">Сайт</a>
	<a href="/MeteorRC/" class="btn">Администрирование</a>
	<a class="pull-right <?if($CONFIG['PANEL_FIXED'] != "N"){?>active<?}?>" id="panelPin" href="#" onclick="PanelToggle(this);"><i class="fa fa-thumb-tack" aria-hidden="true"></i></a>
	<a id="meteor_user" href="?component=users&iblock=users&edit_element=<?=$USER->GetID()?>">
		<img src="<?=$USER->GetAvatar()?$FILE->GetUrlFile($USER->GetAvatar(), 'users'):SITE_TEMPLATE_PATH . "images/nophoto.png"?>"/> 
		<span><?=$USER->GetName()?></span>
	</a>
</div>
<div id="meteor_panel_wraper" class="container-fluid">
	<div class="row">
		<div class="col-sm-4 col-xs-5">
			<div><a class="btn btn-panel" data-toggle="modal" date-title="Настройки" data-target="#modal-meteor" href="/MeteorRC/admin/editors/edit_page_ajax.php?PATCH=<?=$APPLICATION->GetSectionFolder()?>/"><i class="fa fa-pencil-square-o"></i> Параметры страницы</a></div>
			<div><a class="btn btn-panel" data-toggle="modal" date-title="Настройки" data-target="#modal-meteor" href="/MeteorRC/admin/editors/add_page_ajax.php?PATCH=<?=$APPLICATION->GetSectionFolder()?>/&amp;MENU=<?=base64_encode(json_encode($APPLICATION->arMenuInclude))?>"><i class="fa fa-plus-square-o"></i> Создать страницу</a></div>

		</div>
		<div class="col-sm-4 col-xs-5">
			<div>
				<a class="btn btn-panel" data-toggle="modal" date-title="Настройки" data-target="#modal-meteor" href="/MeteorRC/admin/editors/settings_ajax.php"><i class="fa fa-cog"></i> Настройки</a>
			</div>
			<div class="btn-group">
				<button type="button" class="btn btn-panel dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
					<i class="fa fa-bars" aria-hidden="true"></i>
				    <span>Меню</span>
				    <span class="caret"></span>
				</button>
				<ul class="dropdown-menu bg-gragient-panel">
				<?foreach ($APPLICATION->arMenuInclude as $value => $file) {?>
					<li><a data-target="#modal-meteor" data-toggle="modal" date-title="Редактирование (<?=$value?>)" href="/MeteorRC/components/MeteorRC/menu/editor_ajax.php?FILE=<?=$file?>"><?=$value?></a></li>
				<?}?>
				</ul>
			</div>
		</div>
		<div class="col-sm-2 text-center col-xs-2">
			<a class="btn btn-panel-big" href="?clear_cache=Y">
				<i class="fa fa-refresh fa-2x"></i><br>
				<small>Сбросить кэш</small>
			</a>
		</div>

		<div class="col-sm-offset-0 col-xs-offset-4 col-sm-2 col-xs-4 text-center">
			<input id="eyeToggle" class="js-switch" data-plugin="bootstrap-switch" type="checkbox" <?if($CONFIG["EYE_EDITOR"] == "Y"){?>checked="checked"<?}?>>
			<p style="font-size:12px"><?=($CONFIG["EYE_EDITOR"] == "Y")?'Отключить':'Включить'?> визуальное редактирование</p>
		</div>
	</div>
</div>
</div>
<div id="meteorPanelLining" <?if($CONFIG['PANEL_FIXED'] != "N"){?>style="display:block;"<?}?>></div>