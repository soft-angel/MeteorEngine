<?if(!defined("PROLOG_INCLUDED") || PROLOG_INCLUDED!==true) die();?>
<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8"> <![endif]-->
<!--[if !IE]><!-->
<html lang="ru">
<!--<![endif]-->
<head>
	<?CJSCore::Init(array("jquery-1.9.1", 'jquery-ui', "bootstrap", "font-awesome", "mousewheel", 'morris', 'animate', 'gritter', 'pace', 'raphael', 'slimscroll', 'jquery.cookie'));?>
	<title><?$APPLICATION->ShowTitle()?>MeteorEngine | Панель управления</title>
	<meta  http-equiv="Content-Type" content="text/html;" charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<?$APPLICATION->ShowHead();?>
	<?$APPLICATION->SetAdditionalCSS("//fonts.googleapis.com/css?family=Open+Sans:300,400,600,700");?>
	<?$APPLICATION->SetAdditionalCSS(SITE_TEMPLATE_PATH . "css/style.min.css");?>
	<?$APPLICATION->SetAdditionalCSS(SITE_TEMPLATE_PATH . "css/style-responsive.min.css");?>
	<link href="<?=SITE_TEMPLATE_PATH?>css/theme/default.css" rel="stylesheet" id="theme" />
	<?$APPLICATION->SetAdditionalCSS(SITE_TEMPLATE_PATH . "template_styles.css");?>
</head>
<body class="pace-top">
