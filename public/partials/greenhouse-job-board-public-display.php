<?php

/**
 * Provide a public-facing view for the plugin
 *
 * This file is used to markup the public-facing aspects of the plugin.
 *
 * @link       http://example.com
 * @since      1.1.0
 *
 * @package    Greenhouse_Job_Board
 * @subpackage Greenhouse_Job_Board/public/partials
 */
?>
<!-- This file should primarily consist of HTML with a little bit of PHP. -->
<?php

/*TODO

* Add select field that pulls office location via API and allows user to select default
* Add select field that pulls departments via API and allows user to select default
* Add textarea for custom CSS

*/


//options page fields
function greenhouse_job_board_url_token_render(  ) { 

	$options = get_option( 'greenhouse_job_board_settings' );
	?>
	<input type='text' name='greenhouse_job_board_settings[greenhouse_job_board_url_token]' value='<?php echo $options['greenhouse_job_board_url_token']; ?>'>
	<div class="helper">Find your Greenhouse URL Token when you are logged into Greenhouse <a href="https://app.greenhouse.io/configure/dev_center/config" target="_blank">here</a> <br />
	Configure > Dev Center > Configuring your Job Board &amp; labeled 'Your URL Token'</div>
	<?php

}


function greenhouse_job_board_api_key_render(  ) { 

	$options = get_option( 'greenhouse_job_board_settings' );
	?>
	<input type='text' name='greenhouse_job_board_settings[greenhouse_job_board_api_key]' value='<?php echo $options['greenhouse_job_board_api_key']; ?>'>
	<div class="helper">Find your Greenhouse API Key when you are logged into Greenhouse <a href="https://app.greenhouse.io/configure/dev_center/credentials" target="_blank">here</a> <br />
	Configure > Dev Center > API Credentials &amp; labeled 'Job Board API'</div>
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
