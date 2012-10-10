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
	
	function calcPopup() {
		popup = $('#popup');
		popup.width($(window).width());
		popup.height($(window).height());
	}
	$(window).resize(function() {
		calcPopup();
	});
	calcPopup();
	
	var popupurl = '';
	function openPopup(title, url) {
		$('#popup').show();
		$('#popup .header').html(title);
		if(popupurl != url) {
			popupurl = url;
			$.get(popupurl, function(data) {
				$('#popup .container .content').html(data);
				register();
			});
		}
	}
	$('#popup .close').click(function() {
		$('#popup').hide();
	});
	
	function register() {
		$("#popup .container form").submit(function () { return false; });
		$('#popup .container form :submit').click(function() {
			$('#popup .container form :submit').loadingButton();
			$.post(popupurl, $('#popup .container form').serialize() ,function(data) {
				$('#popup .container .content').html(data);
				register();
			});
		});
		
		
		
	}
	register();
	
	$('a.popup').click(function(e) {
		e.preventDefault();
		openPopup($(this).attr('title'), $(this).attr('href'));
	});
	
	$('#popup').click(function(e) {
		if(e.target != this) return;
		$(this).hide();
	});
});