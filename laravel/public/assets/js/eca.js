function getCookie(cname) {
	var name = cname + "=";
	var ca = document.cookie.split(';');
	for(var i=0; i<ca.length; i++) {
		var c = ca[i];
		while (c.charAt(0)==' ') c = c.substring(1);
		if (c.indexOf(name) == 0) return c.substring(name.length,c.length);
	}
	return "";
}

(function($){

	$(document).ready(function() {

		var $menuToggle  = $('.right.menu.open > .toggle');
		$menuToggle.on('click', function() {
			$(this).toggleClass('open');
			$(this).find('.icon').toggleClass('sidebar remove');
			$('.ui.vertical.navbar.menu').toggleClass('hidden');
		});

		$('.ui.vertical.navbar.menu .item').on('click', function() {
			$menuToggle.trigger('click');
		});

		$('.circular.icon.button').on('click', function() {
			$(this).parents('.segment').dimmer('hide');
		});

		$('.bottom.buttons > .button').on('click', function() {
			$(this).parents('.segment').dimmer('show');
		});

		$('.ui.dropdown').dropdown();
	});

})(jQuery)
