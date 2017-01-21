<?require_once($_SERVER["DOCUMENT_ROOT"]."/MeteorRC/main/include/before.php");?>
<?
include("component.php");
sleep(1);
?>
<?if($arResult["ERROR"]){?>
<div class="alert alert-danger" role="alert">
<?
foreach ($arResult["ERROR"] as $key => $value) {
echo $value;
}
?>
</div>
<?}?>

<?if($arResult["MESSAGE"]){?>
<div class="alert alert-success" role="alert">
<?
foreach ($arResult["MESSAGE"] as $key => $value) {
echo $value;
}
?>
</div>
<?}?>