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

 
// If this file is called directly, abort.
defined( 'ABSPATH' ) or die ( 'Buy, buy!' );

// Define namespace.
//namespace SFLD\includes;

// Plugin dir path
define( 'SFLD_SIMPLE_DIR', plugin_dir_path( __FILE__ ) );
// Plugin URL
define( 'SFLD_SIMPLE_URL', plugin_dir_url( __FILE__ ) );
// Gets the basename 
define( 'SFLD_SIMPLE_BASENAME', plugin_basename( __FILE__ ) );

// // Include the autoloader so we can dynamically include the rest of the classes.
// if ( file_exists( SFLD_SIMPLE_DIR . 'lib/autoloader.php' ) ) {
// 	require_once SFLD_SIMPLE_DIR . 'lib/autoloader.php' ;
// }

function activate_sfld_simple() {

    require_once SFLD_SIMPLE_DIR . 'includes/class-sfld-simple-activator.php';
    SFLD_Simple_Activator::activate();

}

function deactivate_sfld_simple() {

    require_once SFLD_SIMPLE_DIR . 'includes/class-sfld-simple-deactivator.php';
    SFLD_Simple_Deactivator::deactivate();

}

register_activation_hook( __FILE__, 'activate_sfld_simple' );
register_deactivation_hook( __FILE__, 'deactivate_sfld_simple' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require_once plugin_dir_path( __FILE__ ) . 'includes/class-sfld-simple.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * 
 */
function run_sfld_simple_plugin() : void {

    $sfld_simple = SFLD_Simple::getInstance();
    $sfld_simple->run_dependencies();
    $sfld_simple->run_hooks();

}

run_sfld_simple_plugin();


/**
 * !!!!!!!!!!!!!!!!!!!!!
 * For testing purposes.
 * 
 */
class SFLD_Simple_Test {

    public function __construct() {
        add_action( 'admin_menu', [$this, 'ld_plugin_settings_pages'] );
    }

    /**
     * Display plugin file paths.
     * Only for testing purposes.
     * 
     */
    function ld_plugin_settings_page_markup() : void {
        // Double check user capabilities
        if ( !current_user_can('manage_options') ) {
            return;
        }
        ?>
        <div class="wrap">
            <h1><?php esc_html_e( get_admin_page_title() ); ?></h1>

            <?php
            $wpplugin_plugin_basename = plugin_basename( __FILE__ );
            $wpplugin_plugin_dir_path = plugin_dir_path( __FILE__ );
            $wpplugin_plugins_url_default = plugins_url();
            $wpplugin_plugins_url = plugins_url( 'includes', __FILE__ );
            $wpplugin_plugin_dir_url = plugin_dir_url( __FILE__ );
            ?>

            <ul>
                <li>plugin_basename( __FILE__ ) - <?php echo $wpplugin_plugin_basename; ?></li>
                <li>plugin_dir_path( __FILE__ ) - <?php echo $wpplugin_plugin_dir_path; ?></li>
                <li>plugins_url() - <?php echo $wpplugin_plugins_url_default; ?></li>
                <li>plugins_url( 'includes', __FILE__ ) - <?php echo $wpplugin_plugins_url; ?></li>
                <li>plugin_dir_url( __FILE__ ) - <?php echo $wpplugin_plugin_dir_url; ?></li>
            </ul>

        </div>
        <?php
    }

    function ld_plugin_settings_pages() : void {

        add_menu_page(
            __( 'File Paths', 'sfldsimple' ),
            __( 'File Paths', 'sfldsimple' ),
            'manage_options',
            'ld_plugin',
            [$this, 'ld_plugin_settings_page_markup'],
            'dashicons-screenoptions',
            100
        );

    }
}

// new SFLD_Simple_Test();
