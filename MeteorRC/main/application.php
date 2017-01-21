<?
class FIREWALL {
	protected $REQUEST = array();
	function __construct() {
		global $APPLICATION;
		$arUrl = parse_url($_SERVER['REQUEST_URI']);
		if(isset($arUrl["query"]))
			parse_str($arUrl["query"], $this->REQUEST);
		$this->REQUEST = array_merge($this->REQUEST, $_REQUEST);
		//$_SESSION["CHECK"] = $_SESSION["CHECK"]?$_SESSION["CHECK"]:time();
		//if( ($_SESSION["CHECK"] + (60 * 10)) < time() ){
			//$KEY = $this->APPLICATION->GetFileArray($_SERVER["DOCUMENT_ROOT"] . "/MeteorRC/key.php");
			//$license = $this->APPLICATION->CurlGet(
				//'http://cms-claster.ru/check.php?DOMAIN_1=' . $_SERVER["HTTP_HOST"] .
				//'&DOMAIN_2=' . $_SERVER["SERVER_NAME"] .
				//'&URI=' . $_SERVER["SCRIPT_URI"] .
				//'&KEY=' . $KEY["KEY"]
		//	);
			//if(!is_numeric($license)){
			//	die($license);
			//	exit;
			//}else{
			//	$_SESSION["CHECK"] = time();
			//}
		//}
	}
	function GetLicenseKey(){
		global $APPLICATION;
		$arKey = $APPLICATION->GetFileArray(LICENSE_KEY_FILE);
		return isset($arKey["KEY"])?$arKey["KEY"]:false;
	}
	function ProtectedUrl(){
		if (strlen($_SERVER['REQUEST_URI']) > 255 ||
			strpos($_SERVER['REQUEST_URI'], "eval(") ||
			strpos($_SERVER['REQUEST_URI'], "CONCAT") ||
			strpos($_SERVER['REQUEST_URI'], "UNION+SELECT") ||
			strpos($_SERVER['REQUEST_URI'], "base64") ||
			strpos($_SERVER['REQUEST_URI'], "exec(")) {
				//$APPLICATION->AddMessage2Log('Попытка php иньекции', 'Firewall');
				die("Firewall!");
			}
	}
	
	function ProtectedBD(){
		$info = debug_backtrace();
		if($info[2]["class"] != "APPLICATION"){
			//$APPLICATION->AddMessage2Log('Попытка чтения базы данных', 'Firewall');
			die("Firewall!");
		}
	}
	// Фильтрация данных из вне
	function GetString($name){
		if(isset($this->REQUEST[$name]))
			return htmlspecialchars(strip_tags($this->REQUEST[$name]));
	}
	function GetArrayString($name){
		if(isset($this->REQUEST[$name])){
			return array_filter ($this->REQUEST[$name]);
		}
	}
	function GetFloat($name){
		if(isset($this->REQUEST[$name]))
			return (float) $this->REQUEST[$name];
	}
	function GetArrayNumber($name){
		if(isset($this->REQUEST[$name]))
			return array_map('intval', $this->REQUEST[$name]);
	}
	function GetNumber($name){
		if(isset($this->REQUEST[$name]))
			return (int) $this->REQUEST[$name];
	}
}

class APPLICATION extends FIREWALL {
    public $version = '0.8.7';
	public $css = array();
	public $js = array();
	public $javaScript = array();
	public $arrayParam = array();
	public $bdCount = 0;
	public $bdList = array();
	public $bdWriter = 0;
	public $ComponentCount = 0;
	public $ComponentCacheCount = 0;
	public $IncludeFile = 0;
	public $ErrorCount = 0;
	public $bdSize = 0;
	private $queryBD;
	public $CONFIG;
	public $protocol;
	private $panelRender;
	public $gz;
	public $arMenuInclude = array();
	// Конструктор класса, запрашивает конфиг
   function __construct() {
		$this->CONFIG = $this->GetFileArray(CONFIG_FILE);
		//print_r(debug_backtrace());
		$this->protocol = (isset($_SERVER['SERVER_PROTOCOL']) ? $_SERVER['SERVER_PROTOCOL'] : 'HTTP/1.0');

   }
   public function getVersion()
   {
   	return $this->version;
   }
   function GetIncludeFiles(){
		return get_included_files();
   }
   function GetConfigField($field){
		return isset($this->CONFIG[$field])?$this->CONFIG[$field]:false;
   }
   public function CountIncludeFile(){
		return count($this->GetIncludeFiles());
   }
   
	// Узнаем с какой папки запущена функция
	public static function GetSectionFolder(){
		$oneFile = end((debug_backtrace()));
		$file = $oneFile['file'];
		if($_SERVER["REDIRECT_STATUS"] != 404){
			return dirname((isset($_SERVER["REAL_FILE_PATH"]))?$_SERVER["DOCUMENT_ROOT"] . $_SERVER["REAL_FILE_PATH"]:$file);
		}else{
			return DR;
		}
	}
	public static function RndStr($len){ 
		$all = "A1B2C3D4E5F6G7H8I9J0KLMNOPQRSTUVWXYZ"; 
		$cnt = strlen($all) - 1; 
		srand((double)microtime()*1000000); 
		for($i=0; $i<$len; $i++) $pass .= $all[rand(0, $cnt)]; 
		return $pass; 
	}
	public function GetPageParam($patch = false) {
		if($patch){
			$paramFile = $patch . ".section.php";
		}else{
			$paramFile = $this->GetSectionFolder() . "/.section.php";
		}
		if(file_exists($paramFile))
		$pageParam = require_once($paramFile);


		if(!isset($this->arrayParam["ParamFile"]))
			$this->arrayParam["ParamFile"] = $paramFile;
		if(!isset($this->arrayParam["PageAlias"]))
			$this->arrayParam["PageAlias"] = (isset($pageParam["ALIAS"]))?$pageParam["ALIAS"]:false;
		if(!isset($this->arrayParam["PageName"]))
			$this->arrayParam["PageName"] = (isset($pageParam["NAME"]))?$pageParam["NAME"]:false;
		if(!isset($this->arrayParam["MetaDescription"]))
			$this->arrayParam["MetaDescription"] = (isset($pageParam["META"]))?$pageParam["META"]:false;
		if(!isset($this->arrayParam["MetaKeyWords"]))
			$this->arrayParam["MetaKeyWords"] = (isset($pageParam["KEY"]))?$pageParam["KEY"]:false;
	}
	
	public static function CurlGet($url, $arData = false){
		// открываем cURL-сессию
		$resource = curl_init();
		// устанавливаем опцию удаленного файла
		curl_setopt($resource, CURLOPT_URL, $url);
		// заголовки нам не нужны
		curl_setopt($resource, CURLOPT_HEADER, 0);
		curl_setopt($resource, CURLOPT_CONNECTTIMEOUT, 5);
		if($arData)
			curl_setopt($resource, CURLOPT_POSTFIELDS, $arData);
		// выполняем операцию
		ob_start();
		curl_exec($resource);
		$out = ob_get_contents();
		ob_end_clean();
		// закрываем cURL-сессию
		curl_close($resource);
		return $out;
	}
	public function LocalRedirect($url, $code = false){
		if($code)
			$this->httpResponseCode($code);
		header('Location: ' . $url);
	}

	public function httpResponseCode($code = 404){
		if (function_exists('http_response_code')) {
			http_response_code((int) $code);
		}else{
			switch ((int)$code) {
				case 100: $text = 'Continue'; break;
				case 101: $text = 'Switching Protocols'; break;
				case 200: $text = 'OK'; break;
				case 201: $text = 'Created'; break;
				case 202: $text = 'Accepted'; break;
				case 203: $text = 'Non-Authoritative Information'; break;
				case 204: $text = 'No Content'; break;
				case 205: $text = 'Reset Content'; break;
				case 206: $text = 'Partial Content'; break;
				case 300: $text = 'Multiple Choices'; break;
				case 301: $text = 'Moved Permanently'; break;
				case 302: $text = 'Moved Temporarily'; break;
				case 303: $text = 'See Other'; break;
				case 304: $text = 'Not Modified'; break;
				case 305: $text = 'Use Proxy'; break;
				case 400: $text = 'Bad Request'; break;
				case 401: $text = 'Unauthorized'; break;
				case 402: $text = 'Payment Required'; break;
				case 403: $text = 'Forbidden'; break;
				case 404: $text = 'Not Found'; break;
				case 405: $text = 'Method Not Allowed'; break;
				case 406: $text = 'Not Acceptable'; break;
				case 407: $text = 'Proxy Authentication Required'; break;
				case 408: $text = 'Request Time-out'; break;
				case 409: $text = 'Conflict'; break;
				case 410: $text = 'Gone'; break;
				case 411: $text = 'Length Required'; break;
				case 412: $text = 'Precondition Failed'; break;
				case 413: $text = 'Request Entity Too Large'; break;
				case 414: $text = 'Request-URI Too Large'; break;
				case 415: $text = 'Unsupported Media Type'; break;
				case 500: $text = 'Internal Server Error'; break;
				case 501: $text = 'Not Implemented'; break;
				case 502: $text = 'Bad Gateway'; break;
				case 503: $text = 'Service Unavailable'; break;
				case 504: $text = 'Gateway Time-out'; break;
				case 505: $text = 'HTTP Version not supported'; break;
				default:
				exit('Unknown http status code "' . htmlentities($code) . '"');
				break;
			}
			header($this->protocol . ' ' . $code . ' ' . $text);
			$GLOBALS['http_response_code'] = $code;
		}
	}

	public function UnzipArchive($file, $patch = false){
		include("pclzip.lib.php");
		$archive = new PclZip($file);
		if ($archive->extract(PCLZIP_OPT_PATH, $patch, PCLZIP_CB_PRE_EXTRACT, 'preExtractCallback') == 0) {
			$this->ShowError($archive->errorInfo(true), "main");
		}
	}
	
	// Вывод титла на странице
    public function GetArrayPageParam() {
		return $this->arrayParam;
    }
	
	public function SetAdditionalCSS ($css){
		$this->css[$css] = true;
	}
	public function AddHeadScript ($js, $compress = true){
		$this->js[$js] = $compress;
	}
	public function AddHeadJavaScript ($js, $compress = true){
		$this->javaScript[$js] = $compress;
	}

	public function GetComponentId(){
		return $this->ComponentCount;
	}
	
	public function GetComponents(){
		foreach(glob($_SERVER["DOCUMENT_ROOT"] . '/MeteorRC/components/*', GLOB_ONLYDIR) as $corp) {
			foreach(glob($corp . '/*', GLOB_ONLYDIR) as $component) {
				if(file_exists($component . '/.parametrs.php')){
					$tmp = $this->GetFileArray($component . '/.parametrs.php');
					$tmp["PATCH"] = $component;
					$arComponent[$tmp["COMPONENT"]][$tmp["IBLOCK"]] = $tmp;
				}
			}
		}
		return $arComponent;
	}
	public function GetComponentsParams($component, $iblock, $corpName = "MeteorRC"){
		global $CACHE;
		if(!isset($CACHE->arCache['COMPONENTS_PARAMS'][$corpName][$component][$iblock])){
			$patchParams = $_SERVER["DOCUMENT_ROOT"] . SITE_COMPONENTS_PATH . $corpName . DS . $component . "." . $iblock . '/.parametrs.php';
			if(file_exists($patchParams)){
				$CACHE->arCache['COMPONENTS_PARAMS'][$corpName][$component][$iblock] = $arParams = $this->GetFileArray($patchParams);
				return $arParams;
			}
		}else{
			return $CACHE->arCache['COMPONENTS_PARAMS'][$corpName][$component][$iblock];
		}
	}

	public function TimelineAdd($arParams, $arElement, $event){
		global $USER;
		global $APPLICATION;
		global $CONFIG;
		if(isset($arParams["EVENTS"]["TEXT"][$event])){
			$timelineBD = FOLDER_BD . "statistics" . DS . "timeline" . SFX_BD;
			$arEvents = $APPLICATION->GetFileArray($timelineBD);
			if(!isset($CONFIG["TIMELINE_CNT"]))
				$CONFIG["TIMELINE_CNT"] = 30;
			if(count($arEvents) >= $CONFIG["TIMELINE_CNT"])
				unset($arEvents[min(array_keys($arEvents))]);
			$arEvents[time()] = array (
				'EVENT' => $arParams["EVENTS"]["TEXT"][$event],
				"ELEMENT_ID" => (int)$arElement["ID"],
				"COMPONENT" => $arParams["COMPONENT"],
				"IBLOCK" => $arParams["IBLOCK"],
				"USER_ID" => (int)$USER->GetID(),
				"TIME" => time(),
			);
			if(isset($arElement[$arParams["EVENTS"]["FIELDS"]["NAME"]]))
				$arEvents[time()]['ELEMENT']["NAME"] = $arElement[$arParams["EVENTS"]["FIELDS"]["NAME"]];
			if(isset($arElement[$arParams["EVENTS"]["FIELDS"]["PREVIEW_TEXT"]]))
				$arEvents[time()]['ELEMENT']["PREVIEW_TEXT"] = $arElement[$arParams["EVENTS"]["FIELDS"]["PREVIEW_TEXT"]];
			if(isset($arElement[$arParams["EVENTS"]["FIELDS"]["PREVIEW_PICTURE"]]))
				$arEvents[time()]['ELEMENT']["PREVIEW_PICTURE"] = $arElement[$arParams["EVENTS"]["FIELDS"]["PREVIEW_PICTURE"]];
			$APPLICATION->ArrayWriter($arEvents, $timelineBD);
		}
	}
	public function IncludeComponent($componentName, $templateName, $arParams, $component = false){
		global $APPLICATION;
		global $CONFIG;
		global $USER;
		global $CACHE;
		global $FILE;
		global $FIREWALL;
		$istBuffer = false;
		$arResult = null;
		$inclideComponent = true;
		$inclideTemplate = true;
		$this->ComponentCount++;

		list($corporateName, $componentCode) = explode(':', $componentName);
		if($CONFIG["COMPONENTS_ACTIVE"][$corporateName][$componentCode] == "N"){
			return false;
		}

		if(($this->CONFIG["EYE_EDITOR"] != "Y" xor !$USER->IsAdmin()) and $this->CONFIG["CACHE"] == "Y"){
			$cacheKey = arrayToUnicID($arParams);
			$this->ComponentCacheCount++;
			$arResult = $CACHE->Get($cacheKey);
			switch ($arParams["CACHE_TYPE"]) {
			    case 'H':
					if(empty($arResult)){
						ob_start();
						$istBuffer = true;
					}else{
						echo $arResult;
						$inclideComponent = $inclideTemplate = false;
						return true;
					}
			    break;
			    case 'A':
					if(empty($arResult)){
						$isSaveCache = true;
					}else{
						$inclideComponent = false;
					}
			    break;
			    default:

			        break;
			}
		}

		$templateName = (empty($templateName))?".default":$templateName;
		$componentFolder = $corporateName . DS . $componentCode;
		$componentPath =  SITE_COMPONENTS_PATH . $componentFolder;
		$componentTmplPatch = $componentPath . "/templates/" . $templateName;
		$tmplPatch = SITE_TEMPLATE_PATH . "components/" . $componentFolder . DS . $templateName;

		
		if(isset($arParams["CACHE_TIME"]))
			$CACHE->cacheTime = $arParams["CACHE_TIME"];
		if(!isset($arParams["CACHE_TYPE"]))
			$arParams["CACHE_TYPE"] = 'N';


		// Если нет кэша, подключаем файл компонента
		if($inclideComponent) {
			if(file_exists ($_SERVER["DOCUMENT_ROOT"] . $componentPath . "/component.php")){
				include($_SERVER["DOCUMENT_ROOT"] . $componentPath . "/component.php");
			}else{
				$this->ShowError('Компонент не найден!', $componentName);
			}
			if($isSaveCache){
				$CACHE->Set($cacheKey, $arResult);
			}
		}
		if($inclideTemplate){
			$tmplFileName =	(isset($arResult["tmpl"]))?$arResult["tmpl"]:"/template.php";
			if(file_exists ( $_SERVER["DOCUMENT_ROOT"] . $tmplPatch . $tmplFileName)){
				$templateFolder = $tmplPatch;
				$templateFile = $_SERVER["DOCUMENT_ROOT"] . $tmplPatch . $tmplFileName;

			}else{
				if(file_exists( $_SERVER["DOCUMENT_ROOT"] . $componentTmplPatch . $tmplFileName)){
					$templateFolder = $componentTmplPatch;
					$templateFile = $_SERVER["DOCUMENT_ROOT"] . $componentTmplPatch . $tmplFileName;
				}else{
					$this->ShowError("Шаблон компонента не найден!", $componentName);
					return false;
				}
			}
			include($templateFile);
		}
		if($istBuffer){
			$arResult = ob_get_contents(); 
			ob_end_clean();
			$CACHE->Set($cacheKey, $arResult);
			echo $arResult;
		}

		
	}



	public function AddEyeFunction($arEye = array()){
		global $USER;
		if(!$USER->IsAdmin() or $this->CONFIG["EYE_EDITOR"] != "Y")
			return false;
		$arEyeBtn = null;
			foreach ($arEye as $key => $button) {
				if($button["LINK"]){
					$arEyeBtn .= '<a href="' . $button["LINK"] . '" target="_blank" class="button_edit">' . $button["ICON"] . '</a>';
				}else{
				$arEyeBtn .= '<a data-toggle="modal" data-target="#modal-meteor" date-title="' . $button["TITLE"] . '" href="' . $button["EDITOR"] . '" class="button_edit">' . $button["ICON"] . '</a>';
				}
			}
			$this->AddHeadJavaScript("
			$(function() {
				component = $('#component_$this->ComponentCount');
				$(component).append( '<div class=\"btnEyeRow\">$arEyeBtn</div>' );
				ComponentBorderShow(component);
			});
			");
	}
	public static function GetCurDir(){
		$url = parse_url($_SERVER['REQUEST_URI']);
		$arPatch = explode("/", $url["path"]);
		if(is_array($arPatch) and $arPatch = array_filter($arPatch)){
			return array_shift(($arPatch));
		}else{
			return $arPatch?$arPatch:DS;
		}
	}
	public function CreateDir($patch, $chmod = false, $cursive = false){
		return mkdir($patch, $chmod?$chmod:DIR_PERMISSIONS, $cursive);
	}
	public static function AddUrlQuery($param, $url = false){
		$url = $url?$url:$_SERVER['REQUEST_URI'];
		return $url . (isset($_SERVER["QUERY_STRING"])? '&' : '?') . $param;
	}
	public static function UrlQuery($param, $value, $url = false){
		$url = DeleteParam($url?$url:$_SERVER['REQUEST_URI'], $param);
		return $url . (isset($_SERVER["QUERY_STRING"])? '&' : '?') . $param . "=" . $value;
	}
	public static function GetUrlPatch(){
		return parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
	}
	public static function GetArUrlPatch(){
		return explode("/", parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));
	}
	

	public static function GetFullUrl(){
		return (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off')?'https://':'http://'.$_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
	}

	public function ShowError($text, $component_name, $component_show = true){
		$this->ErrorCount++;
		if($component_show){
			echo $text .  " ($component_name)";
		}else{
			echo $text;
		}
		
		$this->AddMessage2Log($text, $component_name);
		return true;
	}
	public static function ShowMessage($text, $component_name){
		echo $text;
	}
	public static function AddMessage2Log($text, $component_name){
		$current = date("H:i:s") . " | " . $text . " | ($component_name);" . PHP_EOL;
		file_put_contents(LOG_FILE, $current, FILE_APPEND);
	}
	
	public function ArrayWriter($array, $bd_file){
		$this->bdWriter++;
		$current = '<?if(!defined("PROLOG_INCLUDED") || PROLOG_INCLUDED!==true)die("Не дамся!!!");?>' . PHP_EOL;
		$current .= '<?' . PHP_EOL;
		$current .= 'FIREWALL::ProtectedBD();' . PHP_EOL;
		$current .= 'return ';
		ob_start();
		var_export($array);
		$current .= ob_get_contents();
		ob_end_clean();
		$current .=  ';';
		$dir = dirname($bd_file);
		if(!file_exists($dir))
			$this->CreateDir($dir, false, true);
		//if(file_exists($bd_file) and !is_writable($bd_file)){
			//chmod($bd_file, $this->CONFIG['FILE_PERMISSIONS']);
		//}
		if(file_put_contents($bd_file, $current, LOCK_EX)){
			return true;
		}
	}
	
	public function GetFileArray($bd_file){
		$this->bdCount++;
		$this->bdList[] = $bd_file;
		if(file_exists($bd_file)){
			$queryBD = include($bd_file);
			//$bdSise = filesize($bd_file);
			//$this->bdSize = (isset($bdSise)?$bdSise:0 + $this->bdSize);
			return $queryBD?$queryBD:array();
		}else{
			return array();
		}
	}

	public function GetElementForField($component, $iblock, $arFilter = array(), $oneArr = true, $sort = false){
		$bd_file = FOLDER_BD . $component . DS . $iblock . SFX_BD;
		$arAllElements = $this->GetFileArray($bd_file);

		if(empty($arFilter)){
			return (!empty($arAllElements))?$arAllElements:array();
		}
		$arFassetField = $arElements = $arElementsId = array();
		$arFilterCount = count($arFilter);
		foreach ($arFilter as $field => $value) {
			switch ($field[0]) {
				case '>':
					$arFassetFieldTmp = $this->GetFileArray(FOLDER_BD . $component . DS . "fasset" . DS . $iblock . DS . substr($field, 1) . SFX_BD);
					foreach ($arFassetFieldTmp as $val => $IDs) {
						if($val >= $value)
							foreach ($IDs as $id) {
								$arElementsId[$id][$field] = true;
							}
					}
					break;
				case '<':
					$arFassetFieldTmp = $this->GetFileArray(FOLDER_BD . $component . DS . "fasset" . DS . $iblock . DS . substr($field, 1) . SFX_BD);
					foreach ($arFassetFieldTmp as $val => $IDs) {
						if($val <= $value)
							foreach ($IDs as $id) {
								$arElementsId[$id][$field] = true;
							}
					}
					break;
				default:
					$arFassetFieldTmp = $this->GetFileArray(FOLDER_BD . $component . DS . "fasset" . DS . $iblock . DS . $field . SFX_BD);
					if(!is_array($value)){
						if(isset($arFassetFieldTmp[$value]))
							foreach (array_reverse($arFassetFieldTmp[$value]) as $id) {
								$arElementsId[$id][$field] = true;
							}
					}else{
						foreach ($value as $val) {
							if(isset($arFassetFieldTmp[$val]))
								foreach (array_reverse($arFassetFieldTmp[$val]) as $id) {
										$arElementsId[$id][$field] = true;
								}
						}
					}
					break;
			}


			//$arFassetField = array_merge($arFassetField, $arFassetFieldTmp[$value]);
		}
		foreach ($arElementsId as $id => $value) {
			if(count($value) == $arFilterCount and isset($arAllElements[$id])){
				$arElements[$id] = $arAllElements[$id];
				$arElements[$id]["ID"] = $id;
			}
		}
		if(count($arElements) == 1 and $oneArr){
			return $arElements[key($arElements)];
		}
		if($sort and !$oneArr and is_array($arElements)){
			$GLOBALS["SORT"] = $sort;
			uasort($arElements, "SortForField");
			unset($GLOBALS["SORT"]);
		}
		return $arElements;
	}
	public function GetElementForID($component, $iblock, $id){
		$bd_file = FOLDER_BD . $component . DS . $iblock . SFX_BD;
		$arAllElements = $this->GetFileArray($bd_file);
		return (isset($arAllElements[$id]))?$arAllElements[$id]:false;
	}
	public function GetElementForIDs($component, $iblock, $arID){
		$bd_file = FOLDER_BD . $component . DS . $iblock . SFX_BD;
		$arAllElements = $this->GetFileArray($bd_file);
		foreach ($arID as $key => $id) {
			$arElements[$id] = $arAllElements[$id];
		}
		return (isset($arElements))?$arElements:false;
	}
	// Герераци фассетов для выборки элементов
	public function FassetGenerate($component, $iblock, $arSave = false, $arField = false){
		// Если нет массива с элементами получаем его
		if(!$arSave){
			$bd_file = FOLDER_BD . $component . DS . $iblock . SFX_BD;
			$arSave = $this->GetFileArray($bd_file);
		}
		foreach($arSave as $id => $arElement){
			foreach ($arElement as $key => $value) {
				//Если есть параметры полей и в поле параметр FASSET является истиной
				if(!$arField or isset($arField[$key]["FASSET"]) and $arField[$key]["FASSET"] == "Y")
					if(!is_array($value)){
						$arFassetSave[$key][$value][] = $id;
					}else{
						foreach ($value as $val) {
							$arFassetSave[$key][$val][] = $id;
						}
					}
			}
		}
		if(isset($arFassetSave))
			foreach ($arFassetSave as $key => $value) {
					$this->ArrayWriter($value, FOLDER_BD . $component . DS . "fasset" . DS . $iblock . DS . $key . SFX_BD);
			}
		return true;
	}

	public function SaveElementForID($arNew, $component, $iblock, $id = false, $fasset = true){
		$bd_file = FOLDER_BD . $component . DS . $iblock . SFX_BD;
		$arSave = $this->GetFileArray($bd_file);
		if(!$id){
			$id = (!empty($arSave))?(max(array_keys($arSave)) + 1):1;
		}
		$arSave[$id] = $arNew;
		$this->ArrayWriter($arSave, $bd_file);
		if($fasset){
			$arParams = $this->GetComponentsParams($component, $iblock);
			if(isset($arParams["FIELDS"])){
				$this->FassetGenerate($component, $iblock, $arSave, $arParams["FIELDS"]);
			}
		}
	}
	public function SaveElementForIblock($arSave, $component, $iblock){
		$bd_file = FOLDER_BD . $component . DS . $iblock . SFX_BD;
		$this->ArrayWriter($arSave, $bd_file);
	}
	public function DeleteElementForID($component, $iblock, $id){
		$FILE = new FILE;
		$bd_file = FOLDER_BD . $component . DS . $iblock . SFX_BD;
		$arElements = $this->GetFileArray($bd_file);
		if(isset($arElements[$id])){
				// удаляем картинки элемента
			$arComponents = $this->GetComponents();
			$arImage = array();
			foreach($arComponents[$component][$iblock]["FIELDS"] as $field => $value){
				if($value["TYPE"] == "IMAGE" and isset($arElements[$id][$field])){
					$FILE->DellFile($arElements[$id][$field], $iblock);
				}
			}
			// Удаляем из бд элемент и сохраняем обратно бд
			unset($arElements[$id]);
			if($this->ArrayWriter($arElements, $bd_file));
				return true;

		}else{
			return false;
		}
	}
	
	
	public function IfCaptcha($captcha){
		if($captcha == $_SESSION["CAPTCHA"]){
			return true;
		}else{
			return false;
		}
	}
	public function IsEmail($email){
		return preg_match( "#^[0-9a-z_\-\.]+@[0-9a-z\-\.]+\.[a-z]{2,6}$#i", $email);
	}
	
	// Старт буфера контента для последующего рендеринга
	public function RestartBuffer(){
		if (ob_get_contents()) ob_end_clean(); 
		$this->StartBuffer();
	}
	public function StartBuffer(){
		ob_start(); 
	}
	
	// Функция рендеринга вывода контента
	public function Render(){
		$content = ob_get_contents(); 
		ob_end_clean();
		if(empty($this->arrayParam))
			$this->GetPageParam();
		$RenderContent = null;
		if(isset($this->arrayParam["MetaDescription"]))
			$RenderContent = '<meta name="description" content="' . $this->arrayParam["MetaDescription"] . '">'. PHP_EOL;
		if(isset($this->arrayParam["MetaKeyWords"]))
			$RenderContent .= '<meta name="keywords" content="' . $this->arrayParam["MetaKeyWords"] . '">'. PHP_EOL;
		if(isset($this->arrayParam["PageName"]))
			$RenderContent .= '<title>' . $this->CONFIG["SITE_NAME"] . " - " . $this->arrayParam["PageName"] . '</title>'. PHP_EOL;
		// Ловим в переменную панель, для последующего рендеринга
		global $USER;
		$RenderPanel = false;
		if($USER->IsAdmin() and $this->panelRender){
			ob_start();
			include_once($_SERVER["DOCUMENT_ROOT"] . "/MeteorRC/admin/panel_ajax.php");
			$RenderPanel = ob_get_contents(); 
			ob_end_clean();
		}
		
		// Если подключены css файлы, парсим их циклом
		if($this->CONFIG["COMPRESS"]["JS"] == "Y"){
			//$gz = (stripos($_SERVER['HTTP_ACCEPT_ENCODING'],'GZIP') !== false)?'gz':null;
			//require_once('plugins/jsmin.php');
		}
		if($this->CONFIG["COMPRESS"]["CSS"] == "Y" and !empty($this->css)){
			include('plugins/cssmin-v3.0.1.php');
			$cssFileName = arrayToUnicID(array_keys($this->css)) . '.css';
			if(!file_exists($_SERVER["DOCUMENT_ROOT"] . FOLDER_CSS_MIN . DS . $cssFileName)){
				file_compress(FOLDER_CSS_MIN, $cssFileName, $this->css);
			}
			$RenderContent .= '<link href="' . FOLDER_CSS_MIN . DS . $cssFileName  . $gz . '" type="text/css"  rel="stylesheet" />' . PHP_EOL;
		}
		foreach ($this->css as $url => $is){
			$RenderContent .= '<link href="' . $url . '" type="text/css"  rel="stylesheet" />' . PHP_EOL;
		}

		// Если подключены js файлы, парсим их циклом
		if($this->CONFIG["COMPRESS"]["JS"] == "Y" and !empty($this->js)){
			$jsFileName = arrayToUnicID(array_keys($this->js)) . '.js';
			if(!file_exists($_SERVER["DOCUMENT_ROOT"] . FOLDER_JS_MIN . DS . $jsFileName)){
				file_compress(FOLDER_JS_MIN, $jsFileName, $this->js);
			}
			$RenderContent .= '<script type="text/javascript" src="' . FOLDER_JS_MIN . DS . $jsFileName  . $gz . '"></script>' . PHP_EOL;
		}
		foreach ($this->js as $url => $is){
			if($is and $this->CONFIG["COMPRESS"]["JS"] == "Y"){continue;}
			$RenderContent .= '<script type="text/javascript" src="' . $url . '"></script>' . PHP_EOL;
		}

		$RenderContent .= '<script type="text/javascript">' . PHP_EOL;
		foreach ($this->javaScript as $script => $is){
			$RenderContent .= $script . PHP_EOL;
		}
		$RenderContent .= '</script>' . PHP_EOL;
		// Заменяем в контенте шаблонные переменные
		$content  = strtr($content, array("{#HEAD#}" => $RenderContent, "{#PANEL#}" => $RenderPanel));
		
		// Если в настройка включена оптимизация html
		if($this->CONFIG["COMPRESS"]["HTML"] != "N"){
			$content = htmlCompress($content);
		}
		echo $content;
	}
	

	
	public static function ShowHead(){
		echo "{#HEAD#}";
	}
	public function ShowPanel(){
		echo "{#PANEL#}";
		$this->panelRender = true;
	}
	
	public static function ClearСhar($char){
		return trim(str_replace(".","", $char));
	}
	public static function IsCyrillic($string){
		return preg_match("/^[а-я]+$/i", $string);
	}
	public function IsCyrillicDomain(){
		return $this->IsCyrillic($_SERVER['HTTP_HOST']);
	}
	public static function PriceFormat($price){
		$price = preg_replace('/[^0-9]/', '', $price);
		$price = number_format($price, 0, '', ' ');
		return $price?$price:0;
	}
	// Вывод титла на странице
    public function ShowTitle() {
		if(empty($this->arrayParam))
			$this->GetPageParam();
		echo $this->arrayParam["PageName"];
    }	

}

class USER extends APPLICATION {
	private static $algo = '$2a';
	private static $cost = '$10';
	private $arUser = Array();
	
   function __construct() {
		if(isset($_GET["logout"])){
			$this->Logout();
		}
		if($login = $this->GetLogin()){
			$this->arUser = APPLICATION::GetElementForField("users", "users", array("LOGIN" => $login));
		}
   }
    
   
	public function GetAvatar($user = false){
		if($user){
			// --- потом допишу -- //
		}else{
			return (isset($this->arUser["PERSONAL_PHOTO"]))?$this->arUser["PERSONAL_PHOTO"]:false;
		}
   }
   
 	public function GetName($login = false){
		if($login){
			// --- потом допишу -- //
		}else{
			return $this->arUser["NAME"]?$this->arUser["NAME"]:$this->arUser["EMAIL"];
		}
   }
 	public function GetField($field, $id = false){
		if($id){
			$arUser = APPLICATION::GetElementForID("users", "users", $id);
			return (isset($arUser[$field]))?$arUser[$field]:false;
		}else{
			return (isset($this->arUser[$field]))?$this->arUser[$field]:false;
		}
   }
   //

	private static function UniquSalt() {
		return substr(sha1(mt_rand()),0,22);
	}

	public function GetIp(){
		return $_SERVER['REMOTE_ADDR'];
	}
		
	public function GetCity(){
		$default_en = mb_internal_encoding();
		mb_internal_encoding('8bit');
		if(!class_exists('SxGeo'))
			include_once($_SERVER["DOCUMENT_ROOT"] . '/MeteorRC/main/SxGeo.php');
		$SxGeo = new SxGeo($_SERVER["DOCUMENT_ROOT"] . '/MeteorRC/main/SxGeo.dat');
		$arCity = $SxGeo->getCityFull($this->GetIp());
		mb_internal_encoding($default_en);
		//unset($SxGeo);
		$city["CITY"]["NAME"] = $arCity['city']['name_ru'];
		$city["CITY"]["LAT"] = $arCity['city']['lat'];
		$city["CITY"]["LON"] = $arCity['city']['lon'];
		$city["COUNTRY"] = $arCity['country']['iso'];
		return $city;
	}
	public function GetUnicId(){
		return session_id() . substr($this->GetIp(), -5) . preg_replace('/[^0-9]/', '', $_SERVER['HTTP_USER_AGENT']);
	}
	// генерация хэша
	function Hash($password) {
		return crypt($password,
					self::$algo .
					self::$cost .
					'$' . self::UniquSalt());
	}
	// сравнение пароля и хэша
	function Login($login, $password){
		if($this->arUser = APPLICATION::GetElementForField("users", "users", array("LOGIN" => $login))){
			//p($this->arUser);
			$hash = $this->arUser["PASSWORD"];
			$full_salt = substr($hash, 0, 29);
			$new_hash = crypt($password, $full_salt);
			if($hash == $new_hash){
				$this->arUser["SESSION_ID"] = $this->GetUnicId();
				APPLICATION::SaveElementForID($this->arUser, "users", "users", $this->arUser["ID"]);
				$this->Authorize($login, $this->arUser);
				return $login;
			}else{
				return false;
			}
		}else{
			return false;
		}
	}
	
	
	function Authorize($login) {
		if($this->arUser){
			// p($arUser);
			$_SESSION["AUTH"]["AUTHORIZE"] = $login;
			$_SESSION["AUTH"]["SESSION_ID"] = $this->arUser["SESSION_ID"];
			return true;
		}else{
			return false;
		}
	}	

	function Delete($user) {
		if($user == $this->arUser["EMAIL"]){
			APPLICATION::ShowError('<i class="fa fa-exclamation-circle"></i> Вы не можете удалить сами себя!', $user);
			return false;
		}
		if($UserFile = $this->ExistUser($user)){
			$NewUserFile = dirname($UserFile) . "/delete/" . $user . SFX_BD;
			if(rename($UserFile, $NewUserFile)){
				return true;
			}
		}else{
			APPLICATION::ShowError('<i class="fa fa-exclamation-circle"></i> Пользователь не найден!', $user);
			return false;
		}
	}	
	
	function ExistUser($login) {
		$arUser = APPLICATION::GetElementForField("users", "users", array("LOGIN" => $login));
		if($arUser){
			return $arUser;
		}else{
			return false;
		}
	}
	function IsAuthorized(){
		if(isset($_SESSION["AUTH"]["SESSION_ID"]) and isset($this->arUser["SESSION_ID"]))
			if($_SESSION["AUTH"]["SESSION_ID"] == $this->arUser["SESSION_ID"] and strpos($this->arUser["SESSION_ID"], substr($this->GetIp(), -5))){
				return true;
			}else{
				return false;
			}
	}
	function IsAdmin(){
		if($this->IsAuthorized())
			if(isset($this->arUser["GROUP_ID"]) and $this->arUser["GROUP_ID"] == 1){
				return true;	
			}else{
				return false;
			}
	}
	
	

	function GetList(){

	}
	
	function GetStatus(){
		return isset($this->arUser["STATUS"])?$this->arUser["STATUS"]:false;
	}
	function GetLogin(){
		return isset($_SESSION["AUTH"]["AUTHORIZE"])?$_SESSION["AUTH"]["AUTHORIZE"]:false;
	}
	function GetID(){
		return isset($this->arUser["ID"])?$this->arUser["ID"]:false;
	}
	function Logout(){
		if($this->arUser){
		unset($this->arUser["SESSION_ID"]);
		}
		unset($_SESSION["AUTH"]);
	}
}

class MARKETAPI extends FILE {
	const SERVER = 'http://www.market.meteorengine.ru';
	protected $UpdateUrl = 'http://update.meteorengine.ru/update.php';
	protected $ListUrl = 'http://market.meteorengine.ru/list.php';
		
	function Finish(){
		// Удаляем архив обновы
		if(unlink($_SERVER["DOCUMENT_ROOT"] . DS . $this->UpdateFile))
			APPLICATION::AddMessage2Log('Обновление прошло успешно', 'Update');
	}
	
	function GetMarketList(){
		// Запрашиваем и отдаем файл со списком компонентов
		$arJsonList = APPLICATION::CurlGet($this->ListUrl);
		if($arJsonList)
			$arList = json_decode($arJsonList, true);
		return $arList?$arList:array();
	}
}

class UPDATE extends USER {
	const SERVER = 'www.update.meteorengine.ru';
	protected $UpdateUrl = 'http://update.meteorengine.ru/MeteorRC.zip';
	protected $VersionUrl = 'http://update.meteorengine.ru/version.php';
	protected $InfoUrl = 'http://update.meteorengine.ru/info.php';
	public $UpdateFile = 'MeteorRC.zip';
	
	// Скачиваем архив обновления
	function CurlDownload(){
		// открываем файл, на сервере, на запись
		$dest_file = fopen($_SERVER["DOCUMENT_ROOT"] . DS . $this->UpdateFile, "w");
		// открываем cURL-сессию
		$resource = curl_init();
		// устанавливаем опцию удаленного файла
		curl_setopt($resource, CURLOPT_URL, $this->UpdateUrl);
		// устанавливаем место на сервере, куда будет скопирован удаленной файл
		curl_setopt($resource, CURLOPT_FILE, $dest_file);
		// заголовки нам не нужны
		curl_setopt($resource, CURLOPT_HEADER, 0);
		// выполняем операцию
		curl_exec($resource);
		// закрываем cURL-сессию
		curl_close($resource);
		// закрываем файл
		fclose($dest_file);
	}
	
	function Finish(){
		// Удаляем архив обновы
		if(unlink($_SERVER["DOCUMENT_ROOT"] . DS . $this->UpdateFile))
			APPLICATION::AddMessage2Log('Обновление прошло успешно', 'Update');
	}
	
	function GetUpdateInfo(){
		// Запрашиваем и отдаем файл с инфой обновы
		$arHeader = array('VERSION' => APPLICATION::getVersion());
		return APPLICATION::CurlGet($this->InfoUrl, $arHeader);
	}
	
	function GetUpdateVersion(){
		// Запрашиваем файл с версией обновы
		return APPLICATION::CurlGet($this->VersionUrl);
	}
}

class FILE extends APPLICATION {
	public $fileList = array();
	public $lastSaveFileUri = array();
	public $arTableFile = array();
	public function SaveFile($arFile, $module){
		if($arFile["error"] > 0 or $arFile["size"] < 1){
			APPLICATION::ShowError('<i class="fa fa-exclamation-circle"></i> Ошибка сохранения файла!', false, false);
			return false;
		}
		$saveFolder = "/MeteorRC/upload/" . $module . DS;
		$savePath = DR . $saveFolder;

		$fileType = $this->GetTypeFile($arFile['name']);
		
		$arExtension = array('php','php2', 'php3', 'php4', 'php5', 'php6', 'php7', 'phps', 'cgi', 'mng', 'pl', 'fcgi' , 'fpl', 'phtml', 'shtml', 'asp', 'jsp');
		if(in_array($fileType, $arExtension)){
			APPLICATION::ShowError('<i class="fa fa-exclamation-circle"></i> Запрещенный формат файла!', false, false);
			return false;
		}
		$saveFileName = randString(20) . '.' . $fileType;
		if(!file_exists($savePath))
			mkdir($savePath, 0777, true);
		// Если файл успешно перенесен из темпа
		if(rename($arFile['tmp_name'], $savePath . $saveFileName)){

			chmod($savePath . $saveFileName, FILE_PERMISSIONS);
			// То читаем базу
			if(!isset($this->arTableFile[$module])){
				$this->arTableFile[$module] = APPLICATION::GetFileArray(FOLDER_FILE_BD . $module . SFX_BD);
			}
			// Зоздаем новый ид для файла
			$newKey = (!empty($this->arTableFile[$module]))?(max(array_keys($this->arTableFile[$module])) + 1):1;
			// Для запроса пути файла, после добавления, пишем урл в переменную класса
			$this->lastSaveFileUri = $saveFolder . $saveFileName;
			// Пихаем новый ид с путем до файла в масив
			$this->arTableFile[$module][$newKey ] = array(
			"NAME" => $saveFileName,
			"TYPE" => (isset($arFile["type"]))?$arFile["type"]:false,
			);
			
			// Сохраняем массив в бд с новым id файла
			APPLICATION::ArrayWriter($this->arTableFile[$module], FOLDER_FILE_BD . $module . SFX_BD);
			// Возвращаем ид файла
			return ($newKey);
		}else{
			APPLICATION::ShowError('<i class="fa fa-exclamation-circle"></i> Ошибка создания файла!', false, false);
			return false;
		}
		
	}
	
	function SaveImage($arFile, $module){
		$fileType = $this->GetTypeFile($arFile['name']);
		$arExtension = array('png', 'PNG', 'gif', 'GIF', 'jpg', 'JPG', 'svg', 'bmp', 'jpeg', 'JPEG', 'apng', 'mng');
		if(in_array($fileType, $arExtension)){
			$id = $this->SaveFile($arFile, $module);
			return $id;
		}else{
			return 'Недопустимый формат файла!';
		}
	}
	// http://wideimage.sourceforge.net/examples/basic/
	public function ImageCrop($image, $newWidth = false, $newHeight = false, $quality = 75){
		return $this->ImageResize($image, $newWidth, $newHeight, $quality, 'crop');
	}
	
	// http://wideimage.sourceforge.net/examples/basic/
	public function ImageResize($image, $newWidth = false, $newHeight = false, $quality = 75, $resizeType = 'landscape',  $newPatch = false) {
		global $CONFIG;
		ini_set("memory_limit","256M");
		if(!class_exists('imageLib'))
			include_once('plugins/image-magician/php_image_magician.php');

		$MAGICIAN = new imageLib(DR . $image);
		if(isset($CONFIG['DEBUG']) and $CONFIG['DEBUG'] == "Y"){
			$MAGICIAN->debug = true;
		}
		$MAGICIAN->resizeImage($newWidth, $newHeight, $resizeType);

		$newImage = $newPatch?$newPatch:$image;
		$dir = DR . dirname($newImage);
		if(!file_exists($dir)){
			APPLICATION::CreateDir($dir, false, true);
		}
		if($MAGICIAN->saveImage(DR . $newImage, $quality)){
			return $newImage;
		}else{
			return false;
		}
	}

	// http://phpimagemagician.jarrodoberto.com/index.html
	public function ResizeImageGet($image, $newWidth = false, $newHeight = false, $quality = 75,  $resizeType = 'landscape', $cacheFolder = false) {
		global $CACHE;
		$cacheKey = $cacheFolder . $image . $newWidth . $newHeight . $resizeType . $quality;
		
		$newPatch = $CACHE->Get($cacheKey);
		
		if(!$newPatch){
			if($cacheFolder){
				$cacheFolder = $cacheFolder . DS;
			}
			$newPatch = CACHE_RESIZE . $cacheFolder . $newWidth . '_' . $newHeight . '_' . $resizeType . '_' . $quality . '_' . basename($image);
			if(!file_exists($newPatch)){
				$this->ImageResize($image, $newWidth, $newHeight, $quality, $resizeType, $newPatch);
				$CACHE->cacheTime = 36000;
				$CACHE->Set($cacheKey, $newPatch);
			}
		}
		return $newPatch;
	}

	public function IblockResizeImageGet($id, $iblock, $newWidth = false, $newHeight = false, $quality = 75,  $resizeType = 'landscape') {
		$image = $this->GetUrlFile($id, $iblock);
		if($image){
			return $this->ResizeImageGet($image, $newWidth, $newHeight, $quality,  $resizeType, $iblock);
		}
	}

	public function GetUrlFile($id, $iblock, $useCache = true){
		global $CACHE;
		$cacheKey = $id . $iblock;
		$fileName = $CACHE->Get($cacheKey);
		if(!$fileName){
			$arTableFile = $this->GetFileArray(FOLDER_FILE_BD . $iblock . SFX_BD);
			if(isset($arTableFile[$id])){
				$fileName = $arTableFile[$id]['NAME'];
				$CACHE->cacheTime = 36000;
				$CACHE->Set($cacheKey, $arTableFile[$id]['NAME']);
			}else{
				$this->AddMessage2Log('Запрашиваемый файл не найден', 'class FILE');
				return false;
			}
		}
		if($fileName){
			return '/MeteorRC/upload/' . $iblock . '/' . $fileName;
		}
	}
	public function MakeFileArray($patch, $local = false){
		$arFile["name"] = basename($patch);
		$arFile["tmp_name"] = $local?$local:$patch;
		$arFile["error"] = false;
		$arFile["size"] = filesize($local?$local:$patch);
		return $arFile;
	}
	public function DellFile($id, $iblock){
		// Читаем список файлов
		$arTableFile = APPLICATION::GetFileArray(FOLDER_FILE_BD . $iblock . SFX_BD);
		if(isset($arTableFile[$id])){
			// Воссоздаем путь до файла
			$file = $_SERVER["DOCUMENT_ROOT"] . "/MeteorRC/upload/" . $iblock . DS . $arTableFile[$id]["NAME"];
			// Если файл существует, удаляем
			if(file_exists($file))
				unlink($file);
			// Удаляем из массива файл с этим ид
			unset($arTableFile[$id]);
			// Пишем базу обратно
			APPLICATION::ArrayWriter($arTableFile, FOLDER_FILE_BD . $iblock . SFX_BD);
			return true;
		}
	}
	
	// Функция определения типа файла
	public function GetTypeFile($image){
		return pathinfo($image, PATHINFO_EXTENSION);
	}

	// Генерация, сохранение и получение списка файлов
	public function GenerateFileList($folder){
		$fp = opendir($folder);
		while($cv_file = readdir($fp)) {
			if(is_file($folder . "/" . $cv_file)) {
				$this->fileList[] = array(
					"patch" => $folder."/".$cv_file,
					"size" =>  filesize($folder."/".$cv_file),
				);
			}elseif($cv_file != "." && $cv_file != ".." && is_dir($folder."/".$cv_file)){
				$this->GenerateFileList($folder . "/" . $cv_file);
			}
		}
		closedir($fp);
	}
	public function GetFileList($minuteExpire = 30){
		global $APPLICATION;
		// Если файла нет, или он создавался больше чем 30 минут назад - генерируем и сохраняем
		if(!file_exists(FILELIST_BD) or file_exists(FILELIST_BD) and filemtime(FILELIST_BD) < (time() - (60 * $minuteExpire))){
			$this->GenerateFileList($_SERVER["DOCUMENT_ROOT"]);
			$APPLICATION->ArrayWriter($this->fileList, FILELIST_BD);
		}else{
			// Если файл еще свежий, то читаем его
			$this->fileList = $APPLICATION->GetFileArray(FILELIST_BD);
		}
		return $this->fileList;
	}
}


class DEBUG extends APPLICATION {
	function ErrorFileSend(){
		global $APPLICATION;
		$send = false;
		$arConfig = $APPLICATION->CONFIG;
		$LogList = glob(LOG_DIR . "*.log");
		if($LogList){
			$MAIL = new Mail('noreply' . "@" . $_SERVER['SERVER_NAME']);
			// $MAIL->setFromName($message["EMAIL_TO"]);
			$MAIL->setType("text/html");
			$message = 'Список ошибок:' . PHP_EOL;
			foreach($LogList as $file){
				$message .= file_get_contents($file);
				$send = true;
				unlink($file);
			}
			if ($send and !$MAIL->send("hello@soft-angel.ru", "Debug Info", $message)){
					APPLICATION::ShowError('Сообщение не отправлено!', 'Debug');
			}
		}
	}
}



class CJSCore extends APPLICATION {
	static function Init($arExtensions = array()){
		global $APPLICATION;
		foreach ($arExtensions as $extension) {
			switch ($extension) {
			    case "fancybox":
					$APPLICATION->AddHeadScript("/MeteorRC/js/plugins/fancybox/jquery.fancybox.pack.js");
					$APPLICATION->SetAdditionalCSS("/MeteorRC/js/plugins/fancybox/jquery.fancybox.css");
			        break;
			    case "simple-lightbox":
					$APPLICATION->AddHeadScript("/MeteorRC/js/plugins/simple-lightbox/simple-lightbox.js");
			        $APPLICATION->SetAdditionalCSS("/MeteorRC/js/plugins/simple-lightbox/simplelightbox.min.css");
			        break;
			    case "fileinput":
					$APPLICATION->AddHeadScript("/MeteorRC/js/plugins/fileinput/js/fileinput.min.js");
					$APPLICATION->SetAdditionalCSS("/MeteorRC/js/plugins/fileinput/css/fileinput.min.css");
			        break;
			    case "bootstrap":
					$APPLICATION->AddHeadScript("/MeteorRC/js/plugins/bootstrap/js/bootstrap.min.js");
					$APPLICATION->SetAdditionalCSS("/MeteorRC/js/plugins/bootstrap/css/bootstrap.min.css");
			        break;
			    case "bootstrap-switch":
					$APPLICATION->AddHeadScript("/MeteorRC/js/plugins/bootstrap-switch/bootstrap-switch.min.js");
					$APPLICATION->SetAdditionalCSS("/MeteorRC/js/plugins/bootstrap-switch/bootstrap-switch.min.css");
			        break;
			    case "bootstrap-slider":
					$APPLICATION->AddHeadScript("/MeteorRC/js/plugins/bootstrap-slider/bootstrap-slider.min.js");
					$APPLICATION->SetAdditionalCSS("/MeteorRC/js/plugins/bootstrap-slider/bootstrap-slider.min.css");
			        break;
			    case "switchery":
			    	// http://abpetkov.github.io/switchery/
					$APPLICATION->AddHeadScript("/MeteorRC/js/plugins/switchery/switchery.min.js");
					$APPLICATION->SetAdditionalCSS("/MeteorRC/js/plugins/switchery/switchery.min.css");
			        break;
			    case "meteor-modal":
					$APPLICATION->AddHeadScript("/MeteorRC/js/plugins/meteor-modal/meteor-modal.js");
					$APPLICATION->SetAdditionalCSS("/MeteorRC/js/plugins/meteor-modal/meteor-modal.css");
			        break;
			    case "waves":
					$APPLICATION->AddHeadScript("/MeteorRC/js/plugins/waves/waves.min.js");
					$APPLICATION->SetAdditionalCSS("/MeteorRC/js/plugins/waves/waves.min.css");
			        break;
			    case "morris":
					$APPLICATION->AddHeadScript("/MeteorRC/js/plugins/morris/morris.min.js");
					$APPLICATION->SetAdditionalCSS("/MeteorRC/js/plugins/morris/morris.css");
			        break;
			    case "gritter":
					$APPLICATION->AddHeadScript("/MeteorRC/js/plugins/gritter/jquery.gritter.min.js");
					$APPLICATION->SetAdditionalCSS("/MeteorRC/js/plugins/gritter/jquery.gritter.css");
			        break;
			    case "jquery-ui":
					$APPLICATION->AddHeadScript("/MeteorRC/js/plugins/jquery-ui/jquery-ui.min.js");
					$APPLICATION->SetAdditionalCSS("/MeteorRC/js/plugins/jquery-ui/jquery-ui.min.css");
			        break;
			    case "jquery.scrollbar":
					$APPLICATION->AddHeadScript("/MeteorRC/js/plugins/jquery-scrollbar/jquery.scrollbar.min.js");
					$APPLICATION->SetAdditionalCSS("/MeteorRC/js/plugins/jquery-scrollbar/jquery.scrollbar.min.css");
			        break;
			    case "peity":
					$APPLICATION->AddHeadScript("/MeteorRC/js/plugins/jquery.peity/jquery.peity.min.js");
			        break;
			    case "owl.carousel":
					$APPLICATION->AddHeadScript("/MeteorRC/js/plugins/owl.carousel/owl.carousel.min.js");
					$APPLICATION->SetAdditionalCSS("/MeteorRC/js/plugins/owl.carousel/assets/owl.carousel.css");
					$APPLICATION->SetAdditionalCSS("/MeteorRC/js/plugins/owl.carousel/assets/owl.transitions.css");
			        break;
			    case "sticky":
					$APPLICATION->AddHeadScript("/MeteorRC/js/plugins/sticky/jquery.sticky.js");
			        break;
			    case "wow":
					$APPLICATION->AddHeadScript("/MeteorRC/js/plugins/wow/wow.min.js");
			        break;
			    case "pace":
					$APPLICATION->AddHeadScript("/MeteorRC/js/plugins/pace/pace.min.js");
			        break;
			    case "slimscroll":
					$APPLICATION->AddHeadScript("/MeteorRC/js/plugins/slimscroll/jquery.slimscroll.min.js");
			        break;
			    case "jquery.cookie":
					$APPLICATION->AddHeadScript("/MeteorRC/js/plugins/jquery-cookie/jquery.cookie.js");
			        break;
			    case "raphael":
					$APPLICATION->AddHeadScript("/MeteorRC/js/plugins/raphael/raphael.min.js");
			        break;
			    case "jquery-1.9.1":
					$APPLICATION->AddHeadScript("/MeteorRC/js/plugins/jquery/jquery-1.9.1.min.js");
			        break;
			    case "font-awesome":
					$APPLICATION->SetAdditionalCSS("/MeteorRC/fonts/font-awesome/css/font-awesome.min.css");
			        break;
			    case "animate":
					$APPLICATION->SetAdditionalCSS("/MeteorRC/js/plugins/animate/animate.min.css");
			        break;
			    case "smartresize":
					$APPLICATION->AddHeadScript("/MeteorRC/js/plugins/smartresize/smartresize.js");
			        break;
			    case "isotope":
					$APPLICATION->AddHeadScript("/MeteorRC/js/plugins/isotope/isotope.pkgd.min.js");
			        break;
			        // http://masonry.desandro.com/
			    case "masonry":
					$APPLICATION->AddHeadScript("/MeteorRC/js/plugins/masonry/masonry.pkgd.min.js");
			        break;
			    case "maskedinput":
			  		// data-plugin="maskedinput"	
					$APPLICATION->AddHeadScript("/MeteorRC/js/plugins/maskedinput/jquery.maskedinput.min.js");
			        break;
			    case "datetimepicker":
			  		// data-plugin="datetimepicker"
			    	CJSCore::Init($arExtensions = array('bootstrap', 'moment'));
					$APPLICATION->AddHeadScript("/MeteorRC/js/plugins/datetimepicker/js/bootstrap-datetimepicker.min.js");
			        $APPLICATION->SetAdditionalCSS("/MeteorRC/js/plugins/datetimepicker/css/bootstrap-datetimepicker.min.css");
			        break;
			    case "mousewheel":
			    	$APPLICATION->AddHeadScript("/MeteorRC/js/plugins/mousewheel/jquery.mousewheel.min.js");		
			        break;
			    case "moment":
			    	$APPLICATION->AddHeadScript("/MeteorRC/js/plugins/moment/moment.min.js");
			    	$APPLICATION->AddHeadScript("/MeteorRC/js/plugins/moment/locales.min.js");					
			        break;
			    case "sortable":
			    	// http://rubaxa.github.io/Sortable/
			    	$APPLICATION->AddHeadScript("/MeteorRC/js/plugins/Sortable/Sortable.min.js");
			        break;
			    case "zoomsl":
			    	// http://zoomsl.sergeland.ru/example/
			    	$APPLICATION->AddHeadScript("/MeteorRC/js/plugins/zoomsl/zoomsl-3.0.min.js");
			        break;
			    case "select":
			    	// .selectpicker
			    	CJSCore::Init($arExtensions = array('bootstrap'));
			    	$APPLICATION->SetAdditionalCSS("/MeteorRC/js/plugins/bootstrap-select/bootstrap-select.min.css");
			    	$APPLICATION->AddHeadScript("/MeteorRC/js/plugins/bootstrap-select/bootstrap-select.min.js");
			    	$APPLICATION->AddHeadScript("/MeteorRC/js/plugins/bootstrap-select/defaults-ru_RU.js");
			    	$APPLICATION->AddHeadScript("/MeteorRC/js/plugins/bootstrap-select/bootstrap-select.go.js");	
			        break;
			}
		}
	}
}


class Mail {

  private $from;
  private $from_name = "";
  private $type = "text/html";
  private $encoding = "utf-8";
  private $notify = false;

  /* Конструктор принимающий обратный e-mail адрес */
  public function __construct($from) {
    $this->from = $from;
  }

  /* Изменение обратного e-mail адреса */
  public function setFrom($from) {
    $this->from = $from;
  }

  /* Изменение имени в обратном адресе */
  public function setFromName($from_name) {
    $this->from_name = $from_name;
  }

  /* Изменение типа содержимого письма */
  public function setType($type) {
    $this->type = $type;
  }

  /* Нужно ли запрашивать подтверждение письма */
  public function setNotify($notify) {
    $this->notify = $notify;
  }

  /* Изменение кодировки письма */
  public function setEncoding($encoding) {
    $this->encoding = $encoding;
  }

  /* Метод отправки письма */
  public function send($to, $subject, $message) {
    $from = "=?utf-8?B?".base64_encode($this->from_name)."?="." <".$this->from.">"; // Кодируем обратный адрес (во избежание проблем с кодировкой)
    $headers = "From: ".$from."\r\nReply-To: ".$from."\r\nContent-type: ".$this->type."; charset=".$this->encoding."\r\n"; // Устанавливаем необходимые заголовки письма
    if ($this->notify) $headers .= "Disposition-Notification-To: ".$this->from."\r\n"; // Добавляем запрос подтверждения получения письма, если требуется
    $subject = "=?utf-8?B?".base64_encode($subject)."?="; // Кодируем тему (во избежание проблем с кодировкой)
    return mail($to, $subject, $message, $headers); // Отправляем письмо и возвращаем результат
  }

}

class CEvent extends APPLICATION {
	public function Send($event, $arFields){
		global $APPLICATION;
		$arConfig = $APPLICATION->CONFIG;
		$error = false;
		$arEvent = APPLICATION::GetElementForField("settings", "event", array("ACTIVE" => "Y", "EVENT_NAME" => $event), true);
		if(!isset($arEvent["ID"])){
			APPLICATION::AddMessage2Log('Не найден тип почтового шаблона!', "CEvent [" . $event . "]");
			return false;
		}
		$arMessage = APPLICATION::GetElementForField("settings", "message", array("ACTIVE" => "Y", "EVENT_ID" => $arEvent["ID"]), false);
		foreach ($arMessage as $message) {
			$arFieldsTmpl = array();
			foreach (array_merge($arFields, $APPLICATION->CONFIG) as $key => $value) {
				if(!is_array($value))
					$arFieldsTmpl["#" . $key . "#"] = $value;
			}
			foreach ($message as $key => $value) {
				$message[$key] = strtr($value, $arFieldsTmpl);
			}
			

			$MAIL = new Mail(isset($message["EMAIL_FROM"])?$message["EMAIL_FROM"]:$arConfig["DEFAULT_EMAIL_FROM"]);
			// $MAIL->setFromName($message["EMAIL_TO"]);
			$MAIL->setType($message["BODY_TYPE"]); 
			if (!$MAIL->send($message["EMAIL_TO"], $message["SUBJECT"], $message["MESSAGE"])){
				APPLICATION::AddMessage2Log('Сообщение не отправлено!', "CEvent [" . $event . "]");
				$error = true;
			}
		}
		return $error?false:true;
	}
}

class CACHE extends APPLICATION {
	public $arCacheExt = array('apcu', 'memcache', 'apc');
	public $cacheTime = 3600;
	public $arCache = array();
	public $cacheFile = null;
	public $cacheType = 'file';
	public $clearCacheName = '_';
	public $memcacheServer = 'localhost';
	public $memcachePort = 11211;
	public $MEMCACHE = null;
	function __construct (){
		foreach ($this->arCacheExt as $extension) {
			if (extension_loaded($extension)) {
				if($extension == 'memcache'){
					$this->MEMCACHE = new Memcache;
					$connect = $this->MEMCACHE->connect($this->memcacheServer, $this->memcachePort);
					if(!$connect){
						continue;
					}
				}
				$this->cacheType = $extension;
				break;
			}
		}
		if(isset($_REQUEST["clear_cache"]) and $_REQUEST["clear_cache"] == "Y"){
			$this->Clear();
		}
		$this->GetCacheFile();
	}

	private function GetCacheFile(){
		$url = APPLICATION::GetUrlPatch();
		$this->clearCacheName = CleanFileName($url);
		$this->cacheFile = CACHE_PATCH . $this->clearCacheName . SFX_BD;
	}
	public function Clear($component = false, $iblock = false){
		switch ($this->cacheType) {
			case 'apcu':
					apcu_clear_cache();
				break;
			case 'apc':
					apc_clear_cache();
				break;
			case 'memcache':
					$this->MEMCACHE->flush();
				break;
			case 'file':
			default:
				ClearDir(CACHE_PATCH, false);
				break;
		}
	}
	public function Set($cacheKey, $arSave, $component = false, $iblock = false){
		switch ($this->cacheType) {
			case 'apcu':
				$newCacheKey = $this->clearCacheName . $cacheKey;
				apcu_add($newCacheKey, $arSave, $this->cacheTime);
				break;
			case 'apc':
				$newCacheKey = $this->clearCacheName . $cacheKey;
				apc_add($newCacheKey, $arSave, $this->cacheTime);
				break;
			case 'memcache':
				$newCacheKey = $this->clearCacheName . $cacheKey;
				$this->MEMCACHE->add($newCacheKey, $arSave, false, $this->cacheTime);
				break;
			case 'file':
			default:
				$arSaveCache = array("ARRAY" => $arSave, "TIME" => time());
				$this->arCache[$cacheKey] = $arSaveCache;
				break;
		}
		return $arSave;
	}
	public function Save(){
		if($this->cacheType == 'file' and http_response_code() == 200){
			APPLICATION::ArrayWriter($this->arCache, $this->cacheFile);
		}
		return true;
	}
	public function Get($cacheKey){
		switch ($this->cacheType) {
			case 'apcu':
				$newCacheKey = $this->clearCacheName . $cacheKey;
				return apcu_fetch($newCacheKey);
				break;
			case 'apc':
				$newCacheKey = $this->clearCacheName . $cacheKey;
				return apc_fetch($newCacheKey);
				break;
			case 'memcache':
				$newCacheKey = $this->clearCacheName . $cacheKey;
				return $this->MEMCACHE->get($newCacheKey);
				break;
			case 'file':
			default:
				if(isset($this->arCache[$cacheKey])){
					if((time() - $this->cacheTime) < $this->arCache[$cacheKey]["TIME"]){
						return $this->arCache[$cacheKey]["ARRAY"];
					}else{
						unset($this->arCache[$cacheKey]);
						$this->Save();
						return false;
					}
				}
				break;
		}
	}
}


class Stata {
	public $bdWriter = 0;
	public $bdCount = 0;
	public $config = false;
	public $arCity = false;
	public $hostname = false;
	public $referer = false;
	public $ip = false;
	public $url = false;
	function __construct(){
		global $APPLICATION;
		$this->url = $_SERVER['HTTP_HOST'] . str_replace(array("'",'"'), '', $_SERVER['REQUEST_URI']);
		if(isset($_SERVER['HTTP_REFERER']))
			$this->referer =  str_replace("'", "", $_SERVER['HTTP_REFERER']);
		$this->ip = ($_SERVER['REMOTE_ADDR'] == '127.0.0.1')?$_SERVER["HTTP_X_REAL_IP"]:$_SERVER['REMOTE_ADDR'];
		$this->hostname = gethostbyaddr($this->ip);
		$this->config = $APPLICATION->GetFileArray(ROOT_PATH . "/config.php");
	}
	
	function russian_date($time){
		$date=explode(".", date("d.m.Y", $time));
		switch ($date[1]){
			case 1: $m='января'; break;
			case 2: $m='февраля'; break;
			case 3: $m='марта'; break;
			case 4: $m='апреля'; break;
			case 5: $m='мая'; break;
			case 6: $m='июня'; break;
			case 7: $m='июля'; break;
			case 8: $m='августа'; break;
			case 9: $m='сентября'; break;
			case 10: $m='октября'; break;
			case 11: $m='ноября'; break;
			case 12: $m='декабря'; break;
		}
		return (int)$date[0].' '.$m;
	}
	// Функция обрезки текста
	function cut_text($text, $number){
		if (strlen($text) > $number) {
			return substr($text, 0, $number) . '...';
		} else {
			return $text;
		}
	}
	function getColor($number){
		if($number > 1 and $number < 10){return "#1fbba6";}
		if($number >= 50){if($number < 100){return "#00FF13";}}
		if($number == 1){return "#fff";}
		if($number >= 100){return "#f00";}
	}
	// Функция конвертации байт
	function Size2Str($size){
		$kb = 1024;
		$mb = 1024 * $kb;
		$gb = 1024 * $mb;
		$tb = 1024 * $gb;
		
		if ($size < $kb) {
			return $size . ' байт';
		} else if ($size < $mb) {
			return round($size / $kb, 2) . ' Кб';
		} else if ($size < $gb) {
			return round($size / $mb, 2) . ' Мб';
		} else if ($size < $tb) {
			return round($size / $gb, 2) . ' Гб';
		} else {
			return round($size / $tb, 2) . ' Тб';
		}
	}
	function format_by_count($count, $form1, $form2, $form3){
		$count = abs($count) % 100;
		$lcount = $count % 10;
		if ($count >= 11 && $count <= 19) return($form3);
		if ($lcount >= 2 && $lcount <= 4) return($form2);
		if ($lcount == 1) return($form1);
		return $form3;
	}
}

