<?php

/**
 * 
 * Table of Contents (number is code line):
 * 
 * Include admin scripts
 * Include frontend scripts
 * Include Swiper.js plugin scripts
 * Admin pages - menu page, for CPT courses, under Tools
 * Admin pages - settings and forms
 * Load Course Template - with Swiper.js plugin carousel
 * Load Archive Courses Template - with Ajax load more button
 * Register CPT Courses
 * Register CPT Professors
 * Register Custom Taxonomies for CPT Courses with additional functionalities for tax Level
 * Tax Level has only 4 terms, custom metabox with input type radio (only one option can be selected)
 * Taxonomies Level, Subject, Topics in draft have autosave set to term Any
 * Register Custom Taxonomies for CPT Professors and autopopulate
 * Register Shortcode to display Swiper.js slider in Course Template
 * Metabox - Select Editor
 * Save Editor to Post Meta
 * Metabox - Add Custom Fields - Courses
 * Save Course Details to custom DB table
 * Woo GDPR Complience Checkbox for the Comments/Reviews
 * 
 * @package SFLD Simple Features
 *  
 */

namespace SFLD\Includes;
use SFLD\Includes\Abstracts\SFLD_Singleton;

final class SFLD_Simple_Features extends SFLD_Singleton
{

    private $loader;
    private $plugin_name;
    private $plugin_version;


    /**
     * Protected class constructor to prevent direct object creation
     *
     * This is meant to be overridden in the classes which implement
     * this trait. This is ideal for doing stuff that you only want to
     * do once, such as hooking into actions and filters, etc.
     */
    protected function __construct() {  

        $this->plugin_name = 'sfldsimple';
        $this->plugin_version = '2.0.0';

        $this->include(); // Include files witout the autoloader
        $this->init();
        $this->init_hooks();

    }

    /**
     * Load all dependencies.
     * 
     */
    private function include() : void {

        if ( ! file_exists( SFLD_SIMPLE_DIR . 'lib/autoloader.php' ) ) {

            // Include files witout the autoloader
            include_once SFLD_SIMPLE_DIR . 'includes/class-sfld-loader.php';
            include_once SFLD_SIMPLE_DIR . 'includes/admin/class-sfld-admin.php';
            include_once SFLD_SIMPLE_DIR . 'includes/frontend/class-sfld-public.php';
            include_once SFLD_SIMPLE_DIR . 'includes/templates/class-sfld-templates.php';
            include_once SFLD_SIMPLE_DIR . 'includes/cpt/class-sfld-cpt.php';
            include_once SFLD_SIMPLE_DIR . 'includes/cpt/class-sfld-select-editor.php';
            include_once SFLD_SIMPLE_DIR . 'includes/cpt/class-sfld-courses-details.php';
            include_once SFLD_SIMPLE_DIR . 'includes/taxonomies/class-sfld-taxonomies.php';
            include_once SFLD_SIMPLE_DIR . 'includes/shortcodes/class-sfld-shortcodes.php';
            include_once SFLD_SIMPLE_DIR . 'includes/ajax/class-sfld-ajax-vote.php';
            include_once SFLD_SIMPLE_DIR . 'includes/ajax/class-sfld-ajax-load-more.php';
            include_once SFLD_SIMPLE_DIR . 'includes/gdpr/class-sfld-woo-gdpr.php';
            include_once SFLD_SIMPLE_DIR . 'includes/test/class-sfld-test.php';

        }

    }

    /**
     * Initialize all dependencies.
     * 
     */
    private function init() : void {

        $this->loader = SFLD_Loader::get_instance();

        $this->define_admin_hooks();
        $this->define_public_hooks();
        
        $this->define_template_hooks();
        $this->define_cpt_hooks();
        $this->define_taxonomy_hooks();
        $this->define_shortcode_hooks();
        $this->define_ajax_hooks();
        $this->define_gdpr_hooks();
        
        Test\SFLD_Test::get_instance();
        
    }

    /**
     * Retrieve the name of the plugin used to uniquely identify it.
     * 
     */
    public function get_plugin_name() : string {
        return $this->plugin_name;
    }

    /**
     * Retrieve the version number of the plugin.
     * 
     */
    public function get_plugin_version() : string {
        return $this->plugin_version;
    }

     /**
     * Run the loader to execute all of the hooks with WordPress.
     *
     */
    public function init_hooks() : void {
        $this->loader->run_hooks();
    }

    /**
     * Define all hooks & register shortcodes.
     * 
     */
    private function define_admin_hooks() : void {

        $plugin_admin = Admin\SFLD_Admin::get_instance();
        $plugin_admin->init( $this->get_plugin_name(), $this->get_plugin_version() );
        $this->loader->add_filter( $plugin_admin->get_plugin_action_links(), $plugin_admin, 'sfld_settings_link' );
        $this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'sfld_enqueue_admin_assets' );

        $plugin_admin_pages = Admin\SFLD_Admin_Pages::get_instance();
        $this->loader->add_action( 'admin_menu', $plugin_admin_pages, 'sfld_simple_settings_page' );
        $this->loader->add_action( 'admin_init', $plugin_admin_pages, 'sfld_simple_description_options' );
        $this->loader->add_action( 'admin_init', $plugin_admin_pages->admin_form_init(), 'sfld_simple_admin_form_init' );
        $this->loader->add_action( 'admin_init', $plugin_admin_pages->main_form_init(), 'sfld_simple_main_form_init' );
        
    }
    
    private function define_public_hooks() : void {

        $plugin_public = Frontend\SFLD_Public::get_instance();
        $plugin_public->init( $this->get_plugin_name(), $this->get_plugin_version() );
        $this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'sfld_enqueue_frontend_assets' );

    }

    private function define_template_hooks() : void {

        $plugin_templates = Templates\SFLD_Templates::get_instance();
        $this->loader->add_filter( 'single_template', $plugin_templates, 'sfld_template_course' );
        $this->loader->add_filter( 'template_include', $plugin_templates, 'sfld_template_arcive_courses' );

    }

    private function define_cpt_hooks() : void {

        $plugin_cpt = CPT\SFLD_CPT::get_instance();
        $this->loader->add_filter( 'init', $plugin_cpt, 'sfld_register_cpt' );

        $plugin_select_editor = CPT\SFLD_Select_Editor::get_instance();
        $this->loader->add_action( 'add_meta_boxes', $plugin_select_editor, 'sfld_select_editor_main' );
        $this->loader->add_action( 'save_post', $plugin_select_editor, 'sfld_save_editor' );

        $plugin_courses_details = CPT\SFLD_Courses_Details::get_instance();
        $this->loader->add_action( 'add_meta_boxes', $plugin_courses_details, 'sfld_courses_details_main' );
        $this->loader->add_action( 'save_post', $plugin_courses_details, 'sfld_save_course_details' );

    }

    private function define_taxonomy_hooks() : void {

        $plugin_taxonomies = Taxonomies\SFLD_Taxonomies::get_instance();
        // Professors CPT
        $this->loader->add_filter( 'init', $plugin_taxonomies, 'sfld_register_curriculum_taxonomy', 0 );
        $this->loader->add_action( 'save_post', $plugin_taxonomies, 'sfld_insert_curriculum_taxonomy_terms', 100, 2 );
        // Courses CPT
        $this->loader->add_filter( 'init', $plugin_taxonomies, 'sfld_register_courses_taxonomies', 0 );
        $this->loader->add_action( 'save_post', $plugin_taxonomies, 'sfld_set_default_object_terms', 100, 2 );
        $this->loader->add_action( 'init', $plugin_taxonomies, 'sfld_cleanup_level_taxonomy_terms' );
        $this->loader->add_action( 'init', $plugin_taxonomies, 'sfld_insert_level_taxonomy_terms', 999 );
        $this->loader->add_action( 'add_meta_boxes', $plugin_taxonomies, 'sfld_level_meta_box' );
        $this->loader->add_action( 'save_post', $plugin_taxonomies, 'sfld_save_level_taxonomy' );

    }

    private function define_shortcode_hooks() : void {

        $plugin_shortcode = Shortcodes\SFLD_Shortcodes::get_instance();
        // Usage echo do_shortcode('[swiper_slider_01]');
        $this->loader->add_shortcode( 'swiper_slider_01', $plugin_shortcode, 'sfld_swiper_shortcode' );
        // Usage echo do_shortcode('[ajax_load_more]');
	    $this->loader->add_shortcode( 'ajax_load_more', $plugin_shortcode, 'sfld_ajax_lm_shortcode' );
        
    }

    private function define_ajax_hooks() : void {

        $plugin_ajax_vote = Ajax\SFLD_Ajax_Vote::get_instance();
        $this->loader->add_action( 'wp_ajax_sfld_ajax_user_vote', $plugin_ajax_vote, 'sfld_ajax_user_vote' );
        $this->loader->add_action( 'wp_ajax_nopriv_sfld_ajax_must_login', $plugin_ajax_vote, 'sfld_ajax_must_login' );

        $plugin_ajax_load_more = Ajax\SFLD_Ajax_Load_More::get_instance();
        $this->loader->add_action( 'wp_ajax_load_more', $plugin_ajax_load_more, 'sfld_ajax_load_more_posts' );
        $this->loader->add_action( 'wp_ajax_nopriv_load_more', $plugin_ajax_load_more, 'sfld_ajax_load_more_posts' );
        
    }
    
    private function define_gdpr_hooks() : void {

        $plugin_woo_gdpr = GDPR\SFLD_Woo_GDPR::get_instance();
        $this->loader->add_action('comment_form_logged_in_after', $plugin_woo_gdpr, 'sfld_additional_fields');
        $this->loader->add_action('comment_form_after_fields', $plugin_woo_gdpr, 'sfld_additional_fields');
        $this->loader->add_action('comment_post', $plugin_woo_gdpr, 'sfld_save_comment_meta_data');
        $this->loader->add_filter('preprocess_comment', $plugin_woo_gdpr, 'sfld_verify_comment_meta_data');
        $this->loader->add_action('add_meta_boxes_comment', $plugin_woo_gdpr, 'sfld_extend_comment_add_meta_box');
        $this->loader->add_action('edit_comment', $plugin_woo_gdpr, 'sfld_extend_comment_edit_metafields');
        
    }

}
