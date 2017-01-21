<?if(!defined("PROLOG_INCLUDED") || PROLOG_INCLUDED!==true) die();?>
<!DOCTYPE html>
<html>
<head>
    <?$APPLICATION->ShowHead();?>
    <?$APPLICATION->SetAdditionalCSS(SITE_TEMPLATE_PATH . "template_styles.css");?>
    <?CJSCore::Init(array('jquery-1.9.1', 'bootstrap', 'font-awesome'));?>
    <?$APPLICATION->SetAdditionalCSS(SITE_TEMPLATE_PATH . "css/style.css");?>
    <?$APPLICATION->AddHeadScript(SITE_TEMPLATE_PATH . "js/script.js")?>
    <meta  http-equiv="Content-Type" content="text/html;" charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link href='//fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,400,300,600,700|Six+Caps' rel='stylesheet' type='text/css' />
        <!--[if lt IE 9]>
          <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
          <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
        <![endif]-->
    <link rel="apple-touch-icon" sizes="57x57" href="<?=SITE_TEMPLATE_PATH?>images/favicon/apple-icon-57x57.png">
    <link rel="apple-touch-icon" sizes="60x60" href="<?=SITE_TEMPLATE_PATH?>images/favicon/apple-icon-60x60.png">
    <link rel="apple-touch-icon" sizes="72x72" href="<?=SITE_TEMPLATE_PATH?>images/favicon/apple-icon-72x72.png">
    <link rel="apple-touch-icon" sizes="76x76" href="<?=SITE_TEMPLATE_PATH?>images/favicon/apple-icon-76x76.png">
    <link rel="apple-touch-icon" sizes="114x114" href="<?=SITE_TEMPLATE_PATH?>images/favicon/apple-icon-114x114.png">
    <link rel="apple-touch-icon" sizes="120x120" href="<?=SITE_TEMPLATE_PATH?>images/favicon/apple-icon-120x120.png">
    <link rel="apple-touch-icon" sizes="144x144" href="<?=SITE_TEMPLATE_PATH?>images/favicon/apple-icon-144x144.png">
    <link rel="apple-touch-icon" sizes="152x152" href="<?=SITE_TEMPLATE_PATH?>images/favicon/apple-icon-152x152.png">
    <link rel="apple-touch-icon" sizes="180x180" href="<?=SITE_TEMPLATE_PATH?>images/favicon/apple-icon-180x180.png">
    <link rel="icon" type="image/png" sizes="192x192"  href="<?=SITE_TEMPLATE_PATH?>images/favicon/android-icon-192x192.png">
    <link rel="icon" type="image/png" sizes="32x32" href="<?=SITE_TEMPLATE_PATH?>images/favicon/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="96x96" href="<?=SITE_TEMPLATE_PATH?>images/favicon/favicon-96x96.png">
    <link rel="icon" type="image/png" sizes="16x16" href="<?=SITE_TEMPLATE_PATH?>images/favicon/favicon-16x16.png">
    <link rel="manifest" href="<?=SITE_TEMPLATE_PATH?>images/favicon/manifest.json">
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="msapplication-TileImage" content="<?=SITE_TEMPLATE_PATH?>images/favicon/ms-icon-144x144.png">
    <meta name="theme-color" content="#ffffff">
</head>
<body>
<?$APPLICATION->ShowPanel();?>

<?$APPLICATION->IncludeComponent("MeteorRC:menu","top",Array(
        "ROOT_MENU_TYPE" => "top", 
        "MAX_LEVEL" => "1", 
        "USE_EXT" => "N",
        "CACHE_TYPE" => "H",    // Тип кеширования
        "CACHE_TIME" => "36000000", // Время кеширования (сек.)
    )
);?>

<?if($APPLICATION->GetCurDir() != "/"){?>
<?}?>