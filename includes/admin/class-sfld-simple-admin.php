<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @package SFLD Simple Features
 */

namespace SFLD\includes\admin;
use SFLD\includes\admin\pages\SFLD_Simple_Admin_Pages;
use SFLD\includes\admin\pages\settings\SFLD_Simple_Admin_Form;
use SFLD\includes\admin\pages\settings\SFLD_Simple_Main_Form;

class SFLD_Simple_Admin {

    public function __construct( $plugin_name, $plugin_version ) {

        $this->plugin_name = $plugin_name;
        $this->plugin_version = $plugin_version;

        // $this->admin_includes();
        $this->admin_init();

	}

    private function admin_includes() : void {

        include_once SFLD_SIMPLE_DIR . 'includes/admin/class-sfld-simple-admin-links.php';
        include_once SFLD_SIMPLE_DIR . 'includes/admin/pages/class-sfld-simple-admin-pages.php';
        include_once SFLD_SIMPLE_DIR . 'includes/admin/pages/settings/class-sfld-simple-admin-form.php';
        include_once SFLD_SIMPLE_DIR . 'includes/admin/pages/settings/class-sfld-simple-main-form.php';

    }

    public function admin_init() {
        
        $this->admin_links = new SFLD_Simple_Admin_Links;
        $this->admin_pages = new SFLD_Simple_Admin_Pages;
        $this->admin_form_settings = new SFLD_Simple_Admin_Form;
        $this->admin_main_settings = new SFLD_Simple_Main_Form;

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
