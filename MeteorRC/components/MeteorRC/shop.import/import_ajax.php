<?require_once($_SERVER["DOCUMENT_ROOT"]."/MeteorRC/main/include/before.php");?>
<?
if($USER->IsAdmin()){

sleep(1);
$FILE = new FILE;
$arParams = $APPLICATION->GetFileArray($_SERVER["DOCUMENT_ROOT"] . '/MeteorRC/components/MeteorRC/shop.products.list/.parametrs.php');

if(isset($_FILES["FILES"])){
	foreach ($_FILES["FILES"]["name"] as $id => $name) {
		$fileType[$id] = $FILE->GetTypeFile($name);
		if($fileType[$id] == "xml"){
			$xml = simplexml_load_file($_FILES["FILES"]["tmp_name"][$id]);
			$elements = $xml->shop->offers->offer;
			if(move_uploaded_file($_FILES["FILES"]['tmp_name'][$id], __DIR__ . "/import.xml")){

			}

		}
		break;
	}
}



if($arPost = (isset($_POST["IMPORT"])?$_POST["IMPORT"]:false)){
	$bd_file = FOLDER_BD . $arParams["COMPONENT"] . DS . $arParams["IBLOCK"] . SFX_BD;
	$arSave = $APPLICATION->GetFileArray($bd_file);
	if(!$arSave)
		$arSave = array();
	$xml = simplexml_load_file(__DIR__ . "/import.xml");
	$elements = $xml->shop->offers->offer;
	$sections = json_decode(json_encode((array)$xml->shop->categories->category), TRUE);
	foreach ($elements as $element) {
		unset($arElement);
		foreach ($arPost as $key => $value) {
			if($value){
				foreach ($value as $field) {
					switch($arParams["FIELDS"][$field]["TYPE"])
					{
						case "TRANSLIT":
							$arElement[$arParams["FIELDS"][$field]["TRANSLIT_FOR"]] = translit( (string) $element->$key);
							$arElement[$field] = (string) $element->$key;
						break;
						case "PRICE":
							$arElement[$field] = $APPLICATION->PriceFormat( (string) $element->$key);
						break;
						case "SELECT_BD":
							$bd_select = FOLDER_BD . "shop" . DS . $arParams["FIELDS"][$field]["BD"] . SFX_BD;
							$arSelectSave = $APPLICATION->GetFileArray($bd_select);
							if(!isset($arSelectSave[(string) $element->$key])){
								foreach ($xml->shop->categories->xPath('//category') as $id_tag => $atribut) {
									if((string)$atribut['id'] == (string) $element->$key){
								   		$arSelectSave[(string) $element->$key]["NAME"] = $sections[$id_tag];
								   		$arSelectSave[(string) $element->$key]["ALIAS"] = translit( $sections[$id_tag] );
									}
								}
								$arSelectSave[(string) $element->$key]["ACTIVE"] = "Y";


								$APPLICATION->ArrayWriter($arSelectSave, $bd_select);
							}
							$arElement[$field] = (string) $element->$key;
						break;
						case "IMAGE":
							$fileType = $FILE->GetTypeFile((string) $element->$key);
							$local = __DIR__ . "/file." . $fileType;
							if (file_put_contents($local, file_get_contents((string) $element->$key))) {
								$picture = $FILE->MakeFileArray((string) $element->$key, $local);
							}
							$ImageID = $FILE->SaveImage($picture, "products");
							if(is_numeric($ImageID)){
								//$imagePatch = $FILE->GetUrlFile($ImageID, "products");
								//$img = $_SERVER["DOCUMENT_ROOT"] . $imagePatch;
								//$FILE->ImageResize($img, (isset($_REQUEST["MAX_WIDTH"]))?$_REQUEST["MAX_WIDTH"]:1024, false, (isset($_REQUEST["QUALITY"]))?$_REQUEST["QUALITY"]:80);
								$arElement[$field] = $ImageID;
							}
						break;
						case "TEXT":
						default:
							$arElement[$field] = (string) $element->$key;
					}
				}
			}
		}
			$arElement["ACTIVE"] = "Y";
		if(empty($arSave)){
			$arSave[1] = $arElement;
		}else{
			$arSave[] = $arElement;
		}
		}
		$save = $APPLICATION->ArrayWriter($arSave, $bd_file);
		$APPLICATION->FassetGenerate($arParams["COMPONENT"], $arParams["IBLOCK"], $arSave);
		exit;
}
?>
<?ob_start();?>
<form action="/MeteorRC/components/MeteorRC/shop.import/import_ajax.php" method="post" id="import-config">
		<table class="table table-striped">
            <thead>
              <tr>
                <th>#</th>
                <th>Поле из xml</th>
                <th>Является</th>
              </tr>
            </thead>
            <tbody>
<?
$i=0;
foreach ($elements[0] as $key => $value) {
	$i++;
?>
              <tr>
                <td><?=$i?></td>
                <td><?=$key?> (<?=mb_strimwidth($value, 0, 30, "...");?>)</td>
                <td>
                	<select name="IMPORT[<?=$key?>][]" id="import_<?=$i?>" multiple>
<?

foreach ($arParams["FIELDS"] as $key => $value) {?>
						<option value="<?=$key?>"><?=$value["NAME"]?> [<?=$key?>]</option>
<?}?>
                	</select>
					<script type="text/javascript">$('#import_<?=$i?>').selectpicker({'style': 'btn-white', 'liveSearch': true});</script>
                </td>
              </tr>
<?}?>
            </tbody>
          </table>
			<div class="text-center">
				<button type="submit" class="btn btn-sm btn-success"><i class="fa fa-download"></i> Начать импорт</button>
			</div>
</form>
<?
$out["table"] = ob_get_contents();
ob_end_clean();
echo json_encode($out);


}
?>