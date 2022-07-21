<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @package SFLD Simple Features
 */

class SFLD_Simple_Public {

    /**
     * Register frontend assets for the public-facing side of the site.
     *
     * 
     */
    public function __construct( $plugin_name, $plugin_version ) {

        $this->plugin_name = $plugin_name;
        $this->plugin_version = $plugin_version;

    }

    public function sfld_enqueue_frontend_assets() : void {
        wp_enqueue_style(
			$this->plugin_name . '-front-style',
			SFLD_SIMPLE_URL . 'assets/css/frontend.css',
			[],
			$this->plugin_version
        );

        wp_enqueue_script( 
            $this->plugin_name . "-ajax-voter-script",
            SFLD_SIMPLE_URL . 'assets/js/ajax-voter.js',
            ['jquery'],
            $this->plugin_version,
            true
        );

        wp_localize_script( 
            $this->plugin_name . "-ajax-voter-script", 
            'myAjax', 
            array( 'ajaxurl' => admin_url( 'admin-ajax.php' )),
        );

        wp_enqueue_script( 
            $this->plugin_name . "-ajax-load-script",
            SFLD_SIMPLE_URL . 'assets/js/ajax-load-more.js',
            ['jquery'],
            $this->plugin_version,
            true
        );

        // wp_localize_script( 
        //     $this->plugin_name . "-ajax-load-script", 
        //     'ajax_posts', 
        //     array( 'ajaxurl' => admin_url( 'admin-ajax.php' )),
        // );

        wp_enqueue_style(
            $this->plugin_name . '-swiper-bundle',
            SFLD_SIMPLE_URL . 'public/plugins/css/swiper-bundle.min.css',
			[],
			$this->plugin_version
        );

        wp_enqueue_script(
            $this->plugin_name . '-swiper-bundle',
            SFLD_SIMPLE_URL . 'public/plugins/js/swiper-bundle.min.js',
            NULL,
            $this->plugin_version,
            true
        );

        wp_enqueue_script(
            $this->plugin_name . '-swiper-initialize',
            SFLD_SIMPLE_URL . 'public/plugins/js/swiper-initialize.js',
            NULL,
            $this->plugin_version,
            true
        );

    }

}
