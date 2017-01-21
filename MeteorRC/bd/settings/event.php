<?if(!defined("PROLOG_INCLUDED") || PROLOG_INCLUDED!==true)die("Не дамся!!!");?>
<?
FIREWALL::ProtectedBD();
return array (
  1 => 
  array (
    'ID' => '1',
    'ACTIVE' => 'Y',
    'EVENT_NAME' => 'NEW_ORDER',
    'NAME' => 'Новый заказ на сайте',
    'ACTIVE_TIME' => 1460609585,
    'EDIT_TIME' => 1460609585,
  ),
  2 => 
  array (
    'ID' => '1',
    'ACTIVE' => 'Y',
    'EVENT_NAME' => 'ORDER_PAID',
    'NAME' => 'Новый оплаченный заказ',
  ),
  3 => 
  array (
    'ID' => '3',
    'ACTIVE' => 'Y',
    'EVENT_NAME' => 'CALL_BACK',
    'NAME' => 'Онлайн запись с сайта',
    'ACTIVE_TIME' => 1463101157,
    'EDIT_TIME' => 1463101157,
  ),
);