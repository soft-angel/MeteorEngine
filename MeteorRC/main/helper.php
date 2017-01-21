<?
function p($array){
    echo "<pre>";
    print_r($array);
    echo "</pre>";
}
function translit($str)
{
$tr = array(
"А"=>"a","Б"=>"b","В"=>"v","Г"=>"g",
"Д"=>"d","Е"=>"e","Ж"=>"j","З"=>"z","И"=>"i",
"Й"=>"y","К"=>"k","Л"=>"l","М"=>"m","Н"=>"n",
"О"=>"o","П"=>"p","Р"=>"r","С"=>"s","Т"=>"t",
"У"=>"u","Ф"=>"f","Х"=>"h","Ц"=>"ts","Ч"=>"ch",
"Ш"=>"sh","Щ"=>"sch","Ъ"=>"","Ы"=>"yi","Ь"=>"",
"Э"=>"e","Ю"=>"yu","Я"=>"ya","а"=>"a","б"=>"b",
"в"=>"v","г"=>"g","д"=>"d","е"=>"e","ж"=>"j",
"з"=>"z","и"=>"i","й"=>"y","к"=>"k","л"=>"l",
"м"=>"m","н"=>"n","о"=>"o","п"=>"p","р"=>"r",
"с"=>"s","т"=>"t","у"=>"u","ф"=>"f","х"=>"h",
"ц"=>"ts","ч"=>"ch","ш"=>"sh","щ"=>"sch","ъ"=>"y",
"ы"=>"yi","ь"=>"","э"=>"e","ю"=>"yu","я"=>"ya",
" "=> "_", "."=> "", "/"=> "_"
);
return strtr($str,$tr);
}

function DBFilter($node) {
    if (get_magic_quotes_gpc()) $node = stripcslashes($node);
    return mysql_real_escape_string(trim(preg_replace('/ +/',' ',$node))); 

}
function htmlCompress($html){
    preg_match_all('!(<(?:code|pre|script).*>[^<]+</(?:code|pre|script)>)!',$html,$pre);
    $html = preg_replace('!<(?:code|pre).*>[^<]+</(?:code|pre)>!', '#pre#', $html);
    $html = preg_replace('#<!–[^\[].+–>#', '', $html);
    $html = preg_replace('/[\r\n\t]+/', ' ', $html);
    $html = preg_replace('/>[\s]+</', '><', $html);
    $html = preg_replace('/[\s]+/', ' ', $html);
    if (!empty($pre[0])) {
        foreach ($pre[0] as $tag) {
            $html = preg_replace('!#pre#!', $tag, $html,1);
        }
    }
    return $html;
} 
// Конвертер размера
function ConvertFileSize($bytes, $round = 2){
    if($bytes){
        $symbols = array('Байт', 'Кб', 'Мб', 'Гб', 'Тб', 'PiB', 'EiB', 'ZiB', 'YiB');
        $exp = floor(log($bytes)/log(1024));
        return  sprintf('%.' . $round . 'f '.$symbols[$exp], ($bytes/pow(1024, floor($exp))));
    }
}
function escape($a) {
    if (is_array($a))
    foreach ($a as $key=>$node) {
      if (is_array($node)) $result[$key] = escape($node); else $result[$key] = DBFilter($node);
    } else $result = DBFilter($a);
return $result;
}

Function array_clean(&$array, &$parent = NULL, $parent_key = NULL) { 
    if(count($array) > 0) {
        foreach($array as $key => &$item) {
            if(is_array($item))
                array_clean($item, $array, $key);
            elseif(trim($item) == '') {
                unset($array[$key]);
                if(count($array) == 0)
                    unset($parent[$parent_key]);
            }
        }
    } else
        unset($parent[$parent_key]);
}
function ParseDateTime($datetime, $format=false)
{
    if ($format===false && defined("FORMAT_DATETIME"))
        $format = FORMAT_DATETIME;

    $fm_args = array();
    if(preg_match_all("/(DD|MI|MMMM|MM|M|YYYY|HH|H|SS|TT|T|GG|G)/i", $format , $fm_args))
    {
        $dt_args = array();
        if(preg_match_all("~([^:\\\\/\\s.,0-9-]+|[^:\\\\/\\s.,a-z-]+)~i".BX_UTF_PCRE_MODIFIER, $datetime, $dt_args))
        {
            $arrResult = array();
            foreach($fm_args[0] as $i => $v)
            {
                if (is_numeric($dt_args[0][$i]))
                {
                    $arrResult[$v] = sprintf("%0".strlen($v)."d", intval($dt_args[0][$i]));
                }
                elseif(($dt_args[0][$i] == "am" || $dt_args[0][$i] == "pm") && array_search("T", $fm_args[0]) !== false)
                {
                    $arrResult["T"] = $dt_args[0][$i];
                }
                elseif(($dt_args[0][$i] == "AM" || $dt_args[0][$i] == "PM") && array_search("TT", $fm_args[0]) !== false)
                {
                    $arrResult["TT"] = $dt_args[0][$i];
                }
                elseif(isset($dt_args[0][$i]))
                {
                    $arrResult[$v] = $dt_args[0][$i];
                }
            }
            return $arrResult;
        }
    }
    return false;
}


function rus_date() {
    $translate = array(
    "am" => "дп",
    "pm" => "пп",
    "AM" => "ДП",
    "PM" => "ПП",
    "Monday" => "Понедельник",
    "Mon" => "Пн",
    "Tuesday" => "Вторник",
    "Tue" => "Вт",
    "Wednesday" => "Среда",
    "Wed" => "Ср",
    "Thursday" => "Четверг",
    "Thu" => "Чт",
    "Friday" => "Пятница",
    "Fri" => "Пт",
    "Saturday" => "Суббота",
    "Sat" => "Сб",
    "Sunday" => "Воскресенье",
    "Sun" => "Вс",
    "January" => "Января",
    "Jan" => "Янв",
    "February" => "Февраля",
    "Feb" => "Фев",
    "March" => "Марта",
    "Mar" => "Мар",
    "April" => "Апреля",
    "Apr" => "Апр",
    "May" => "Мая",
    "May" => "Мая",
    "June" => "Июня",
    "Jun" => "Июн",
    "July" => "Июля",
    "Jul" => "Июл",
    "August" => "Августа",
    "Aug" => "Авг",
    "September" => "Сентября",
    "Sep" => "Сен",
    "October" => "Октября",
    "Oct" => "Окт",
    "November" => "Ноября",
    "Nov" => "Ноя",
    "December" => "Декабря",
    "Dec" => "Дек",
    "st" => "ое",
    "nd" => "ое",
    "rd" => "е",
    "th" => "ое"
    );
    
    if (func_num_args() > 1) {
        $timestamp = func_get_arg(1);
        return strtr(date(func_get_arg(0), $timestamp), $translate);
    } else {
        return strtr(date(func_get_arg(0)), $translate);
    }
}
// print rus_date("l, j F Y");

function randString($pass_len=10, $pass_chars=false)
{
    static $allchars = "abcdefghijklnmopqrstuvwxyzABCDEFGHIJKLNMOPQRSTUVWXYZ0123456789";
    $string = "";
    if(is_array($pass_chars))
    {
        while(strlen($string) < $pass_len)
        {
            if(function_exists('shuffle'))
                shuffle($pass_chars);
            foreach($pass_chars as $chars)
            {
                $n = strlen($chars) - 1;
                $string .= $chars[mt_rand(0, $n)];
            }
        }
        if(strlen($string) > count($pass_chars))
            $string = substr($string, 0, $pass_len);
    }
    else
    {
        if($pass_chars !== false)
        {
            $chars = $pass_chars;
            $n = strlen($pass_chars) - 1;
        }
        else
        {
            $chars = $allchars;
            $n = 61; //strlen($allchars)-1;
        }
        for ($i = 0; $i < $pass_len; $i++)
            $string .= $chars[mt_rand(0, $n)];
    }
    return $string;
}



function mapTree($dataset, $parent) {
    $tree = array();
    foreach ($dataset as $id=>&$node) {
        if (!isset($node[$parent])) {
            $tree[$id] = &$node;
        }else {
            $dataset[$node[$parent]]['CHILDS'][$id] = &$node;
        }
    }
    return $tree;
}
function IntOnly($int){
    return preg_replace("/\D/", "", $int);
}


function SortForField($a, $b){
    switch ($GLOBALS["SORT"]["TYPE"]) {
        case "INT":
            $result = (isset($a[$GLOBALS["SORT"]["BY"]]) and $a[$GLOBALS["SORT"]["BY"]] < $b[$GLOBALS["SORT"]["BY"]])?false:true;
        break;
        default:
            $result = strcmp($a[$GLOBALS["SORT"]["BY"]], $b[$GLOBALS["SORT"]["BY"]]);
        break;
    }
    if($GLOBALS["SORT"]["ORDER"] == "ASC")
        return $result;
    if($GLOBALS["SORT"]["ORDER"] == "DESC")
        return ($result)?-1:1;
}

function UrlToPattern($arPattern, $subject){
    foreach (array_filter($arPattern) as $key => $value) {
        $otherParam = preg_replace ("/#(.*)#/" ,"", $value);
        $cleanParam = str_replace($otherParam, "", $value);
        if(isset($subject[$key]))
            $arUrlRewrite[str_replace("#", "", $cleanParam)] = str_replace($otherParam, "", $subject[$key]);
    }
    return (isset($arUrlRewrite))?array_filter($arUrlRewrite):array();
}
// брезка строки с добавлением троеточия
function cutString($string, $maxlen) {
    $len = (mb_strlen($string) > $maxlen) ? mb_strripos(mb_substr($string, 0, $maxlen), ' ') : $maxlen;
    $cutStr = mb_substr($string, 0, $len);
    return (mb_strlen($string) > $maxlen) ? $cutStr . '...' : $cutStr;
}
// Добавление атрибута nofollow
function nofollow($content) {
return preg_replace('/href="(http:\/\/.*?)"/','href="$1" rel="nofollow"',$content); 
}

// Альтернатива функции implode() для многомерных массивов
function multi_implode($sep, $array) {
    if(is_array($array)){
        foreach($array as $val)
            $_array[] = is_array($val)? multi_implode($sep, $val) : $val;
        if(isset($_array))
            return implode($sep, $_array);
    }else{
        return $array;
    }
}
function ClearDir($path, $isAll = true){
    if(file_exists($path) && is_dir($path)){
        $dirHandle = opendir($path);
        while(false!==($file = readdir($dirHandle))){
            if($file!='.' && $file!='..'){
                $tmpPath = $path.'/'.$file;
                chmod($tmpPath, 0777);
                if(is_dir($tmpPath)){
                    ClearDir($tmpPath);
                } else {
                    unlink($tmpPath);
                }
            }
        }
        closedir($dirHandle);
    }
    if($isAll and file_exists($path))
        rmdir($path);
}

function DeleteParam($url, $ParamNames)
{
    $arUrl = parse_url($url);
    if(isset($arUrl["query"]))
            parse_str($arUrl["query"], $aParams);
    foreach(array_keys($aParams) as $key)
    {
        if(strcasecmp($ParamNames, $key) == 0)
        {
            unset($aParams[$key]);
            break;
        }
    }
    return $arUrl["path"] . "?" . http_build_query($aParams, "", "&");
}


// Функция склонения числительных в русском языке 
// echo declOfNum(5, array('иностранный язык', 'иностранных языка', 'иностранных языков'));
function declOfNum($number, $titles){
    $cases = array (2, 0, 1, 1, 1, 2);
    return $number." ".$titles[ ($number%100 > 4 && $number %100 < 20) ? 2 : $cases[min($number%10, 5)] ];
}

function arrayToUnicID($array = array()){
        return crc32(multi_implode("_", $array));
}

function MergeArrays($Arr1, $Arr2)
{
  foreach($Arr2 as $key => $Value)
  {
    if(array_key_exists($key, $Arr1) && is_array($Value))
      $Arr1[$key] = MergeArrays($Arr1[$key], $Arr2[$key]);

    else
      $Arr1[$key] = $Value;

  }

  return $Arr1;

}
function fixPathes($css_file_name, $file_string) {
    $path = dirname($css_file_name) . '/';
    $mathes = array();
    preg_match_all('@([\.*\/\w+\/]*[\-\w]+\.(?>jpg|gif|png|svg|css|jpeg|woff|eot|ttf))@iS', $file_string, $mathes);
    $fixed = array();
    foreach($mathes[0] as $original_file_name) {

        if(isset($fixed[$original_file_name]))
            continue;

        if(strpos($original_file_name, './') === 0) {
            $file_name = str_replace('./', '', $original_file_name);
        } else {
            $file_name = $original_file_name;
        }

        $file_string = str_replace($original_file_name, ''.$path.$file_name, $file_string);

        $fixed[$original_file_name] = true;
    }

    return $file_string;
}
function file_compress($adir, $file_name, &$file_input) {
    global $CONFIG;
    $pos = strrpos($file_name,'.');               //get last . in file name
    if ($pos==false)
        die ('illogical response from strrpos');
    $fn = substr($file_name,0,$pos).substr($file_name,$pos);  //put timestamp into file name
    $fl = null;                       //clear file data variable
    foreach($file_input as $key => $value){
        if(!$value){continue;}
        unset($file_input[$key]);
        
        $fl .= '/* File: ' . $key . ' */' . PHP_EOL;
        if (strtolower(substr($file_name,$pos+1,2)) == 'js') {
            $fl .= file_get_contents($_SERVER["DOCUMENT_ROOT"] . $key);
        }else{
            $css = CssMin::minify(file_get_contents($_SERVER["DOCUMENT_ROOT"] . $key));
            $fl .= fixPathes($key, $css);
           // = preg_replace('/\n\r|\r\n|\n|\r|\t| {2,}/', '', );
        }
        $fl .= PHP_EOL;
    }
    $fileGZ = $_SERVER["DOCUMENT_ROOT"] . $adir.'/'.$fn.'gz';
    $fileNormal = $_SERVER["DOCUMENT_ROOT"] . $adir.'/'.$fn;
    file_put_contents ($fileNormal,$fl);
    //file_put_contents ($fileGZ,gzencode ($fl,9));
    chmod($fileNormal, $CONFIG['FILE_PERMISSIONS']);
    //chmod($fileGZ, $CONFIG['FILE_PERMISSIONS']);
}
function CleanFileName($filename) {
    return preg_replace('/[^a-zа-яё]+/iu', '_', $filename);
}