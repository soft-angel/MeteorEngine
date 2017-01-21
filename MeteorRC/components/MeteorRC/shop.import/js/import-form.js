$( document ).ready(function() {
(function() {
  
	var app = {
		
		initialize : function () {	
			this.setUpListeners();
		},

		setUpListeners: function () {
			$('form#import-config').on('submit', app.submitForm);
		},

		submitForm: function (e) {
			e.preventDefault();

			var form = $(this),
				submitBtn = form.find('button[type="submit"]'); 

			// если валидация не проходит - то дальше не идём

			var str = form.serialize();   

			// против повторного нажатия
	        submitBtn.attr({disabled: 'disabled'});

            $.ajax({
                type: "POST",
                url: "/MeteorRC/components/MeteorRC/shop.import/import_ajax.php",
                data: str                
            }).done(function(msg) {
                if(msg == 'OK') {
                    result = '<div class="alert alert-success">Мы получили Вашу заявку и свяжемся с Вами в ближайшее время.</div>';
                    form.html(result);
                } else {
                    alert(msg);
                }		
            }).always(function(){
            	submitBtn.removeAttr("disabled");
            })
		}
	}

	app.initialize();

}());
});