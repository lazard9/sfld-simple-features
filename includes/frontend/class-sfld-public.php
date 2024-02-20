<?php defined('WPINC') or die();

/**
 * The public-facing functionality of the plugin.
 *
 * @package SFLD Simple Features
 */

namespace SFLD\Includes\Frontend;

use SFLD\Includes\Abstracts\SFLD_Singleton;

if (!class_exists('SFLD_Public', false)) : class SFLD_Public extends SFLD_Singleton
    {

        private $plugin_name;
        private $plugin_version;
        /**
         * Protected class constructor to prevent direct object creation
         *
         */
        protected function __construct()
        {
        }

        public function init($plugin_name, $plugin_version): void
        {

            $this->plugin_name = $plugin_name;
            $this->plugin_version = $plugin_version;
        }

        /**
         * Register frontend assets for the public-facing side of the site.
         *
         */
        public function sfld_enqueue_frontend_assets(): void
        {

            /**
             * Check if Swiper plugin is active,
             * to prevent double loading of the same resources.
             * 
             */
            if (!is_plugin_active('wp-swiper/wp-swiper.php')) {

                wp_enqueue_style(
                    $this->plugin_name . '-swiper-bundle',
                    SFLD_SIMPLE_URL . 'assets/vendor/css/swiper-bundle.min.css',
                    [],
                    $this->plugin_version
                );

                wp_enqueue_script(
                    $this->plugin_name . '-swiper-bundle',
                    SFLD_SIMPLE_URL . 'assets/vendor/js/swiper-bundle.min.js',
                    NULL,
                    $this->plugin_version,
                    true
                );
            }

            wp_enqueue_style(
                $this->plugin_name . '-frontend-style',
                SFLD_SIMPLE_URL . 'assets/build/css/frontend.css',
                [],
                $this->plugin_version
            );

            wp_enqueue_script(
                $this->plugin_name . "-frontend-script",
                SFLD_SIMPLE_URL . 'assets/build/js/frontend.bundle.js',
                ['jquery'],
                $this->plugin_version,
                true
            );

            wp_localize_script(
                $this->plugin_name . "-frontend-script",
                'ajaxConfig',
                [
                    'ajaxUrl' => admin_url('admin-ajax.php'),
                    'ajax_nonce' => wp_create_nonce('load_more_post_nonce'),
                    'enable_infinite_scroll' => get_option('sfld_main_settings') ?? ['checkbox-ajax']
                ]
            );
        }
    }
endif;
