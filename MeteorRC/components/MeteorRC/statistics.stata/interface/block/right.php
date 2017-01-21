<?$arUser = $Stata->GetFileArray(PATCH_USER . '/' . $date . '.php');?>
<?
if(count($arUser) > 0){
	foreach ($arUser as $ip => $user){
		$arUserSort[$user["TIME"]] = $user;
		if($user["Q"])
			$arQName[] = $user["Q"]["NAME"];
		// Считаем количество хитов
		$user["CNT"] = $user["CNT"]?$user["CNT"]:1;
		$userCount = ($userCount + $user["CNT"]);
	}
	if($arQCount){
		$arQCount = array_count($arQName);
		asort($arQCount);
		$arQCount = array_slice($arQCount, -2);
	}
}
?>
<div class="head">
<div class="head_wrap">
<span><i title="Просмотров" class="fa fa-eye"></i> <?=$userCount?></span>
<span><i title="Пользователей" class="fa fa-users"></i> <?=count($arUser)?></span>
<?
if($arQCount)
while (list ($key, $val) = each($arQCount)){?>
<span class="top_list"><img width="16px" height="16px" src="interface/img/search/<?=$arSearch[$key]["IMG"]?>">&nbsp;<?=$key?>:&nbsp;<?=$val?></span>
<?}?>
<form action="" method="GET">
<input onchange="" class="form" type="date" name="date" value="<?=$_GET[ 'date' ]?$_GET[ 'date' ]:date("Y-m-d")?>">
<button class="button"><i class="fa fa-check"></i></button>
</form>
</div>
</div>

<div class="right_list">
<ul>
<?
if($arUserSort){
foreach (array_reverse($arUserSort) as $ip => $user){?>
<li>
<p>
<span class="time"><i class="fa fa-clock-o"></i> <?=date("d.m.Y", $user["TIME"])?> <b><?=date("H:i:s", $user["TIME"])?></b></span>
<span class="name"><?=$user["U_A"]?></span>
<span class="count">Просмотров: <b><?=$user["CNT"]?$user["CNT"]:1?></b></span>
<span class="city"><?=$user["CITY"]?$user["CITY"]:"?"?></span>
<span class="country"><?if($arCountry[$user["CTR"]]){?><img width="16px" height="16px" title="<?=$arCountry[$user["CTR"]]["NAME"]?>" src="interface/img/country/<?=$arCountry[$user["CTR"]]["IMG"]?>"><?}else{?><?=$user["CTR"]?><?}?></span>
</p>
<?if($user["OS"]){?>
<span class="os"><img width="16px" height="16px" src="interface/img/os/<?=$arOs[$user["OS"]]["IMG"]?>"> <?=$arOs[$user["OS"]]["NAME"]?$arOs[$user["OS"]]["NAME"]:$user["OS"]?></span>
<?}?>
<?if($user["BRW"]){?>
<span class="browser"><img width="16px" height="16px" src="interface/img/browser/<?=$arBrowser[$user["BRW"]]["IMG"]?>"> <?=$arBrowser[$user["BRW"]]["NAME"]?$arBrowser[$user["BRW"]]["NAME"]:$user["BRW"]?></span>
<?}?>
<?if($user["Q"]["NAME"]){?>
<span class="search"><img width="16px" height="16px" title="<?=$arSearch[$user["Q"]["NAME"]]["NAME"]?>" src="interface/img/search/<?=$arSearch[$user["Q"]["NAME"]]["IMG"]?>"> <b><?=$user["Q"]["Q"]?></b></span>
<?}?>
<?if($user["URL"]){?>
<p class="link"><span>Страница:</span> <a target="_blank" data-href="<?=$user["URL"]?>" href="//<?=$user["URL"]?>"><?=$user["URL"]?></a></p>
<?}?>
</li>
<?}?>
</ul>
<?}else{?>
<p class="nodata"><i class="fa fa-exclamation-triangle"></i> Нет данных</p>
<?}?>

<?unset($arUser)?>
</div>