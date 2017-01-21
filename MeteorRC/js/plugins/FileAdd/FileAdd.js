function OnchacgeFileFields() {
		var inputs = $("input.FileAdd[data-change=need]");
		$(inputs).change(function(){
			$(this).parent().siblings("a").text("Загрузка...");
			var field = this;
			var xhr = new XMLHttpRequest();
			var form = new FormData();
			form.append("FILE", this.files[0]);
			form.append("IBLOCK", $(this).attr("data-iblock"));
			form.append("ID", $(this).attr("data-id"));
			xhr.open("post","/MeteorRC/admin/ajax/file_ajax.php",true);
			xhr.send(form);
			xhr.onreadystatechange = function(){
				var out = xhr.responseText;
				result = JSON.parse(out);
				if(!result["ERROR"]){
					$(field).parent().siblings("a").attr("href", result["HREF"]);
					$(field).parent().siblings("a").text("Скачать");
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
	OnchacgeFileFields();
});