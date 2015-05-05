<?php

/**
 * Provide a public-facing view for the plugin
 *
 * This file is used to markup the public-facing aspects of the plugin.
 *
 * @link       http://example.com
 * @since      1.6.0
 *
 * @package    Greenhouse_Job_Board
 * @subpackage Greenhouse_Job_Board/public/partials
 */

/** This file should primarily consist of HTML with a little bit of PHP. */


/*TODO

* Add select field that pulls office location via API and allows user to select default
* Add select field that pulls departments via API and allows user to select default
* Add textarea for custom CSS

*/


//options page fields
function greenhouse_job_board_url_token_render(  ) { 

	$options = get_option( 'greenhouse_job_board_settings' );
	?>
	<input type='text' name='greenhouse_job_board_settings[greenhouse_job_board_url_token]' value='<?php 
	if ( isset( $options['greenhouse_job_board_url_token'] ) ) {
		echo $options['greenhouse_job_board_url_token']; 
	} ?>'>
	<div class="helper">Find your Greenhouse URL Token when you are logged into Greenhouse <a href="https://app.greenhouse.io/configure/dev_center/config" target="_blank">here</a> <br />
	Configure > Dev Center > Configuring your Job Board &amp; labeled 'Your URL Token'</div>
	<?php

}


function greenhouse_job_board_api_key_render(  ) { 

	$options = get_option( 'greenhouse_job_board_settings' );
	?>
	<input type='text' name='greenhouse_job_board_settings[greenhouse_job_board_api_key]' value='<?php 
	if ( isset( $options['greenhouse_job_board_api_key'] ) ) {
		echo $options['greenhouse_job_board_api_key']; 
	} ?>'>
	<div class="helper">Find your Greenhouse API Key when you are logged into Greenhouse <a href="https://app.greenhouse.io/configure/dev_center/credentials" target="_blank">here</a> <br />
	Configure > Dev Center > API Credentials &amp; labeled 'Job Board API'</div>
	<?php

}


function greenhouse_job_board_apply_now_render(  ) { 

	$options = get_option( 'greenhouse_job_board_settings' );
	?>
	<input type='text' name='greenhouse_job_board_settings[greenhouse_job_board_apply_now]' value='<?php 
	if ( !isset( $options['greenhouse_job_board_apply_now'] ) ) { // Nothing yet saved
		echo 'Apply Now'; 
	}
	else {
		echo $options['greenhouse_job_board_apply_now']; 
	}
	?>'>
	<div class="helper">Set the text for your `Apply Now` button.</div>
	<?php

}


function greenhouse_job_board_apply_now_cancel_render(  ) { 

	$options = get_option( 'greenhouse_job_board_settings' );
	?>
	<input type='text' name='greenhouse_job_board_settings[greenhouse_job_board_apply_now_cancel]' value='<?php 
	if ( !isset( $options['greenhouse_job_board_apply_now_cancel']) ) { // Nothing yet saved
		echo 'Cancel'; 
	}
	else {
		echo $options['greenhouse_job_board_apply_now_cancel']; 
	}
	?>'>
	<div class="helper">Set the text for your `Cancel` button.</div>
	<?php

}


function greenhouse_job_board_read_full_desc_render(  ) { 

	$options = get_option( 'greenhouse_job_board_settings' );
	?>
	<input type='text' name='greenhouse_job_board_settings[greenhouse_job_board_read_full_desc]' value='<?php 
	if ( !isset( $options['greenhouse_job_board_read_full_desc'] ) ) { // Nothing yet saved
		echo 'Read Full Description'; 
	}
	else {
		echo $options['greenhouse_job_board_read_full_desc']; 
	}
	?>'>
	<div class="helper">Set the text for your `Read Full Description` button.</div>
	<?php

}


function greenhouse_job_board_hide_full_desc_render(  ) { 

	$options = get_option( 'greenhouse_job_board_settings' );
	?>
	<input type='text' name='greenhouse_job_board_settings[greenhouse_job_board_hide_full_desc]' value='<?php 
	if ( !isset( $options['greenhouse_job_board_hide_full_desc'] ) ) { // Nothing yet saved
		echo 'Hide Full Description'; 
	}
	else {
		echo $options['greenhouse_job_board_hide_full_desc']; 
	}
	?>'>
	<div class="helper">Set the text for your `Hide Full Description` button.</div>
	<?php

}


function greenhouse_job_board_location_label_render(  ) { 

	$options = get_option( 'greenhouse_job_board_settings' );
	?>
	<input type='text' name='greenhouse_job_board_settings[greenhouse_job_board_location_label]' value='<?php 
	if ( !isset( $options['greenhouse_job_board_location_label'] ) ) { // Nothing yet saved
		echo 'Location: '; 
	}
	else {
		echo $options['greenhouse_job_board_location_label']; 
	}
	?>'>
	<div class="helper">Set the text for your location label. Note, this is only displayed when the display location option is active.</div>
	<?php

}

function greenhouse_job_board_office_label_render(  ) { 

	$options = get_option( 'greenhouse_job_board_settings' );
	?>
	<input type='text' name='greenhouse_job_board_settings[greenhouse_job_board_office_label]' value='<?php 
	if ( !isset( $options['greenhouse_job_board_office_label'] ) ) { // Nothing yet saved
		echo 'Office: '; 
	}
	else {
		echo $options['greenhouse_job_board_office_label']; 
	}
	?>'>
	<div class="helper">Set the text for your office label. Note, this is only displayed when the display office option is active.</div>
	<?php

}

function greenhouse_job_board_department_label_render(  ) { 

	$options = get_option( 'greenhouse_job_board_settings' );
	?>
	<input type='text' name='greenhouse_job_board_settings[greenhouse_job_board_department_label]' value='<?php 
	if ( !isset( $options['greenhouse_job_board_department_label'] ) ) { // Nothing yet saved
		echo 'Department: '; 
	}
	else {
		echo $options['greenhouse_job_board_department_label']; 
	}
	?>'>
	<div class="helper">Set the text for your department label. Note, this is only displayed when the display department option is active.</div>
	<?php

}

function greenhouse_job_board_description_label_render(  ) { 

	$options = get_option( 'greenhouse_job_board_settings' );
	?>
	<input type='text' name='greenhouse_job_board_settings[greenhouse_job_board_description_label]' value='<?php 
	if ( !isset( $options['greenhouse_job_board_description_label'] ) ) { // Nothing yet saved
		echo ''; 
	}
	else {
		echo $options['greenhouse_job_board_description_label']; 
	}
	?>'>
	<div class="helper">Set the text for your description label. Note, this is only displayed when the display description option is active. Default is blank.</div>
	<?php

}


function greenhouse_job_board_settings_section_callback(  ) { 

	echo __( 'Update with settings from your Greenhouse account. These will be the defaults across the entire website. You can still use the shortcode attributes to override these defaults if you wish.', 'greenhouse_job_board' );

}

function greenhouse_job_board_options_page(  ) { 

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

}
