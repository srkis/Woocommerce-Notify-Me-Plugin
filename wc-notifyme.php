<?php

/**
 * Plugin Name:       Woo Nottify Me
 * Plugin URI:        https://srdjan.icodes.rocks/
 * Description:       Woo notifyme plugin send notification to your subscribed customers about changes on your products.
 * Version:           1.0.0
 * Author:            Srdjan Stojanovic
 * Author URI:        https://srdjan.icodes.rocks/
 * License:           Copyright (C) Srdjan Stojanovic - All Rights Reserved. Unauthorized copying of this file, via any medium is strictly prohibited. Proprietary and confidential. Written by Srdjan Stojanovic <stojanovicsrdjan27@gmail.com>, March, 13, 2020
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       wc-notifyme
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

global $wpdb;

/**
 * Currently plugin version.
 */
define( 'WC_NOTIFYME_VERSION', '1.0.0' );
define( 'WC_NOTIFYME_TABLE_NAME', $wpdb->prefix . 'notifyme_wc_product_data' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-plugin-name-activator.php
 */
function activate_wc_notifyme() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-wc-notifyme-activator.php';
	WC_Notifyme_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-plugin-name-deactivator.php
 */
function deactivate_wc_notifyme() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-wc-notifyme-deactivator.php';
	WC_Notifyme_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_wc_notifyme' );
register_deactivation_hook( __FILE__, 'deactivate_wc_notifyme' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-wc-notifyme.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_wc_notifyme() {

	$plugin = new WC_Notifyme();
	$plugin->run();

}
run_wc_notifyme();
