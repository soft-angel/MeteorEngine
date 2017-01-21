window.onload = function() {
    startPlay();
};
function startPlay() {
	var audio = document.getElementById('musicBackround');
	var cookieAudio = $.cookie('audio');
	if(cookieAudio){
		audio.currentTime = cookieAudio;
	}
	audio.play();

	var timerId = setInterval(function() {
	  $.cookie('audio', audio.currentTime, { expires: 7, path: '/' });
	}, 1000);
	$('#startPlay').hide();
	$('#pausePlay').show();
}
function pausePlay() {
	var audio = document.getElementById('musicBackround');
	audio.pause();
	$('#startPlay').show();
	$('#pausePlay').hide();
}