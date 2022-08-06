<?php

/**
 * Plugin Name: SFLD Simple Features
 * Description: Extends functionalities
 * Author: Lazar Dacic
 * Author URI: https://profiles.wordpress.org/lazarus9/
 * Version: 2.0.0
 * Text Domain: sfldsimple
 * 
 * @package SFLD Simple Features
 */

/**
 * This plugin is for practice. Free for everyone to use.
 * Slightly inspired by WooCommerce and Swiper.js plugins.
 * Various functionalities have been added (some unfinished!) 
 * from several courses, tutorials etc. Code refacting in progess!
 */



// If this file is called directly, abort.
defined( 'ABSPATH' ) or die ( 'Buy, buy!' );

// Define namespace.
namespace SFLD\Includes;

// Plugin dir path
if ( ! defined( 'SFLD_SIMPLE_DIR' ) ) {
    define( 'SFLD_SIMPLE_DIR', plugin_dir_path( __FILE__ ) );
}
// Plugin URL
if ( ! defined( 'SFLD_SIMPLE_URL' ) ) {
    define( 'SFLD_SIMPLE_URL', plugin_dir_url( __FILE__ ) );
}
// Gets the basename
if ( ! defined( 'SFLD_SIMPLE_BASENAME' ) ) {
    define( 'SFLD_SIMPLE_BASENAME', plugin_basename( __FILE__ ) );
}
// Include the autoloader so we can dynamically include the rest of the classes.
if ( ! class_exists( 'SFLD_Simple_Features', false ) && file_exists( SFLD_SIMPLE_DIR . 'lib/autoloader.php' ) ) {
    include_once SFLD_SIMPLE_DIR . 'lib/autoloader.php' ;
} 
 else {
    return;
}

function activate_sfld_simple() {
    // include_once SFLD_SIMPLE_DIR . 'includes/class-sfld-activator.php'; // Include files witout the autoloader
    SFLD_Activator::activate();
}

function deactivate_sfld_simple() {
    // include_once SFLD_SIMPLE_DIR . 'includes/class-sfld-deactivator.php'; // Include files witout the autoloader
    SFLD_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_sfld_simple' );
register_deactivation_hook( __FILE__, 'deactivate_sfld_simple' );


/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
// if ( ! class_exists( 'SFLD_Simple_Features', false ) ) {
// 	include_once plugin_dir_path( __FILE__ ) . 'includes/class-sfld-features.php'; // Include files witout the autoloader
// }

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * 
 */
function sfld_instance() : void {

    $sfld_instance = SFLD_Simple_Features::get_instance();
    $sfld_instance->run_dependencies();
    $sfld_instance->run_hooks();

}

sfld_instance();

