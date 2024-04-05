<?php
/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://internetstiftelsen.se
 * @since             1.0.0
 * @package           Iis_Pack
 *
 * @wordpress-plugin
 * Plugin Name:       IIS Pack
 * Plugin URI:        https://internetstiftelsen.se
 * Description:       Functions for GTM, local avatars, removal of emoji scripts etc
 * Version:           3.0.1
 * Author:            The Swedish Internet Foundation
 * Author URI:        https://internetstiftelsen.se
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       iis-pack
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-iis-pack-activator.php
 */
function activate_iis_pack() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-iis-pack-activator.php';
	Iis_Pack_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-iis-pack-deactivator.php
 */
function deactivate_iis_pack() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-iis-pack-deactivator.php';
	Iis_Pack_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_iis_pack' );
register_deactivation_hook( __FILE__, 'deactivate_iis_pack' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-iis-pack.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_iis_pack() {

	$plugin = new Iis_Pack();
	$plugin->run();
}

run_iis_pack();

$iis_disable_notifications = get_option( 'iis_pack_disable_password_change_notifications' );

if ( $iis_disable_notifications && ! function_exists( 'wp_password_change_notification' ) ) { function wp_password_change_notification() {} }
