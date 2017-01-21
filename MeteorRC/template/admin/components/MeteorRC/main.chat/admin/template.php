<?if(!defined("PROLOG_INCLUDED") || PROLOG_INCLUDED!==true)die();?>
			        <div class="panel panel-inverse" data-sortable-id="index-<?=$arParams["COMPONENT"]?>-<?=$arParams["IBLOCK"]?>">
			            <div class="panel-heading">
			                <h4 class="panel-title">Админ чат
                            <div class="panel-heading-btn m-r-10">
                                <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-success" data-click="panel-expand"><i class="fa fa-expand"></i></a>
                            </div>
                            </h4>

			            </div>
			            <div class="panel-body bg-silver">
                            <div id="chat-list" data-scrollbar="true" data-height="225px" data-start="bottom">
                                <ul class="chats"><?
                                if(!empty($arResult["ELEMENTS"])){
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
								}else{
?>
									<li>Чат предназначен для общения администраторов</li>
<?
								}
?>
                                </ul>
                            </div>
                        </div>
                        <div class="panel-footer">
                            <form name="send_message_form" action="/MeteorRC/admin/editors/save_ajax.php" method="post" id="form-<?=$arParams["IBLOCK"]?>">
								<input type="hidden" name="PARAMS[IBLOCK]" value="<?=$arParams["IBLOCK"]?>">
								<input type="hidden" name="PARAMS[COMPONENT]" value="<?=$arParams["COMPONENT"]?>">
								<input type="hidden" name="SAVE[USER_ID]" value="<?=$USER->GetID()?>">
								<input type="hidden" name="SAVE[TIME]" value="<?=time()?>">
                                <div class="input-group">
                                    <input id="message-input" type="text" class="form-control input-sm" name="SAVE[MESSAGE]" placeholder="Введите сообщение">
                                    <span class="input-group-btn">
                                        <button type="submit" id="message-button" class="btn btn-primary btn-sm" type="button">Отправить</button>
                                    </span>
                                </div>
                            </form>
                        </div>
			        </div>
<script>
$( document ).ready(function() {
	$("form#form-<?=$arParams["IBLOCK"]?>").on('submit',
		function (e) {
			if($('#message-input').val() == '')
				return;
			var form = $(this);
			var str = form.serialize(); 
            $.ajax({
                type: "POST",
                url: form.attr("action"),
                data: str                
            }).done(function(msg) {
                if(msg == 'OK') {
                	$('#message-input').val('');
					GetMessages();
                } else {
                    alert("No");
                }       
            });
            e.preventDefault();
	});
});

function GetMessages(){
	$.ajax({
		type: "POST",
		url: "/MeteorRC/components/MeteorRC/main.chat/get_message_ajax.php",
	}).done(function(msg) {
		$("ul.chats").html(msg);
		var block = document.getElementById("chat-list");
		block.scrollTop = block.scrollHeight;
	});
}
</script>