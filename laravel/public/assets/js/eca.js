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

		$('body').observe('added', '.ui.dropdown', function() {
			$('.ui.dropdown').dropdown();
		});

		// Custom file input

		$('body').observe('added', '.btn-file', function() {
			var fileExtentionRange = '.pdf';
			var MAX_SIZE = 30; // MB

			$(document).on('change', '.btn-file :file', function() {
			    var input = $(this);

			    if (navigator.appVersion.indexOf("MSIE") != -1) { // IE
			        var label = input.val();

			        input.trigger('fileselect', [ 1, label, 0 ]);
			    } else {
			        var label = input.val().replace(/\\/g, '/').replace(/.*\//, '');
			        var numFiles = input.get(0).files ? input.get(0).files.length : 1;
			        var size = input.get(0).files[0].size;

			        input.trigger('fileselect', [ numFiles, label, size ]);
			    }
			});

			$('.btn-file :file').on('fileselect', function(event, numFiles, label, size) {
			    $('#attachmentName').attr('name', 'attachmentName'); // allow upload.

			    var postfix = label.substr(label.lastIndexOf('.'));
			    if (fileExtentionRange.indexOf(postfix.toLowerCase()) > -1) {
			        if (size > 1024 * 1024 * MAX_SIZE ) {
			            alert('Max size for file is ' + MAX_SIZE);

			            $('#attachmentName').removeAttr('name'); // cancel upload file.
			        } else {
			            $('#_attachmentName').val(label);
			        }
			    } else {
			        alert('File type must be ' + fileExtentionRange);

			        $('#attachmentName').removeAttr('name'); // cancel upload file.
			    }
			});
		});

	});

})(jQuery)
