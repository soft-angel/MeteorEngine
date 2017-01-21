$(function() {
	
	var MiniCart = {
		
		initialize : function () {	
			this.button = '#popcart';
			this.cartBody = '.popcart';
			this.cartBodyWrap = '#popcart-wrap';
			this.updateUrl = '/MeteorRC/components/MeteorRC/shop.basket.mini/update_ajax.php';
			this.initializeToggle();
			this.setUpListeners();
			this.initializeDelete();
		},

		initializeToggle : function () {	
			$(MiniCart.button).click(function() {
				MiniCart.toggleCart();
			});
		},

		initializeDelete : function () {
			$("a[data-cart-id]").bind('click', function( event ) {
				event.preventDefault();
				MiniCart.minicartUpdate({DELETE: $(this).attr("data-cart-id")});
			})
		},

		toggleCart: function () {
			$(MiniCart.cartBody).toggle('fast', function() {});
		},

		setUpListeners: function () {
			$('form[data-addcart=minicart]').on('submit', MiniCart.submitForm);
		},

		addCompleted: function () {
			 MiniCart.minicartUpdate();
		},

		scrollTop: function () {
			 $('html, body').animate({ scrollTop: $(MiniCart.button).offset().top }, 'slow');
		},

		minicartUpdate: function (data) {
            $.ajax({
                type: "POST",
                url: MiniCart.updateUrl,
                data: data                
            }).done(function(msg) {
            	$(MiniCart.cartBodyWrap).replaceWith(msg);
            	$(MiniCart.cartBody).show('fast');
            	MiniCart.scrollTop();
          		MiniCart.initializeToggle();
          		MiniCart.initializeDelete();
            }).always(function(){
  
            })
		},
		submitForm: function (e) {
			e.preventDefault();

			var form = $(this);
			var submitBtn = form.find('button[type="submit"]'); 
			var data = form.serialize();
			var url = $(form).attr("action");
			var type = $(form).attr("method");

			if(!type)
				var type = "POST";
			// против повторного нажатия
	        submitBtn.attr({disabled: 'disabled'});

            $.ajax({
                type: type,
                url: url,
                data: data                
            }).done(function(msg) {
                    //alert(msg);
                   MiniCart.addCompleted();
            }).always(function(){
            	submitBtn.removeAttr("disabled");
            })
		},

	}

	MiniCart.initialize();

});
