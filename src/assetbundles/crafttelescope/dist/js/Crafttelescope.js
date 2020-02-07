/**
 * Craft Telescope plugin for Craft CMS
 *
 * @author    Simon Davies
 * @copyright Copyright (c) 2019 Simon Davies
 * @link      https://simon-davies.name/
 * @package   Crafttelescope
 * @since     0.0.1
 */

jQuery(document).ready(function($){

	function popupwindow(url, title, win, w, h) {
		var y = win.top.outerHeight / 2 + win.top.screenY - ( h / 2)
		var x = win.top.outerWidth / 2 + win.top.screenX - ( w / 2)
		return win.open(url, title, 'toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=no, resizable=no, copyhistory=no, width='+w+', height='+h+', top='+y+', left='+x);
	}

	jQuery('#settings-telescope-connect').click(function(e){
		e.preventDefault();
		var data = {
			title: $(this).data('title'),
			url: $(this).data('url'),
			lang: $(this).data('lang'),
			api_key: $(this).data('api-key'),
		};
		popupwindow('https://craft-telescope.io/sites/new?' + $.param(data), 'Craft Telescope', window, 600,600);
	});

});
