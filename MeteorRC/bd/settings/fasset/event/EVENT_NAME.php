<?if(!defined("PROLOG_INCLUDED") || PROLOG_INCLUDED!==true)die("Не дамся!!!");?>
<?
FIREWALL::ProtectedBD();
return array (
  'NEW_ORDER' => 
  array (
    0 => 1,
  ),
  'ORDER_PAID' => 
  array (
    0 => 2,
  ),
  'CALL_BACK' => 
  array (
    0 => 3,
  ),
);