<?require_once($_SERVER["DOCUMENT_ROOT"]."/MeteorRC/main/include/before.php");?>
<?
global $APPLICATION;
global $USER;
?>
<?if($USER->IsAdmin() and $_REQUEST["type"] == "config"){?>
<?
$CONFIG["EYE_EDITOR"] = $_REQUEST["VARIABLE"]["EYE_EDITOR"];
$APPLICATION->ArrayWriter($CONFIG, CONFIG_FILE);
?>
<?}?>