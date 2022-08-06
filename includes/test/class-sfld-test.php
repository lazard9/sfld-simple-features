<?php defined( 'WPINC' ) or die();

namespace SFLD\Includes\Test;

if ( ! class_exists( 'SFLD_Test', false ) ) : class SFLD_Test {

    public function __construct() {
        add_action( 'admin_menu', [$this, 'sfld_plugin_settings_pages'] );
    }

    /**
     * Display plugin file paths.
     * Only for testing purposes.
     * 
     */
    function sfld_plugin_settings_page_markup() : void {
        // Double check user capabilities
        if ( !current_user_can('manage_options') ) {
            return;
        }
        ?>
        <div class="sfld-wrap">
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

    function sfld_plugin_settings_pages() : void {

        add_menu_page(
            __( 'File Paths', 'sfldsimple' ),
            __( 'File Paths', 'sfldsimple' ),
            'manage_options',
            'sfld_plugin',
            [$this, 'sfld_plugin_settings_page_markup'],
            'dashicons-image-rotate',
            100
        );

    }

} endif;
