// Authorize
function AuthorizeForm(form, component_id){
    $(".default-login-" + component_id).hide();
    $(".load-login-" + component_id).show();
	$.ajax({
            type: $(form).attr("method"),
            url: $(form).attr("action"),
            data: $(form).serialize(),
            timeout: 10000,
            error: function(request,error) {
                if (error == "timeout") {
                    alert('timeout');
                }
                else {
                    alert('Error! Please try again!');
                }
            },
            success: function(data) {
                if($(form).children(".result").html(data)){
                    $(".default-login-" + component_id).show();
                    $(".load-login-" + component_id).hide();
				}
            }
	});
	return false;
}

    $(function() {
        $("#reg").click(function() {
          $('.regwrap').toggle('fast', function() {
          });
        });
    });