$(function(){
  
  var app = {
    
    initialize : function () {  
      this.setUpListeners();
    },

    setUpListeners: function () {
      $('#formSendReviews').on('submit', app.submitForm);
      $('#formSendReviews').on('keydown', '.has-error', app.removeError);
    },

    submitForm: function (e) {
      e.preventDefault();

      var form = $(this),
        submitBtn = form.find('button[type="submit"]'),
        jsform = this;
      // если валидация не проходит - то дальше не идём
      if ( app.validateForm(form) === false ) return false; 

      var str = form.serialize();   

      // против повторного нажатия
          submitBtn.attr({disabled: 'disabled'});

            $.ajax({
                type: "POST",
                url: $(form).attr('action'),
                data: str                
            }).done(function(msg) {
              jsform.reset();
              form.find('.result').html('<div class="alert alert-success" role="alert">Отзыв успешно добавлен и появится на сайте после проверки модератором.</div>');
            }).always(function(){
              submitBtn.removeAttr("disabled");
            })
    },

    validateForm: function (form){

      var inputs = form.find('.required'),
        valid = true;
      
      //inputs.tooltip('destroy');

      $.each(inputs, function(index, val) {
        var input = $(val),
          val = input.val(),
          formGrout = input.parents('.form-group'),
          textError = input.attr("data-error");

          if(val.length === 0){
            formGrout.addClass('has-error').removeClass('has-success');   
            valid = false;    
          }else{
              formGrout.removeClass('has-error');
          }
      });

      return valid;
      
    },

    removeError: function() {
      $(this).removeClass('has-error').find('input').tooltip('destroy');
    }
    
  }

  app.initialize();

});