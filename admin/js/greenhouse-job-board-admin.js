(function( $ ) {
	'use strict';

	/**
	 * All of the code for your admin-specific JavaScript source
	 * should reside in this file.
	 *
	 * Note that this assume you're going to use jQuery, so it prepares
	 * the $ function reference to be used within the scope of this
	 * function.
	 *
	 * From here, you're able to define handlers for when the DOM is
	 * ready:
	 *
	 * $(function() {
	 *
	 * });
	 *
	 * Or when the window is loaded:
	 *
	 * $( window ).load(function() {
	 *
	 * });
	 *
	 * ...and so on.
	 *
	 * Remember that ideally, we should not attach any more than a single DOM-ready or window-load handler
	 * for any particular page. Though other scripts in WordPress core, other plugins, and other themes may
	 * be doing this, we should try to minimize doing that in our own work.
	 */
	$( window ).load(function() {
				
		$('.wp-admin').on('click', '.insert-greenhouse-shortcode-button', function(e){
			e.preventDefault();
			
			var shortcode = '[greenhouse';
			
			//url token
			var url_token = $('#url_token').val();
			if (url_token) {
				shortcode += ' url_token="' + url_token + '"';
			}
			
			//department filter
			var department_filter = $('#department_filter').val();
			if (department_filter) {
				shortcode += ' department_filter="' + department_filter + '"';
			}
			
			shortcode += ']';
						
			window.send_to_editor(shortcode);
			
		});
		
		$('.include_url_token').on('click', function(e){
			$('.section_url_token').toggle();
		});
		$('.include_filter').on('click', function(e){
			$('.section_filter').toggle();
		});
		$('.include_department_filter').on('click', function(e){
			$('.section_department_filter').toggle();
		});
    });

})( jQuery );
