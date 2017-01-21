<?if(!defined("PROLOG_INCLUDED") || PROLOG_INCLUDED!==true)die();?>
			        <div class="panel panel-inverse" data-sortable-id="index-<?=$arParams["COMPONENT"]?>-<?=$arParams["IBLOCK"]?>">
			            <div class="panel-heading">
			                <h4 class="panel-title">Новые пользователи<span class="pull-right label label-success">Пользователей: <?=count($arResult["ELEMENTS"])?></span></h4>
			            </div>
                        <ul class="registered-users-list clearfix">
<?
						$i = 0;
						foreach($arResult["ELEMENTS"] as $id => $arElement){
							$i++;
?>
                            <li>
                                <a href="?component=users&iblock=users&edit_element=<?=$id?>"><img src="<?=(isset($arElement["PERSONAL_PHOTO"]))?"/MeteorRC/main/plugins/phpthumb/phpThumb.php?src=" . $FILE->GetUrlFile($arElement["PERSONAL_PHOTO"], $arParams["IBLOCK"]) . "&w=128&h=128&zc=1&q=65":SITE_TEMPLATE_PATH . "images/noimage.png"?>" alt="" class="img-responsive"/></a>
                                <h4 class="username text-ellipsis text-center">
                                    <?=$arElement["NAME"]?>
                                    <small class="text-center"><?=$arElement["LOGIN"]?></small>
                                </h4>
                            </li>
<?
							if(isset($arParams["ELEMENT_COUNT"]) and $i >= $arParams["ELEMENT_COUNT"])
								break;
						}
?>
                        </ul>
			            <div class="panel-footer text-center">
			                <a href="?component=users&iblock=users" class="text-inverse">Показать всех</a>
			            </div>
			        </div>