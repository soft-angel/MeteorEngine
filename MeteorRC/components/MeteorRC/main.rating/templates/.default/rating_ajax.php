<?require_once($_SERVER["DOCUMENT_ROOT"] ."/MeteorRC/main/include/before.php");?>

<?
$arResult = $APPLICATION->GetElementForID($FIREWALL->GetString("COMPONENT"), $FIREWALL->GetString("IBLOCK"), $FIREWALL->GetNumber("ELEMENT_ID"));


if(!isset($_SESSION["RATING"][$FIREWALL->GetString("COMPONENT")][$FIREWALL->GetString("IBLOCK")][$FIREWALL->GetNumber("ELEMENT_ID")])){
	$_SESSION["RATING"][$FIREWALL->GetString("COMPONENT")][$FIREWALL->GetString("IBLOCK")][$FIREWALL->GetString("ELEMENT_ID")] = "Y";


	$arResult[$FIREWALL->GetString("FIELD_VOTE_SUMM")] = (isset($arResult[$FIREWALL->GetString("FIELD_VOTE_SUMM")]))?($arResult[$FIREWALL->GetString("FIELD_VOTE_SUMM")] + $FIREWALL->GetNumber("VOTE")):$FIREWALL->GetNumber("VOTE");
	$arResult[$FIREWALL->GetString("FIELD_VOTE_COUNT")] = (isset($arResult[$FIREWALL->GetString("FIELD_VOTE_COUNT")]))?($arResult[$FIREWALL->GetString("FIELD_VOTE_COUNT")] + 1):1;

	$arResult[$FIREWALL->GetString("FIELD_VOTE")] = ($arResult[$FIREWALL->GetString("FIELD_VOTE_SUMM")] / $arResult[$FIREWALL->GetString("FIELD_VOTE_COUNT")]);
	$save = $APPLICATION->SaveElementForID($arResult, $FIREWALL->GetString("COMPONENT"), $FIREWALL->GetString("IBLOCK"), $FIREWALL->GetNumber("ELEMENT_ID"));
}
	