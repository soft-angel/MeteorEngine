<?if(!defined("PROLOG_INCLUDED") || PROLOG_INCLUDED!==true) die();?>
<?
$FILE = new FILE;

$arExtension = array(
	'IMAGE' => array('png', 'gif', 'jpg', 'svg', 'bmp', 'jpeg', 'apng', 'mng'),
	'ARCHIVE' => array('7z', 'rar', 'zip', 'gzip', 'tar', 'gz'),
	'CODE' => array('php', 'js', 'html', 'css', 'txt'),
	'DOC' => array('pdf', 'doc', 'rtf', 'odt', 'sxw', 'docx', 'docm'),
	'FONTS' => array('otf', 'ttf', 'dfont', 'eot', 'euf', 'woff', 'fnt', 'fon', 'euf'),
);
$arIcon = array(
	"ARCHIVE" => '<i class="fa fa-file-archive-o" aria-hidden="true"></i>',
	"CODE" => '<i class="fa fa-file-code-o" aria-hidden="true"></i>',
	"DOC" => '<i class="fa fa-file-word-o" aria-hidden="true"></i>',
	"FONTS" => '<i class="fa fa-file-powerpoint-o" aria-hidden="true"></i>',
);

$arResult["FOLDER"] = $FIREWALL->GetString("FOLDER");
$arResult["PATCH"] = realpath($_SERVER["DOCUMENT_ROOT"] . $arResult["FOLDER"]);
$arResult["FILES"] = scandir($arResult["PATCH"]);

unset($arResult["FILES"][0]);
if($arResult["PATCH"] == $_SERVER["DOCUMENT_ROOT"])
	unset($arResult["FILES"][1]);

