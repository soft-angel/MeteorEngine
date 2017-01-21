<?require_once($_SERVER["DOCUMENT_ROOT"] ."/MeteorRC/main/include/before.php");

global $APPLICATION;
global $USER;
if($USER->IsAdmin()){
	if($component = $FIREWALL->GetString("component") and $iblock = $FIREWALL->GetString("iblock") and $id = $FIREWALL->GetNumber("id")){
		$arElment = $APPLICATION->GetElementForID($component, $iblock, $id);
		if($APPLICATION->DeleteElementForID($component, $iblock, $id)){
			echo "OK";
			$arParams = $APPLICATION->GetComponentsParams($component, $iblock);
			if(isset($arParams["EVENTS"]["TEXT"]["DELL"])){
				$APPLICATION->TimelineAdd($arParams, $arElment, 'DELL');
			}
		}else{
			?><div class="alert alert-danger">Ошибка удаления</div><?
		}
	}
}
