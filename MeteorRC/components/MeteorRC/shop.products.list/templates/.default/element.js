$(function() {
	// ересчет цены
	reCalculationPrice();

		$('#myTab a').click(function (e) {
		  e.preventDefault()
		  $(this).tab('show')
		});

		$('.fancybox').fancybox();


    $("#OneClickBtn").click(function(e){
    	e.preventDefault();
		$.getScript( "/MeteorRC/components/MeteorRC/shop.products.list/buyoneclick.js" )
		  .done(function( script, textStatus ) {
			goPhone("input.phone");
			$("#OneClickModal").modal();
		});
		$.getScript( "/MeteorRC/js/plugins/awesomplete/awesomplete.js" )
		  .done(function( script, textStatus ) {
		  	CSSLoad("/MeteorRC/js/plugins/awesomplete/awesomplete.css");

			jQuery(function($){
			    $ = Awesomplete.$;
			    $$ = Awesomplete.$$;
			    new Awesomplete($('input[type="email"]'), {
			        list: ["@yahoo.ru", "@yandex.ru", "@mail.ru", "@facebook.com", "@gmail.com", "@rambler.ru", "@googlemail.com", "@google.com", "@hotmail.com", "@hotmail.co.uk", "@icloud.com", "@me.com", "@mail.com", "@msn.com", "@live.com", "@sbcglobal.net", "@verizon.net", "@yahoo.com", "@yahoo.co.uk"],
			        item: function(text, input){
			        var newText = input.slice(0, input.indexOf("@")) + text;
			 
			        return Awesomplete.$.create("li", {
			            innerHTML: newText.replace(RegExp(input.trim(), "gi"), "<mark>$&</mark>"),
			            "aria-selected": "false"
			        });
			    },
			    filter: function(text, input){
			        return RegExp("^" + Awesomplete.$.regExpEscape(input.replace(/^.+?(?=@)/, ''), "i")).test(text);
			    }
			}); });
		});
    });
});

function goPhone(obect){
		$.getScript( "/MeteorRC/js/plugins/maskedinput/jquery.maskedinput.min.js" )
		  .done(function( script, textStatus ) {
			jQuery(function($){
			   $(obect).mask("+7 (999) 999-9999");
			});
		});
}

function CSSLoad(file){
	var link = document.createElement("link");
	link.setAttribute("rel", "stylesheet");
	link.setAttribute("type", "text/css");
	link.setAttribute("href", file);
	document.getElementsByTagName("head")[0].appendChild(link)
}

function reCalculationPrice(){
	if ($('#option-MATERIAL').length > 0) {
		var option = parseInt($('option:selected', $('#option-MATERIAL')).attr('data-price').replace(/\s+/g,''));
	}else{
		var option = 0;
	}
	var price = parseInt($('#productPriceDefault').text().replace(/\s+/g,''));
	var newPrice = splitNums(' ', (option + price).toString());
	$('#productPrice').text(newPrice).hide().toggle( "pulsate" );
}


function splitNums(delimiter, str)
{   
    str = str.replace(/(\d+)(\.\d+)?/g,
          function(c,b,a){return b.replace(/(\d)(?=(\d{3})+$)/g, '$1'+delimiter) + (a ? a : '')} );

    return str;
}