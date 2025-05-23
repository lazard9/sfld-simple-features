<?php defined('WPINC') or die();

/**
 * The admin-specific functionality of the plugin.
 *
 * @package SFLD Simple Features
 */

namespace SFLD\Includes\Admin;

use SFLD\Includes\Abstracts\SFLD_Singleton;

if (!class_exists('SFLD_Admin', false)) : class SFLD_Admin extends SFLD_Singleton
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

            $this->includes(); // Include files witout the autoloader

        }

        private function includes(): void
        {

            if (!file_exists(SFLD_SIMPLE_DIR . 'lib/autoloader.php')) {

                // Include files witout the autoloader
                include_once SFLD_SIMPLE_DIR . 'includes/admin/class-sfld-admin-pages.php';
                include_once SFLD_SIMPLE_DIR . 'includes/admin/settings/class-sfld-admin-form.php';
                include_once SFLD_SIMPLE_DIR . 'includes/admin/settings/class-sfld-main-form.php';
            }
        }

        /**
         * Add a link to your settings page in your plugin
         * 
         */
        public function sfld_settings_link($links): array
        {

            $settings_link = '<a href="admin.php?page=sfld_settings">' . __('Settings', 'sfldsimple') . '</a>';
            array_push($links, $settings_link);
            return $links;
        }

        /**
         * Retrieve the plugin action links.
         * 
         */
        public function get_plugin_action_links(): string
        {

            return "plugin_action_links_" . SFLD_SIMPLE_BASENAME;
        }

        /**
         * Register admin assets.
         *
         */
        public function sfld_enqueue_admin_assets(): void
        {

            wp_enqueue_style(
                $this->plugin_name . '-admin-style',
                SFLD_SIMPLE_URL . 'assets/build/css/admin.css',
                [],
                $this->plugin_version
            );

            wp_enqueue_script(
                $this->plugin_name . "-main",
                SFLD_SIMPLE_URL . 'assets/build/js/admin.bundle.js',
                [],
                $this->plugin_version,
                true
            );
        }
    }
endif;
