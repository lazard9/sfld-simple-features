<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @package SFLD Simple Features
 */

namespace SFLD\includes\admin;

class SFLD_Admin_Links {

    /**
     * Add a link to your settings page in your plugin
     * 
     */
    public function sfld_simple_add_settings_link( $links ) : array {
    
        $settings_link = '<a href="admin.php?page=sfld-simple">' . __( 'Settings', 'sfldsimple' ) . '</a>';
        array_push( $links, $settings_link );
        return $links;
    
    }
    
    /**
     * Retrieve the plugin action links.
     * 
     */
    public function get_plugin_action_links() : string {
    
        return "plugin_action_links_" . SFLD_SIMPLE_BASENAME;
    
    }

}
