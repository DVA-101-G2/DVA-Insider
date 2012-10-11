var popupurl = '';
//Öppnar en popup
function openPopup(title, url) {
	$('#popup').show();
	$('#popup .header span').html(title);
	if(popupurl != url) {
		$('#popup .content').empty();
		$('#popup .content').append($('<img />').attr('src', '/img/loading.gif').addClass('loading'));
		popupurl = url;
		$.get(popupurl, function(data) {
			$('#popup .content').html(data);
			registerPopupContent();
		});
	}
}

//Stäng popup
function closePopup() {
	$('#popup').hide();
}

//Eftersom jquery registerar bara elementen som finns i DOM i läget den körs så måste man om registera vaje gång en popup laddas om.
function registerPopupContent() {
	$("#popup .container form").submit(function () { return false; });
	$('#popup .container form :submit').click(function() {
		$('#popup .container form :submit').loadingButton();
		$.post(popupurl, $('#popup .container form').serialize() ,function(data) {
			$('#popup .container .content').html(data);
			registerPopupContent();
		});
	});
	$('a.popup').click(function(e) {
		e.preventDefault();
		openPopup($(this).attr('rel'), $(this).attr('href'));
	});
}

$(function() {
	// scroll menu
	$(window).scroll(function(e){ 
	  $el = $('.fixedheader'); 

	  if ($(this).scrollTop() > 100 && $el.css('visibility') != 'visible'){ 
		$el.css({'visibility': 'visible'}); 
		$('header').css({'visibility': 'hidden'}); 
	  } 

	  if ($(this).scrollTop() < 100 && $el.css('visibility') != 'hidden'){ 
		$el.css({'visibility': 'hidden'}); 
		$('header').css({'visibility': 'visible'}); 
	  } 
	});
	
	$('#popup .close').click(function() {
		closePopup();
	});
	$('#popup').click(function(e) {
		if(e.target != this) return;
		closePopup();
	});
	//Regga länkar som kan öppna popups
	$('a.popup').click(function(e) {
		e.preventDefault();
		openPopup($(this).attr('rel'), $(this).attr('href'));
	});
});