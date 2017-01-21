<?if(!defined("PROLOG_INCLUDED") || PROLOG_INCLUDED!==true)die();
/** @var array $arParams */
/** @var array $arResult */
/** @global class $APPLICATION */
/** @global class $USER */
/** @global class $CONFIG */
/** @global class $CACHE */
/** @global class $FILE */
/** @var string $templateName - Имя шаблона */
/** @var string $templateFile - файл шаблона */
/** @var string $templateFolder - папка шаблона относительно корня сайта */
/** @var string $componentPath - папка компонента относительно корня сайта */
//$APPLICATION->AddHeadScript($templateFolder . "/script.js");
//p($arResult);
?>
            <ul class="timeline">
<?foreach($arResult as $id => $arElement){?>
                <li>
                    <!-- begin timeline-time -->
                    <div class="timeline-time">
                        <span class="date"><?=rus_date("d F Y", $arElement["TIME"])?></span>
                        <span class="time"><?=date("H:i", $arElement["TIME"])?></span>
                    </div>
                    <!-- end timeline-time -->
                    <!-- begin timeline-icon -->
                    <div class="timeline-icon">
                        <a href="/MeteorRC/admin/?component=<?=$arElement["COMPONENT"]?>&iblock=<?=$arElement["IBLOCK"]?>"><?=$arParams[$arElement["COMPONENT"]][$arElement["IBLOCK"]]["ICON"]?></a>
                    </div>
                    <!-- end timeline-icon -->
                    <!-- begin timeline-body -->
                    <div class="timeline-body">
                        <div class="timeline-header">
                            <span class="userimage"><img src="/MeteorRC/main/plugins/phpthumb/phpThumb.php?src=<?=$FILE->GetUrlFile($arElement["USER"]["PERSONAL_PHOTO"], "users")?>&amp;w=34&amp;h=34&amp;zc=1&amp;q=65" /></span>
                            <a href="/MeteorRC/admin/?component=users&iblock=users&edit_element=<?=$arElement["USER_ID"]?>" class="username"><?=(isset($arElement["USER"]["NAME"]))?$arElement["USER"]["NAME"]:"SYSTEM"?></a>
                            <!--<span class="pull-right text-muted">1,021,282 Views</span>-->
                        </div>
                        <div class="timeline-content">
                            <h4 class="template-title">
                                <?=$arElement["EVENT"]?>: 
                                <?if(isset($arElement["ELEMENT_ID"])){?>
                                <a href="/MeteorRC/admin/?component=<?=$arElement["COMPONENT"]?>&iblock=<?=$arElement["IBLOCK"]?>&edit_element=<?=$arElement["USER_ID"]?>"><?=$arElement["ELEMENT"]["NAME"]?></a>
                                <?}else{?>
                                <?=$arElement["ELEMENT"]["NAME"]?>
                                <?}?>
                            </h4>
                            <?if(isset($arElement["ELEMENT"]["PREVIEW_PICTURE"])){?>
                            <p><?=htmlspecialchars_decode($arElement["ELEMENT"]["PREVIEW_TEXT"])?></p>
                            <?}?>
                            <?if(isset($arElement["ELEMENT"]["PREVIEW_PICTURE"])){?>
                            <p class="m-t-20">
                                <img src="/MeteorRC/main/plugins/phpthumb/phpThumb.php?src=<?=$FILE->GetUrlFile($arElement["ELEMENT"]["PREVIEW_PICTURE"], $arElement["IBLOCK"])?>&amp;w=200&amp;h=200&amp;zc=1&amp;q=65" />
                            </p>
                            <?}?>
                        </div>
                        <div class="timeline-footer">
                            <a href="javascript:;" class="m-r-15"><i class="fa fa-thumbs-up fa-fw"></i> Like</a>
                            <a href="javascript:;"><i class="fa fa-comments fa-fw"></i> Comment</a>
                        </div>
                    </div>
                    <!-- end timeline-body -->
                </li>
<?}?>
                <!--<li>
                    <div class="timeline-icon">
                        <a href="javascript:;"><i class="fa fa-spinner"></i></a>
                    </div>
                    <div class="timeline-body">
                        Загрузка...
                    </div>
                </li>-->

            </ul>