<?php
/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 *
 * @link       http://example.com
 * @since      1.1.0
 *
 * @package    Greenhouse_Job_Board
 * @subpackage Greenhouse_Job_Board/includes
 */

/**
 * The core plugin class.
 *
 * This is used to define internationalization, admin-specific hooks, and
 * public-facing site hooks.
 *
 * Also maintains the unique identifier of this plugin as well as the current
 * version of the plugin.
 *
 * @since      1.1.0
 * @package    Greenhouse_Job_Board
 * @subpackage Greenhouse_Job_Board/includes
 * @author     Your Name <email@example.com>
 */
class Greenhouse_Job_Board {

	/**
	 * The loader that's responsible for maintaining and registering all hooks that power
	 * the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      Greenhouse_Job_Board_Loader    $loader    Maintains and registers all hooks for the plugin.
	 */
	protected $loader;

	/**
	 * The unique identifier of this plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $greenhouse_job_board    The string used to uniquely identify this plugin.
	 */
	protected $greenhouse_job_board;

	/**
	 * The current version of the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $version    The current version of the plugin.
	 */
	protected $version;

	/**
	 * Define the core functionality of the plugin.
	 *
	 * Set the plugin name and the plugin version that can be used throughout the plugin.
	 * Load the dependencies, define the locale, and set the hooks for the admin area and
	 * the public-facing side of the site.
	 *
	 * @since    2.7.0
	 */
	public function __construct() {

		$this->greenhouse_job_board = 'greenhouse-job-board';
		$this->version              = '2.8.2';

		$this->load_dependencies();
		$this->set_locale();
		$this->define_admin_hooks();
		$this->define_public_hooks();

		$this->template_accordion = '<div class="job job_{{id}} job_{{slug}}" 
	data-id="{{id}}" 
	id="{{slug}}" 
	data-department="{{departments}}"
	data-location="{{locations}}"
>
	<h2 class="job_title">{{title}}</h2>
	<p><a href="#" class="job_read_full">{{text.read_full_desc}}</a></p>
	<div class="job_description job_description_{{id}}">
	{{#if display_location }}<div class="display_location"><span class="location_label">{{text.location_label}}</span>{{display_location}}</div>{{/if}}
		{{#if display_office }}<div class="display_office"><span class="office_label">{{text.office_label}}</span>{{display_office}}</div>{{/if}}
		{{#if display_department }}<div class="display_department"><span class="department_label">{{text.department_label}}</span>{{display_department}}</div>{{/if}}
			{{#if display_description }}<div class="display_description"><span class="description_label">{{text.description_label}}</span>{{{content}}}</div>{{/if}}
	</div>
	{{#ifeq hide_forms "false"}}<p><a href="#" class="job_apply job_apply_{{id}}" data-opened-text="{{text.apply_now_cancel}}" data-closed-text="{{text.apply_now}}">{{text.apply_now}}</a></p>{{/ifeq}}
</div>';
	}

	/**
	 * Load the required dependencies for this plugin.
	 *
	 * Include the following files that make up the plugin:
	 *
	 * - Greenhouse_Job_Board_Loader. Orchestrates the hooks of the plugin.
	 * - Greenhouse_Job_Board_i18n. Defines internationalization functionality.
	 * - Greenhouse_Job_Board_Admin. Defines all hooks for the admin area.
	 * - Greenhouse_Job_Board_Public. Defines all hooks for the public side of the site.
	 *
	 * Create an instance of the loader which will be used to register the hooks
	 * with WordPress.
	 *
	 * @since    1.1.0
	 * @access   private
	 */
	private function load_dependencies() {

		/**
		 * The class responsible for orchestrating the actions and filters of the
		 * core plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-greenhouse-job-board-loader.php';

		/**
		 * The class responsible for defining internationalization functionality
		 * of the plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-greenhouse-job-board-i18n.php';

		/**
		 * The class responsible for defining all actions that occur in the admin area.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-greenhouse-job-board-admin.php';

		/**
		 * The class responsible for defining all actions that occur in the public-facing
		 * side of the site.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/class-greenhouse-job-board-public.php';
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/partials/greenhouse-job-board-public-display.php';

		$this->loader = new Greenhouse_Job_Board_Loader();

	}

	/**
	 * Define the locale for this plugin for internationalization.
	 *
	 * Uses the Greenhouse_Job_Board_i18n class in order to set the domain and to register the hook
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function set_locale() {

		$plugin_i18n = new Greenhouse_Job_Board_I18n();
		$plugin_i18n->set_domain( $this->get_greenhouse_job_board() );

		$this->loader->add_action( 'plugins_loaded', $plugin_i18n, 'load_plugin_textdomain' );

	}

	/**
	 * Register all of the hooks related to the admin area functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_admin_hooks() {

		$plugin_admin = new Greenhouse_Job_Board_Admin( $this->get_greenhouse_job_board(), $this->get_version() );

		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_styles' );
		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_scripts' );

		$this->loader->add_filter( 'plugin_action_links_greenhouse-job-board/greenhouse-job-board.php', $plugin_admin, 'greenhouse_add_action_links' );

		$this->loader->add_action( 'media_buttons', $plugin_admin, 'greenhouse_add_shortcode_media_button', 20 );

	}

	/**
	 * Register all of the hooks related to the public-facing functionality
	 * of the plugin.
	 *
	 * @since    1.1.0
	 * @access   private
	 */
	private function define_public_hooks() {

		$plugin_public = new Greenhouse_Job_Board_Public( $this->get_greenhouse_job_board(), $this->get_version() );

		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_styles' );
		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_scripts' );

		$this->loader->add_action( 'init', $plugin_public, 'register_shortcodes' );

		$this->loader->add_action( 'admin_menu', $plugin_public, 'greenhouse_job_board_add_admin_menu' );
		$this->loader->add_action( 'admin_init', $plugin_public, 'greenhouse_job_board_settings_init' );
	}

	/**
	 * Run the loader to execute all of the hooks with WordPress.
	 *
	 * @since    1.0.0
	 */
	public function run() {
		$this->loader->run();
	}

	/**
	 * The name of the plugin used to uniquely identify it within the context of
	 * WordPress and to define internationalization functionality.
	 *
	 * @since     1.0.0
	 * @return    string    The name of the plugin.
	 */
	public function get_greenhouse_job_board() {
		return $this->greenhouse_job_board;
	}

	/**
	 * The reference to the class that orchestrates the hooks with the plugin.
	 *
	 * @since     1.0.0
	 * @return    Greenhouse_Job_Board_Loader    Orchestrates the hooks of the plugin.
	 */
	public function get_loader() {
		return $this->loader;
	}

	/**
	 * Retrieve the version number of the plugin.
	 *
	 * @since     1.0.0
	 * @return    string    The version number of the plugin.
	 */
	public function get_version() {
		return $this->version;
	}


	/**
	 * Give the plugin accordion template.
	 *
	 * @since   2.8.0
	 */
	public function get_template_accordion() {
		return $this->template_accordion;
	}

}
