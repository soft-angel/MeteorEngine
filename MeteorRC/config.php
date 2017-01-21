<?if(!defined("PROLOG_INCLUDED") || PROLOG_INCLUDED!==true)die("Не дамся!!!");?>
<?
FIREWALL::ProtectedBD();
return array (
  'SITE_NAME' => '',
  'EYE_EDITOR' => 'Y',
  'COMPRESS' => 
  array (
    'HTML' => 'N',
  ),
  'DEFAULT_EMAIL_FROM' => 'meteor@soft-angel.ru',
  'CACHE' => 'Y',
  'FILE_PERMISSIONS' => '0775',
  'DIR_PERMISSIONS' => '0664',
  'TIMELINE_CNT' => 50,
);