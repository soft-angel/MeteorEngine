<?if(!defined("PROLOG_INCLUDED") || PROLOG_INCLUDED!==true) die();?>
<?
global $APPLICATION;
global $CONFIG;
global $USER;
function decl($int, $expr){  
  settype($int, "integer");  
  $count = $int % 100;  
  if ($count >= 5 && $count <= 20) {  
    $result = $int." ".$expr['2'];  
  } else {  
    $count = $count % 10;  
    if ($count == 1) {  
      $result = $int." ".$expr['0'];  
    } elseif ($count >= 2 && $count <= 4) {  
      $result = $int." ".$expr['1'];  
    } else {  
      $result = $int." ".$expr['2'];  
    }  
  }  
  return $result;  
} 

if( ini_get('allow_url_fopen') ) {
  $arResult = json_decode(file_get_contents("http://hosting.meteorengine.ru/get.php?domain=" . $_SERVER['HTTP_HOST']), true);

  if($arResult["MONEY"]){
      $arResult["PRICE"] = ($arResult["MONEY"] / 31);
      $arResult["PRICE_DAY"] = $arResult["BALANS"] / $arResult["PRICE"];
      $arResult["PRICE_YEAR"] = round(date('L')?366:365) / 31 * $arResult["MONEY"];
      $arResult["PRICE_HOUR"] = ($arResult["MONEY"] / 31 / 24);
  }
}
?>