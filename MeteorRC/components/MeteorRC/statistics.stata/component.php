<?
include('helper.php');
$Stata = new Stata;


$arCity = $USER->GetCity();
//p($arCity);
// Определение бота
if ($userAgent = getBOT($_SERVER['HTTP_USER_AGENT'])) {
	 if ($Stata->config["botssstat"] == 'Y') {
		$arBot = $APPLICATION->GetFileArray(FILE_BOT);
		$arBot[$USER->GetIp()] = array(
			'TIME' => time(),
			'U_A' => $userAgent,
			'CTR' => $arCity['COUNTRY'],
			'CITY' => $arCity['CITY']['NAME'],
			'GEO' => $arCity['CITY']['LAT'] . ',' . $arCity['CITY']['LON'],
			'URL' => $Stata->url,
		);
		// Запись данных
		$APPLICATION->ArrayWriter($arBot, FILE_BOT);
	 }
} else {
    if ($domain = getOTHBOTdomain($Stata->hostname) or $userAgent = getOTHBOT($_SERVER['HTTP_USER_AGENT'])) {
        if ($Stata->config["otherrobots"] == 'Y') {
			$arOthBot = $APPLICATION->GetFileArray(FILE_OTH_BOT);
			$arOthBot[$USER->GetIp()] = array(
				'TIME' => time(),
				'U_A' => $userAgent,
				'CTR' => $arCity['COUNTRY'],
				'CITY' => $arCity['CITY']['NAME'],
				'GEO' =>$arCity['CITY']['LAT'] . ',' . $arCity['CITY']['LON'],
				'HOST' => $domain,
				'URL' => $Stata->url,
			);
			// Запись данных
			$APPLICATION->ArrayWriter($arOthBot, FILE_OTH_BOT);
        }
    } else {
		$_SESSION["STATA"][date("Y-m-d")] = 0;
        $_SESSION["STATA"][date("Y-m-d")]++;
        if($_SESSION["STATA"][date("Y-m-d")] > 0){
        	define("STATA_IS_USER", true);
        }

        if(!isset($_SESSION["STATA"][$_SERVER['REQUEST_URI']]))
			$_SESSION["STATA"][$_SERVER['REQUEST_URI']] = 0;
        $_SESSION["STATA"][$_SERVER['REQUEST_URI']]++;
        if($_SESSION["STATA"][$_SERVER['REQUEST_URI']] == 1){
        	define("STATA_IS_USER_UNIQ_PAGE", true);
        }

        if ($_SESSION["STATA"][date("Y-m-d")] == 1) {
            if ($browser = getBROWSER($_SERVER['HTTP_USER_AGENT'])) {
                // Запись Юзера
				if ($Stata->config["usersstat"] == 'Y') {
					$arUser = $APPLICATION->GetFileArray(FILE_USER);
					// Был ли ранее записан
					if(isset($arUser[$USER->GetIp()])){
						// Если да, то прибавлям посещение и последний тайм
						$arUser[$USER->GetIp()]['CNT'] = ($arUser[$USER->GetIp()]['CNT'] + 1);
						$arUser[$USER->GetIp()]['LAST_TIME'] = time();
					}else{
						$arUser[$USER->GetIp()] = array(
							'TIME' => time(),
							'CTR' => $arCity['COUNTRY'],
							'CITY' => $arCity['CITY']['NAME'],
							'GEO' =>$arCity['CITY']['LAT'] . ',' . $arCity['CITY']['LON'],
							'URL' => $Stata->url,
						);
						if($os = getOS($_SERVER['HTTP_USER_AGENT']))
							$arUser[$USER->GetIp()]['OS'] = $os;
						if($q = getQ($Stata->referer, true))
							$arUser[$USER->GetIp()]['Q'] = $q;
						if($Stata->referer and !$q)
							$arUser[$USER->GetIp()]['REFERER'] = $Stata->referer;
						if($browser)
							$arUser[$USER->GetIp()]['BRW'] = $browser;
					}
					// Запись данных
					$APPLICATION->ArrayWriter($arUser, FILE_USER);
					//Задаем константу, которая будет значить, что запрос от пользователя а не бота
				}
            } else {
                if ($Stata->config["otherusers"] == 'Y') {
					$arUser = $APPLICATION->GetFileArray(FILE_OTH_USER);
					$arUser[$USER->GetIp()] = array(
						'TIME' => time(),
						'U_A' => $_SERVER['HTTP_USER_AGENT'],
						'CTR' => $arCity['COUNTRY'],
						'CITY' => $arCity['CITY']['NAME'],
						'GEO' =>$arCity['CITY']['LAT'] . ',' . $arCity['CITY']['LON'],
						'URL' => $http_host . $request_url,
						'REFERER' => $Stata->referer,
						'URL' => $Stata->url,
					);
					// Запись данных
					$APPLICATION->ArrayWriter($arUser, FILE_OTH_USER);
                }
            }
        }
    }
}