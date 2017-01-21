function splitNums(delimiter, str)
{   
	if(typeof str != 'string')
		str = str.toString();
    str = str.replace(/(\d+)(\.\d+)?/g,
          function(c,b,a){return b.replace(/(\d)(?=(\d{3})+$)/g, '$1'+delimiter) + (a ? a : '')} );

    return str;
}
$(function() {
	var basket = {
		
		initialize : function () {	
			this.form = $("form#basket-form");
			this.totalPriceElement = $('span[data-total-price]');
			this.quantity = $("input.quantityControl");
			this.createOrderUrl = $(this.form).attr("action");
			this.submitBtn = this.form.find('button[type="submit"]');
			this.inputs = this.form.find('input.validate');
			this.deliveryControl = this.form.find('#deliveryPrice input');
			this.result = this.form.children('.result');
			this.totalPriceElements = 0;
			this.setUpListeners();
			this.recalculationCart();
		},

		setUpListeners: function () {
			this.form.on('submit', basket.submitForm);
			this.quantity.on('input', basket.recalculationCart);
			this.deliveryControl.on('click', basket.recalculationCart);
			//this.form.on('keydown', '.has-error', basket.removeError);
		},

		recalculationCart: function() {
			$( "input[data-price-product-total]" ).each(function( index ) {
				// Получаем старые значения для расчетов
				var quantity = parseInt($(this).val());
				var id = parseInt($(this).attr('data-id'));
				var price = parseInt($(this).attr('data-price'));
				var priceProductTotal = parseInt($(this).attr('data-price-product-total'));
				var newPriceProductTotal = (quantity * price);
				$("#quanityTotal-" + id).text(splitNums(' ', newPriceProductTotal));

				basket.totalPriceElements = (basket.totalPriceElements + newPriceProductTotal);
			});
			var delivery = basket.form.find('#deliveryPrice input:checked');
			var priceDelivery = parseInt($(delivery).attr('data-price'));
			if(priceDelivery > 0){
				basket.totalPriceElements = (priceDelivery + basket.totalPriceElements);
			}

			//alert(basket.totalPriceElements);

			basket.totalPriceElement.text(splitNums(' ', basket.totalPriceElements));

			basket.totalPriceElements = 0;

		},

		submitForm: function (e) {
			e.preventDefault();

			// если валидация не проходит - то дальше не идём
			if ( basket.validateForm(basket.form) === false )	return false; 
			// против повторного нажатия
	        basket.submitBtn.attr({disabled: 'disabled'});

            $.ajax({
                type: "POST",
                url: basket.createOrderUrl,
                data: basket.form.serialize()                
            }).done(function(msg) {
            	var json;
            	if(json = JSON.parse(msg)){
	            	if(json.respond = "OK"){
	            		result = '<div class="alert alert-success order_result">' + json.message + '</div>';
	                    basket.form.html(result);
	            	}else if(json.respond = "ERROR"){
	            		result = '<div class="alert alert-danger">' + json.message + '</div>';
	                    basket.form.html(result);
	            	}
            	}else{
            		alert(msg);
            	}

            }).always(function(){
            	basket.submitBtn.removeAttr("disabled");
            })
		},
		validateForm: function (form){
			var valid = true;

			basket.result.html('');

			$.each(basket.inputs, function(index, val) {
				var input = $(val),
					val = input.val(),
					formGrout = input.parents('.input-group'),
					textError = input.attr("data-error");
					if(val.length === 0){
						$('html, body').stop();
						if($('html, body').animate({ scrollTop: input.offset().top - 200 }, 200)){
							formGrout.addClass('has-error').removeClass('has-success');	
							setTimeout(function () {
								input.tooltip({
									trigger: 'manual',
									placement: 'right',
									title: textError
								}).tooltip('show');	
							}, 400); 
		
							valid = false;	
						}
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

	basket.initialize();
});