<?php defined('WPINC') or die();

/**
 * The admin-specific functionality of the plugin.
 *
 * @package SFLD Simple Features
 */

namespace SFLD\Includes\Admin;

use SFLD\Includes\Abstracts\SFLD_Singleton;
use SFLD\Includes\Admin\Settings\SFLD_Admin_Form;
use SFLD\Includes\Admin\Settings\SFLD_Main_Form;

if (!class_exists('SFLD_Admin_Pages', false)) : class SFLD_Admin_Pages extends SFLD_Singleton
    {
        /**
         * Protected class constructor to prevent direct object creation
         *
         */
        protected function __construct()
        {
        }

        public function admin_form_init(): object
        {
            return new SFLD_Admin_Form;
        }

        public function main_form_init(): object
        {
            return new SFLD_Main_Form;
        }

        /**
         * Admin pages & sub pages.
         * 
         */
        public function sfld_simple_settings_page(): void
        {

            add_menu_page(
                __('Simple Features Plugin Options', 'sfldsimple'), // Name of the plugin
                __('SFLD', 'sfldsimple'), // Menu name of the plugin
                'manage_options',
                'sfld_settings',
                [$this, 'sfld_simple_settings_page_markup'],
                'dashicons-screenoptions',
                100
            );

            // add_submenu_page( string $parent_slug, string $page_title, string $menu_title, string $capability, string $menu_slug, callable $callback = '', int|float $position = null )
            add_submenu_page(
                'sfld_settings',
                __('SFLD various form fields', 'sfldsimple'),
                __('Form', 'sfldsimple'),
                'manage_options',
                'sfld_form',
                [$this, 'sfld_simple_form_subpage_markup'],
            );

            add_submenu_page(
                'sfld_settings',
                __('SFLD Description', 'sfldsimple'),
                __('Description', 'sfldsimple'),
                'manage_options',
                'sfld_description',
                [$this, 'sfld_simple_descriptio_subpage_markup']
            );

            /**
             * Adds a submenu page for the CPT Courses.
             * 
             */
            add_submenu_page(
                'edit.php?post_type=courses',
                __('SFLD Simple Default Sub Page', 'sfldsimple'),
                __('SFLD Sub Page', 'sfldsimple'),
                'manage_options',
                'sfld_subpage',
                [$this, 'sfld_simple_courses_submenu_page_markup'],
            );

            /**
             * Adds a submenu page for the management page (tools).
             * 
             */
            // Can add page as a submenu using the following:
            // add_dashboard_page()
            // add_posts_page()
            // add_media_page()
            // add_pages_page()
            // add_comments_page()
            // add_theme_page()
            // add_plugins_page()
            // add_users_page()
            // add_management_page()
            // add_options_page()

            add_management_page(
                __('SFLD Simple Sub Page Info', 'sfldsimple'),
                __('SFLD Info', 'sfldsimple'),
                'manage_options',
                'sfld_info',
                [$this, 'sfld_simple_management_submenu_page_markup']
            );
        }

        /**
         * Display callback for the menu page.
         * 
         */
        public function sfld_simple_settings_page_markup(): void
        {
            // Double check user capabilities
            if (!current_user_can('manage_options')) {
                return;
            }

            include SFLD_SIMPLE_DIR . 'includes/admin/templates/template-main.php';
        }

        /**
         * Display callback for the Form submenu page.
         * 
         */
        public function sfld_simple_form_subpage_markup(): void
        {
            // Double check user capabilities
            if (!current_user_can('manage_options')) {
                return;
            }

            include SFLD_SIMPLE_DIR . 'includes/admin/templates/template-form.php';
        }

        /**
         * Add and save options (sfld_simple_options)
         * for the Description submenu page.
         * 
         */
        public function sfld_simple_description_options()
        {

            // $options = [
            //   'First Name',
            //   'Second Option',
            //   'Third Option'
            // ];

            $options = [];
            $options['name']      = 'Lazar Dacic';
            $options['location']  = 'Serbia';
            $options['sponsor']   = 'Plugin Dev. Co.';

            if (!get_option('sfld_simple_options')) {
                add_option('sfld_simple_options', $options);
            }
            update_option('sfld_simple_options', $options);
            // delete_option( 'sfld_simple_options' );

        }

        /**
         * Display callback for the Description submenu page.
         * 
         */
        function sfld_simple_descriptio_subpage_markup()
        {
            // Double check user capabilities
            if (!current_user_can('manage_options')) {
                return;
            }

            include SFLD_SIMPLE_DIR . 'includes/admin/templates/template-description.php';
        }

        /**
         * Display callback for CPT Courses the submenu page.
         * 
         */
        public function sfld_simple_courses_submenu_page_markup(): void
        {

            include SFLD_SIMPLE_DIR . 'includes/admin/templates/template-cpt-courses.php';
        }

        /**
         * Display callback for the submenu management (tools) page.
         * 
         */
        public function sfld_simple_management_submenu_page_markup(): void
        {

            include SFLD_SIMPLE_DIR . 'includes/admin/templates/template-management.php';
        }
    }
endif;
