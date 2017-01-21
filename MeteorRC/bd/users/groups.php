<?if(!defined("PROLOG_INCLUDED") || PROLOG_INCLUDED!==true)die("Не дамся!!!");?>
<?
FIREWALL::ProtectedBD();
return array (
  1 => 
  array (
    'ACTIVE' => 'Y',
    'NAME' => 'Администраторы',
    'ALIAS' => 'ADMIN',
    'ACCESS' => 'Y',
    'ACTIVE_TIME' => 1460609298,
    'EDIT_TIME' => 1460609298,
    'ID' => '1',
  ),
  2 => 
  array (
    'ACTIVE' => 'Y',
    'NAME' => 'Default',
    'ALIAS' => 'DEFAULT',
    'ACCESS' => 'Y',
    'TIME' => 1460052845,
    'ID' => '2',
  ),
);