<?if(!defined("PROLOG_INCLUDED") || PROLOG_INCLUDED!==true)die("Не дамся!!!");?>
<?
FIREWALL::ProtectedBD();
return array (
  1 => 
  array (
    'ID' => '1',
    'ACTIVE' => 'Y',
    'SUBJECT' => 'Новый заказ на сайте - #SITE_NAME#',
    'EVENT_ID' => '1',
    'EMAIL_FROM' => '#EMAIL#',
    'EMAIL_TO' => '#DEFAULT_EMAIL_FROM#',
    'BODY_TYPE' => 'text/plain',
    'MESSAGE' => 'ID Заказа: #ID#
Имя: #NAME#
Фамилия: #LAST_NAME#

Адрес: #ADDRES#
Город: #CITY#
Почтовый индекс: #POST_CODE#

E-mail: #EMAIL#
Телефон: #PHONE#

Комментарий: #COMMENT#

Способ оплаты: #PAY_NAME#

Дата заказа: #DATE#',
  ),
  2 => 
  array (
    'ID' => '2',
    'ACTIVE' => 'Y',
    'SUBJECT' => 'Вы совершили заказ на сайте - #SITE_NAME#',
    'EVENT_ID' => '1',
    'EMAIL_FROM' => '#DEFAULT_EMAIL_FROM#',
    'EMAIL_TO' => '#EMAIL#',
    'BODY_TYPE' => 'text/plain',
    'MESSAGE' => 'ID Заказа: #ID#
Имя: #NAME#
Фамилия: #LAST_NAME#

Адрес: #ADDRES#
Город: #CITY#
Почтовый индекс: #POST_CODE#

E-mail: #EMAIL#
Телефон: #PHONE#

Комментарий: #COMMENT#

Дата заказа: #DATE#

В настоящий момент заказ обрабатывается.',
    'ACTIVE_TIME' => 1460609611,
    'EDIT_TIME' => 1460609611,
  ),
  3 => 
  array (
    'ID' => '3',
    'ACTIVE' => 'Y',
    'SUBJECT' => 'Заказ № #ID# с помощью  #PAY_NAME#  - #SITE_NAME#',
    'EVENT_ID' => '2',
    'EMAIL_FROM' => '#DEFAULT_EMAIL_FROM#',
    'EMAIL_TO' => '#DEFAULT_EMAIL_FROM#',
    'BODY_TYPE' => 'text/plain',
    'MESSAGE' => 'ID Заказа: #ID#
Имя: #NAME#
Фамилия: #LAST_NAME#

Адрес: #ADDRES#
Город: #CITY#
Почтовый индекс: #POST_CODE#

E-mail: #EMAIL#
Телефон: #PHONE#

Комментарий: #COMMENT#

Способ оплаты: #PAY_NAME#

Дата заказа: #DATE#',
    'ACTIVE_TIME' => 1460609598,
    'EDIT_TIME' => 1460609598,
  ),
  4 => 
  array (
    'ID' => '4',
    'ACTIVE' => 'Y',
    'SUBJECT' => 'Онлайн запись с сайта - #SITE_NAME#',
    'EVENT_ID' => '3',
    'EMAIL_FROM' => '#DEFAULT_EMAIL_FROM#',
    'EMAIL_TO' => '#DEFAULT_EMAIL_FROM#',
    'BODY_TYPE' => 'text/plain',
    'MESSAGE' => 'Имя: #NAME#
Тема вопроса: #THEME#
E-mail: #EMAIL#
Телефон: #PHONE#

Желаемая дата консультации: #TIME#
Желаемое время консультации: #DATE#

Запрос поступил с страницы: #URL#

Комментарий: #MESSEGE#
',
    'ACTIVE_TIME' => 1463212898,
    'EDIT_TIME' => 1463212898,
  ),
);