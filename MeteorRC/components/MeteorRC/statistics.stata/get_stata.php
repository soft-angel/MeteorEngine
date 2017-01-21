<?if(!defined("PROLOG_INCLUDED") || PROLOG_INCLUDED!==true)die();?>
<?
ini_set('display_errors', 0);
//require_once($_SERVER["DOCUMENT_ROOT"]."/MeteorRC/main/include/before.php");
global $APPLICATION;
global $USER;
global $CONFIG;
include('helper.php');
$Stata = new Stata;
$arColor = array('#00acac', '#348fe2', '#CD5C5C', '#CD853F', '#F4A460', '#B22222', '#FFA500', '#C71585', '#DA70D6', '#C1CDC1', '#836FFF', '#0000FF', '#00E5EE', '#BCD2EE', '#76EEC6', '#00EE00', '#EEEE00', '#8B658B', '#FF6A6A', '#FF7F24', '#FF6347', '#FF3E96', '#B452CD');

$arUsers = $APPLICATION->GetFileArray(FILE_USER);
if(!empty($arUsers)){
	foreach ($arUsers as $ip => $user){
		$arUserSort[$user["TIME"]] = $user;
		if($user["Q"])
			$arQCount++;
		// Считаем количество хитов
		$user["CNT"]++;
		$userDayCount = ($userDayCount + $user["CNT"]);
	}
}
$_GET["limit"] = "all";
$arCountries = $arQ = $arBrowsers = $arCities = $arUserCount = $arQlist = $arGoogle = $arMail = $arYandex = $arYahoo = array();
$userAllCount = $userAllVisit = 0;
if($arFile = $arFileAll = glob(PATCH_USER . '/*.php')){
    if(isset($_GET["limit"]) and $_GET["limit"] != "all")
        $arFile = array_slice($arFile, -$_GET["limit"]);
    foreach ($arFile as $file){
        $arAllUser = $APPLICATION->GetFileArray($file);
        $count = false;
        unset($date);
        foreach($arAllUser as $arUser){
            //Получаем тайм дня
            if(!isset($date))$date = date("Y-m-d", $arUser["TIME"]);
			if(isset($arUser["Q"]["Q"])){
				$arPSCount[$date][$arUser["Q"]["NAME"]]++;

				$arQlist[$arUser["Q"]["Q"]]["NAME"][] = $arUser["Q"]["NAME"];
				$arQlist[$arUser["Q"]["Q"]]["CNT"] = ($arQlist[$arUser["Q"]["Q"]]["CNT"] + 1);
				$arQlist[$arUser["Q"]["Q"]]["VIEWS"] = ($arQlist[$arUser["Q"]["Q"]]["VIEWS"] + $arUser["CNT"]?$arUser["CNT"]:1);
			}
			//Считаем браузеры
			if(isset($arUser["BRW"]))
				$arBrowsers[] = $arUser["BRW"];
			if(isset($arUser["CITY"]))
				$arCities[$arUser["CITY"]]++;
			if(isset($arUser["CTR"]))
				$arCountries[$arUser["CTR"]]++;
			//Определение трафика
			if(isset($arUser["Q"]["NAME"])){
				$arTraffic["С поисковых систем"]++;
			}elseif(isset($arUser["REFERER"])){
				if(stristr($arUser["REFERER"], 'vk.com') !== false
					or stristr($arUser["REFERER"], 'odnoklassniki.ru') !== false
					or stristr($arUser["REFERER"], 'facebook.com') !== false
					or stristr($arUser["REFERER"], 'twitter.com') !== false
					or stristr($arUser["REFERER"], 'plus.google.com') !== false
					or stristr($arUser["REFERER"], 'ok.ru') !== false
					or stristr($arUser["REFERER"], 'ask.fm') !== false
					or stristr($arUser["REFERER"], 'linkedin.com') !== false
					or stristr($arUser["REFERER"], 'pinterest.com') !== false
				){
					$arTraffic["Из социальных сетей"]++;
				}elseif(stristr($arUser["REFERER"], $_SERVER['SERVER_NAME']) !== false){
					$arTraffic["Внутренние переходы"]++;
				}elseif(isset($arUser["REFERER"])){
					$arTraffic["По ссылкам на сайтах"]++;
				}
			}else{
				$arTraffic["Прямые заходы"]++;
			}
            //Считаем поисковые системы
            if(isset($arUser["Q"]["NAME"]))
                $arPs[] = $arUser["Q"]["NAME"];
            //Считаем просмотры
            $arUser["CNT"] = (isset($arUser["CNT"]))?$arUser["CNT"]:1;

            // Получаем посетителей за день
            $userAllVisit++; 
            //Получаем просмотры за день
            $userAllCount = ($arUser["CNT"] + $userAllCount);
			//Считаем посещение для графика по дадам
			$arUserCount[$date]["COUNT"] = ($arUserCount[$date]["COUNT"] + $arUser["CNT"]);
			$arUserCount[$date]["USERS"]++;
        }
        //Считаем посетителей
        $userCount = (count($arAllUser) + $userCount);
		$arQ[$date] = $arQ[$date]?$arQ[$date]:0;
		$arYandex[$date] = isset($arYandex[$date])?$arYandex[$date]:0;
		$arGoogle[$date] = isset($arGoogle[$date])?$arGoogle[$date]:0;
		$arMail[$date] = isset($arMail[$date])?$arMail[$date]:0;
		$arYahoo[$date] = isset($arYahoo[$date])?$arYahoo[$date]:0;
        
    }
}
//p($arTraffic);
if(isset($arPs))
    $arPsCount = array_count($arPs);
if(isset($arBrowsers))
		$arBrowserCount = array_count($arBrowsers);
//if($arCountries)
		//$arCountryCount = array_count($arCountries);

//print_r($arBrowserCount);
?>