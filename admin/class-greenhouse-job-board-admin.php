<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       http://example.com
 * @since      1.0.0
 *
 * @package    Greenhouse_Job_Board
 * @subpackage Greenhouse_Job_Board/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Greenhouse_Job_Board
 * @subpackage Greenhouse_Job_Board/admin
 * @author     Your Name <email@example.com>
 */
class Greenhouse_Job_Board_Admin {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $greenhouse_job_board    The ID of this plugin.
	 */
	private $greenhouse_job_board;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $greenhouse_job_board       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $greenhouse_job_board, $version ) {

		$this->greenhouse_job_board = $greenhouse_job_board;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Greenhouse_Job_Board_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Greenhouse_Job_Board_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->greenhouse_job_board, plugin_dir_url( __FILE__ ) . 'css/greenhouse-job-board-admin.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Greenhouse_Job_Board_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Greenhouse_Job_Board_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->greenhouse_job_board, plugin_dir_url( __FILE__ ) . 'js/greenhouse-job-board-admin.js', array( 'jquery' ), $this->version, false );

	}
	
	
	
	/**
	 * Add the shortcodes media button.
	 *
	 * @since    1.7.0
	 */
	public function greenhouse_add_shortcode_media_button() {
		add_thickbox();
		
		$greenhouse_settings_url = admin_url('options-general.php?page=greenhouse_job_board' );
		echo <<<HTML
		
<a href="#TB_inline?width=600&height=550&inlineId=add-greenhouse-shortcode-form" id="add-greenhouse-shortcode-button" class="button thickbox">Add Greenhouse Job Board</a>
<div id="add-greenhouse-shortcode-form" style="display:none;">
	<div class="greenhouse-wizard media-modal wp-core-ui">
		<div class="media-frame">
			<div class="media-frame-title">
				<h1>Greenhouse Job Board</h1>
				<h2>Shortcode Wizard</h2>
			</div>
			
			<div class="media-frame-content">
				<div class="section">
					<p>Use these settings to customize your short code settings and then insert your shortcode into your content.</p>
				</div>
				
				<!--<div class="section">
					<label>
						<input type="checkbox" class="include" data-include="url_token" />Include URL token to override <a href="$greenhouse_settings_url">plugin settings</a>?
					</label>
					<div class="section section_url_token" style="display:none;">
						<label for="url_token">Url token
							<input id="url_token" type="text" />
						</label>
					</div>
				</div>-->
				
				<!--<div class="section">
					<label>
						<input type="checkbox" class="include" data-include="api_key" />Include API Key to override <a href="$greenhouse_settings_url">plugin settings</a>?
					</label>
					<div class="section section_api_key" style="display:none;">
						<label for="api_key">API Key
							<input id="api_key" type="text" />
						</label>
					</div>
				</div>-->
				
				<div class="section">
					<label>
						<input type="checkbox" class="include" data-include="texts" />Set Text Values to override <a href="$greenhouse_settings_url">plugin settings</a>?
					</label>
				
					<div class="section section_texts" style="display:none;">
						<div class="section">
							<label for="apply_now">Apply Now Text
								<input id="apply_now" type="text" />
							</label>
						</div>
						<div class="section">
							<label for="apply_now_cancel">Apply Now Cancel Text
								<input id="apply_now_cancel" type="text" />
							</label>
						</div>
						<div class="section">
							<label for="read_full_desc">Read Full Description Text
								<input id="read_full_desc" type="text" />
							</label>
						</div>
						<div class="section">
							<label for="hide_full_desc">Hide Full Description Text
								<input id="hide_full_desc" type="text" />
							</label>
						</div>
						<div class="section">
							<label for="location_label">Location Label Text
								<input id="location_label" type="text" />
							</label>
						</div>
						<div class="section">
							<label for="office_label">Office Label Text
								<input id="office_label" type="text" />
							</label>
						</div>
						<div class="section">
							<label for="department_label">Department Label Text
								<input id="department_label" type="text" />
							</label>
						</div>
					</div>
				</div>
				
				<div class="section">
					<label>
						<input type="checkbox" id="hide_forms" class="include" checked data-include="display_form" />Display Application Forms?
					</label>
				
					<div class="section section_display_form">
						<label>
							<select id="form_type">
								<option value="default" selected>Use default setting</option>
								<option value="iframe">Embed iFrame forms</option>
								<option value="inline">Inline dynamic forms</option>
							</select>
						</label>
					
						<div class="section section_display_form section_form_fields" style="display:none;">
							<label for="form_fields">Form Fields
								<input id="form_fields" type="text" />
							</label>
							<div class="help_text">Pipe '|' delimeted. For example: First Name|Email (leave blank to display all fields).</div>
						</div>
						
					</div>
					
				</div>
				
				
				<div class="section">
					<label>
						<input type="checkbox" id="display_custom_meta" class="include" data-include="display_meta" />Customize Displayed Job Data?
					</label>
				
					<div class="section section_display_meta" style="display:none;">
						<div class="section">
							<label>
								<input type="checkbox" id="display_location" />Display Job Location?
							</label>
						</div>
						<div class="section">
							<label>
								<input type="checkbox" id="display_office" />Display Job Office?
							</label>
						</div>
						<div class="section">
							<label>
								<input type="checkbox" id="display_department" />Display Job Department?
							</label>
						</div>
						<div class="section">
							<label>
								<input type="checkbox" id="display_description" />Display Job Description?
							</label>
						</div>
					</div>
				</div>
				
				
				<div class="section">
					<label>
						<input type="checkbox" class="include" data-include="filter" />Filter jobs?
					</label>
				
					<div class="section section_filter" style="display:none;">
						<div class="section">
							<label>
								<input type="checkbox" class="include" data-include="department_filter" />Filter by department?
							</label>
							<div class="section section_department_filter" style="display:none;">
								<label for="department_filter">Department Filter
									<input id="department_filter" type="text" />
								</label>
								<div class="help_text">Pipe '|' delimeted. For example: Department 1| Department 2.</div>
							</div>
						</div>
						<div class="section">
							<label>
								<input type="checkbox" class="include" data-include="job_filter" />Filter by Job?
							</label>
							<div class="section section_job_filter" style="display:none;">
								<label for="job_filter">Job Filter
									<input id="job_filter" type="text" />
								</label>
								<div class="help_text">Pipe '|' delimeted. For example: job 1| job 2.</div>
							</div>
						</div>
						<div class="section">
							<label>
								<input type="checkbox" class="include" data-include="office_filter" />Filter by Office?
							</label>
							<div class="section section_office_filter" style="display:none;">
								<label for="office_filter">Office Filter
									<input id="office_filter" type="text" />
								</label>
								<div class="help_text">Pipe '|' delimeted. For example: office 1| office 2.</div>
							</div>
						</div>
						<div class="section">
							<label>
								<input type="checkbox" class="include" data-include="location_filter" />Filter by Location?
							</label>
							<div class="section section_location_filter" style="display:none;">
								<label for="location_filter">Location Filter
									<input id="location_filter" type="text" />
								</label>
								<div class="help_text">Single locations only. For example: location 1.</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			
			<div class="media-frame-toolbar">
				<div class="media-toolbar-secondary">
					<a style="float: left;" href="#" onclick="tb_remove(); return false;">Cancel</a>		
				</div>				
				<div class="media-toolbar-primary">
					<a style="float: right;" class="insert-greenhouse-shortcode-button button button-primary button-large media-button">Insert Shortcode</a>
				</div>
			</div>
		</div>
	</div>
</div>

HTML;
	}

}
