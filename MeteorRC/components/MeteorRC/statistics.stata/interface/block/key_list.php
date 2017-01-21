<?php
// error_reporting(E_ALL);
ini_set('display_errors', 1);
include('../../helper.php');
$Stata = new Stata;
?>
<link rel="stylesheet" type="text/css" href="../css/tracking.css">
<script src="http://www.google.com/jsapi"></script><script>google.load("jquery", "1.6.1");</script>
<script type='text/javascript' src="../js/jquery.qtip.js"></script>
<script>
$(document).ready(function () {
	$('div[title]').qtip({position:{ my: 'bottom center', at: 'top center'}});
	$('img[title]').qtip({position:{ my: 'bottom center', at: 'top center'}});
	$('span[title]').qtip({position:{ my: 'bottom center', at: 'top center'}});
});
</script>
<style>
body {
margin: 0;
width: 100%!important;
}
</style>
<?php
if (true){
	if($arFile = glob(PATCH_USER . '/*.php')){
		foreach ($arFile as $file){
			$arAllUser = $Stata->GetFileArray($file);
			foreach($arAllUser as $arUser){
				if($arUser["Q"]["Q"]){
					$arQ[$arUser["Q"]["Q"]]["NAME"][] = $arUser["Q"]["NAME"];
					$arQ[$arUser["Q"]["Q"]]["CNT"] = ($arQ[$arUser["Q"]["Q"]]["CNT"] + 1);
					$arQ[$arUser["Q"]["Q"]]["VIEWS"] = ($arQ[$arUser["Q"]["Q"]]["VIEWS"] + $arUser["CNT"]?$arUser["CNT"]:1);
				}
			}
		}
	}
		//print_r($arQ);
	if($arQ){
		arsort($arQ);
?>

<div id="soe_key" >
<?php 
$i = 0;
foreach ($arQ as $q => $value){
	$i++;
	$arPS = array_unique($value["NAME"]);?>
	<div  style="background: <?=$Stata->getColor($value["CNT"])?>;" class="box_key">
		<div class="oldvalue_left" title="<?=$q?>"><?=$i?>) <?=$q?></div>
		<div class="count_right" ><span title="Количество этого запроса"><?=$value["CNT"]?></span> / <span title="Общаяя глубина просмотров"><?=$value["VIEWS"]?></span>
<?foreach($arPS as $ps){?>
<img width="16px" height="16px" title="<?=$arSearch[$ps]["NAME"]?>" src="../img/search/<?=$arSearch[$ps]["IMG"]?>">
<?}?>
		</div>
	</div>
<?}?>
</div>
<?php }else{ ?>
<div style="margin-bottom: 10px;color: #848484;text-align: center;">Нет данных</div>
<?php }?>
</div>
<?php }else{?>
<div style="margin-bottom: 10px;color: #848484;text-align: center;">Нет доступа</div>
<?php }?>
