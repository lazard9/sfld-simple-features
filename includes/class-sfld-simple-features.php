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
use SFLD\Includes\Base\SFLD_Singleton;

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

        // $this->include(); // Include files witout the autoloader
        $this->init();
        $this->init_hooks();

    }

    /**
     * Load all dependencies.
     * 
     */
    // private function include() : void {

    //     include_once SFLD_SIMPLE_DIR . 'includes/class-sfld-loader.php';

    //     include_once SFLD_SIMPLE_DIR . 'includes/admin/class-sfld-admin.php';
    //     include_once SFLD_SIMPLE_DIR . 'includes/public/class-sfld-public.php';
    //     include_once SFLD_SIMPLE_DIR . 'includes/templates/class-sfld-templates.php';
    //     include_once SFLD_SIMPLE_DIR . 'includes/cpt/class-sfld-cpt.php';
    //     include_once SFLD_SIMPLE_DIR . 'includes/taxonomies/class-sfld-taxonomies.php';
    //     include_once SFLD_SIMPLE_DIR . 'includes/shortcodes/class-sfld-shortcode.php';
    //     include_once SFLD_SIMPLE_DIR . 'includes/metabox/class-sfld-meta-boxes.php';
    //     include_once SFLD_SIMPLE_DIR . 'includes/ajax/class-sfld-ajax-vote.php';
    //     include_once SFLD_SIMPLE_DIR . 'includes/ajax/class-sfld-ajax-load-more.php';
    //     include_once SFLD_SIMPLE_DIR . 'includes/gdpr/class-sfld-woo-gdpr.php';
    //     include_once SFLD_SIMPLE_DIR . 'includes/test/class-sfld-test.php';

    // }

    /**
     * Initialize all dependencies.
     * 
     */
    private function init() : void {

        $this->loader = SFLD_Loader::getInstance();

        $this->define_admin_hooks();
        $this->define_public_hooks();
        
        $this->define_template_hooks();
        $this->define_cpt_hooks();
        $this->define_taxonomy_hooks();
        $this->define_shortcode_hooks();
        $this->define_metabox_hooks();
        $this->define_ajax_hooks();
        $this->define_gdpr_hooks();
        $this->define_test();
        
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

        $plugin_admin = new Admin\SFLD_Admin( $this->get_plugin_name(), $this->get_plugin_version() );
        $this->loader->add_filter( $plugin_admin->get_plugin_action_links(), $plugin_admin, 'sfld_settings_link' );
        $this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'sfld_enqueue_admin_assets' );

        $plugin_admin_pages = new Admin\SFLD_Admin_Pages();
        $this->loader->add_action( 'admin_menu', $plugin_admin_pages, 'sfld_simple_settings_page' );
        $this->loader->add_action( 'admin_init', $plugin_admin_pages, 'sfld_simple_description_options' );
        $this->loader->add_action( 'admin_init', $plugin_admin_pages->admin_form_init(), 'sfld_simple_admin_form_init' );
        $this->loader->add_action( 'admin_init', $plugin_admin_pages->main_form_init(), 'sfld_simple_main_form_init' );
        
    }
    
    private function define_public_hooks() : void {

        $plugin_public = new frontend\SFLD_Public( $this->get_plugin_name(), $this->get_plugin_version() );
        $this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'sfld_enqueue_frontend_assets' );

    }

    private function define_template_hooks() : void {

        $plugin_templates = new Templates\SFLD_Templates();
        $this->loader->add_filter( 'single_template', $plugin_templates, 'sfld_template_course' );
        $this->loader->add_filter( 'template_include', $plugin_templates, 'sfld_template_arcive_courses' );

    }

    private function define_cpt_hooks() : void {

        $plugin_cpt = new CPT\SFLD_CPT();
        $this->loader->add_filter( 'init', $plugin_cpt, 'sfld_register_cpt' );

    }

    private function define_taxonomy_hooks() : void {

        $plugin_taxonies = new Taxonomies\SFLD_Taxonomies();
        // Professors CPT
        $this->loader->add_filter( 'init', $plugin_taxonies, 'sfld_register_curriculum_taxonomy', 0 );
        $this->loader->add_action( 'save_post', $plugin_taxonies, 'sfld_insert_curriculum_taxonomy_terms', 100, 2 );
        // Courses CPT
        $this->loader->add_filter( 'init', $plugin_taxonies, 'sfld_register_courses_taxonomies', 0 );
        $this->loader->add_action( 'save_post', $plugin_taxonies, 'sfld_set_default_object_terms', 100, 2 );
        $this->loader->add_action( 'init', $plugin_taxonies, 'sfld_cleanup_level_taxonomy_terms' );
        $this->loader->add_action( 'init', $plugin_taxonies, 'sfld_insert_level_taxonomy_terms', 999 );

    }

    private function define_shortcode_hooks() : void {

        $plugin_shortcode = new Shortcodes\SFLD_Shortcodes();
        // Usage echo do_shortcode('[swiper_slider_01]');
        $this->loader->add_shortcode( 'swiper_slider_01', $plugin_shortcode, 'sfld_swiper_shortcode' );
        // Usage echo do_shortcode('[ajax_load_more]');
	    $this->loader->add_shortcode( 'ajax_load_more', $plugin_shortcode, 'sfld_ajax_lm_shortcode' );
        
    }

    private function define_metabox_hooks() : void {

        $plugin_meta_boxes = new Metabox\SFLD_Meta_Boxes();
        $this->loader->add_action( 'add_meta_boxes', $plugin_meta_boxes, 'sfld_select_editor' );
        $this->loader->add_action( 'save_post', $plugin_meta_boxes, 'sfld_save_editor' );
        $this->loader->add_action( 'add_meta_boxes', $plugin_meta_boxes, 'sfld_courses_details_main' );
        $this->loader->add_action( 'save_post', $plugin_meta_boxes, 'sfld_save_course_details' );
        $this->loader->add_action( 'add_meta_boxes', $plugin_meta_boxes, 'sfld_level_meta_box' );
        $this->loader->add_action( 'save_post', $plugin_meta_boxes, 'sfld_save_level_taxonomy' );
        
    }

    private function define_ajax_hooks() : void {

        $plugin_ajax_vote = new Ajax\SFLD_Ajax_Vote();
        $this->loader->add_action( 'wp_ajax_sfld_ajax_user_vote', $plugin_ajax_vote, 'sfld_ajax_user_vote' );
        $this->loader->add_action( 'wp_ajax_nopriv_sfld_ajax_must_login', $plugin_ajax_vote, 'sfld_ajax_must_login' );

        $plugin_ajax_load_more = new Ajax\SFLD_Ajax_Load_More();
        $this->loader->add_action( 'wp_ajax_load_more', $plugin_ajax_load_more, 'sfld_ajax_load_more_posts' );
        $this->loader->add_action( 'wp_ajax_nopriv_load_more', $plugin_ajax_load_more, 'sfld_ajax_load_more_posts' );
        
    }
    
    private function define_gdpr_hooks() : void {

        $plugin_woo_gdpr = new GDPR\SFLD_Woo_GDPR();
        $this->loader->add_action('comment_form_logged_in_after', $plugin_woo_gdpr, 'sfld_additional_fields');
        $this->loader->add_action('comment_form_after_fields', $plugin_woo_gdpr, 'sfld_additional_fields');
        $this->loader->add_action('comment_post', $plugin_woo_gdpr, 'sfld_save_comment_meta_data');
        $this->loader->add_filter('preprocess_comment', $plugin_woo_gdpr, 'sfld_verify_comment_meta_data');
        $this->loader->add_action('add_meta_boxes_comment', $plugin_woo_gdpr, 'sfld_extend_comment_add_meta_box');
        $this->loader->add_action('edit_comment', $plugin_woo_gdpr, 'sfld_extend_comment_edit_metafields');
        
    }

    private function define_test() : void {
        new Test\SFLD_Test();
    }

}
