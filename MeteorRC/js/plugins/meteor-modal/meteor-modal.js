function modalClaver(url, title, width, height, style){
	$('#modal_content').css("opacity", "0"); 
	$("#loading").css("display", "block");
	modalOk(title, width, height);
	$.ajax({
          type: 'POST',
          url: url,
          data: false,
          success: function(data) {
			if($("#loading").css("display", "none")){
				$('#modal_content').css("opacity", "1");
				if($('#modal_content').html(data)){
					modalPosition();
					jQuery('.scrollbar-macosx').scrollbar();
					$(".menu_panel").removeClass( "show" );
				}
			}
          },
          error:  function(xhr, str){
                alert('Возникла ошибка: ' + xhr.responseCode);
            }
     });
}

function modalOk(title, width, height){
	// alert(height);
	$("#modal_name").html(title);
	$("body").addClass("blur");
	$("#modal_wrap").css("display", "block");
	if($("#modal_claver").css("width", width).css("height", height)){
		$("#modal_claver").css("top", "50%").css("opacity", "1");
		modalPosition();
	}
}

function modalClaverClose(){
	$('#modal_content').css("opacity", "0"); 
	$("body").removeClass("blur");
	$("#modal_wrap").css("display", "none");
	$("#modal_claver").css("top", "-100%").css("opacity", "0");
	$('#modal_error').html("");
}
function modalPosition(){
	var height_m = $("#modal_claver").innerHeight();
	var width_m = $("#modal_claver").innerWidth();
	$("#modal_claver").css("margin-top", - (height_m / 2)).css("margin-left", - (width_m / 2));
}
$( window ).resize(function() {
	modalPosition();
});
/////////// 