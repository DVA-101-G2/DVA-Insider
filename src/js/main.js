
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