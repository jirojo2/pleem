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

		$('.ui.dropdown').dropdown();

		$('body').observe('added', '.ui.dropdown', function() {
			$('.ui.dropdown').dropdown();
		});

		$('body').on('click', '#people .menu a.item', function() {
			var target = $(this).attr('data-target');

			$('.ui.people.container').addClass('hidden');
			$(target).removeClass('hidden');

			$(this).addClass('active');
			$(this).siblings().removeClass('active');
		});

	});

})(jQuery)
