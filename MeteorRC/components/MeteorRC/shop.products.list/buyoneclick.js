(function() {
  
	var app = {
		
		initialize : function () {	
			this.setUpListeners();
		},

		setUpListeners: function () {
			$('#OneClickModalForm').on('submit', app.submitForm);
			$('#OneClickModalForm').on('keydown', '.has-error', app.removeError);
		},

		submitForm: function (e) {
			e.preventDefault();

			var form = $(this),
				submitBtn = form.find('button[type="submit"]'); 

			// если валидация не проходит - то дальше не идём
			if ( app.validateForm(form) === false )	return false; 

			var str = form.serialize();   

			// против повторного нажатия
	        submitBtn.attr({disabled: 'disabled'});

            $.ajax({
                type: "POST",
                url: "/MeteorRC/components/MeteorRC/shop.products.list/buyoneclick_ajax.php",
                data: str                
            }).done(function(respond) {
				var arRespond = JSON.parse(respond);
                if(arRespond.ERROR) {
                    result = '<div class="alert alert-danger">' + arRespond.ERROR + '<span class="close" data-dismiss="alert">×</span></div>';
                    form.children('.result').html(result);
                } else {
                    result = '<div class="alert alert-success">' + arRespond.SUCCESS + '<span class="close" data-dismiss="alert">×</span></div>';
                    form.children('.result').html(result);
                }
            }).always(function(){
            	submitBtn.removeAttr("disabled");
            })
		},

		validateForm: function (form){

			var inputs = form.find('input'),
				valid = true;
			
			//inputs.tooltip('destroy');

			$.each(inputs, function(index, val) {
				var input = $(val),
					val = input.val(),
					formGrout = input.parents('.input-group'),
					textError = input.attr("data-error");

					if(val.length === 0){
						formGrout.addClass('has-error').removeClass('has-success');	
						input.tooltip({
							trigger: 'manual',
							placement: 'left',
							title: textError
						}).tooltip('show');		
						valid = false;		
					}else{

						if(input.attr("type") == "email"){
							formGrout.addClass('has-error').removeClass('has-success');	
							var pattern = new RegExp(/^(("[\w-\s]+")|([\w-]+(?:\.[\w-]+)*)|("[\w-\s]+")([\w-]+(?:\.[\w-]+)*))(@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$)|(@\[?((25[0-5]\.|2[0-4][0-9]\.|1[0-9]{2}\.|[0-9]{1,2}\.))((25[0-5]|2[0-4][0-9]|1[0-9]{2}|[0-9]{1,2})\.){2}(25[0-5]|2[0-4][0-9]|1[0-9]{2}|[0-9]{1,2})\]?$)/i);
							if (!pattern.test(val)) {
								input.tooltip({
									trigger: 'manual',
									placement: 'left',
									title: "Введите email адрес правильно"
								}).tooltip('show');		
								valid = false;	
							}else{
								formGrout.removeClass('has-error').addClass('has-success');
								input.tooltip('hide');
							}
						}else{
							formGrout.removeClass('has-error').addClass('has-success');
							input.tooltip('hide');
						}
					}
			});

			return valid;
			
		},

		removeError: function() {
			$(this).removeClass('has-error').find('input').tooltip('destroy');
		}
		
	}

	app.initialize();

}());