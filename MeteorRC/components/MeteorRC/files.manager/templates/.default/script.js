function fileDelete(btn, id, file) {
	var isDell = confirm("Удалить: " + file + "?");

    if(isDell){
		$.post( "/MeteorRC/admin/editors/delete_file_ajax.php", {FILE:file}).done(function( msg ){
            if(msg.replace(/\s+/g, '') == 'OK') {
                $("#element-" + id).hide();
            } else {
                alert(msg);
            }   
    	});
    }
}
function showUpload(){
	$("#files-list-upload").toggle();
}