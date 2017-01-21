<?$arBot = $Stata->GetFileArray(PATCH_BOT . '/' . $date . '.php');?>
<?
if(count($arBot) > 0){
	foreach ($arBot as $ip => $bot){
		$arBotSort[$bot["TIME"]] = $bot;
		$arBotsName[] = $bot["U_A"];
	}

	$arBotsCount = array_count($arBotsName);
	asort($arBotsCount);
	$arBotsCount = array_slice($arBotsCount, -4);
}
?>
<div class="head">
<div class="head_wrap">
<?
if($arBotsCount)
while (list ($key, $val) = each($arBotsCount)){?>
<span class="top_list"><?if($arBots[$key]){?><img width="16px" height="16px" src="interface/img/bot/<?=$arBots[$key]["IMG"]?>"><?}?>&nbsp;<?=$key?>:&nbsp;<?=$val?></span>
<?}?>
</div>
</div>

<div class="left_list">
<ul>
<?
if($arBotSort){
foreach (array_reverse($arBotSort) as $bot){?>
<li>
<span class="name"><?if($arBots[$bot["U_A"]]){?><img width="16px" height="16px" src="interface/img/bot/<?=$arBots[$bot["U_A"]]["IMG"]?>"><?}?> <?=$bot["U_A"]?></span>
<span class="time"><i class="fa fa-clock-o"></i> <?=date("d.m.Y", $bot["TIME"])?> <b><?=date("H:i:s", $bot["TIME"])?></b></span>
<span class="city"><?=$bot["CITY"]?></span>
<span class="country"><?if($arCountry[$bot["CTR"]]){?><img width="16px" height="16px" title="<?=$arCountry[$bot["CTR"]]["NAME"]?>" src="interface/img/country/<?=$arCountry[$bot["CTR"]]["IMG"]?>"><?}else{?><?=$bot["CTR"]?><?}?></span>
<?if($bot["URL"]){?>
<p class="link"><span>Индексируемая страница:</span> <a target="_blank" data-href="<?=$bot["URL"]?>" href="//<?=$bot["URL"]?>"><?=$bot["URL"]?></a></p>
<?}?>
</li>
<?}?>
</ul>
<?}else{?>
<p class="nodata"><i class="fa fa-exclamation-triangle"></i> Нет данных</p>
<?}?>

<?unset($arBot)?>
</div>