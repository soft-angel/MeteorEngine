function EyeEditor(checkbox){
  if (checkbox.checked){
    var isChecked = "Y";
  }else{
    var isChecked = "N";
  }
  SaveConfigParam('EYE_EDITOR', isChecked, 1000);
}
function SaveConfigParam(name, value, reloadTimeot = false){
  $.post( "/MeteorRC/admin/editors/settings_ajax.php?SAVE_SETTINGS[ARRAY][" + name + "]=" + value).done(function( data ) {
    if(reloadTimeot)
      setTimeout('location.reload();', reloadTimeot)
    return true;
  });
}
function ComponentBorderShow(component){
  $(component).mouseover(function() {
    $(component).css("box-shadow", "#464646 0 0 0px 2px").css("position", "relative").css("display", "inline-block").addClass("activ");    
  });

  $(component).mouseout(function() {
    $(component).css("box-shadow", "#464646 0 0 0 0");
    $(component).removeClass("activ");
  });
}



$(function() {
  $('#modal-meteor').on('hidden.bs.modal', function(e){ 
    $(this).removeData();
  });
  var changeCheckbox = document.querySelector( '#eyeToggle' );
  var init = new Switchery(changeCheckbox, { size: "small" });

  changeCheckbox.onchange = function() {
    EyeEditor(this);
  };


  PanelSetHeightLining();
});
$( window ).resize(function() {
  PanelSetHeightLining();
});



function PanelSetHeightLining() {
  var panelHeight = $('#meteor_panel').height();
  $('#meteorPanelLining').height(panelHeight);
}

function PanelToggle(btn){
  $('#meteor_panel').toggleClass("panel-fixed");
  $('#panelPin').toggleClass("active");
  if($('#meteor_panel').is( ".panel-fixed" )){
    var isFixed = "Y";
    $('#meteorPanelLining').show();
  }else{
    var isFixed = "N";
    $('#meteorPanelLining').hide();
  }
  SaveConfigParam('PANEL_FIXED', isFixed);
}