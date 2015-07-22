<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       http://example.com
 * @since      1.2.0
 *
 * @package    Greenhouse_Job_Board
 * @subpackage Greenhouse_Job_Board/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Greenhouse_Job_Board
 * @subpackage Greenhouse_Job_Board/public
 * @author     Your Name <email@example.com>
 */
class Greenhouse_Job_Board_Public {

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
	 * @param      string    $greenhouse_job_board       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $greenhouse_job_board, $version ) {

		$this->greenhouse_job_board = $greenhouse_job_board;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
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

		wp_enqueue_style( $this->greenhouse_job_board, plugin_dir_url( __FILE__ ) . 'css/greenhouse-job-board-public.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.7.0
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
		
		wp_enqueue_script( $this->greenhouse_job_board + '_handlebars', plugin_dir_url( __FILE__ ) . 'js/handlebars-v3.0.0.js', array( 'jquery' ), null, false );
		wp_enqueue_script( 'cycle2', plugin_dir_url( __FILE__ ) . 'js/jquery.cycle2.min.js', array( 'jquery' ), '20141007', false );
		wp_enqueue_script( $this->greenhouse_job_board, plugin_dir_url( __FILE__ ) . 'js/greenhouse-job-board-public.js', array( 'jquery' ), '1.7.0', false );

	}
	
	/**
	 * Register the shortcodes.
	 *
	 * @since    1.0.0
	 */
	public function register_shortcodes() {
		add_shortcode( 'greenhouse', array( $this, 'greenhouse_shortcode_function') );
	}
	
	/**
	 * Handle the main [greenhouse] shortcode.
	 *
	 * @since    1.6.0
	 */
	public function greenhouse_shortcode_function( $atts, $content = null ) {
		$options = get_option( 'greenhouse_job_board_settings' );
		
	    $atts = shortcode_atts( array(
	        'url_token' 		=> isset( $options['greenhouse_job_board_url_token'] ) ? $options['greenhouse_job_board_url_token'] : '',
	        'api_key' 			=> isset( $options['greenhouse_job_board_api_key'] ) ? $options['greenhouse_job_board_api_key'] : '',
	        'board_type' 		=> isset( $options['greenhouse_job_board_type'] ) ? $options['greenhouse_job_board_type'] : 'accordion',
	        'back'				=> isset( $options['greenhouse_job_board_back'] ) ? $options['greenhouse_job_board_back'] : 'Back',
	        'apply_now'			=> isset( $options['greenhouse_job_board_apply_now'] ) ? $options['greenhouse_job_board_apply_now'] : 'Apply Now',
	        'apply_now_cancel'	=> isset( $options['greenhouse_job_board_apply_now_cancel'] ) ? $options['greenhouse_job_board_apply_now_cancel'] : 'Cancel',
	        'read_full_desc'	=> isset( $options['greenhouse_job_board_read_full_desc'] ) ? $options['greenhouse_job_board_read_full_desc'] : 'Read Full Description',
	        'hide_full_desc'	=> isset( $options['greenhouse_job_board_hide_full_desc'] ) ? $options['greenhouse_job_board_hide_full_desc'] : 'Hide Full Description',
	        'hide_forms'		=> 'false',
	        'form_type'			=> isset( $options['greenhouse_job_board_form_type'] ) ? $options['greenhouse_job_board_form_type'] : 'iframe',
	        'department_filter'	=> '',
	        'job_filter'		=> '',
	        'office_filter'		=> '',
	        'location_filter'	=> '',
	        'location_label'	=> isset( $options['greenhouse_job_board_location_label'] ) ? $options['greenhouse_job_board_location_label'] : 'Location: ',
	        'office_label'		=> isset( $options['greenhouse_job_board_office_label'] ) ? $options['greenhouse_job_board_office_label'] : 'Office: ',
	        'department_label'	=> isset( $options['greenhouse_job_board_department_label'] ) ? $options['greenhouse_job_board_department_label'] : 'Department: ',
	        'description_label'	=> isset( $options['greenhouse_job_board_description_label'] ) ? $options['greenhouse_job_board_description_label'] : '',
	        'display'			=> isset( $options['display'] ) ? $options['display'] : 'description',
	    ), $atts );
	    
	    //sanitize values
	    //if hide_forms is anything other than true, set it to false
	    if ( $atts['hide_forms'] !== 'true' ) {
	    	$atts['hide_forms'] = 'false';
	    }
	    //reset form_type until set up for more types
	    // if ( $atts['form_type'] !== 'iframe' ) {
	    // 	$atts['form_type'] = 'iframe';
	    // }
	    
	    
		$options  = '<div class="greenhouse-job-board" 
			data-type="' . $atts['board_type'] . '" 
			data-form_type="' . $atts['form_type'] . '">';
		
	    if ( $atts['url_token'] == '' ) {
	    	$options .= 'The greenhouse url_token is required. Please either add it as a shortcode attribute or add it to your <a href="' . admin_url('options-general.php?page=greenhouse_job_board' ) . '">greenhouse settings</a>.';
			$options .= '</div>';
			return $options;
	    }
	    
	    /*
		$options .= '<p>Greenhouse shortcode detected';
		if ($atts['board_type']) {
			$options .= ', with board_type: ' . $atts['board_type'];
		}
		$options .= '</p>';
		*/
		
		//accordion template
		if ( $atts['board_type'] == 'accordion' ) {
		// handlebars template for returned job
		$options .= '<script id="job-template" type="text/x-handlebars-template">
		<div class="job" 
			data-id="{{id}}" 
			data-departments="{{departments}}">
	 	    	<h2 class="job_title">{{title}}</h2>
	 	    	<p><a href="#" class="job_read_full" data-opened-text="' . $atts['hide_full_desc'] . '" data-closed-text="' . $atts['read_full_desc'] . '">' . $atts['read_full_desc'] . '</a></p>
	 	    	<div class="job_description job_description_{{id}}">
    				{{#if display_location }}<div class="display_location"><span class="location_label">' . $atts['location_label'] . '</span>{{display_location}}</div>{{/if}}
    	 	    	{{#if display_office }}<div class="display_office"><span class="office_label">' . $atts['office_label'] . '</span>{{display_office}}</div>{{/if}}
    	 	    	{{#if display_department }}<div class="display_department"><span class="department_label">' . $atts['department_label'] . '</span>{{display_department}}</div>{{/if}}
	 	    			{{#if display_description }}<div class="display_description"><span class="description_label">' . $atts['description_label'] . '</span>{{{content}}}</div>{{/if}}
	 	    	</div>
	 	    	{{#ifeq hide_forms "false"}}<p><a href="#" class="job_apply job_apply_{{id}}" data-opened-text="' . $atts['apply_now_cancel'] . '" data-closed-text="' . $atts['apply_now'] . '">' . $atts['apply_now'] . '</a></p>{{/ifeq}}
	 	</div>
</script>';
		}
		
		
		// cycle template
		else if ( $atts['board_type'] == 'cycle') {
		// handlebars template for returned job
		$options .= '<script id="job-template" type="text/x-handlebars-template">
		<div class="job job_{{id}}" 
			data-id="{{id}}" 
			data-departments="{{departments}}">
	 	    	<h3 class="job_title">{{title}}</h3>
	 	    	<div class="job_excerpt">{{{excerpt}}}<br />
	 	    	<a href="#" class="job_goto">' . $atts['read_full_desc'] . '</a></div>
	 	    	<sc{{!}}ript type="text/javascript" src="https://api.greenhouse.io/v1/boards/' . $atts['url_token'] . '/embed/job?id={{id}}&questions=true&callback=greenhouse_jobs_job"></sc{{!}}ript>
	 	</div>
</script>';
		$options .= '<script id="job-slide-template" type="text/x-handlebars-template">
		<div class="job cycle-slide" 
			data-cycle-hash="{{title}}"
			data-id="{{id}}" 
			data-departments="{{departments}}">
				<div class="job_single">
		 	    	<h1 class="job_title">{{title}}</h1>
		 	    	{{#ifeq hide_forms "false"}}<p><a href="#" class="job_apply job_apply_{{id}} button" data-opened-text="' . $atts['apply_now_cancel'] . '" data-closed-text="' . $atts['apply_now'] . '">' . $atts['apply_now'] . '</a></p>{{/ifeq}}
		 	    	<div class="job_description job_description_{{id}}">
	    				{{#if display_location }}<div class="display_location"><span class="location_label">' . $atts['location_label'] . '</span>{{display_location}}</div>{{/if}}
	    	 	    	{{#if display_office }}<div class="display_office"><span class="office_label">' . $atts['office_label'] . '</span>{{display_office}}</div>{{/if}}
	    	 	    	{{#if display_department }}<div class="display_department"><span class="department_label">' . $atts['department_label'] . '</span>{{display_department}}</div>{{/if}}
		 	    			{{#if display_description }}<div class="display_description"><span class="description_label">' . $atts['description_label'] . '</span>{{{content}}}</div>{{/if}}
		 	    	</div>
		 	    	{{#ifeq hide_forms "false"}}<p><a href="#" class="job_apply job_apply_{{id}} button" data-opened-text="' . $atts['apply_now_cancel'] . '" data-closed-text="' . $atts['apply_now'] . '">' . $atts['apply_now'] . '</a></p>{{/ifeq}}
		 	    	<p><a href="#" class="return">' . $atts['back'] . '</a></p>
	 	    	</div>
	 	</div>
</script>';
		}
		
		// html container
		$options .= '<div class="all_jobs">';
		if ( $atts['board_type'] != 'cycle') {
			$options .= '<div class="jobs"';
		}
		elseif ( $atts['board_type'] == 'cycle') {
			$options .= '<div class="jobs cycle-slide" data-cycle-hash="All"';	
		}
		$options .= '"
				data-department_filter="' . $atts['department_filter'] . '"
				data-job_filter="' . $atts['job_filter'] . '"
				data-office_filter="' . $atts['office_filter'] . '"
				data-location_filter="' . $atts['location_filter'] . '"
				data-hide_forms="' . $atts['hide_forms'] . '"
				data-form_type="' . $atts['form_type'] . '"
				data-display="' . $atts['display'] . '"
				><h1>Careers</h1>
			</div>';
			
		if ( $atts['hide_forms'] !== 'true' &&
			 $atts['form_type'] === 'inline' ) {
			$options .= '<div class="cycle-slide" data-cycle-hash="Apply"><div class="apply_jobs">
					<h1>Join the Team!</h1><h2>Apply for a job with Vetlocity</h2>
					<form id="apply_form" method="POST" action="/wp-content/plugins/greenhouse-job-board/public/partials/greenhouse-job-board-apply-submit.php" enctype="multipart/form-data">
							<input type="hidden" id="hidden_id" name="id" value="35682" />
							<input type="hidden" id="hidden_mapped_url_token" name="mapped_url_token" value="https://www.brownbagmarketing.com/careers/?gh_jid=35682" />
							
							<div class="field_wrap field_fname field_left">
								<label for="first_name">First Name<span class="asty">*</span></label>
								<input type="text" name="first_name" id="first_name" title="First Name" placeholder="First" class="required" />
							</div>
							<div class="field_wrap field_lname field_right">
								<label for="last_name">Last Name<span class="asty">*</span></label>
								<input type="text" name="last_name" id="last_name" title="Last Name" placeholder="Last" class="required" />
							</div>
							<div class="field_wrap field_email field_left">
								<label for="email">Email<span class="asty">*</span></label>
								<input type="email" name="email" id="email" title="Email" placeholder="email@example.com" class="email required" />
							</div>
							<div class="field_wrap field_phone field_right">
								<label for="tel1">Phone<span class="asty">*</span></label>
								<input type="text" class="tel tel1" id="tel1" maxlength="3" placeholder="xxx" />
								<input type="text" class="tel tel2" maxlength="3" placeholder="xxx" />
								<input type="text" class="tel tel3" maxlength="4" placeholder="xxxx" />
								<input type="hidden" name="phone" id="phone_number" title="Phone" placeholder="Phone" class="phone required" />
							</div>
							<div class="field_wrap field_linkedin field_left">
								<label for="linkedin_profile_url">LinkedIn Profile Url<span class="asty">*</span></label>
								<input type="text" name="question_89835" id="linkedin_profile_url" title="LinkedIn Profile Url" placeholder="https://www.linkedin.com/in/myurl" class="url required" />
							</div>
							<div class="field_wrap field_position field_right">
								<label for="positions">Position<span class="asty">*</span></label>
								<select id="positions" class="select required" title="Position">
									<option value="">Select Position</option>
								</select>
							</div>
							<div class="field_wrap field_resume field_left">
								<label for="resume">Upload Resume<span class="asty">*</span></label>
								<input type="file" id="resume" name="resume" title="Resume" placeholder="Resume" class="required" />
							</div>
							<div class="field_wrap field_cl field_full">
								<label for="cover_letter_text">Tell us why you\'re interested in working at Vetlocity</label>
								<textarea id="cover_letter_text" name="cover_letter_text" title="Cover Letter" class="" rows="4" placeholder="" ></textarea>
							</div>
							
							<div class="field_wrap field_submit">
								<div class="submit button">Submit Application</div>
							</div>
							
							
						</form>
						<p><a href="#" class="return">' . $atts['back'] . '</a></p>
						</div></div>
						<div class="cycle-slide" data-cycle-hash="Thanks">
							<div class="apply_ty">
								<h2>Thank you for your interest in Vetlocity!</h2>
								<p>We’ll review your application as soon as possible.</p>
								<p>Hopefully your skills and our needs will be a perfect match.</p>
							</div>
						</div>';
		}
			
		$options .= '</div>';
		// api call to get jobs with callback
		$options .= '<script type="text/javascript" src="https://api.greenhouse.io/v1/boards/' . $atts['url_token'] . '/embed/jobs?content=true&callback=greenhouse_jobs"></script>';
		// iframe container
		if ( $atts['hide_forms'] !== 'true' &&
			 $atts['form_type'] === 'iframe' ) {
			$options .= '<div id="grnhse_app"></div>';// script for loading iframe
			$options .= '<script src="https://app.greenhouse.io/embed/job_board/js?for=' . $atts['url_token'] . '"></script>';
		}
		
		// close all_jobs
		$options .= '</div>';
		
		return $options;

	}
	
	
	/**
	 * Register the settings page.
	 *
	 * @since    1.7.0
	 */
	//http://wpsettingsapi.jeroensormani.com/settings-generator
	function greenhouse_job_board_add_admin_menu(  ) { 
		add_options_page( 'Greenhouse Job Board Settings', 'Greenhouse', 'manage_options', 'greenhouse_job_board', 'greenhouse_job_board_options_page' );
	}
	
	function greenhouse_job_board_settings_init(  ) { 
		register_setting( 'greenhouse_settings', 'greenhouse_job_board_settings' );

		add_settings_section(
			'greenhouse_job_board_greenhouse_settings_section', 
			__( 'Greenhouse Account', 'greenhouse_job_board' ), 
			'greenhouse_job_board_settings_section_callback', 
			'greenhouse_settings'
		);
		
		//url_token
		add_settings_field( 
			'greenhouse_job_board_url_token', 
			__( 'URL Token', 'greenhouse_job_board' ), 
			'greenhouse_job_board_url_token_render', 
			'greenhouse_settings', 
			'greenhouse_job_board_greenhouse_settings_section' 
		);

		add_settings_field( 
			'greenhouse_job_board_api_key', 
			__( 'API key', 'greenhouse_job_board' ), 
			'greenhouse_job_board_api_key_render', 
			'greenhouse_settings', 
			'greenhouse_job_board_greenhouse_settings_section' 
		);

		add_settings_field( 
			'greenhouse_job_board_type', 
			__( 'Type', 'greenhouse_job_board' ), 
			'greenhouse_job_board_type_render', 
			'greenhouse_settings', 
			'greenhouse_job_board_greenhouse_settings_section' 
		);

		add_settings_field( 
			'greenhouse_job_board_back', 
			__( 'Back Text', 'greenhouse_job_board' ), 
			'greenhouse_job_board_back_render', 
			'greenhouse_settings', 
			'greenhouse_job_board_greenhouse_settings_section' 
		);

		add_settings_field( 
			'greenhouse_job_board_apply_now', 
			__( 'Apply Now Text', 'greenhouse_job_board' ), 
			'greenhouse_job_board_apply_now_render', 
			'greenhouse_settings', 
			'greenhouse_job_board_greenhouse_settings_section' 
		);

		add_settings_field( 
			'greenhouse_job_board_apply_now_cancel', 
			__( 'Apply Now Cancel Text', 'greenhouse_job_board' ), 
			'greenhouse_job_board_apply_now_cancel_render', 
			'greenhouse_settings', 
			'greenhouse_job_board_greenhouse_settings_section' 
		);

		add_settings_field( 
			'greenhouse_job_board_read_full_desc', 
			__( 'Read Full Description Text', 'greenhouse_job_board' ), 
			'greenhouse_job_board_read_full_desc_render', 
			'greenhouse_settings', 
			'greenhouse_job_board_greenhouse_settings_section' 
		);

		add_settings_field( 
			'greenhouse_job_board_hide_full_desc', 
			__( 'Hide Full Description Text', 'greenhouse_job_board' ), 
			'greenhouse_job_board_hide_full_desc_render', 
			'greenhouse_settings', 
			'greenhouse_job_board_greenhouse_settings_section' 
		);
		
		add_settings_field( 
			'greenhouse_job_board_form_type', 
			__( 'Form Type', 'greenhouse_job_board' ), 
			'greenhouse_job_board_form_type_render', 
			'greenhouse_settings', 
			'greenhouse_job_board_greenhouse_settings_section' 
		);

		add_settings_field( 
			'greenhouse_job_board_location_label', 
			__( 'Location Label', 'greenhouse_job_board' ), 
			'greenhouse_job_board_location_label_render', 
			'greenhouse_settings', 
			'greenhouse_job_board_greenhouse_settings_section' 
		);

		add_settings_field( 
			'greenhouse_job_board_office_label', 
			__( 'Office Label', 'greenhouse_job_board' ), 
			'greenhouse_job_board_office_label_render', 
			'greenhouse_settings', 
			'greenhouse_job_board_greenhouse_settings_section' 
		);

		add_settings_field( 
			'greenhouse_job_board_department_label', 
			__( 'Department Label', 'greenhouse_job_board' ), 
			'greenhouse_job_board_department_label_render', 
			'greenhouse_settings', 
			'greenhouse_job_board_greenhouse_settings_section' 
		);

		add_settings_field( 
			'greenhouse_job_board_description_label', 
			__( 'Description Label', 'greenhouse_job_board' ), 
			'greenhouse_job_board_description_label_render', 
			'greenhouse_settings', 
			'greenhouse_job_board_greenhouse_settings_section' 
		);
	}


}