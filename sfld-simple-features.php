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

// Define namespace. Just for testing!!!!!!
namespace SFLD\includes;

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
if ( ! class_exists( 'SFLD_Simple', false ) && file_exists( SFLD_SIMPLE_DIR . 'lib/autoloader.php' ) ) {

    include_once SFLD_SIMPLE_DIR . 'lib/autoloader.php' ;
    define( 'AUTOLOADER_FILE_INCLUDED', TRUE );

}

function activate_sfld_simple() {
    // require_once SFLD_SIMPLE_DIR . 'includes/class-sfld-simple-activator.php';
    SFLD_Simple_Activator::activate();
}

function deactivate_sfld_simple() {
    // require_once SFLD_SIMPLE_DIR . 'includes/class-sfld-simple-deactivator.php';
    SFLD_Simple_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_sfld_simple' );
register_deactivation_hook( __FILE__, 'deactivate_sfld_simple' );


/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
// if ( ! class_exists( 'SFLD_Simple', false ) ) {
// 	include_once plugin_dir_path( __FILE__ ) . 'includes/class-sfld-simple.php';
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
if ( AUTOLOADER_FILE_INCLUDED ) {

    function run_simple() : void {

        $sfld_simple = SFLD_Simple::get_instance();
        $sfld_simple->run_dependencies();
        $sfld_simple->run_hooks();

    }

    run_simple();
}
