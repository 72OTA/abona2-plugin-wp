<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://chiledevelopers.com
 * @since             1.0.0
 * @package           Abona2_Management_Tool
 *
 * @wordpress-plugin
 * Plugin Name:       Abona2 management tools
 * Plugin URI:        https://chiledevelopers.com
 * Description:       Plugin para el control de membresía, automatizando el flujo respectivo a modo de aprobación, rechazo y envio de correos.
 * Version:           3.0.0
 * Author:            Felipe Andrade
 * Author URI:        https://chiledevelopers.com
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       abona2-management-tool
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

if (!function_exists('is_plugin_active')) {
    include_once(ABSPATH . '/wp-admin/includes/plugin.php');
}
/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define( 'ABONA2_MANAGEMENT_TOOL_VERSION', '1.0.0' );
define( 'ABONA2_MANAGEMENT_TOOL_PLUGIN_URL', plugin_dir_url( __FILE__ ) );
define( 'ABONA2_MANAGEMENT_TOOL_PLUGIN_PATH', plugin_dir_path( __FILE__ ) );

/**
* Check for the existence of WooCommerce and any other requirements
*/
function abona2_check_requirements() {
    if ( is_plugin_active( 'woocommerce/woocommerce.php') && is_plugin_active('woocommerce-transbank-1/webpay.php') && is_plugin_active('wp-mail-smtp/wp_mail_smtp.php') ) {
        return true;
    } else {
        add_action( 'admin_notices', 'abona2_missing_wc_notice' );
        return false;
    }
}

/**
* Display a message advising WooCommerce is required
*/
function abona2_missing_wc_notice() { 
    $class = 'notice notice-error';
    $message = __( 'Abona2 requiere de los siguientes plugins <a href="https://www.wordpress.org/plugins/woocommerce/" target="_blank">WooCommerce</a>, <a href="https://www.transbankdevelopers.cl/plugin/woocommerce/" target="_blank">Transbank Webpay</a> y <a href="https://cl.wordpress.org/plugins/wp-mail-smtp/" target="_blank">wp-mail-smtp</a> para su correcto funcionamiento.', 'abona2-management-tool' );
 
    printf( '<div class="%1$s"><p>%2$s</p></div>', esc_attr( $class ),  $message  ); 
}

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-abona2-management-tool-activator.php
 */
function activate_abona2_management_tool() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-abona2-management-tool-activator.php';
	Abona2_Management_Tool_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-abona2-management-tool-deactivator.php
 */
function deactivate_abona2_management_tool() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-abona2-management-tool-deactivator.php';
	Abona2_Management_Tool_Deactivator::deactivate();
}

add_action( 'plugins_loaded', 'abona2_check_requirements' );

register_activation_hook( __FILE__, 'activate_abona2_management_tool' );
register_deactivation_hook( __FILE__, 'deactivate_abona2_management_tool' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-abona2-management-tool.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_abona2_management_tool() {
	if (abona2_check_requirements()) {
		$plugin = new Abona2_Management_Tool();
		$plugin->run();       
    }
	

}
run_abona2_management_tool();
