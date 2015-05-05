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
			//API key
			var api_key = $('#api_key').val();
			if (api_key) {
				shortcode += ' api_key="' + api_key + '"';
			}
			
			//text strings
			var apply_now = $('#apply_now').val();
			if (apply_now) {
				shortcode += ' apply_now="' + apply_now + '"';
			}
			var apply_now_cancel = $('#apply_now_cancel').val();
			if (apply_now_cancel) {
				shortcode += ' apply_now_cancel="' + apply_now_cancel + '"';
			}
			var read_full_desc = $('#read_full_desc').val();
			if (read_full_desc) {
				shortcode += ' read_full_desc="' + read_full_desc + '"';
			}
			var hide_full_desc = $('#hide_full_desc').val();
			if (hide_full_desc) {
				shortcode += ' hide_full_desc="' + hide_full_desc + '"';
			}
			var location_label = $('#location_label').val();
			if (location_label) {
				shortcode += ' location_label="' + location_label + '"';
			}
			var office_label = $('#office_label').val();
			if (office_label) {
				shortcode += ' office_label="' + office_label + '"';
			}
			var department_label = $('#department_label').val();
			if (department_label) {
				shortcode += ' department_label="' + department_label + '"';
			}
			
			//hide_forms
			if ( $('#hide_forms:checked').length == 0 ) {
				shortcode += ' hide_forms="true"';
			}
			
			//meta data display
			var display_meta = '';
						
			if ( $('#display_custom_meta:checked').length > 0 ) {
				
				console.log($('#display_custom_meta:checked').length + ' ' + $('#display_description:checked').length + ' ' + $('#display_location:checked').length + ' ' + $('#display_office:checked').length + ' ' + $('#display_department:checked').length);

				if ( $('#display_description:checked').length > 0 ) {
					display_meta += 'description';
				}
				if ( $('#display_location:checked').length > 0 ) {
					display_meta += '|location';
				}
				if ( $('#display_office:checked').length > 0 ) {
					display_meta += '|office';
				}
				if ( $('#display_department:checked').length > 0 ) {
					display_meta += '|department';
				}
				
				if ( display_meta != '' ) {
					shortcode += ' display="' + display_meta + '"';
				}
			}
				// shortcode += ' display="' + display_meta + '"';
			
			//department filter
			var department_filter = $('#department_filter').val();
			if (department_filter) {
				shortcode += ' department_filter="' + department_filter + '"';
			}
			
			//job filter
			var job_filter = $('#job_filter').val();
			if (job_filter) {
				shortcode += ' job_filter="' + job_filter + '"';
			}
			
			//office filter
			var office_filter = $('#office_filter').val();
			if (office_filter) {
				shortcode += ' office_filter="' + office_filter + '"';
			}
			
			//location filter
			var location_filter = $('#location_filter').val();
			if (location_filter) {
				shortcode += ' location_filter="' + location_filter + '"';
			}
			
			shortcode += ']';
						
			window.send_to_editor(shortcode);
			
		});
		
		$('.include').on('click', function(e){
			$('.section_' + $(this).data('include') ).toggle();
		});
		
    });

})( jQuery );
