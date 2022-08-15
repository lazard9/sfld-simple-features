<?php

/**
 * @wordpress-plugin
 * Plugin Name: SFLD Simple Features
 * Plugin URI:
 * Version: 2.0.0
 * Author: Lazar Dacic
 * Author URI: https://profiles.wordpress.org/lazarus9/
 * Text Domain: sfldsimple
 * Domain Path: /languages
 * Description: Extends functionalities
 * Requires PHP: 7.2
 * License: GPL v2 or later
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
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
defined( 'WPINC' ) or die( 'Buy, buy!' ); 

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


/**
 * Include the autoloader so we can dynamically include the rest of the classes.
 * 
 * Files will be included in case the autoloader.php file doesn't exist!
 */
if ( ! class_exists( 'SFLD_Simple_Features', false ) && file_exists( SFLD_SIMPLE_DIR . 'lib/autoloader.php' ) ) {
    include_once SFLD_SIMPLE_DIR . 'lib/autoloader.php';
} 
 else {

    function sfld_simple_error_notice() {

        if ( current_user_can( 'manage_options' ) ) {
            ?>
                <div class="error notice">
                    <p><?php _e( 'There has been an error with autoloader!', 'sfldsimple' ); ?></p>
                </div>
            <?php
        }

    }
    
    add_action( 'admin_notices', 'sfld_simple_error_notice' );

}

if ( ! file_exists( SFLD_SIMPLE_DIR . 'lib/autoloader.php' )  ) {
    include_once SFLD_SIMPLE_DIR . 'includes/abstracts/class-sfld-base-singleton.php';
}

function activate_sfld_simple_features() {

    if ( ! file_exists( SFLD_SIMPLE_DIR . 'lib/autoloader.php' ) ) {
        include_once SFLD_SIMPLE_DIR . 'includes/class-sfld-activator.php'; // Include files witout the autoloader
    }

    SFLD\Includes\SFLD_Activator::activate();
    
}

function deactivate_sfld_simple_features() {
    if ( ! current_user_can( 'activate_plugins' ) ) {
        return;
    }
    
    // Reload textdomain on update
    if ( is_textdomain_loaded( 'sfldsimple' ) ) {
        unload_textdomain( 'sfldsimple' );
    }

    if ( ! file_exists( SFLD_SIMPLE_DIR . 'lib/autoloader.php' ) ) {
        include_once SFLD_SIMPLE_DIR . 'includes/class-sfld-deactivator.php'; // Include files witout the autoloader
    }

    SFLD\Includes\SFLD_Deactivator::deactivate();

}

register_activation_hook( __FILE__, 'activate_sfld_simple_features' );
register_deactivation_hook( __FILE__, 'deactivate_sfld_simple_features' );


/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
if ( ! class_exists( 'SFLD_Simple_Features', false ) && ! file_exists( SFLD_SIMPLE_DIR . 'lib/autoloader.php' ) ) {
	include_once SFLD_SIMPLE_DIR . 'includes/class-sfld-simple-features.php'; // Include files witout the autoloader
}

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * 
 */
function sfld_simple_features() : void {

    SFLD\Includes\SFLD_Simple_Features::getInstance();

}

sfld_simple_features();
