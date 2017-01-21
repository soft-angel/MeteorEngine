<?require_once($_SERVER["DOCUMENT_ROOT"] ."/MeteorRC/main/include/before.php");?>
<?
global $APPLICATION;
global $USER;
if(!$_REQUEST["SAVE_PRODUCT"]["GO"] and $USER->IsAdmin()){
$arResult["SECTIONS"] = $APPLICATION->GetFileArray(FOLDER_PRODUCT_BD . "product" . SFX_BD);
?>
<?$arCity = $APPLICATION->GetFileArray(FOLDER_CITY_BD . "city" . SFX_BD)?>
<form id="meteorrc_product_city" action="/" onsubmit="return SaveProductForm()">
<div id="menu_list">
<?//p($arResult)?>
<ul id="product_edit_list">
<?$arKey = null;?>
<?foreach($arResult["SECTIONS"] as $key => $section){?>
<?$arKey[] = $key;?>
<li class="product_edit_list accordion accordion_<?=$key?>" id="city_list_<?=$key?>">
<div id="product_name_<?=$key?>" class="accordion_name"><?=$section["NAME"]?></div>
<button onclick="ElementDell(this)" class="button button_dell_accordion" type="button"><i class="fa fa-trash-o"></i></button>
<button onclick="AccordionEdit(this, <?=$key?>)" class="button button_edit_accordion" type="button"><i class="fa fa-pencil"></i></button>
<div class="accordion_edit_all">
<div class="squaredTwo">
	<input name="SAVE_PRODUCT[ARRAY][<?=$key?>][ACTIVE]" class="input_checkbox" id="product_active_<?=$key?>" value="Y" <?if($section["ACTIVE"] == "Y"){?>checked="checked"<?}?> type="checkbox">
	<label for="product_active_<?=$key?>"></label>
</div>
<span class="input_left"><i class="fa fa-shopping-cart"></i></span>
<input oninput="ProductOninputName(this, <?=$key?>)"  placeholder="Имя товара" name="SAVE_PRODUCT[ARRAY][<?=$key?>][NAME]" value="<?=$section["NAME"]?>" type="text">
<span class="input_left"><i class="fa fa-link"></i></span>
<input placeholder="Алиас" name="SAVE_PRODUCT[ARRAY][<?=$key?>][ALIAS]" id="product_alias_<?=$key?>" value="<?=$section["ALIAS"]?>" type="text">

<div class="padding_product"></div>
<span class="input_left"><i class="fa fa-rub"></i></span>
<input placeholder="Цена" name="SAVE_PRODUCT[ARRAY][<?=$key?>][PRICE]" value="<?=$section["PRICE"]?>" type="text">

<span class="input_left"><i class="fa fa-map-marker"></i></span>
<select name="SAVE_PRODUCT[ARRAY][<?=$key?>][CITY]">
<?foreach($arCity as $city){?>
<option <?if($section["CITY"] == $city["ALIAS"]){?>selected="selected"<?}?> value="<?=$city["ALIAS"]?>"><?=$city["NAME"]?></option>
<?}?>
</select>

<div class="padding_product"></div>
<span class="input_left"><i class="fa fa-cart-plus"></i></span>
<input placeholder="Количество" name="SAVE_PRODUCT[ARRAY][<?=$key?>][BONUS]" value="<?=$section["BONUS"]?>" type="text">
</div>
<div class="accordion_adress_all">
<div class="accordion_adress">
<?if(!empty($section["ADRESS"])){?>
<?foreach($section["ADRESS"] as $keys => $adress){?>
<?$arKeyAdress[] = $keys;?>
<div>
<span class="input_left"><i class="fa fa-align-left"></i></span>
<input placeholder="Описание адреса" name="SAVE_PRODUCT[ARRAY][<?=$key?>][ADRESS][<?=$keys?>][DESCRIPTION]" value="<?=$adress["DESCRIPTION"]?>" type="text">
<span class="input_left"><i class="fa fa-map-o"></i></span>
<input placeholder="Район" name="SAVE_PRODUCT[ARRAY][<?=$key?>][ADRESS][<?=$keys?>][AREA]" value="<?=$adress["AREA"]?>" type="text">
<button onclick="ElementDell(this)" class="button button_dell_accordion" type="button"><i class="fa fa-times"></i></button>
</div>
<?}?>
<input id="save_adress_max_<?=$key?>" autocomplete="off" value="<?=max(array_reverse($arKeyAdress))?>" name="SAVE_PRODUCT[MAX_ADRESS]" type="hidden">
<?}else{?>
<div>
<span class="input_left"><i class="fa fa-align-left"></i></span>
<input placeholder="Описание адреса" name="SAVE_PRODUCT[ARRAY][<?=$key?>][ADRESS][0][DESCRIPTION]" type="text">
<span class="input_left"><i class="fa fa-map-o"></i></span>
<input placeholder="Район" name="SAVE_PRODUCT[ARRAY][<?=$key?>][ADRESS][0][AREA]" type="text">
<input id="save_adress_max_<?=$key?>" autocomplete="off" value="0" name="SAVE_PRODUCT[MAX_ADRESS]" type="hidden">
<button onclick="ElementDell(this)" class="button button_dell_accordion" type="button"><i class="fa fa-times"></i></button>
</div>
<?}?>
</div>
<button onclick="AdressAdd(this, <?=$key?>)" class="button button_accordion_add" type="button"><i class="fa fa-plus"></i></button>
</div>

</li>
<?}?>
</ul>
<button onclick="ProductAdd(this)" class="button button_accordion_add" type="button"><i class="fa fa-plus"></i></button>
<button class="button button_save" type="submit">Сохранить <i class="fa fa-floppy-o"></i></button>
<input autocomplete="off" value="Y" name="SAVE_PRODUCT[GO]" type="hidden">
<input autocomplete="off" value="<?=$_REQUEST["FILE"]?>" name="SAVE_PRODUCT[FILE]" type="hidden">
<input id="save_product_max" autocomplete="off" value="<?=max(array_reverse($arKey))?>" name="SAVE_PRODUCT[MAX]" type="hidden">
</form>
<?}else{?>
<?
sleep(1);
// p($_REQUEST["SAVE_PRODUCT"]["ARRAY"]);
if($_REQUEST["SAVE_PRODUCT"]["ARRAY"]){
$APPLICATION->ArrayWriter($_REQUEST["SAVE_PRODUCT"]["ARRAY"], $_REQUEST["SAVE_PRODUCT"]["FILE"]);
}
?>
<?}?>