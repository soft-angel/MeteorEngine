<?require_once($_SERVER["DOCUMENT_ROOT"] ."/MeteorRC/main/include/before.php");?>
<?
class SaveElement {
	private $arParamsComponents;
	private $bdFile;
	private $arParams;
	public $arRespond = array();
	function __construct($arParams, $arSaveElement){
		global $APPLICATION;
		global $CACHE;
		$this->arParams = $arParams;
		//p($arParams);
		// Что бы новые данные не занесли и не стали админом например)))
		unset($arSaveElement["GROUP_ID"], $arSaveElement["ACTIVE"], $arSaveElement["ID"], $arSaveElement["SESSION_ID"]);
		$this->arSaveElement = $arSaveElement;
		
		// Проверяем всевозможные параметрры на ошибки
		if($this->Check()){
			$this->bdFile = FOLDER_BD . $arParams["COMPONENT"] . DS . $arParams["IBLOCK"] . SFX_BD;
			// получаем параметры компонента
			$this->arParamsComponents = $APPLICATION->GetComponentsParams($arParams["COMPONENT"], $arParams["IBLOCK"]);
			// подгружаем массив всех элементов для дальнейшей записи
			$this->GetElementsIblock();
			// проверяем поля сохраняемого элемента на требования компонента, такие как обязательное поле и уникальное поле
			$this->CheckForFields();
			// Дополняем поля элемента
			$this->CheckElementFields();
			if(!isset($this->arRespond["ERROR"])){
				// сохраняем все это дело
				$this->Save();
				$APPLICATION->TimelineAdd($this->arParamsComponents, $this->arSaveElement, $this->event);
				// Генерируем фассеты
				if(isset($this->arParamsComponents["FIELDS"]))
					$APPLICATION->FassetGenerate($arParams["COMPONENT"], $arParams["IBLOCK"], $this->arElementsIblock, $this->arParamsComponents["FIELDS"]);
				// Чистим кэш компонента на всех страницах
				$CACHE->Clear($arParams["COMPONENT"], $arParams["IBLOCK"]);
			}
		}
	}
	private function Check(){
		global $USER;
		if(!$USER->IsAuthorized() or $USER->GetID() != $this->arSaveElement["OLD_KEY"])
			$this->arRespond["ERROR"][] = "Ошибка доступа";
		if(empty($this->arParams))
			$this->arRespond["ERROR"][] = "Не указаны параметры для сохранения";
		if(!isset($this->arParams['COMPONENT']))
			$this->arRespond["ERROR"][] = "Не указан компонент для сохранения";
		if(!isset($this->arParams['IBLOCK']))
			$this->arRespond["ERROR"][] = "Не указан инфоблок для сохранения";
		if(!isset($this->arRespond["ERROR"]))
			return true;
	}
	private function GetElementsIblock(){
		global $APPLICATION;
		$this->arElementsIblock = $APPLICATION->GetFileArray($this->bdFile);
	}

	private function CheckElementFields(){
		global $USER;
		if(isset($this->arSaveElement["PASSWORD"]) and $this->arSaveElement["PASSWORD"] != "******"){
			$this->arSaveElement["PASSWORD"] = $USER->Hash($this->arSaveElement["PASSWORD"]);
		}

		$this->arSaveElement["EDIT_TIME"] = time();

		if(isset($this->arParams["OLD_KEY"]) and $this->arParams["OLD_KEY"]){
			$this->elementID = $this->arParams["OLD_KEY"];
			if(isset($this->arSaveElement["PASSWORD"]) and $this->arSaveElement["PASSWORD"] == "******"){
				$this->arSaveElement["PASSWORD"] = $this->arElementsIblock[$arParams["OLD_KEY"]]["PASSWORD"];
			}
			$this->event = "EDIT";
		}else{
			$this->event = "ADD";
			$this->elementID = (!empty($this->arElementsIblock))?(max(array_keys($this->arElementsIblock)) + 1):1;
			$this->arRespond["OLD_KEY"] = $this->elementID;
		}
		$this->arSaveElement["ID"] = $this->elementID;
		if(!isset($this->arElementsIblock[$this->elementID]["ACTIVE_TIME"])){
			$this->arSaveElement["ACTIVE_TIME"] = time();
		}
	}

	private function Save(){
		global $APPLICATION;
		$this->arElementsIblock[$this->elementID] = array_merge($this->arElementsIblock[$this->elementID], $this->arSaveElement);
		$this->respondSave = $APPLICATION->ArrayWriter($this->arElementsIblock, $this->bdFile);
		if($this->respondSave){
			$this->arRespond["SUCCESS"] = (isset($this->arParams["TEXT_SAVE"]))?$this->arParams["TEXT_SAVE"]:"Успешно сохранено";
		}else{
			$this->arRespond["ERROR"]= "Ошибка сохранения";
		}
	}
	private function CheckForFields(){
		foreach ($this->arParamsComponents["FIELDS"] as $fieldCode => $arField) {
			if($fieldCode == "GROUP_ID")
				continue;
			if(isset($arField["TRANSLIT_FOR"]) and $arField["TRANSLIT_FOR"]){
				$translit = $this->arSaveElement[$arField["TRANSLIT_FOR"]];
				//$this->arSaveElement[$arField["TRANSLIT_FOR"]] = translit($translit);
			}

			if(isset($arField["UNIQUE"]) and $arField["UNIQUE"] == "Y"){
				foreach ($this->arElementsIblock as $id => $arElement) {
					if(isset($this->arParams["OLD_KEY"]) and $this->arParams["OLD_KEY"] == $id)
						continue;
					if(isset($arElement[$fieldCode]) and $arElement[$fieldCode] == $this->arSaveElement[$fieldCode]){
						$this->arRespond["ERROR"] = "Значение из поля \"{$arField['NAME']}\" уже используется другим пользователем";
					}
				}
			}
			if(isset($arField["REQUIRED"]) and $arField["REQUIRED"] == "Y"){
				if(empty($this->arSaveElement[$fieldCode])){
					$this->arRespond["ERROR"] = "Значение поля \"{$arField['NAME']}\" не должно быть пустым";
				}
			}
		}
	}
}

global $FIREWALL;
$arParams = $FIREWALL->GetArrayString("PARAMS");
$arParams["COMPONENT"] = "users";
$arParams["IBLOCK"] = "users";

$arElement = $FIREWALL->GetArrayString("SAVE");
$SaveElement = new SaveElement($arParams, $arElement);
die(json_encode($SaveElement->arRespond));
?>
