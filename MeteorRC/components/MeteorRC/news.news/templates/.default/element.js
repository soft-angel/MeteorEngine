	$(function(){
		var $gallery = $('.gallery a').simpleLightbox();
		
		$gallery.on('show.simplelightbox', function(){
			console.log('Requested for showing');
		})
	});