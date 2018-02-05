<?php
/**
 * Provide a public-facing view for the plugin
 *
 * This file is used to markup the public-facing aspects of the plugin.
 *
 * @since      2.7.0
 *
 * @package    Greenhouse_Job_Board
 * @subpackage Greenhouse_Job_Board/public/partials
 */

/*
* TODO
* Add select field that pulls office location via API and allows user to select default
* Add select field that pulls departments via API and allows user to select default
*/

/**
 *  Options page fields.
 */
function greenhouse_job_board_url_token_render() {

	$options = get_option( 'greenhouse_job_board_settings' );
	if ( isset( $options['greenhouse_job_board_url_token'] ) ) {
		$ghjb_option_value = $options['greenhouse_job_board_url_token'];
	}
	?>
	<input type='text' name='greenhouse_job_board_settings[greenhouse_job_board_url_token]' value='<?php echo esc_attr( $ghjb_option_value ); ?>' class="regular-text">
	<div class="helper">Find your Greenhouse URL Token when you are logged into Greenhouse <a href="https://app.greenhouse.io/configure/dev_center/config" target="_blank">here</a> <br />
	Configure > Dev Center > Configuring your Job Board &amp; labeled 'Your URL Token'. If you have multple job boards within greenhouse, ensure you have properly selected the url token to the job board you wish to display.</div>
	<?php

}

/**
 *  Options page field to render api field.
 */
function greenhouse_job_board_api_key_render() {

	$options = get_option( 'greenhouse_job_board_settings' );
	if ( isset( $options['greenhouse_job_board_api_key'] ) ) {
		$ghjb_option_value = $options['greenhouse_job_board_api_key'];
	}
	?>
	<input type='text' name='greenhouse_job_board_settings[greenhouse_job_board_api_key]' value='<?php echo esc_attr( $ghjb_option_value ); ?>' class="regular-text">
	<div class="helper">Find your Greenhouse API Key when you are logged into Greenhouse <a href="https://app.greenhouse.io/configure/dev_center/credentials" target="_blank">here</a> <br />
	Configure > Dev Center > API Credentials &amp; labeled 'Job Board API'</div>
	<?php

}


/**
 *  Options page field to render job board type.
 */
function greenhouse_job_board_type_render() {

	$options = get_option( 'greenhouse_job_board_settings' );

	if ( isset( $options['greenhouse_job_board_type'] ) ) {
		$ghjb_option_value = $options['greenhouse_job_board_type'];
	} else {
		$ghjb_option_value = 'accordion';
	}

	$ghjb_option_values = array(
		'Accordion' => 'accordion',
		'Cycle'     => 'cycle',
	);

	?>
	<select
		name='greenhouse_job_board_settings[greenhouse_job_board_type]'
		class='regular-text'
	>
	<?php foreach ( $ghjb_option_values as $key => $value ) { ?>
		<option value="<?php echo esc_attr( $value ); ?>"
		<?php
		if ( $value === $ghjb_option_value ) {
			echo 'selected';
		}
		?>
		><?php echo esc_attr( $key ); ?></option>
	<?php } ?>
	</select>
	<div class="helper">Select the type of job board you would like to display on your site by default.</div>
	<?php

}


/**
 *  Options page field for cycle fx.
 */
function greenhouse_job_board_cycle_fx_render() {

	$options = get_option( 'greenhouse_job_board_settings' );

	if ( isset( $options['greenhouse_job_cycle_fx'] ) ) {
		$ghjb_option_value = $options['greenhouse_job_cycle_fx'];
	} else {
		$ghjb_option_value = 'fade';
	}

	$ghjb_option_values = array(
		'Fade'                => 'fade',
		'Fade Out'            => 'fadeout',
		'Scroll Horizontally' => 'scrollHorz',
		'none'                => 'none',
	);
	?>
	<select
		name='greenhouse_job_board_settings[greenhouse_job_cycle_fx]'
		class='regular-text'
	>
	<?php foreach ( $ghjb_option_values as $key => $value ) { ?>
		<option value="<?php echo esc_attr( $value ); ?>"
		<?php
		if ( $value === $ghjb_option_value ) {
			echo 'selected';
		}
		?>
		><?php echo esc_attr( $key ); ?></option>
	<?php } ?>
	</select>
	<div class="helper">Select the transition type for the job board when the type is set to cycle (above). This will be ignored with the accordion job board.</div>

	<?php
}

/**
 *  Options page field for interactive filter.
 */
function greenhouse_job_board_interactive_filter_render() {

	$options = get_option( 'greenhouse_job_board_settings' );

	if ( isset( $options['greenhouse_job_interactive_filter'] ) ) {
		$ghjb_option_value = $options['greenhouse_job_interactive_filter'];
	} else {
		$ghjb_option_value = 'none';
	}

	$ghjb_option_values = array(
		'No Interactive Filter'         => 'none',
		'Location Filter'               => 'location',
		'Department Filter'             => 'department',
		'Location & Department Filters' => 'location and department',
	);
	?>
	<select
		name='greenhouse_job_board_settings[greenhouse_job_interactive_filter]'
		class='regular-text'
	>
	<?php foreach ( $ghjb_option_values as $key => $value ) { ?>
		<option value="<?php echo esc_attr( $value ); ?>"
		<?php
		if ( $value === $ghjb_option_value ) {
			echo 'selected';
		}
		?>
		><?php echo esc_attr( $key ); ?></option>
	<?php } ?>
	</select>
	<div class="helper">Select options to display an interactive dropdown filter as part of the job board? and what filtering should be active.</div>

	<?php
}

/**
 *  Options page field for debug field.
 */
function greenhouse_job_board_debug_render() {

	$options = get_option( 'greenhouse_job_board_settings' );

	if ( isset( $options['greenhouse_job_board_debug'] ) ) {
		$ghjb_option_value = $options['greenhouse_job_board_debug'];
	} else {
		$ghjb_option_value = 'false';
	}

	$ghjb_option_values = array(
		'Debug On'  => 'true',
		'Debug Off' => 'false',
	);

	?>
	<select
		name='greenhouse_job_board_settings[greenhouse_job_board_debug]'
		class='regular-text'
	>
	<?php foreach ( $ghjb_option_values as $key => $value ) { ?>
		<option value="<?php echo esc_attr( $value ); ?>"
		<?php
		if ( $value === $ghjb_option_value ) {
			echo 'selected';
		}
		?>
		><?php echo esc_attr( $key ); ?></option>
	<?php } ?>
	</select>
	<div class="helper">Debug mode will turn on extra messages and logging, not recommended for production environments.</div>
	<?php

}

/**
 *  Options page field to render tracking option.
 */
function greenhouse_job_board_allow_track() {

	$options = get_option( 'greenhouse_job_board_settings' );

	if ( isset( $options['greenhouse_job_allow_track'] ) ) {
		$ghjb_option_value = $options['greenhouse_job_allow_track'];
	} else {
		$ghjb_option_value = 'false';
	}

	if ( 'true' === $ghjb_option_value ) {
		// set up plugin object to get version.
		$plugin = new Greenhouse_Job_Board();
		// add tracking to page.
		?>
		<!-- Global site tag (gtag.js) - Google Analytics -->
		<script async src="https://www.googletagmanager.com/gtag/js?id=UA-61962313-2"></script>
		<script>
		window.dataLayer = window.dataLayer || [];
		function gtag(){dataLayer.push(arguments);}
		gtag('js', new Date());
		gtag('config', 'UA-61962313-2');
		// send tracking call with dimensions.
		gtag('event', 'id', {
			'event_category': 'domain',
			'event_label': '<?php echo esc_attr( $_SERVER['SERVER_NAME'] ); ?>'
		});
		gtag('event', 'metric', {
			'event_category': 'phpversion',
			'event_label': '<?php echo esc_attr( phpversion() ); ?>'
		});
		gtag('event', 'metric', {
			'event_category': 'wpversion',
			'event_label': '<?php echo esc_attr( get_bloginfo( 'version' ) ); ?>'
		});
		gtag('event', 'metric', {
			'event_category': 'curlversion', 
			'event_label': '<?php echo esc_attr( curl_version()['version'] ); ?>'
		});
		gtag('event', 'metric', {
			'event_category': 'pluginversion', 
			'event_label': '<?php echo esc_attr( $plugin->get_version() ); ?>'
		});
		gtag('event', 'feature', {
			'event_category': 'boardtype', 
			'event_label': '<?php echo esc_attr( $options['greenhouse_job_board_type'] ); ?>'
		});
		gtag('event', 'feature', {
			'event_category': 'formtype', 
			'event_label': '<?php echo esc_attr( $options['greenhouse_job_board_form_type'] ); ?>'
		});
		</script>
		<?php
	}

	$ghjb_option_values = array(
		'Allow Tracking' => 'true',
		'No Tracking'    => 'false',
	);

	?>
	<select
		name='greenhouse_job_board_settings[greenhouse_job_allow_track]'
		class='regular-text'
	>
	<?php foreach ( $ghjb_option_values as $key => $value ) { ?>
		<option value="<?php echo esc_attr( $value ); ?>"
		<?php
		if ( $value === $ghjb_option_value ) {
			echo 'selected';
		}
		?>
		><?php echo esc_attr( $key ); ?></option>
	<?php } ?>
	</select>
	<div class="helper">Allow this plugin to track usage via anonymous data to improve the plugin usability, functionality and performance.</div>
	<?php

}

/**
 *  Options page field to log errors.
 */
function greenhouse_job_board_log_errors_render() {

	$options = get_option( 'greenhouse_job_board_settings' );

	if ( isset( $options['greenhouse_job_log_errors'] ) ) {
		$ghjb_option_value = $options['greenhouse_job_log_errors'];
	} else {
		$ghjb_option_value = 'false';
	}

	$ghjb_option_values = array(
		'Log Errors' => 'true',
		'No Logging' => 'false',
	);

	?>
	<select
		name='greenhouse_job_board_settings[greenhouse_job_log_errors]'
		class='regular-text'
	>
	<?php foreach ( $ghjb_option_values as $key => $value ) { ?>
		<option value="<?php echo esc_attr( $value ); ?>"
		<?php
		if ( $value === $ghjb_option_value ) {
			echo 'selected';
		}
		?>
		><?php echo esc_attr( $key ); ?></option>
	<?php } ?>
	</select>
	<div class="helper">Allow this plugin to log errors to a log file. It can come in handy when debugging.</div>
	<?php

}

/**
 *  Options page field to activate google analytics.
 */
function greenhouse_job_board_analytics_render() {

	$options = get_option( 'greenhouse_job_board_settings' );

	if ( isset( $options['greenhouse_job_board_analytics'] ) ) {
		$ghjb_option_value = $options['greenhouse_job_board_analytics'];
	} else {
		$ghjb_option_value = 'false';
	}

	$ghjb_option_values = array(
		'Add Analytics' => 'true',
		'No Analytics'  => 'false',
	);
	?>
	<select
		name='greenhouse_job_board_settings[greenhouse_job_board_analytics]'
		class='regular-text'
	>
	<?php foreach ( $ghjb_option_values as $key => $value ) { ?>
		<option value="<?php echo esc_attr( $value ); ?>"
		<?php
		if ( $value === $ghjb_option_value ) {
			echo 'selected';
		}
		?>
		><?php echo esc_attr( $key ); ?></option>
	<?php } ?>
	</select>
	<div class="helper">Track job views as page views in your google analytics. This assumes you have google analytics tracking code already installed on your site. It will only track user navigation in the job board.</div>
	<?php

}

/**
 *  Options page field to render form type.
 */
function greenhouse_job_board_form_type_render() {

	$options = get_option( 'greenhouse_job_board_settings' );

	// ensure that the API key is in place before allowing inline option.
	$allow_inline = false;
	if ( isset( $options['greenhouse_job_board_api_key'] ) &&
		'' !== $options['greenhouse_job_board_api_key'] ) {
		$allow_inline = true;
	}

	if ( isset( $options['greenhouse_job_board_form_type'] ) && $allow_inline ) {
		$ghjb_option_value = $options['greenhouse_job_board_form_type'];
	} else {
		$ghjb_option_value = 'iframe';
	}

	$ghjb_option_values = array(
		'IFrame' => 'iframe',
		'Inline' => 'inline',
	);
	?>
	<select
		name='greenhouse_job_board_settings[greenhouse_job_board_form_type]'
		class='regular-text'
	>
	<?php foreach ( $ghjb_option_values as $key => $value ) { ?>
		<option value="<?php echo esc_attr( $value ); ?>"
		<?php
		if ( $value === $ghjb_option_value ) {
			echo 'selected';
		}
		?>
		<?php
		if ( 'inline' === $value && false === $allow_inline ) {
			echo 'disabled';
		}
		?>
		>
		<?php
		echo esc_attr( $key );
		if ( 'inline' === $value && false === $allow_inline ) {
			echo ' (requires API key)';
		}
		?>
		</option>
	<?php } ?>
	</select>
	<div class="helper">Select the type of forms you would like to display on your site by default.</div>
	<?php

}

/**
 *  Options page field to set form fields to render.
 */
function greenhouse_job_board_form_fields_render() {

	$options = get_option( 'greenhouse_job_board_settings' );

	if ( isset( $options['greenhouse_job_board_form_fields'] ) ) {
		$ghjb_option_value = $options['greenhouse_job_board_form_fields'];
	} else {
		$ghjb_option_value = '';
	}

	?>
	<input
		type='text'
		name='greenhouse_job_board_settings[greenhouse_job_board_form_fields]'
		value='<?php echo esc_attr( $ghjb_option_value ); ?>'
		class="regular-text"
	>
	<div class="helper">Select the form fields you would like to display on your apply forms by default, List either the form labels or names from greenhouse. Note that this is only used when using inline forms (and not iframes).</div>
	<?php

}


/**
 *  Options page field for render job board back button.
 */
function greenhouse_job_board_back_render() {

	$options = get_option( 'greenhouse_job_board_settings' );

	if ( isset( $options['greenhouse_job_board_back'] ) ) {
		$ghjb_option_value = $options['greenhouse_job_board_back'];
	} else {
		$ghjb_option_value = 'Back';
	}

	?>
	<input
		type='text'
		name='greenhouse_job_board_settings[greenhouse_job_board_back]'
		value='<?php echo esc_attr( $ghjb_option_value ); ?>'
		class="regular-text"
	>
	<div class="helper">Set the text for your `Back` button.</div>
	<?php

}


/**
 *  Options page field for job board apply now text..
 */
function greenhouse_job_board_apply_now_render() {

	$options = get_option( 'greenhouse_job_board_settings' );

	if ( isset( $options['greenhouse_job_board_apply_now'] ) ) {
		$ghjb_option_value = $options['greenhouse_job_board_apply_now'];
	} else {
		$ghjb_option_value = 'Apply Now';
	}
	?>
	<input
		type='text'
		name='greenhouse_job_board_settings[greenhouse_job_board_apply_now]'
		value='<?php echo esc_attr( $ghjb_option_value ); ?>'
		class="regular-text"
	>
	<div class="helper">Set the text for your `Apply Now` button.</div>
	<?php

}


/**
 *  Options page field for job board cancel button.
 */
function greenhouse_job_board_apply_now_cancel_render() {

	$options = get_option( 'greenhouse_job_board_settings' );

	if ( isset( $options['greenhouse_job_board_apply_now_cancel'] ) ) {
		$ghjb_option_value = $options['greenhouse_job_board_apply_now_cancel'];
	} else {
		$ghjb_option_value = 'Cancel';
	}
	?>
	<input
		type='text'
		name='greenhouse_job_board_settings[greenhouse_job_board_apply_now_cancel]'
		value='<?php echo esc_attr( $ghjb_option_value ); ?>'
		class="regular-text"
	>
	<div class="helper">Set the text for your `Cancel` button.</div>
	<?php

}


/**
 *  Options page field for full description text.
 */
function greenhouse_job_board_read_full_desc_render() {

	$options = get_option( 'greenhouse_job_board_settings' );
	if ( isset( $options['greenhouse_job_board_read_full_desc'] ) ) {
		$ghjb_option_value = $options['greenhouse_job_board_read_full_desc'];
	} else {
		$ghjb_option_value = 'Read Full Description';
	}
	?>
	<input
		type='text'
		name='greenhouse_job_board_settings[greenhouse_job_board_read_full_desc]'
		value='<?php echo esc_attr( $ghjb_option_value ); ?>'
		class="regular-text"
	>
	<div class="helper">Set the text for your `Read Full Description` button.</div>
	<?php

}

/**
 *  Options page field for hide descirption text.
 */
function greenhouse_job_board_hide_full_desc_render() {

	$options = get_option( 'greenhouse_job_board_settings' );
	if ( isset( $options['greenhouse_job_board_hide_full_desc'] ) ) {
		$ghjb_option_value = $options['greenhouse_job_board_hide_full_desc'];
	} else {
		$ghjb_option_value = 'Hide Full Description';
	}
	?>
	<input
		type='text'
		name='greenhouse_job_board_settings[greenhouse_job_board_hide_full_desc]'
		value='<?php echo esc_attr( $ghjb_option_value ); ?>'
		class="regular-text"
	>
	<div class="helper">Set the text for your `Hide Full Description` button.</div>
	<?php

}


/**
 *  Options page field for location label.
 */
function greenhouse_job_board_location_label_render() {

	$options = get_option( 'greenhouse_job_board_settings' );
	if ( isset( $options['greenhouse_job_board_location_label'] ) ) {
		$ghjb_option_value = $options['greenhouse_job_board_location_label'];
	} else {
		$ghjb_option_value = 'Location: ';
	}
	?>
	<input
		type='text'
		name='greenhouse_job_board_settings[greenhouse_job_board_location_label]'
		value='<?php echo esc_attr( $ghjb_option_value ); ?>'
		class="regular-text"
	>
	<div class="helper">Set the text for your location label. Note, this is only displayed when the display location option is active.</div>
	<?php

}

/**
 *  Options page field for office label.
 */
function greenhouse_job_board_office_label_render() {

	$options = get_option( 'greenhouse_job_board_settings' );
	if ( isset( $options['greenhouse_job_board_office_label'] ) ) {
		$ghjb_option_value = $options['greenhouse_job_board_office_label'];
	} else {
		$ghjb_option_value = 'Office: ';
	}
	?>
	<input
		type='text'
		name='greenhouse_job_board_settings[greenhouse_job_board_office_label]'
		value='<?php echo esc_attr( $ghjb_option_value ); ?>'
		class="regular-text"
	>
	<div class="helper">Set the text for your office label. Note, this is only displayed when the display office option is active.</div>
	<?php

}

/**
 *  Options page field for department label.
 */
function greenhouse_job_board_department_label_render() {

	$options = get_option( 'greenhouse_job_board_settings' );
	if ( isset( $options['greenhouse_job_board_department_label'] ) ) {
		$ghjb_option_value = $options['greenhouse_job_board_department_label'];
	} else {
		$ghjb_option_value = 'Department: ';
	}
	?>
	<input
		type='text'
		name='greenhouse_job_board_settings[greenhouse_job_board_department_label]'
		value='<?php echo esc_attr( $ghjb_option_value ); ?>'
		class="regular-text">
	<div class="helper">Set the text for your department label. Note, this is only displayed when the display department option is active.</div>
	<?php

}

/**
 *  Options page field for job description label.
 */
function greenhouse_job_board_description_label_render() {

	$options = get_option( 'greenhouse_job_board_settings' );
	if ( isset( $options['greenhouse_job_board_description_label'] ) ) {
		$ghjb_option_value = $options['greenhouse_job_board_description_label'];
	} else {
		$ghjb_option_value = '';
	}
	?>
	<input
		type='text'
		name='greenhouse_job_board_settings[greenhouse_job_board_description_label]'
		value='<?php echo esc_attr( $ghjb_option_value ); ?>'
		class="regular-text"
	>
	<div class="helper">Set the text for your description label. Note, this is only displayed when the display description option is active. Default is blank.</div>
	<?php

}

/**
 *  Options page field for apply headline.
 */
function greenhouse_job_board_apply_headline_render() {

	$options = get_option( 'greenhouse_job_board_settings' );
	if ( isset( $options['greenhouse_job_board_apply_headline'] ) ) {
		$ghjb_option_value = $options['greenhouse_job_board_apply_headline'];
	} else {
		$ghjb_option_value = 'Apply';
	}
	?>
	<input
		type='text'
		name='greenhouse_job_board_settings[greenhouse_job_board_apply_headline]'
		value='<?php echo esc_attr( $ghjb_option_value ); ?>'
		class="regular-text"
	>
	<div class="helper">Set the headline for your application form. Note, this is only displayed with the inline form type. Default is 'Apply'.</div>
	<?php

}

/**
 *  Options page field for thank you headline.
 */
function greenhouse_job_board_thanks_headline_render() {

	$options = get_option( 'greenhouse_job_board_settings' );
	if ( isset( $options['greenhouse_job_board_thanks_headline'] ) ) {
		$ghjb_option_value = $options['greenhouse_job_board_thanks_headline'];
	} else {
		$ghjb_option_value = 'Thank you for your interest!';
	}
	?>
	<input
		type='text'
		name='greenhouse_job_board_settings[greenhouse_job_board_thanks_headline]'
		value='<?php echo esc_attr( $ghjb_option_value ); ?>'
		class="regular-text"
	>
	<div class="helper">Set the headline for your thank you messaging. Note, this is only displayed with the inline form type after successful application submission. Default is "Thank you for your interest".</div>
	<?php

}

/**
 *  Options page field for thank you body text.
 */
function greenhouse_job_board_thanks_body_render() {

	$options = get_option( 'greenhouse_job_board_settings' );
	if ( isset( $options['greenhouse_job_board_thanks_body'] ) ) {
		$ghjb_option_value = $options['greenhouse_job_board_thanks_body'];
	} else {
		$ghjb_option_value = '';
	}
	?>
	<textarea
		name='greenhouse_job_board_settings[greenhouse_job_board_thanks_body]'
		class="large-text"
	><?php echo esc_attr( $ghjb_option_value ); ?></textarea>
	<div class="helper">Set the text for your thank you messaging. Note, this is only displayed with the inline form type after successful application submission.</div>
	<?php

}

/**
 *  Options page field for error headline.
 */
function greenhouse_job_board_error_headline_render() {

	$options = get_option( 'greenhouse_job_board_settings' );
	if ( isset( $options['greenhouse_job_board_error_headline'] ) ) {
		$ghjb_option_value = $options['greenhouse_job_board_error_headline'];
	} else {
		$ghjb_option_value = 'Uh Oh, Something went wrong.';
	}
	?>
	<input
		type='text'
		name='greenhouse_job_board_settings[greenhouse_job_board_error_headline]'
		value='<?php echo esc_attr( $ghjb_option_value ); ?>'
		class="regular-text"
	>
	<div class="helper">Set the headline for your error messaging. Note, this is only displayed with the inline form type after an unsuccessful application submission.</div>
	<?php

}

/**
 *  Options page field for error body message.
 */
function greenhouse_job_board_error_body_render() {

	$options = get_option( 'greenhouse_job_board_settings' );
	if ( isset( $options['greenhouse_job_board_error_body'] ) ) {
		$ghjb_option_value = $options['greenhouse_job_board_error_body'];
	} else {
		$ghjb_option_value = '';
	}
	?>
	<textarea 
		name='greenhouse_job_board_settings[greenhouse_job_board_error_body]'
		class="large-text"
	><?php echo esc_attr( $ghjb_option_value ); ?></textarea>
	<div class="helper">Set the text for your thank you messaging. Note, this is only displayed with the inline form type after an unsuccessful application submission.</div>
	<?php

}

/**
 *  Options page field for cache expiration.
 */
function greenhouse_job_board_cache_expiry_render() {

	$options = get_option( 'greenhouse_job_board_settings' );

	if ( isset( $options['greenhouse_job_board_cache_expiry'] ) ) {
		$ghjb_option_value = $options['greenhouse_job_board_cache_expiry'];
	} else {
		$ghjb_option_value = '3600';
	}
	// if set to no cache, delete any transient data that is currently cached.
	if ( '1' === $ghjb_option_value ) {
		delete_transient( 'ghjb_json' );
		delete_transient( 'ghjb_jobs' );
	}

	$ghjb_option_values = array(
		'No Cache (not recommended, except for testing)' => '1',
		'1 Hour'                                         => '3600',
		'2 Hours'                                        => '7200',
		'6 Hours'                                        => '21600',
		'12 Hours'                                       => '43200',
		'1 Day (24 Hours)'                               => '86400',
		'2 Days (48 Hours)'                              => '172800',
		'7 Days (168 Hours)'                             => '604800',

	);
	?>

	<select
		name='greenhouse_job_board_settings[greenhouse_job_board_cache_expiry]'
		class='regular-text'
	>
	<?php foreach ( $ghjb_option_values as $key => $value ) { ?>
		<option value="<?php echo esc_attr( $value ); ?>"
		<?php
		if ( $value === $ghjb_option_value ) {
			echo 'selected';
		}
		?>
		><?php echo esc_attr( $key ); ?></option>
	<?php } ?>
	</select>
	<div class="helper">Cache expiration time for the greenhouse API data.</div>
	<?php

}

/**
 *  Options page field for clearing cache.
 */
function greenhouse_job_board_clear_cache_render() {

	$options         = get_option( 'greenhouse_job_board_settings' );
	$display_message = false;

	if ( isset( $options['greenhouse_job_board_clear_cache'] ) &&
		'1' === $options['greenhouse_job_board_clear_cache'] ) {
		delete_transient( 'ghjb_json' );
		delete_transient( 'ghjb_jobs' );
		$display_message = true;
	} else {
		$options['greenhouse_job_board_clear_cache'] = '0';
	}

	?>
	<label class="helper">
		<input
			type='checkbox'
			name='greenhouse_job_board_settings[greenhouse_job_board_clear_cache]'
			value='1'
		>
		To refresh any Greenhouse API data, check this box and then save changes.
	</label>

	<?php
	if ( $display_message ) {
		echo '<div class="updated notice"><p>Cache cleared successfully.</p></div>';
	}

}

/**
 *  Options page field for custom css.
 */
function greenhouse_job_board_custom_css_render() {

	$options = get_option( 'greenhouse_job_board_settings' );
	if ( isset( $options['greenhouse_job_board_custom_css'] ) ) {
		$ghjb_option_value = $options['greenhouse_job_board_custom_css'];
	} else {
		$ghjb_option_value = '';
	}
	?>
	<textarea 
		name='greenhouse_job_board_settings[greenhouse_job_board_custom_css]'
		class="large-text"
		rows="20"
	><?php echo esc_attr( $ghjb_option_value ); ?></textarea>
	<div class="helper">Place any custom CSS here.</div>
	<?php

}

/**
 *  Options page field for inline form template.
 *  Not in use (yet).
 */
function greenhouse_job_board_inline_form_template_render() {

	$options = get_option( 'greenhouse_job_board_settings' );
	if ( isset( $options['greenhouse_job_board_inline_form_template'] ) ) {
		$ghjb_option_value = $options['greenhouse_job_board_inline_form_template'];
	} else {
		$ghjb_option_value = '';
	}
	?>
	<textarea 
		name='greenhouse_job_board_settings[greenhouse_job_board_inline_form_template]' 
		class="large-text"
	><?php echo esc_attr( $ghjb_option_value ); ?></textarea>
	<?php

}


/**
 *  Options page field for greenhouse callback.
 */
function greenhouse_job_board_gh_settings_section_callback() {

	echo 'Configure to your Greenhouse account. These settings will be the defaults across this website. You may use the shortcode attributes to override these defaults if you wish.';

}

/**
 *  Options page field for job board callback.
 */
function greenhouse_job_board_jb_settings_section_callback() {

	echo 'Update with settings for your job board. These will be the defaults across the entire website. You may use the shortcode attributes to override these defaults if you wish.';

}

/**
 *  Options page field for p callback.
 */
function greenhouse_job_board_p_settings_section_callback() {

}

/**
 *  Options page form.
 */
function greenhouse_job_board_options_page() {

	?>
	<form action='options.php' method='post'>

		<h2>Greenhouse Job Board Settings</h2>

		<?php
			settings_fields( 'greenhouse_settings' );
			do_settings_sections( 'greenhouse_settings' );
			submit_button();
		?>

	</form>
	<?php

} ?>
