<?if(!defined("PROLOG_INCLUDED") || PROLOG_INCLUDED!==true) die();?>
<?
//$arParamsComponnts = $APPLICATION->GetComponentsParams($arParams["COMPONENT"], $arParams["IBLOCK"]);
//$arParams = (array_merge($arParams, $arParamsComponnts));
if($arReview = $FIREWALL->GetArrayString("REVIEWS")){
	$arNewReview['SYSTEM_MESSAGE'] = null;
	$active = (isset($arParams['PREMODERATE']) and $arParams['PREMODERATE'] == 'Y')?'N':'Y';
	$arNewReview = array(
		'ACTIVE' => $active,
		'NAME' => $arReview['NAME'],
		'RATING' => $arReview['RATING'],
		'TEXT' => $arReview['TEXT'],
		'DATE' => date('d-m-Y H:i:s'),
	);
	$APPLICATION->SaveElementForID($arNewReview, $arParams["COMPONENT"], $arParams["IBLOCK"]);
	if(isset($arParams['PREMODERATE']) and $arParams['PREMODERATE'] == 'Y'){
		$arNewReview['SYSTEM_MESSAGE'] = 'Отзыв не активен! проверьте его и активируйте в панели упраления сайтом.';
	}
	$CEvent = new CEvent;
	$CEvent->Send("REVIEW_ADD", $arNewReview);
}


if(!isset($arParams["FILTER"]))
	$arParams["FILTER"] = array("ACTIVE" => "Y");
if(!isset($arParams["SORT"]))
	$arParams["SORT"] = false;

$arResult["ELEMENTS"] = $APPLICATION->GetElementForField($arParams["COMPONENT"], $arParams["IBLOCK"], $arParams["FILTER"], false, $arParams["SORT"]);

if(isset($arParams["COUNT"]) and $arParams["COUNT"])
	$arResult["ELEMENTS"] = array_slice($arResult["ELEMENTS"], 0, $arParams["COUNT"]);

$arEye = array(
	array(
		"ICON" => '<i class="fa fa-pencil"></i>',
		"LINK" => "/MeteorRC/admin/?component=" . $arParams["COMPONENT"] . "&amp;iblock=" . $arParams["IBLOCK"],
	),
	//array(
		//"ICON" => '<i class="fa fa-file-code-o"></i>',
		//"EDITOR" => "/MeteorRC/admin/editors/edit_file_ajax.php?FILE=" . $templateFolder . $tmplFileName,
	//),
);
$APPLICATION->AddEyeFunction($arEye);
