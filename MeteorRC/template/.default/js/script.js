$(function(){
	$("table").addClass("table").addClass("table-striped");

    $('a[href^="#"]').bind('click.smoothscroll',function (e) {
        e.preventDefault();

        var target = this.hash,
        $target = $(target);

        $('html, body').stop().animate({
        'scrollTop': $target.offset().top - 94
        }, 500, 'swing', function () {
        window.location.hash = target;
        });
    });
});

function CSSLoad(file){
	var link = document.createElement("link");
	link.setAttribute("rel", "stylesheet");
	link.setAttribute("type", "text/css");
	link.setAttribute("href", file);
	document.getElementsByTagName("head")[0].appendChild(link)
}

$(function() {
    var app = {
        initialize : function () {  
            this.setUpListeners();
        },
        setUpListeners: function () {
            $('.ajaxForm').on('submit', app.submitForm);
            $('.ajaxForm').on('keydown', '.has-error', app.removeError);
        },
        submitForm: function (e) {
            e.preventDefault();
            var form = $(this),
                submitBtn = form.find('button[type="submit"]'); 
            // если валидация не проходит - то дальше не идём
            if ( app.validateForm(form) === false ) return false; 
            var str = form.serialize();   
            // против повторного нажатия
            submitBtn.attr({disabled: 'disabled'});
            $.ajax({
                type: "POST",
                url: form.attr('action'),
                data: str                
            }).done(function(respond) {
                var arRespond = JSON.parse(respond);
                if(arRespond.ERROR) {
                    result = '<div class="alert alert-danger"><span class="close" data-dismiss="alert">×</span>' + arRespond.ERROR + '</div>';
                    form.find('.result').html(result);
                } else {
                    
                    result = '<div class="alert alert-success"><span class="close" data-dismiss="alert">×</span>' + arRespond.SUCCESS + '</div>';
                    form.find('.result').html(result);
                    form.trigger('reset');
                }
                //$('body').scrollTop( 400 );
            }).always(function(){
                submitBtn.removeAttr("disabled");
            })
        },
        validateForm: function (form){
            var inputs = form.find('.isec'),
                valid = true;
            //inputs.tooltip('destroy');
            $.each(inputs, function(index, val) {
                var input = $(val),
                    val = input.val(),
                    formGrout = input,
                    textError = input.attr("data-error");

                    if(val.length === 0){
                        formGrout.addClass('ierror').removeClass('has-success');    
                        input.tooltip({
                            trigger: 'manual',
                            placement: 'left',
                            title: textError
                        }).tooltip('show');     
                        valid = false;      
                    }else{

                        if(input.attr("type") == "email"){
                            formGrout.addClass('ierror').removeClass('has-success');    
                            var pattern = new RegExp(/^(("[\w-\s]+")|([\w-]+(?:\.[\w-]+)*)|("[\w-\s]+")([\w-]+(?:\.[\w-]+)*))(@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$)|(@\[?((25[0-5]\.|2[0-4][0-9]\.|1[0-9]{2}\.|[0-9]{1,2}\.))((25[0-5]|2[0-4][0-9]|1[0-9]{2}|[0-9]{1,2})\.){2}(25[0-5]|2[0-4][0-9]|1[0-9]{2}|[0-9]{1,2})\]?$)/i);
                            if (!pattern.test(val)) {
                                input.tooltip({
                                    trigger: 'manual',
                                    placement: 'left',
                                    title: "Введите email адрес правильно"
                                }).tooltip('show');     
                                valid = false;  
                            }else{
                                formGrout.removeClass('ierror').addClass('has-success');
                                input.tooltip('hide');
                            }
                        }else{
                            formGrout.removeClass('ierror').addClass('has-success');
                            input.tooltip('hide');
                        }
                    }
            });
            return valid; 
        },
        removeError: function() {
            $(this).removeClass('ierror').find('input').tooltip('destroy');
        }  
    }
    app.initialize();
});