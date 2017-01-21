<?php
// Определение файлов и путей
defined("ROOT_PATH") || define("ROOT_PATH", __DIR__);

defined("PATCH_USER") || define("PATCH_USER", (STATA_PATCH . '/user'));
defined("PATCH_OTH_USER") || define("PATCH_OTH_USER", (STATA_PATCH . '/user/oth'));
defined("PATCH_BOT") || define("PATCH_BOT", (STATA_PATCH . '/bot'));
defined("PATCH_OTH_BOT") || define("PATCH_OTH_BOT", (STATA_PATCH . '/bot/oth'));

defined("FILE_USER") || define("FILE_USER", (PATCH_USER . '/' . date("Y-m-d") . '.php'));
defined("FILE_OTH_USER") || define("FILE_OTH_USER", (PATCH_OTH_USER . '/' . date("Y-m-d") . '.php'));
defined("FILE_BOT") || define("FILE_BOT", (PATCH_BOT . '/' . date("Y-m-d") . '.php'));
defined("FILE_OTH_BOT") || define("FILE_OTH_BOT", (PATCH_OTH_BOT . '/' . date("Y-m-d") . '.php'));
defined("STATA_PROLOG_INCLUDED") || define("STATA_PROLOG_INCLUDED", true);
//
// Проверка домена
$request_url      = $_SERVER['REQUEST_URI'];
$http_host        = $_SERVER['HTTP_HOST'];
?>
<?php
// Массив присваивания значка и названия страны
$arCountry = array(
	'RU' => array('NAME' => 'Россия', 'IMG' => 'ru.png'),
	'AU' => array('NAME' => 'Австралия', 'IMG' => 'au.png'),
	'UA' => array('NAME' => 'Украина', 'IMG' => 'ua.png'),
	'VI' => array('NAME' => 'Американские Виргинские острова', 'IMG' => 'vi.png'),
	'US' => array('NAME' => 'США', 'IMG' => 'us.png'),
	'BY' => array('NAME' => 'Белоруссия', 'IMG' => 'by.png'),
	'CZ' => array('NAME' => 'Чехия', 'IMG' => 'cz.png'),
	'VG' => array('NAME' => 'Британские Виргинские острова', 'IMG' => 'vg.png'),
	'NL' => array('NAME' => 'Нидерланды', 'IMG' => 'nl.png'),
	'FR' => array('NAME' => 'Франция', 'IMG' => 'fr.png'),
	'DE' => array('NAME' => 'Германия', 'IMG' => 'de.png'),
	'KZ' => array('NAME' => 'Казахстан', 'IMG' => 'kz.png'),
	'AT' => array('NAME' => 'Австрия', 'IMG' => 'at.png'),
	'IT' => array('NAME' => 'Италия', 'IMG' => 'it.png'),
	'CN' => array('NAME' => 'Китай', 'IMG' => 'cn.png'),
	'LT' => array('NAME' => 'Литва', 'IMG' => 'lt.png'),
	'ES' => array('NAME' => 'Испания, Канары', 'IMG' => 'es.png'),
	'TR' => array('NAME' => 'Турция', 'IMG' => 'tr.png'),
	'LK' => array('NAME' => 'Шри-Ланка (Цейлон)', 'IMG' => 'lk.png'),
	'TW' => array('NAME' => 'Тайвань', 'IMG' => 'tw.png'),
	'AZ' => array('NAME' => 'Азербайджан', 'IMG' => 'az.png'),
	'EU' => array('NAME' => 'Евросоюз', 'IMG' => 'eu.png'),
	'CA' => array('NAME' => 'Канада', 'IMG' => 'ca.png'),
	'RS' => array('NAME' => 'Сербия', 'IMG' => 'rs.png'),
	'AM' => array('NAME' => 'Армения', 'IMG' => 'am.png'),
	'PT' => array('NAME' => 'Португалия', 'IMG' => 'pt.png'),
	'ZA' => array('NAME' => 'ЮАР', 'IMG' => 'za.png'),
	'GB' => array('NAME' => 'Великобритания', 'IMG' => 'gb.png'),
	'IL' => array('NAME' => 'Израиль', 'IMG' => 'il.png'),
	'RO' => array('NAME' => 'Румыния', 'IMG' => 'ro.png'),
	'PL' => array('NAME' => 'Польша', 'IMG' => 'pl.png'),
	'AO' => array('NAME' => 'Ангола', 'IMG' => 'ao.png'),
	'IN' => array('NAME' => 'Индия', 'IMG' => 'in.png'),
);
?>
<?php
// Массив присваивания значка и названия os
$arOs = array(
	'Macintosh' => array('NAME' => 'Macintosh', 'IMG' => 'Macintosh.png', 'TYPE' => 'PC'),
	'Windows XP' => array('NAME' => 'Windows XP', 'IMG' => 'Windows_XP.png', 'TYPE' => 'PC'),
	'Windows 7' => array('NAME' => 'Windows 7', 'IMG' => 'Windows_7.png', 'TYPE' => 'PC'),
	'Ubuntu' => array('NAME' => 'Ubuntu', 'IMG' => 'Ubuntu.png', 'TYPE' => 'PC'),
	'Linux' => array('NAME' => 'Linux', 'IMG' => 'Linux.png', 'TYPE' => 'PC'),
	'Windows Vista' => array('NAME' => 'Windows Vista', 'IMG' => 'Windows_Vista.png', 'TYPE' => 'PC'),
	'Windows Phone' => array('NAME' => 'Windows Phone', 'IMG' => 'Windows_Phone.png', 'TYPE' => 'PC'),
	'Windows 8' => array('NAME' => 'Windows 8', 'IMG' => 'Windows_8.png', 'TYPE' => 'PC'),
	'Windows 10' => array('NAME' => 'Windows 10', 'IMG' => 'Windows_10.png', 'TYPE' => 'PC'),
	
	'iPhone' => array('NAME' => 'iPhone', 'IMG' => 'iPhone.png', 'TYPE' => 'PHONE'),
	'iPhone IOS 10' => array('NAME' => 'iPhone IOS 10', 'IMG' => 'iPhone.png', 'TYPE' => 'PHONE'),
	'iPhone IOS 9' => array('NAME' => 'iPhone IOS 9', 'IMG' => 'iPhone.png', 'TYPE' => 'PHONE'),
	'iPhone IOS 8' => array('NAME' => 'iPhone IOS 8', 'IMG' => 'iPhone.png', 'TYPE' => 'PHONE'),
	'iPhone IOS 7' => array('NAME' => 'iPhone IOS 7', 'IMG' => 'iPhone.png', 'TYPE' => 'PHONE'),
	'iPhone IOS 6' => array('NAME' => 'iPhone IOS 6', 'IMG' => 'iPhone.png', 'TYPE' => 'PHONE'),
	'iPhone IOS 5' => array('NAME' => 'iPhone IOS 5', 'IMG' => 'iPhone.png', 'TYPE' => 'PHONE'),
	'iPhone IOS 4' => array('NAME' => 'iPhone IOS 4', 'IMG' => 'iPhone.png', 'TYPE' => 'PHONE'),
	'iPhone IOS 3' => array('NAME' => 'iPhone IOS 3', 'IMG' => 'iPhone.png', 'TYPE' => 'PHONE'),
	'iPhone IOS 2' => array('NAME' => 'iPhone IOS 2', 'IMG' => 'iPhone.png', 'TYPE' => 'PHONE'),
	
	'iPad IOS 10' => array('NAME' => 'iPad IOS 10', 'IMG' => 'IPad.png', 'TYPE' => 'TABLET'),
	'iPad IOS 9' => array('NAME' => 'iPad IOS 9', 'IMG' => 'IPad.png', 'TYPE' => 'TABLET'),
	'iPad IOS 8' => array('NAME' => 'iPad IOS 8', 'IMG' => 'IPad.png', 'TYPE' => 'TABLET'),
	'iPad IOS 7' => array('NAME' => 'iPad IOS 7', 'IMG' => 'IPad.png', 'TYPE' => 'TABLET'),
	'iPad IOS 6' => array('NAME' => 'iPad IOS 6', 'IMG' => 'IPad.png', 'TYPE' => 'TABLET'),
	'iPad IOS 5' => array('NAME' => 'iPad IOS 5', 'IMG' => 'IPad.png', 'TYPE' => 'TABLET'),
	'iPad IOS 4' => array('NAME' => 'iPad IOS 4', 'IMG' => 'IPad.png', 'TYPE' => 'TABLET'),
	'iPad IOS 3' => array('NAME' => 'iPad IOS 3', 'IMG' => 'IPad.png', 'TYPE' => 'TABLET'),
	'iPad IOS 2' => array('NAME' => 'iPad IOS 2', 'IMG' => 'IPad.png', 'TYPE' => 'TABLET'),
	'iPad' => array('NAME' => 'iPad', 'IMG' => 'IPad.png', 'TYPE' => 'TABLET'),

	'Android' => array('NAME' => 'Android', 'IMG' => 'Android.png', 'TYPE' => 'PHONE'),
	'Android 1.5' => array('NAME' => 'Android 1.5', 'IMG' => 'Android.png', 'TYPE' => 'PHONE'),
	'Android 1.6' => array('NAME' => 'Android 1.6', 'IMG' => 'Android.png', 'TYPE' => 'PHONE'),
	'Android 2' => array('NAME' => 'Android 2', 'IMG' => 'Android.png', 'TYPE' => 'PHONE'),
	'Android 4' => array('NAME' => 'Android 4', 'IMG' => 'Android.png', 'TYPE' => 'PHONE'),
	'Android 5' => array('NAME' => 'Android 5', 'IMG' => 'Android.png', 'TYPE' => 'PHONE'),
	'Android 6' => array('NAME' => 'Android 6', 'IMG' => 'Android.png', 'TYPE' => 'PHONE'),
	'Android 7' => array('NAME' => 'Android 7', 'IMG' => 'Android.png', 'TYPE' => 'PHONE'),
	'Android 8' => array('NAME' => 'Android 8', 'IMG' => 'Android.png', 'TYPE' => 'PHONE'),
);
?>
<?php
// Массив присваивания значка и названия ,браузера
$arBrowser = array(
	'Chrome' => array('NAME' => 'Chrome', 'IMG' => 'Chrome.png'),
	'Firefox' => array('NAME' => 'Firefox', 'IMG' => 'Firefox.png'),
	'Safari' => array('NAME' => 'Safari', 'IMG' => 'Safari.png'),
	'Opera' => array('NAME' => 'Opera', 'IMG' => 'Opera.png'),
	'Chromium' => array('NAME' => 'Chromium', 'IMG' => 'Chromium.png'),
	'YaBrowser' => array('NAME' => 'YaBrowser', 'IMG' => 'YaBrowser.png'),
	'Avant Browser' => array('NAME' => 'Avant Browser', 'IMG' => 'Avant_Browser.png'),
	'Amigo' => array('NAME' => 'Амиго', 'IMG' => 'Amigo.png'),
	'Maxthon' => array('NAME' => 'Maxthon', 'IMG' => 'Maxthon.png'),
	'MSIE 6.0' => array('NAME' => 'Internet Explorer 6', 'IMG' => 'MSIE.png'),
	'MSIE 7.0' => array('NAME' => 'Internet Explorer 7', 'IMG' => 'MSIE.png'),
	'MSIE 8.0' => array('NAME' => 'Internet Explorer 8', 'IMG' => 'MSIE.png'),
	'MSIE 9.0' => array('NAME' => 'Internet Explorer 9', 'IMG' => 'MSIE.png'),
	'MSIE 10.0' => array('NAME' => 'Internet Explorer 10', 'IMG' => 'MSIE.png'),
	'MSIE 11.0' => array('NAME' => 'Internet Explorer 11', 'IMG' => 'MSIE.png'),
	'MSIE 12.0' => array('NAME' => 'Internet Explorer 12', 'IMG' => 'MSIE.png'),
	'Edge' => array('NAME' => 'Microsoft Edge', 'IMG' => 'Edge.png'),
);
?>
<?php
// Массив присваивания значка и названия Ботов
$arBots = array(
	'YandexBot' => array('NAME' => 'Yandex Bot', 'IMG' => 'Yandex.png'),
	'Baiduspider' => array('NAME' => 'Baiduspider', 'IMG' => 'Baiduspider.png'),
	'Google' => array('NAME' => 'Google Bot', 'IMG' => 'Google.png'),
	'Bing' => array('NAME' => 'Bing', 'IMG' => 'Bing.png'),
	'Hot Bot search' => array('NAME' => 'Hot Bot search', 'IMG' => 'HotBot.png'),
	'Exabot' => array('NAME' => 'Exabot', 'IMG' => 'Exabot.png'),
	'Mail' => array('NAME' => 'Mail', 'IMG' => 'Mail.png'),
);
?>
<?php
// Массив присваивания значка и названия ПС
$arSearch = array(
	'Yandex' => array('NAME' => 'Яндекс', 'IMG' => 'Yandex.png', 'DESCRIPTION' => ''),
	'Google' => array('NAME' => 'Google', 'IMG' => 'Google.png', 'DESCRIPTION' => ''),
	'ASK' => array('NAME' => 'ASK', 'IMG' => 'ASK.png', 'DESCRIPTION' => ''),
	'Yahoo' => array('NAME' => 'Yahoo', 'IMG' => 'Yahoo.png', 'DESCRIPTION' => ''),
	'Nigma' => array('NAME' => 'Nigma', 'IMG' => 'Nigma.png', 'DESCRIPTION' => ''),
	'Yandex maps' => array('NAME' => 'Яндекс карты', 'IMG' => 'Yandex_maps.png', 'DESCRIPTION' => ''),
	'Yandex images' => array('NAME' => 'Яндекс картинки', 'IMG' => 'Yandex_images.png', 'DESCRIPTION' => ''),
	'Yandex market' => array('NAME' => 'Яндекс маркет', 'IMG' => 'Yandex_market.png', 'DESCRIPTION' => ''),
	'Yandex video' => array('NAME' => 'Яндекс видео', 'IMG' => 'Yandex_video.png', 'DESCRIPTION' => ''),
	'Webalta' => array('NAME' => 'Webalta', 'IMG' => 'Webalta.png', 'DESCRIPTION' => ''),
	'Bing' => array('NAME' => 'Bing', 'IMG' => 'Bing.png', 'DESCRIPTION' => ''),
	'BuenoSearch' => array('NAME' => 'BuenoSearch', 'IMG' => 'BuenoSearch.png', 'DESCRIPTION' => ''),
	'Exalead' => array('NAME' => 'Exalead', 'IMG' => 'Exalead.png', 'DESCRIPTION' => ''),
	'Mail' => array('NAME' => 'Mail', 'IMG' => 'Mail.png', 'DESCRIPTION' => ''),
	'Baidu' => array('NAME' => 'Baidu', 'IMG' => 'Baidu.png', 'DESCRIPTION' => ''),
	'Easou' => array('NAME' => 'Easou', 'IMG' => 'Easou.png', 'DESCRIPTION' => ''),
	'Sogou' => array('NAME' => 'Sogou', 'IMG' => 'Sogou.png', 'DESCRIPTION' => ''),
	'Dogpile' => array('NAME' => 'Dogpile', 'IMG' => 'Dogpile.png', 'DESCRIPTION' => ''),
	'Beaucoup' => array('NAME' => 'Beaucoup', 'IMG' => 'Beaucoup.png', 'DESCRIPTION' => ''),
	'Allonesearch' => array('NAME' => 'Allonesearch', 'IMG' => 'Allonesearch.png', 'DESCRIPTION' => ''),
	'Meta' => array('NAME' => 'Meta', 'IMG' => 'Meta.png', 'DESCRIPTION' => ''),
	'Каталог Mail' => array('NAME' => 'Каталог Mail', 'IMG' => 'Mail_catalog.png', 'DESCRIPTION' => ''),
	'Lycos' => array('NAME' => 'Lycos', 'IMG' => 'Lycos.png', 'DESCRIPTION' => ''),
	'Astalavista' => array('NAME' => 'Astalavista', 'IMG' => 'Astalavista.png', 'DESCRIPTION' => ''),
	'Excite' => array('NAME' => 'Excite', 'IMG' => 'Excite.png', 'DESCRIPTION' => ''),
	'Filez' => array('NAME' => 'Filez', 'IMG' => 'Filez.png', 'DESCRIPTION' => ''),
	'HotBot' => array('NAME' => 'HotBot', 'IMG' => 'HotBot.png', 'DESCRIPTION' => ''),
);
?>
<?php
// Функция определения браузера и присвоение значка
if(!function_exists('getBROWSER')){
	function getBROWSER($user_agent_browser){
	    // Создадим список операционных систем в виде элементов массива
	    $user_browser = array(
	        'Edge' => 'Edge',
	        'Opera' => '(Opera)|(Presto)|(Opera Mobi)|(Opera Mini)|(OPR)|(Edition Campaign )',
	        'Firefox' => 'Firefox',
	        'Chromium' => 'Chromium',
	        'Chrome' => 'Chrome',
	        'Safari' => 'Safari',
	        'MSIE 6.0' => 'MSIE 6.0',
	        'MSIE 7.0' => 'MSIE 7.0',
	        'MSIE 8.0' => 'MSIE 8.0',
	        'MSIE 9.0' => 'MSIE 9.0',
	        'MSIE 10.0' => 'MSIE 10.0',
	        'MSIE 11.0' => 'MSIE 11.0',
	        'MSIE 12.0' => 'MSIE 12.0',
			'Maxthon' => 'Maxthon',
	        'Avant Browser' => 'Avant Browser',
	        'Amigo' => '(MRCHROME SOC)|(Amigo)',
	        'YaBrowser' => 'YaBrowser',
	        'Trident/7' => 'Trident/7',
	    );
	    foreach ($user_browser as $browser => $pattern) {
	        if (mb_ereg($pattern, $user_agent_browser)) {
	            return $browser;
	        }
	    }
	    return false;
	}
}
?>
<?php
// Функция определения OS
if(!function_exists('getOS')){
	function getOS($userAgent){
	    // Создадим список операционных систем в виде элементов массива
	    $oses = array(
	        'Windows Phone' => 'Windows Phone',
			
	        'Android 0.5' => 'Android 0.5',
	        'Android 1.5' => 'Android 1.5',
	        'Android 1.6' => 'Android 1.6',
	        'Android 2' => 'Android 2',
	        'Android 3' => 'Android 3',
	        'Android 4' => 'Android 4',
	        'Android 5' => 'Android 5',
	        'Android 6' => 'Android 6',
	        'Android 7' => 'Android 7',
	        'Android 8' => 'Android 8',
	        'Android' => 'Android',
	        
	        'iPhone IOS 10' => '(iPhone; U; CPU iPhone OS 10_)',
	        'iPhone IOS 9' => '(iPhone; U; CPU iPhone OS 9_)',
	        'iPhone IOS 8' => '(iPhone; U; CPU iPhone OS 8_)',
	        'iPhone IOS 7' => '(iPhone; U; CPU iPhone OS 7_)',
	        'iPhone IOS 6' => '(iPhone; U; CPU iPhone OS 6_)',
	        'iPhone IOS 5' => '(iPhone; U; CPU iPhone OS 5_)',
	        'iPhone IOS 4' => '(iPhone; U; CPU iPhone OS 4)',
	        'iPhone IOS 3' => '(iPhone; U; CPU iPhone OS 3_)',
	        'iPhone IOS 2' => '(iPhone; U; CPU iPhone OS 2_)',
	        'iPhone' => '(iPhone)',
	        
	        
	        'iPad IOS 10' => '(iPad; U; CPU iPhone OS 10_)|(iPad; CPU OS 10_)',
	        'iPad IOS 9' => '(iPad; U; CPU iPhone OS 9_)|(iPad; CPU OS 9_)',
	        'iPad IOS 8' => '(iPad; U; CPU iPhone OS 8_)|(iPad; CPU OS 8_)',
	        'iPad IOS 7' => '(iPad; U; CPU iPhone OS 7_)|(iPad; CPU OS 7_)',
	        'iPad IOS 6' => '(iPad; U; CPU iPhone OS 6_)|(iPad; CPU OS 6_)',
	        'iPad IOS 5' => '(iPad; U; CPU iPhone OS 5_)|(iPad; CPU OS 5_)',
	        'iPad IOS 4' => '(iPad; U; CPU iPhone OS 4_)|(iPad; CPU OS 4_)',
	        'iPad IOS 3' => '(iPad; U; CPU iPhone OS 3_)|(iPad; CPU OS 3_)',
	        'iPad IOS 2' => '(iPad; U; CPU iPhone OS 2_)|(iPad; CPU OS 2_)',
	        'iPad' => '(iPad)',
	        'iPod' => '(iPod)',
	        'Symbian' => 'Symbian',
	        'J2ME/MIDP' => 'J2ME/MIDP',
	        'Bada' => 'Bada',
	        'Windows 3.11' => 'Win16',
	        'Windows 95' => '(Windows 95)|(Win95)|(Windows_95)', // Используем регулярное выражение
	        'Windows 98' => '(Windows 98)|(Win98)',
	        'Windows 2000' => '(Windows NT 5.0)|(Windows 2000)',
	        'Windows XP' => '(Windows NT 5.1)|(Windows XP)',
	        'Windows 2003' => '(Windows NT 5.2)',
	        'Windows Vista' => '(Windows NT 6.0)|(Windows Vista)',
	        'Windows 7' => '(Windows NT 6.1)|(Windows 7)',
	        'Windows 8' => '(Windows NT 6.2)|(Windows NT 6.3)|(Windows 8)',
	        'Windows 10' => '(Windows NT 10.0)|(Windows 10)',
	        'Windows' => '(Windows NT 4.0)|(WinNT4.0)|(WinNT)|(Windows NT)',
	        'Windows ME' => 'Windows ME',
	        'Open BSD' => 'OpenBSD',
			'Ubuntu' => 'Ubuntu',
	        'Sun OS' => 'SunOS',
	        'Linux' => '(Linux)|(X11)',
	        'Macintosh' => '(Mac_PowerPC)|(Macintosh)',
	        'QNX' => 'QNX',
	        'BeOS' => 'BeOS',
	        'OS/2' => 'OS/2',
	    );
	    foreach ($oses as $os => $pattern) {
	        if (mb_ereg($pattern, $userAgent)) {
	            return $os;
	        }
	    }
	    return false;
	}
}
?>
<?php
if(!function_exists('getOTHBOTdomain')){
	function getOTHBOTdomain($domain){
	    // Функция определения и присвоения иконок роботам по домену
	    $domain_othbot = array(
	        'Majordomo' => 'majordomo.ru',
	        'Хостинг-робот' => '(masterhost.ru)|(eserver-ru.com)|(datapoint.ru)|(rbinfo.ru)|(redstation.co.uk)|(os3.nl)|(globatel.ru)|(kundenserver.de)|(itrack.ru)|(page-weight.ru)|(hc.ru)|(masterhost.ru)|(ukraine.com.ua)|(peterhost.ru)|(domain.by)|(webservis.ru)|(jino.ru)|(infobox.ru)|(mchost.ru)|(zenon.net)|(timeweb.ru)|(sweb.ru)|(hoster.by)|(umi.ru)|(host.ru)|(host.net)|(hostland.ru)|(valuehost.ru)|(ho.ua)|(netfox.ru)|(hosting)|(komtet.ru)|(centre.ru)|(rusonyx.ru)|(netangels.ru)|(webstolica.ru)|(nic.ua)|(hoster.ru)|(server)|(ruweb.net)',
	        'Sape' => 'ws.controlstyle.ru',
	        'Pingdom' => 'pingdom.com',
	        'PR-CY' => 'pr-cy.ru',
	        'antivirus-alarm.ru' => 'antivirus-alarm.ru',
	        '2ip.ru' => '2ip.ru',
	        'Site-Shot' => 'your-server.de',
	        'AhrefsBot' => 'softlayer.com'
	    );
	    foreach ($domain_othbot as $os => $pattern) {
	        if (mb_ereg($pattern, $domain)) {
	            return $os;
	        }
	    }
	    return false;
	}
}
?>
<?php
// Функция определения и присвоения иконок не поисковым роботам по user agent
if(!function_exists('getOTHBOT')){
	function getOTHBOT($user_agent_bots2){
	    $user_othbot = array(
	        'vkShare ' => 'vkShare',
	        'Openstat</div> ' => 'openstat.ru',
	        'Twitterbot' => 'Twitterbot',
	        'W3C Validator ' => 'W3C_Validator',
	        'W3C CSS Validator JFouffa' => 'W3C_CSS_Validator_JFouffa',
	        'FunWebProducts' => 'FunWebProducts',
	        'BLEXBot' => 'BLEXBot',
	        'Ezooms' => 'Ezooms',
	        'MJ12bot' => 'MJ12bot',
	        'AhrefsBot' => 'AhrefsBot',
	        '!!!Paros!!!' => 'Paros',
	        '!!!URLGrabber!!!' => 'URLGrabber'
	    );
	    foreach ($user_othbot as $os => $pattern) {
	        if (mb_ereg($pattern, $user_agent_bots2)) {
	            return $os;
	        }
	    }
	    return false;
	}
}

// Функция определения и присвоения иконок роботам по user agent
if(!function_exists('getBOT')){
	function getBOT($user_agent_bots){
	    $user_bot = array(
			array('(Mail.RU_Bot)|(Mail.Ru)|(go.mail.ru)', 'Mail'),
			array('Yandex', 'YandexBot'),
			array('(bingbot)|(msn.com)|(msnbot)', 'Bing'),
			array('YandexImages', 'Yandex'),
			array('YaDirectFetcher', 'Yandex'),
			array('YandexCatalog', 'Yandex'),
			array('YandexBlogs', 'Yandex'),
			array('YandexPagechecker', 'Yandex'),
			array('YandexDirect', 'Yandex'),
			array('YandexMetrika', 'Yandex'),
			array('YandexVideo', 'Yandex'),
			array('YandexMedia', 'Yandex'),
			array('YandexFavicons', 'Yandex'),
			array('YandexWebmaster', 'Yandex'),
			array('YandexAntivirus', 'Yandex'),
			array('Yandex', 'Yandex'),
			array('Adsbot-Google', 'Google'),
			array('Googlebot-Image', 'Google'),
			array('Googlebot', 'Google'),
			array('Googlebot-Mobile', 'Google'),
			array('Mediapartners-Google', 'Google'),
			array('Google', 'Google'),
			array('Slurp', 'Hot Bot search'),
			array('WebCrawler', 'WebCrawler search'),
			array('ZyBorg', 'Wisenut search'),
			array('Scooter', 'AltaVista'),
			array('StackRambler', 'Rambler'),
			array('Aport', 'Aport'),
			array('lycos', 'lycos'),
			array('Yahoo', 'Yahoo'),
			array('WebAlta', 'WebAlta'),
			array('ia_archiver', 'Alexa search engine'),
			array('FAST', 'AllTheWeb'),
			array('rv:1.9.2.16', 'Mail Law'),
			array('istella.it', 'istella'),
			array('Nigma.ru', 'Nigma'),
			array('Exabot', 'Exabot'),
			array('Baiduspider', 'Baiduspider'),
			array('EasouSpider', 'EasouSpider'),
			array('sogou.com', 'Sogou')
	    );
	    foreach ($user_bot as $index => $value) {
	        if (mb_ereg($value[0], $user_agent_bots)) {
	            return $value[1];
	        }
	    }
	    return false;
	}
}
?>
<?php
// Функция определения и расшифровки поисковых запросов
if(!function_exists('getQ')){
	function getQ($referer, $name = false){
	    $array = array(
	        array('yandex.', 'text=', 'Yandex'),
			array('google.', 'q=', 'Google'),
	        array('ask.com', 'q=', 'ASK'),
	        array('yahoo.com', 'p=', 'Yahoo'),
	        array('nigma.ru', 's=', 'Nigma'),
	        array('maps.yandex.', 'text=', 'Yandex maps'),
	        array('images.yandex.', 'text=', 'Yandex images'),
	        array('market.yandex.', 'text=', 'Yandex market'),
	        array('yandex.ru/video/', 'text=', 'Yandex video'),
	        array('yandex.com/video/', 'text=', 'Yandex video'),
	        array('yandex.by/video/', 'text=', 'Yandex video'),
	        array('yandex.kz/video/', 'text=', 'Yandex video'),
	        array('yandex.ua/video/', 'text=', 'Yandex video'),
	        array('webalta.ru', 'q=', 'Webalta'),
	        array('bing.com', 'q=', 'Bing'),
	        array('buenosearch.', 'q=', 'BuenoSearch'),
	        array('exalead.com', 'q=', 'Exalead'),
	        array('rambler.ru', 'query=', 'Rambler'),
	        array('http://mail.ru', 'q=', 'Mail'),
	        array('go.mail.ru', 'q=', 'Mail'),
	        array('baidu.com', 'wd=', 'Baidu'),
	        array('easou.com', 'q=', 'Easou'),
	        array('sogou.com', 'query=', 'Sogou'),
	        array('dogpile.com', 'q=', 'Dogpile'),
	        array('beaucoup.com', 'q=', 'Beaucoup'),
	        array('allonesearch.com', 'find=', 'Allonesearch'),
	        array('meta.ua', 'q=', 'Meta' ),
	        array('list.mail.ru', 'q=', 'Каталог Mail' ),
	        array('lycos.com', 'q=', 'Lycos' ),
	        array('astalavista.box.sk', 'srch=', 'Astalavista'),
	        array('excite.com', 'q=', 'Excite'),
	        array('filez.com', 'q=', 'Filez'),
	        array('hotbot.com', 'q=', 'HotBot')
	    );
	   
		foreach ($array as $value) {
			if (stristr($referer, $value[0])) {
				// Расшифровка запроса
				mb_ereg($value[1] . '([^&]*)', $referer . '&', $phrase2);
				if (stristr($phrase2[1], '%F')) {
					$crawler['Q'] = iconv("CP1251", "UTF-8", urldecode($phrase2[1]));
				} else {
					$crawler['Q'] = urldecode($phrase2[1]);
				}	
				if($name){
					$crawler['NAME'] = $value[2];
				}
			}
		}
		if(isset($crawler)){
			if (stristr($crawler['Q'], '√') or stristr($crawler['Q'], 'Є') or stristr($crawler['Q'], 'ї') or stristr($crawler['Q'], 'Ў') or stristr($crawler['Q'], 'Ё') or stristr($crawler['Q'], 'є')) {
		            $crawler['Q'] = iconv('CP1251', 'UTF-8', iconv('UTF-8', 'CP866', $crawler['Q']));
			} else if (stristr($crawler['Q'], '░')) {
				$crawler['Q'] = iconv('UTF-8', 'UTF-8', iconv('UTF-8', 'CP866', $crawler['Q']));
			}
			if ($crawler['NAME'] and !$crawler['Q']) {
				$crawler['Q'] = 'Не определился';
			}
		}
		return isset($crawler)?$crawler:false;
	}
}

if(!function_exists('array_count')){
	function array_count($array){
		if(is_array($array)){
			$array = array_filter($array);
			$array = array_count_values($array);
		}
	    return $array;
	}
}
?>
