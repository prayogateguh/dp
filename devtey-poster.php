<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://devtey.com/
 * @since             1.0.0
 * @package           Devtey_Poster
 *
 * @wordpress-plugin
 * Plugin Name:       Devtey Poster
 * Plugin URI:        https://devtey.com/plugins/poster
 * Description:       Plugin wallpaper (rasa manual) terbaik, anti ribet.
 * Version:           1.0.2
 * Author:            Devtey Inc.
 * Author URI:        https://devtey.com/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       devtey-poster
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define( 'DP_POSTER_VER', '1.0.2' );
define( 'DP_SK', '5b35daba863653.21864685' );
define( 'DP_SU', 'https://devtey.com' );
define( 'DP_IR', 'Devtey Poster' );

// update checker
require plugin_dir_path( __FILE__ ) . 'admin/include/vendor/plugin-update-checker/plugin-update-checker.php';
$myUpdateChecker = Puc_v4_Factory::buildUpdateChecker(
	'https://devtey.com/updates/poster.json',
	__FILE__, //Full path to the main plugin file or functions.php.
	'devtey-poster'
);

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-devtey-poster-activator.php
 */
function activate_devtey_poster() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-devtey-poster-activator.php';
	Devtey_Poster_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-devtey-poster-deactivator.php
 */
function deactivate_devtey_poster() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-devtey-poster-deactivator.php';
	Devtey_Poster_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_devtey_poster' );
register_deactivation_hook( __FILE__, 'deactivate_devtey_poster' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-devtey-poster.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_devtey_poster() {

	$plugin = new Devtey_Poster();
	$plugin->run();

}
run_devtey_poster();
