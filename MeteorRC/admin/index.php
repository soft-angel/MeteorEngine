<?
define("NAME_TEMPLATE", 'admin');
require_once($_SERVER["DOCUMENT_ROOT"]."/MeteorRC/header.php");
$FILE = new FILE;

if(!$USER->IsAdmin()){
//p($arComponent);
?>
	<!-- begin #page-loader -->
	<div id="page-loader" class="fade in"><span class="spinner"></span></div>
	<!-- end #page-loader -->
	
	<!-- begin #page-container -->
	<div id="page-container" class="fade">
<?$APPLICATION->IncludeComponent("MeteorRC:main.auth","admin",Array(
     "REGISTER_URL" => "register.php",
     "FORGOT_PASSWORD_URL" => "",
     "PROFILE_URL" => "profile.php",
     "SHOW_ERRORS" => "Y" 
     )
);?>
	</div>
	<!-- end page container -->
<?}else{
$arComponent = $APPLICATION->GetComponents();
	?>


	<!-- begin #page-loader -->
	<div id="page-loader" class="fade in"><span class="spinner"></span></div>
	<!-- end #page-loader -->
	
	<!-- begin #page-container -->
	<div id="page-container" class="fade page-sidebar-fixed page-header-fixed">
		<!-- begin #header -->
		<div id="header" class="header navbar navbar-default navbar-fixed-top">
			<!-- begin container-fluid -->
			<div class="container-fluid">
				<!-- begin mobile sidebar expand / collapse button -->
				<div class="navbar-header">
					<a href="/MeteorRC/admin/" class="navbar-brand"><span class="navbar-logo"></span></a>
					<button type="button" class="navbar-toggle" data-click="sidebar-toggled">
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
					</button>
				</div>
				<!-- end mobile sidebar expand / collapse button -->
				
				<!-- begin header navigation right -->
				<ul class="nav navbar-nav navbar-right">
					<li>
						<form class="navbar-form full-width">
							<div class="form-group">
								<input type="text" class="form-control" placeholder="Поиск" />
								<button type="submit" class="btn btn-search"><i class="fa fa-search"></i></button>
							</div>
						</form>
					</li>
					<li class="dropdown">
						<a href="javascript:;" data-toggle="dropdown" class="dropdown-toggle f-s-14">
							<i class="fa fa-bell-o"></i>
							<span class="label">5</span>
						</a>
						<ul class="dropdown-menu media-list pull-right animated fadeInDown">
                            <li class="dropdown-header">Уведомления (1)</li>
                            <li class="media">
                                <a href="javascript:;">
                                    <div class="media-left"><i class="fa fa-bug media-object bg-red"></i></div>
                                    <div class="media-body">
                                        <h6 class="media-heading">Ошибки сервера</h6>
                                        <div class="text-muted f-s-11">3 минуты назад</div>
                                    </div>
                                </a>
                            </li>
                            <li class="dropdown-footer text-center">
                                <a href="javascript:;">Смотреть все</a>
                            </li>
						</ul>
					</li>
					<li class="dropdown navbar-user">
						<a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown">
							<img src="<?=$USER->GetAvatar()?$FILE->GetUrlFile($USER->GetAvatar(), 'users'):SITE_TEMPLATE_PATH . "images/nophoto.png"?>"/> 
							<span class="hidden-xs"><?=$USER->GetLogin()?></span> <b class="caret"></b>
						</a>
						<ul class="dropdown-menu animated fadeInLeft">
							<li class="arrow"></li>
							<li><a href="?component=users&iblock=users&edit_element=<?=$USER->GetID()?>">Профиль</a></li>
							<li><a href="javascript:;">Настройки</a></li>
							<li class="divider"></li>
							<li><a href="?logout">Выход</a></li>
						</ul>
					</li>
				</ul>
				<!-- end header navigation right -->
			</div>
			<!-- end container-fluid -->
		</div>
		<!-- end #header -->
		
		<!-- begin #sidebar -->
		<div id="sidebar" class="sidebar">
			<!-- begin sidebar scrollbar -->
			<div data-scrollbar="true" data-height="100%">
				<!-- begin sidebar user -->
				<ul class="nav">
					<li class="nav-profile">
						<div class="image">
							<a href="javascript:;"><img src="<?=$USER->GetAvatar()?$FILE->GetUrlFile($USER->GetAvatar(), 'users'):SITE_TEMPLATE_PATH . "images/nophoto.png"?>" alt="" /></a>
						</div>
						<div class="info">
							<?=$USER->GetName()?>
							<small><?=$USER->GetStatus()?></small>
						</div>
					</li>
				</ul>
				<!-- end sidebar user -->
				<!-- begin sidebar nav -->
				<ul class="nav">
					<li class="nav-header">Управление</li>
<?
$arMenu = array(
	array(
		"NAME" => "Статистика",
		"CODE" => "statistics",
		"ICON" => '<i class="fa fa-line-chart"></i>'
	),
	array(
		"NAME" => "Файлы",
		"CODE" => "files",
		"ICON" => '<i class="fa fa-file-o"></i>'
	),
	array(
		"NAME" => "Система",
		"CODE" => "main",
		"ICON" => '<i class="fa fa-cog"></i>'
	),
	array(
		"NAME" => "Магазин",
		"CODE" => "shop",
		"ICON" => '<i class="fa fa-shopping-basket"></i>'
	),
	array(
		"NAME" => "Статьи",
		"CODE" => "news",
		"ICON" => '<i class="fa fa-newspaper-o"></i>'
	),
	array(
		"NAME" => "Контент",
		"CODE" => "content",
		"ICON" => '<i class="fa fa-file-text"></i>'
	),
	array(
		"NAME" => "Пользователи",
		"CODE" => "users",
		"ICON" => '<i class="fa fa-user"></i>'
	),
	array(
		"NAME" => "Слайды",
		"CODE" => "sliders",
		"ICON" => '<i class="fa fa-picture-o"></i>'
	),
	array(
		"NAME" => "Настройки",
		"CODE" => "settings",
		"ICON" => '<i class="fa fa-cogs"></i>'
	),
	array(
		"NAME" => "Соцсети",
		"CODE" => "social",
		"ICON" => '<i class="fa fa-link"></i>'
	),
);
foreach ($arMenu as $id => $menu) {
?>
					<li class="has-sub <?if(isset($arComponent[$menu["CODE"]][$_GET["iblock"]])){?>active<?}?>">
						<a href="javascript:;">
						    <b class="caret pull-right"></b>
						    <?=$menu["ICON"]?>
						    <span><?=$menu["NAME"]?> </span>
					    </a>
						<ul class="sub-menu">
							<?foreach($arComponent[$menu["CODE"]] as $key => $menu){
								if(!$menu["ADMIN"] == "Y")continue;?>
						    <li <?if(isset($_GET["iblock"]) and $key == $_GET["iblock"]){?>class="active"<?}?>><a href="/MeteorRC/admin/?component=<?=$menu["COMPONENT"]?>&iblock=<?=$menu["IBLOCK"]?>"><?=$menu["NAME"]?> <?if(isset($menu["NEW"])){?><span class="label label-theme m-l-5">NEW</span><?}?></a></li>
						    <?}?>
						</ul>
					</li>
<?}?>
			        <!-- begin sidebar minify button -->
					<li><a href="javascript:;" class="sidebar-minify-btn" data-click="sidebar-minify"><i class="fa fa-angle-double-left"></i></a></li>
			        <!-- end sidebar minify button -->
				</ul>
				<!-- end sidebar nav -->
			</div>
			<!-- end sidebar scrollbar -->
		</div>
		<div class="sidebar-bg"></div>
		<!-- end #sidebar -->
<?
$page = false;
if(isset($_GET["component"]) and isset($_GET["iblock"])){
	foreach ($arComponent as $category) {
		foreach ($category as $component) {
			if($component["COMPONENT"] == $_GET["component"] and $_GET["iblock"] == $component["IBLOCK"]){
				(!empty($component["EDITOR_FILE"]))?include($_SERVER["DOCUMENT_ROOT"] . $component["EDITOR_FILE"]):include($component["PATCH"] . "/admin.php");
				$page = true;
			}
		}
	}
if($page){

}
}else{
	include("page/home.php");
}
?>
		
        <!-- begin theme-panel -->
        <div class="theme-panel">
            <a href="javascript:;" data-click="theme-panel-expand" class="theme-collapse-btn"><i class="fa fa-cog"></i></a>
            <div class="theme-panel-content">
                <h5 class="m-t-0">Цветовая тема</h5>
                <ul class="theme-list clearfix">
                    <li class="active"><a href="javascript:;" class="bg-green" data-theme="default" data-click="theme-selector" data-toggle="tooltip" data-trigger="hover" data-container="body" data-title="По умолчанию">&nbsp;</a></li>
                    <li><a href="javascript:;" class="bg-red" data-theme="red" data-click="theme-selector" data-toggle="tooltip" data-trigger="hover" data-container="body" data-title="Красный">&nbsp;</a></li>
                    <li><a href="javascript:;" class="bg-blue" data-theme="blue" data-click="theme-selector" data-toggle="tooltip" data-trigger="hover" data-container="body" data-title="Голубой">&nbsp;</a></li>
                    <li><a href="javascript:;" class="bg-purple" data-theme="purple" data-click="theme-selector" data-toggle="tooltip" data-trigger="hover" data-container="body" data-title="Фиолетовый">&nbsp;</a></li>
                    <li><a href="javascript:;" class="bg-orange" data-theme="orange" data-click="theme-selector" data-toggle="tooltip" data-trigger="hover" data-container="body" data-title="Оранжевый">&nbsp;</a></li>
                    <li><a href="javascript:;" class="bg-black" data-theme="black" data-click="theme-selector" data-toggle="tooltip" data-trigger="hover" data-container="body" data-title="Черный">&nbsp;</a></li>
                </ul>
                <div class="divider"></div>
                <div class="row m-t-10">
                    <div class="col-md-5 control-label double-line">Стиль верхней панели</div>
                    <div class="col-md-7">
                        <select name="header-styling" class="form-control input-sm">
                        	<option value="1">Темный</option>
                            <option value="2">Белый</option>
                            
                        </select>
                    </div>
                </div>
                <div class="row m-t-10">
                    <div class="col-md-5 control-label">Тип верхней панели</div>
                    <div class="col-md-7">
                        <select name="header-fixed" class="form-control input-sm">
                            <option value="1">Фиксированный</option>
                            <option value="2">Статичный</option>
                        </select>
                    </div>
                </div>
                <div class="row m-t-10">
                    <div class="col-md-5 control-label double-line">Стиль левой панели</div>
                    <div class="col-md-7">
                        <select name="sidebar-styling" class="form-control input-sm">
                            <option value="1">По умолчанию</option>
                            <option value="2">Сетка</option>
                        </select>
                    </div>
                </div>
                <div class="row m-t-10">
                    <div class="col-md-5 control-label">Тип левой панели</div>
                    <div class="col-md-7">
                        <select name="sidebar-fixed" class="form-control input-sm">
                            <option value="1">Фиксированный</option>
                            <option value="2">Статичный</option>
                        </select>
                    </div>
                </div>
                <div class="row m-t-10">
                    <div class="col-md-5 control-label double-line">Градиент в девой панели</div>
                    <div class="col-md-7">
                        <select name="content-gradient" class="form-control input-sm">
                            <option value="1">Выключено</option>
                            <option value="2">Включено</option>
                        </select>
                    </div>
                </div>
                <div class="row m-t-10">
                    <div class="col-md-5 control-label double-line">тиль контента</div>
                    <div class="col-md-7">
                        <select name="content-styling" class="form-control input-sm">
                            <option value="1">Светлый</option>
                            <option value="2">Темный</option>
                        </select>
                    </div>
                </div>
                <div class="row m-t-10">
                    <div class="col-md-12">
                        <a href="#" class="btn btn-inverse btn-block btn-sm" data-click="reset-local-storage"><i class="fa fa-refresh m-r-3"></i> Все по умолчанию</a>
                    </div>
                </div>
            </div>
        </div>
        <!-- end theme-panel -->
		
		<!-- begin scroll to top btn -->
		<a href="javascript:;" class="btn btn-icon btn-circle btn-success btn-scroll-to-top fade" data-click="scroll-top"><i class="fa fa-angle-up"></i></a>
		<!-- end scroll to top btn -->
	</div>
	<!-- end page container -->
<?}?>
<?require($_SERVER["DOCUMENT_ROOT"]."/MeteorRC/footer.php");?>