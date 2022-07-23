<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @package SFLD Simple Features
 */

class SFLD_Simple_Admin {

    public function __construct( $plugin_name, $plugin_version ) {

        $this->plugin_name = $plugin_name;
        $this->plugin_version = $plugin_version;
        $this->load_admin_dependencies();

	}

    private function load_admin_dependencies() : void {

        require_once SFLD_SIMPLE_DIR . 'includes/admin/class-sfld-simple-admin-links.php';
        require_once SFLD_SIMPLE_DIR . 'includes/admin/class-sfld-simple-admin-pages.php';

        $this->admin_links = new SFLD_Simple_Admin_Links;
        $this->admin_pages = new SFLD_Simple_Admin_Pages;

    }

    /**
     * Register admin assets.
     *
     */
    public function sfld_enqueue_admin_assets() : void {
        wp_enqueue_style( 
            $this->plugin_name . '-admin-style', 
            SFLD_SIMPLE_URL . 'assets/css/admin.css',
            [],
			$this->plugin_version
        );
    }

}
