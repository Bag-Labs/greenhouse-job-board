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
	 * @since    1.5.0
	 */
	public function greenhouse_add_shortcode_media_button() {
		add_thickbox();
		echo <<<HTML
		
		<a href="#TB_inline?width=600&height=550&inlineId=add-greenhouse-shortcode-form" id="add-greenhouse-shortcode-button" class="button thickbox">Add Greenhouse Job Board</a>
		<div id="add-greenhouse-shortcode-form" style="display:none;">
		<div class="greenhouse-wizard">
		
		<h1>Greenhouse Job Board Shortcode</h1>
		
		<div class="section">
			<label>
				<input type="checkbox" class="include" data-include="url_token" />Include URL token to override plugin settings?
			</label>
			<div class="section section_url_token" style="display:none;">
				<label for="url_token">Url token
					<input id="url_token" type="text" />
				</label>
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
			</div>
		</div>
		
		<hr />
		<a style="float: left;" href="#" onclick="tb_remove(); return false;">Cancel</a>		
		<a style="float: right;" class="insert-greenhouse-shortcode-button button button-primary">Insert Shortcode</a>
		
		</div>
		</div>
HTML;
	}

}
