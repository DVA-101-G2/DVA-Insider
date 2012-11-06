var popupurl = '';
//Öppnar en popup
function openPopup(title, url, onclose) {
	$('#popup').show();
	$('#popup').data('onclose', onclose == undefined ? function(){} : onclose);
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
	$('#popup').data('onclose').apply($('#popup'));
	popupurl = '';
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
	$('.ckeditor').each(function() {
		create_editor(this);
	});
}

function create_editor(ele) {
	$(ele).tinymce({
		script_url : '/tiny_mce/tiny_mce.js',
		theme : "advanced",
		plugins : "inlinepopups,fullscreen"
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
	
	
	
	//Widget system!
	function updateWidget(widget) {
		$.get('/widget/get/'+widget.data('id'), function(data) {
			$(widget).find('.content').html(data);
		});
	}
	$('.widgets').each(function() {
		var isowner = $(this).hasClass('owner');
		var widgets = $(this);
		ids = $(this).attr('id').replace('widgets-', '');
		console.log(ids);
		ids = ids.split("-");
		var group = ids[0];
		var owner = ids[1];
		
		function addWidget(ele) {
			var widget = ele;
			var id = widget.attr('id').replace('widget-','');
			widget.data('id', id);
			var actions = $('<div />').addClass('actions');
			widget.append(actions);
			if(isowner) {
				$('<div />').addClass('delete').click(function() {
					if(!confirm('Är du säker på att du vill ta bort den här widgeten?')) return;
					$.get('/widget/delete/'+widget.data('id'), function(data) {
						widget.remove();
					});
				}).appendTo(actions);
				$('<div />').addClass('config').click(function() {
					openPopup('Konfigurera Widget', '/widget/config/'+widget.data('id'), function() {
						updateWidget(widget);
					});
				}).appendTo(actions);
				$('<div />').css('clear', 'both').appendTo(actions);
			}
			$('<div />').addClass('content').appendTo(widget);
			updateWidget(widget);
			
			widget.hover(function(event){
				actions.show();
			},
			function(event) {
				actions.hide();
			});
			
			var breakpointUp;
			var breakpointDown;
			var widgety;
			function calcbreakpoints(py) {
				prev = widget.prev();
				next = widget.next();
				if(prev.length != 0) {
					breakpointUp = prev.offset().top+(prev.height()/2);
				}
				else
					breakpointUp = false;
				
				if(next.length != 0) {
					breakpointDown = next.offset().top+(next.height()/2);
				}
				else
					breakpointDown = false;
					
				widgety = widget.offset().top+(py-widget.offset().top);
				widgetoffset = widget.offset().top;
			}
			widget.mousehold(function(e, first) {
				if(first) {
					widget.css('position', 'relative');
					calcbreakpoints(e.pageY);
					widget.disableSelection();
				}
				ry = e.pageY-widgety;
				
				if(!breakpointUp) {
					if(ry < 0) return; 
				}
				else if(e.pageY < breakpointUp) {
					widget.insertBefore(widget.prev());
					calcbreakpoints(e.pageY);
				}
				
				if(!breakpointDown) {
					if(widget.offset().top+widget.height() > widgets.height()+widgets.offset().top) return; 
				}
				else if(e.pageY > breakpointDown) {
					widget.insertAfter(widget.next());
					calcbreakpoints(e.pageY);
				}
				
				ry = e.pageY-widgety;
				widget.css('top', ry);
			});
			
			out = function() {
				widget.animate({
					top: '0'
				}, 400, function() {
					widget.css('position', 'static');
					widget.css('top', 0);
				});
			};
			
			widget.mouseup(out);
		}
		
		if(isowner) {
			var addwidgetbar = $('<ul />');
			$(this).prepend(addwidgetbar);
			$.getJSON('/widget/listgroup/'+group, function(data) {
				$.each(data, function(key, val) {
					var key = key;
					$('<li><a href="#'+key+'" class="add-widget-item"><img src="/img/widget-icons/'+val.icon+'" />'+val.name+'</a></li>')
					.appendTo(addwidgetbar)
					.children('a')
					.click(function(e) {
						e.preventDefault();
						$.get('/widget/create/'+group+'/'+key+'/'+owner, function(data) {
							addWidget($('<div class="widget" id="widget-'+data+'" />').prependTo(widgets));
						});
					});
				});
			});
		}
		
		$(this).find('.widget').each(function() {
			addWidget($(this));
		});
	});
	
	
	
});