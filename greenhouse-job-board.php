<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://www.brownbagmarketing.com
 * @since             1.4.0
 * @package           Greenhouse_Job_Board
 *
 * @wordpress-plugin
 * Plugin Name:       Greenhouse Job Board
 * Plugin URI:        https://wordpress.org/plugins/greenhouse-job-board/
 * Description:       Pull a job board from greenhouse.io via API calls.
 * Version:           1.4.0
 * Author:            Brown Bag Marketing
 * Author URI:        https://www.brownbagmarketing.com/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       greenhouse-job-board
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-greenhouse-job-board-activator.php
 */
function activate_greenhouse_job_board() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-greenhouse-job-board-activator.php';
	Greenhouse_Job_Board_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-greenhouse-job-board-deactivator.php
 */
function deactivate_greenhouse_job_board() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-greenhouse-job-board-deactivator.php';
	Greenhouse_Job_Board_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_greenhouse_job_board' );
register_deactivation_hook( __FILE__, 'deactivate_greenhouse_job_board' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-greenhouse-job-board.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_greenhouse_job_board() {

	$plugin = new Greenhouse_Job_Board();
	$plugin->run();

}
run_greenhouse_job_board();
