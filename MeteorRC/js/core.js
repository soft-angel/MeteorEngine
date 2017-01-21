function SaveFormToModal(form, url, close, reload, selector_load){
  if(!selector_load){
    selector_load = ".button_save";
  }
  $(selector_load + " i").removeClass("fa-floppy-o").addClass("fa-spinner").addClass("fa-pulse").addClass("fa-fw").addClass("margin-bottom");
  $.ajax({
            type: "POST",
            url: url,
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
              //alert(data);
              var msg, msgHTML;
              var success = true;
              var isJson = true;
              try {json = window.JSON.parse(data);}
              catch (e) { isJson = false }
                if(isJson){
                  if(json.ERROR){
                    success = false;
                    if(typeof json.ERROR == 'object'){
                      msg = json.ERROR.join('<br>');
                    }else{
                      msg = json.ERROR;
                    }
                    msgHTML = '<div class="alert alert-danger"><span class="close" data-dismiss="alert" aria-label="close">&times;</span>' + msg +'</div>';
                  }else if(json.SUCCESS){
                    msg = json.SUCCESS;
                    msgHTML = '<div class="alert alert-success"><span class="close" data-dismiss="alert" aria-label="close">&times;</span>' + msg +'</div>';
                  }
                }else if(!data == 'OK'){
                  alert(data);
                  success = false;
                }

        $(form).children('.result').html(msgHTML);

        $(selector_load + " i").removeClass("fa-spinner").removeClass("fa-pulse").removeClass("fa-fw").removeClass("margin-bottom");
        $(selector_load + " i").addClass("fa-floppy-o");
        if(close && success)
          $('#modal-meteor').modal('hide');
        if(reload && success)
          location.reload();
            }
  });
  return false;
}
function onlyDigits(input) {
  input.value = input.value.replace(/[^\d\.]/g, "");
  if(input.value.match(/\./g).length > 1) {
    input.value = input.value.substr(0, input.value.lastIndexOf("."));
  }
}

// возвращает cookie с именем name, если есть, если нет, то undefined
function getCookie(name) {
  var matches = document.cookie.match(new RegExp(
    "(?:^|; )" + name.replace(/([\.$?*|{}\(\)\[\]\\\/\+^])/g, '\\$1') + "=([^;]*)"
  ));
  return matches ? decodeURIComponent(matches[1]) : undefined;
}