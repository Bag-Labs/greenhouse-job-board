/**
 * Javascript file
 *
 * @since      1.1.0
 *
 * @package    Greenhouse_Job_Board
 * @subpackage Greenhouse_Job_Board/admin/js
 */

(function( $ ) {
	'use strict';

	$( window ).load(function() {

		$( '.wp-admin' ).on( 'click', '.insert-greenhouse-shortcode-button', function( e ){
			e.preventDefault();
			var shortcode,
				url_token,
				api_key,
				apply_now,
				apply_now_cancel,
				read_full_desc,
				hide_full_desc,
				location_label,
				office_label,
				department_label,
				description_label,
				display_meta,
				department_filter,
				location_filter,
				office_filter,
				job_filter,
				form_type,
				form_fields,
				sort_order,
				sort_orderby,
				sticky_position,
				sticky_id,
				grouping,
				group_headline;
			var scope = '#TB_window ';
			
			
			shortcode = '[greenhouse';
			
			//url token
			url_token = $( scope + '#url_token' ).val();
			if ( url_token ) {
				shortcode += ' url_token="' + url_token + '"';
			}
			//API key
			api_key = $( scope + '#api_key' ).val();
			if ( api_key ) {
				shortcode += ' api_key="' + api_key + '"';
			}
			
			//text strings
			apply_now = $( scope + '#apply_now').val();
			if ( apply_now ) {
				shortcode += ' apply_now="' + apply_now + '"';
			}
			apply_now_cancel = $( scope + '#apply_now_cancel' ).val();
			if ( apply_now_cancel ) {
				shortcode += ' apply_now_cancel="' + apply_now_cancel + '"';
			}
			read_full_desc = $( scope + '#read_full_desc').val();
			if ( read_full_desc ) {
				shortcode += ' read_full_desc="' + read_full_desc + '"';
			}
			hide_full_desc = $( scope + '#hide_full_desc').val();
			if ( hide_full_desc ) {
				shortcode += ' hide_full_desc="' + hide_full_desc + '"';
			}
			location_label = $( scope + '#location_label').val();
			if ( location_label ) {
				shortcode += ' location_label="' + location_label + '"';
			}
			office_label = $( scope + '#office_label').val();
			if ( office_label ) {
				shortcode += ' office_label="' + office_label + '"';
			}
			department_label = $( scope + '#department_label').val();
			if ( department_label ) {
				shortcode += ' department_label="' + department_label + '"';
			}
			description_label = $( scope + '#description_label').val();
			if ( description_label ) {
				shortcode += ' description_label="' + description_label + '"';
			}
			
			//hide_forms
			if ( $( scope + '#hide_forms:checked' ).length == 0 ) {
				shortcode += ' hide_forms="true"';
			}
			
			form_type = $( scope + '#form_type option:selected' ).val();
			console.log( form_type );
			if ( form_type === 'default' ){
				form_type = false;
			}
			else if ( form_type ) {
				shortcode += ' form_type="' + form_type + '"';
			}
			form_fields = $( scope + '#form_fields' ).val();
			if ( form_fields ) {
				shortcode += ' form_fields="' + form_fields + '"';
			}
			
			//meta data display
			display_meta = '';
						
			if ( $( scope + '#display_custom_meta:checked').length > 0 ) {
				
				if ( $( scope + '#display_description:checked').length > 0 ) {
					display_meta += 'description';
				}
				if ( $( scope + '#display_location:checked').length > 0 ) {
					display_meta += '|location';
				}
				if ( $( scope + '#display_office:checked').length > 0 ) {
					display_meta += '|office';
				}
				if ( $( scope + '#display_department:checked').length > 0 ) {
					display_meta += '|department';
				}
				
				if ( display_meta != '' ) {
					shortcode += ' display="' + display_meta + '"';
				}
			}
				// shortcode += ' display="' + display_meta + '"';
			
			//department filter
			department_filter = $( scope + '#department_filter' ).val();
			if ( department_filter ) {
				shortcode += ' department_filter="' + department_filter + '"';
			}
			
			//job filter
			job_filter = $( scope + '#job_filter' ).val();
			if ( job_filter ) {
				shortcode += ' job_filter="' + job_filter + '"';
			}
			
			//office filter
			office_filter = $( scope + '#office_filter' ).val();
			if ( office_filter ) {
				shortcode += ' office_filter="' + office_filter + '"';
			}
			
			//location filter
			location_filter = $( scope + '#location_filter' ).val();
			if ( location_filter ) {
				shortcode += ' location_filter="' + location_filter + '"';
			}
			
			//sort order
			if ( $( scope + '#custom_order:checked' ).length > 0 ) {
				sort_orderby = $( scope + '#board_orderby option:selected' ).val();
				shortcode += ' orderby="' + sort_orderby + '"';
				
				sort_order = $( scope + '#board_order option:selected' ).val();
				if ( sort_order === 'ASC' ) {
					shortcode += ' order="ASC"';	
				}
								
			}
			if ( $( scope + '#include_sticky:checked' ).length > 0 ) {
				sticky_position = $( scope + '#sticky_position option:selected' ).val();
				sticky_id = $( scope + '#sticky_id' ).val();
				if ( sticky_id ) {
					shortcode += ' sticky="' + sticky_position + '|' + sticky_id + '"';
				}
			}
			//group
			if ( $( scope + '#custom_group:checked' ).length > 0 ) {
				grouping = $( scope + '#grouping option:selected' ).val();
				shortcode += ' group="' + grouping + '"';
				
				group_headline = $( scope + '#group_headline option:selected' ).val();
				if ( group_headline === 'false' ) {
					shortcode += ' group_headline="false"';	
				}
								
			}
			
			shortcode += ']';
						
			window.send_to_editor( shortcode );
			
		});
		
		$('.include').on( 'click', function( e ){
			$( '.section_' + $(this).data('include') ).toggle();
		});
		
		$('#form_type').on( 'change blur mouseup', function( e ){
			
			if ( $(this).parents('.section').is(":visible") ) {
				console.log('hide forms checked');
				
				if ( $(this).find(':selected').val() === 'inline' ) {
					$('.section_form_fields').show();
				}
				else if (	$(this).find(':selected').val() === 'default' ||
							$(this).find(':selected').val() === 'iframe'
						){
					$('.section_form_fields').hide();
				}
			}
		});


		// greenhouse settings page
		if ( $('body').hasClass('settings_page_greenhouse_job_board') ) {

			// toggle visibility for job board type option
			$('#greenhouse_job_board_type').on('change', function(e){
				//only show template when custom board type is selected.
				if ( 'custom-accordion' === this.value ){
					$('#greenhouse_job_board_template').parents('tr').show();
				} else {
					$('#greenhouse_job_board_template').parents('tr').hide();
				}
				//only show cycle fx when cycle board type is selected.
				if ( 'cycle' === this.value ){
					$('#greenhouse_job_cycle_fx').parents('tr').show();
				} else {
					$('#greenhouse_job_cycle_fx').parents('tr').hide();
				}
			});

			// reset defaults for templates
			$('a[data-reset]').on('click', function(e){
				e.preventDefault();
				$('#greenhouse_job_board_template').val( $('#job-template-accordion').html() );
			});
		}


	});
	

})( jQuery );
