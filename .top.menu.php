<?if(!defined("PROLOG_INCLUDED") || PROLOG_INCLUDED!==true)die("Не дамся!!!");?>
<?
FIREWALL::ProtectedBD();
return array (
  array (
    'NAME' => 'Главная',
    'URL' => '/',
  ),
  array (
    'NAME' => 'Новости',
    'URL' => '/news/',
  ),
  array (
    'NAME' => 'Товары',
    'URL' => '/catalog/',
  ),
  array (
    'NAME' => 'Контакты',
    'URL' => '/contacts/',
  ),
  array (
    'NAME' => 'Отзывы',
    'URL' => '/reviews/',
  ),
);