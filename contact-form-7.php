<?php

/**
 * Contact Form 7 ZohoCampaigns Extension
 *
 * Integrate Contact Form 7 with Zoho Campaigns newsletter
 *
 * @link              http://neshable.com
 * @since             1.0.0
 * @package           CF7_Zoho_CMPG
 *
 * @wordpress-plugin
 * Plugin Name:       Contact Form 7 ZohoCampaigns Extension
 * Plugin URI:        http://github.com
 * Description:       Integrate Contact Form 7 with Zoho Campaigns newsletter.
 * Version:           1.0.0
 * Author:            Nesho Sabakov
 * Author URI:        http://neshable.com
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       contact-form-7
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( !defined( 'WPINC' ) ) {
    die;
}

/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 */
define( 'CF7_ZOHOCMP_EXT_VER', '1.0.0' );

/**
 * Define plugin options prefix
 */
define( 'CF7_ZOHOCMP_PREFIX', 'cf7_zoho_cmpg_' );
define( 'CF7_ZOHOCMP_PREFIX_GLOBAL', 'cf7_zoho_cmpg' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-cf7-zoho-cmpg-activator.php
 */
function activate_CF7_Zoho_CMPG() {
    require_once plugin_dir_path( __FILE__ ) . 'includes/class-cf7-zoho-cmpg-activator.php';
    CF7_Zoho_CMPG_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-cf7-zoho-cmpg-deactivator.php
 */
function deactivate_CF7_Zoho_CMPG() {
    require_once plugin_dir_path( __FILE__ ) . 'includes/class-cf7-zoho-cmpg-deactivator.php';
    CF7_Zoho_CMPG_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_CF7_Zoho_CMPG' );
register_deactivation_hook( __FILE__, 'deactivate_CF7_Zoho_CMPG' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-cf7-zoho-cmpg-api.php';
require plugin_dir_path( __FILE__ ) . 'includes/class-cf7-zoho-cmpg.php';

/**
 * Begins execution of the plugin.
 *
 * @since    1.0.0
 */

function run_CF7_Zoho_CMPG() {

    $plugin = new CF7_Zoho_CMPG();
    $plugin->run();

}

run_CF7_Zoho_CMPG();
