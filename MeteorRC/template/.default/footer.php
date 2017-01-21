<?if(!defined("PROLOG_INCLUDED") || PROLOG_INCLUDED!==true) die();?>

<?$APPLICATION->IncludeComponent("MeteorRC:social.links", "", Array(
        "COMPONENT" => "social",
        "IBLOCK" => "links",    // Инфоблок
    ),
    false
);?>
<footer>
    <p>&copy; «<?=$CONFIG["SITE_NAME"]?>» 2014 - <?=date("Y")?></p>
</footer>
</body>
</html>