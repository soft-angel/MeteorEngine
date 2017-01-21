<?require_once($_SERVER["DOCUMENT_ROOT"]."/MeteorRC/main/include/before.php");?>
<?
global $APPLICATION;
global $USER;
if($USER->IsAdmin()){
if(!$_REQUEST["SAVE_REVIEWS"]["GO"]){
$arResult["REVIEWS"] = $APPLICATION->GetFileArray(REVIEWS_BD);
?>
<form id="meteorrc_save_reviews" action="/" onsubmit="return SaveFormToModal(this, '<?=$_SERVER["PHP_SELF"]?>', true, true)">

<ul id="reviews_edit_list">
<?$arKey = null;?>
<?foreach($arResult["REVIEWS"] as $key => $reviews){?>
<?$arKey[] = $key;?>
<li class="reviews_edit_list accordion accordion_<?=$key?>" id="reviews_list_<?=$key?>">
<div class="accordion_top">
<span>Пользователь: "<?=$reviews["USER"]?>", <i class="fa fa-calendar"></i> <?=$reviews["DATE"]?></span>
</div>
<button onclick="ElementDell(this)" class="button button_dell_accordion" type="button"><i class="fa fa-trash-o"></i></button>
<button onclick="AccordionEdit(this, <?=$key?>)" class="button button_edit_accordion" type="button"><i class="fa fa-pencil"></i></button>
<div class="accordion_edit_all">
<div class="squaredTwo">
	<input name="SAVE_REVIEWS[ARRAY][<?=$key?>][ACTIVE]" class="input_checkbox" id="reviews_active_<?=$key?>" value="Y" <?if($reviews["ACTIVE"] == "Y"){?>checked="checked"<?}?> type="checkbox">
	<label for="reviews_active_<?=$key?>"></label>
</div>
<span class="input_left"><i class="fa fa-user"></i></span>
<input placeholder="Пользователь" name="SAVE_REVIEWS[ARRAY][<?=$key?>][USER]" value="<?=$reviews["USER"]?>" type="text">
<span class="input_left"><i class="fa fa-star-half-o"></i></span>
<input placeholder="Оценка" name="SAVE_REVIEWS[ARRAY][<?=$key?>][RATING]" value="<?=$reviews["RATING"]?>" type="text">
<div class="padding_product"></div>
<span class="input_left"><i class="fa fa-calendar"></i></span>
<input placeholder="Дата" name="SAVE_REVIEWS[ARRAY][<?=$key?>][DATE]" value="<?=$reviews["DATE"]?>" type="text">
<textarea rows="6" cols="50" class="text_reviews" placeholder="Текст отзыва" name="SAVE_REVIEWS[ARRAY][<?=$key?>][TEXT]"><?=$reviews["TEXT"]?></textarea>
</div>
</li>
<?}?>
</ul>

<button onclick="ReviewsAdd(this)" class="button button_accordion_add" type="button"><i class="fa fa-plus"></i></button>
<button class="button button_save" type="submit">Cохранить <i class="fa fa-floppy-o"></i></button>
<input autocomplete="off" value="Y" name="SAVE_REVIEWS[GO]" type="hidden">
<input id="seve_reviews_max" autocomplete="off" value="<?=max(array_reverse($arKey))?>" name="SAVE_REVIEWS[MAX]" type="hidden">
</form>
<?}else{?>
<?
sleep(1);
if($_REQUEST["SAVE_REVIEWS"]["ARRAY"]){
$APPLICATION->ArrayWriter($_REQUEST["SAVE_REVIEWS"]["ARRAY"], REVIEWS_BD);
}
?>
<?}?>
<?}?>