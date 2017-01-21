function OnchacgeImageFields() {
		var inputs = $("input.imageAdd[data-change=need]");
		$(inputs).change(function(){
			$(this).parent().siblings("img").attr("src", "/MeteorRC/images/loading.gif");
			var field = this;
			var xhr = new XMLHttpRequest();
			var form = new FormData();
			form.append("IMAGE", this.files[0]);
			form.append("IBLOCK", $(this).attr("data-iblock"));
			form.append("ID", $(this).attr("data-id"));
			form.append("MAX_WIDTH", $(this).attr("data-max-width"));
			form.append("QUALITY", $(this).attr("data-quality"));
			xhr.open("post","/MeteorRC/admin/ajax/image_ajax.php",true);
			xhr.send(form);
			xhr.onreadystatechange = function(){
				var out = xhr.responseText;
				result = JSON.parse(out);
				if(!result["ERROR"]){
					$(field).parent().siblings("img").attr("src", result["SRC"]);
					$(field).parent().siblings("input[type$='hidden']").val(result["ID"]);
					$(field).attr("data-id", result["ID"]);
				}else{
					alert(result["ERROR"]);
				}
			}
		});
		$(inputs).attr('data-change', 'ok');
}

$( document ).ready(function() {
	OnchacgeImageFields();
});