// Avoid `console` errors in browsers that lack a console.
if (!(window.console && console.log)) {
    (function() {
        var noop = function() {};
        var methods = ['assert', 'clear', 'count', 'debug', 'dir', 'dirxml', 'error', 'exception', 'group', 'groupCollapsed', 'groupEnd', 'info', 'log', 'markTimeline', 'profile', 'profileEnd', 'markTimeline', 'table', 'time', 'timeEnd', 'timeStamp', 'trace', 'warn'];
        var length = methods.length;
        var console = window.console = {};
        while (length--) {
            console[methods[length]] = noop;
        }
    }());
}

// Place any jQuery/helper plugins in here.
(function( $ ) {
  $.fn.loadingButton = function() {
	img = $('<img src="/img/loading.gif" />');
	di = this.height();
	o = new Object();
	o.left = di;
	o.top = -2;
	img.height(di).css('margin-left', '4px').css('position', 'relative').css('margin', (di*-1/2)+'px').offset(o);
	this.append(img).addClass('hovered').attr("disabled", true);
  };
})( jQuery );