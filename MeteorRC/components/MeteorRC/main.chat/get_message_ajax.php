<?require_once($_SERVER["DOCUMENT_ROOT"] ."/MeteorRC/main/include/before.php");?>
<?
$FILE = new FILE;
$arResult["ELEMENTS"] = $APPLICATION->GetElementForField("chat", "history");
$arResult["USERS"] = $APPLICATION->GetFileArray(FOLDER_BD . "users" . DS . "users" . SFX_BD);
								foreach($arResult["ELEMENTS"] as $id => $arElement){
?>
									<li class="<?if($USER->GetID() == $arElement["USER_ID"]){?>right<?}else{?>left<?}?>">
                                        <span class="date-time"><?=date("H:i:s", $arElement["TIME"])?></span>
                                        <a href="javascript:$('#message-input').val('<?=$arResult["USERS"][$arElement["USER_ID"]]["NAME"]?>, ').focus();" class="name">
                                        	<?if($USER->GetID() == $arElement["USER_ID"]){?><span class="label label-primary">ADMIN</span> Я<?}else{?><?=$arResult["USERS"][$arElement["USER_ID"]]["NAME"]?><?}?>
                                        </a>
                                        <a href="javascript:$('#message-input').val('<?=$arResult["USERS"][$arElement["USER_ID"]]["NAME"]?>, ').focus();" class="image"><img alt="" src="<?=(isset($arResult["USERS"][$arElement["USER_ID"]]["PERSONAL_PHOTO"]))?"/MeteorRC/main/plugins/phpthumb/phpThumb.php?src=" . $FILE->GetUrlFile($arResult["USERS"][$arElement["USER_ID"]]["PERSONAL_PHOTO"], "users") . "&w=128&h=128&zc=1&q=65":SITE_TEMPLATE_PATH . "images/noimage.png"?>"></a>
                                        <div class="message">
                                            <?=$arElement["MESSAGE"]?>
                                        </div>
                                    </li>
<?
								}
?>