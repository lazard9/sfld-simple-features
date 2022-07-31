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

namespace SFLD\includes;
 
class SFLD_Simple
{

    // Unique instance
    private static $_instance = null;

    // Private constructor prevent you from instancing the class with "new".
    private function __construct() {  
    }

    // Method to get the unique instance.
    public static function get_instance() {
        // Create the instance if it does not exist.
        if (!isset(self::$_instance)) {
            self::$_instance = new SFLD_Simple();  
        }

        // Return the unique instance.
        return self::$_instance;
    }

    protected $loader;
    protected $plugin_name;
    protected $plugin_version;

    public function run_dependencies() {

        $this->plugin_name = 'sfld-simple';
        $this->plugin_version = '2.0.0';

        // $this->include();
        $this->init();

	}

    /**
     * Load all dependencies.
     * 
     */
    private function include() : void {

        include_once SFLD_SIMPLE_DIR . 'includes/admin/class-sfld-simple-admin.php';
        include_once SFLD_SIMPLE_DIR . 'includes/public/class-sfld-simple-public.php';
        include_once SFLD_SIMPLE_DIR . 'includes/load-templates/class-sfld-simple-templates.php';
        include_once SFLD_SIMPLE_DIR . 'includes/cpt/class-sfld-simple-cpt.php';
        include_once SFLD_SIMPLE_DIR . 'includes/taxonomy/class-sfld-simple-courses-taxonomies.php';
        include_once SFLD_SIMPLE_DIR . 'includes/taxonomy/class-sfld-simple-professors-taxonomy.php';
        include_once SFLD_SIMPLE_DIR . 'includes/shortcode/class-sfld-simple-shortcode.php';
        include_once SFLD_SIMPLE_DIR . 'includes/meta-box/class-sfld-simple-meta-boxes.php';
        include_once SFLD_SIMPLE_DIR . 'includes/ajax/class-sfld-simple-ajax-vote.php';
        include_once SFLD_SIMPLE_DIR . 'includes/ajax/class-sfld-simple-ajax-load-more.php';
        include_once SFLD_SIMPLE_DIR . 'includes/gdpr/class-sfld-simple-woo-gdpr.php';
        require_once SFLD_SIMPLE_DIR . 'includes/class-sfld-simple-loader.php';

    }

    /**
     * Initialize all dependencies.
     * 
     */
    private function init() : void {

        $this->loader = new SFLD_Simple_Loader();

        $this->define_admin_hooks();
        $this->define_public_hooks();
        $this->define_template_hooks();
        $this->define_cpt_hooks();
        $this->define_taxonomy_hooks();
        $this->define_shortcode_hooks();
        $this->define_meta_boxes();
        $this->define_ajax_vote();
        $this->define_ajax_load_more();
        $this->define_woo_gdpr();
        $this->define_test();
        
    }

    /**
     * Run the loader to execute all of the hooks with WordPress.
     *
     */
    public function run_hooks() : void {
        $this->loader->run();
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

    private function define_admin_hooks() : void {

        $plugin_admin = new admin\SFLD_Simple_Admin( $this->get_plugin_name(), $this->get_plugin_version() );
        $this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'sfld_enqueue_admin_assets' );

        // $plugin_admin_links = new SFLD_Simple_Admin_Links();
        $this->loader->add_filter( $plugin_admin->admin_links->get_plugin_action_links(), $plugin_admin->admin_links, 'sfld_simple_add_settings_link' );

        // $plugin_admin_pages = new SFLD_Simple_Admin_Pages();
        $this->loader->add_action( 'admin_menu', $plugin_admin->admin_pages, 'sfld_simple_settings_page' );
        $this->loader->add_action( 'admin_init', $plugin_admin->admin_pages, 'sfld_simple_description_options' );
        
        // $plugin_admin_form_settings = new SFLD_Simple_Admin_Form();
        $this->loader->add_action( 'admin_init', $plugin_admin->admin_form_settings, 'sfld_simple_admin_form_init' );

        // $plugin_admin_main_settings = new SFLD_Simple_Main_Form();
        $this->loader->add_action( 'admin_init', $plugin_admin->admin_main_settings, 'sfld_simple_main_form_init' );
        
    }
    
    private function define_public_hooks() : void {

        $plugin_public = new frontend\SFLD_Simple_Public( $this->get_plugin_name(), $this->get_plugin_version() );
        $this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'sfld_enqueue_frontend_assets' );

    }

    private function define_template_hooks() : void {

        $plugin_templates = new templates\SFLD_Simple_Templates();
        $this->loader->add_filter( 'single_template', $plugin_templates, 'sfld_template_course' );
        $this->loader->add_filter( 'template_include', $plugin_templates, 'sfld_template_arcive_courses' );

    }

    private function define_cpt_hooks() : void {

        $plugin_cpt = new cpt\SFLD_Simple_CPT();
        $this->loader->add_filter( 'init', $plugin_cpt, 'sfld_simple_cpt_init' );

    }

    private function define_taxonomy_hooks() : void {

        $courses_taxonies = new taxonomy\SFLD_Simple_Courses_Taxonomies();
        $this->loader->add_filter( 'init', $courses_taxonies, 'sfld_simple_courses_taxonomies_init', 0 );
        $this->loader->add_action( 'save_post', $courses_taxonies, 'sfld_set_default_object_terms', 100, 2 );
        $this->loader->add_action( 'init', $courses_taxonies, 'sfld_cleanup_level_taxonomy_terms' );
        $this->loader->add_action( 'init', $courses_taxonies, 'sfld_insert_level_taxonomy_terms', 999 );
        $this->loader->add_action( 'add_meta_boxes', $courses_taxonies, 'sfld_add_level_meta_box' );
        $this->loader->add_action( 'save_post', $courses_taxonies, 'sfld_save_level_taxonomy' );

        $professors_taxony = new taxonomy\SFLD_Simple_Professors_Taxonomy();
        $this->loader->add_filter( 'init', $professors_taxony, 'sfld_simple_professors_taxonomy_init', 0 );
        $this->loader->add_action( 'save_post', $professors_taxony, 'sfld_insert_curriculums_taxonomy_terms', 100, 2 );

    }

    private function define_shortcode_hooks() : void {

        $plugin_shortcode = new shortcode\SFLD_Simple_Shortcode();
        $this->loader->add_shortcode( 'swiper-slider-01', $plugin_shortcode, 'sfld_create_shortcode_swiper' );
        
    }

    private function define_meta_boxes() : void {

        $plugin_meta_boxes = new metabox\SFLD_Simple_Meta_Boxes();
        $this->loader->add_action( 'add_meta_boxes', $plugin_meta_boxes, 'sfld_select_editor' );
        $this->loader->add_action( 'save_post', $plugin_meta_boxes, 'sfld_save_editor' );
        $this->loader->add_action( 'add_meta_boxes', $plugin_meta_boxes, 'sfld_courses_details_main' );
        $this->loader->add_action( 'save_post', $plugin_meta_boxes, 'sfld_save_course_details' );
        
    }

    private function define_ajax_vote() : void {

        $plugin_ajax_vote = new ajax\SFLD_Simple_Ajax_Vote();
        $this->loader->add_action( 'wp_ajax_sfld_ajax_user_vote', $plugin_ajax_vote, 'sfld_ajax_user_vote' );
        $this->loader->add_action( 'wp_ajax_nopriv_sfld_ajax_must_login', $plugin_ajax_vote, 'sfld_ajax_must_login' );
        
    }

    private function define_ajax_load_more() : void {

        $plugin_ajax_load_more = new ajax\SFLD_Simple_Ajax_Load_More();
        $this->loader->add_action( 'wp_ajax_sfld_ajax_load_more_posts', $plugin_ajax_load_more, 'sfld_ajax_load_more_posts' );
        $this->loader->add_action( 'wp_ajax_nopriv_sfld_ajax_load_more_posts', $plugin_ajax_load_more, 'sfld_ajax_load_more_posts' );

        // add_action('wp_ajax_weichie_load_more', 'weichie_load_more');
        // add_action('wp_ajax_nopriv_weichie_load_more', 'weichie_load_more');
        
    }
    
    private function define_woo_gdpr() : void {

        $plugin_woo_gdpr = new gdpr\SFLD_Simple_Woo_GDPR();
        $this->loader->add_action('comment_form_logged_in_after', $plugin_woo_gdpr, 'sfld_additional_fields');
        $this->loader->add_action('comment_form_after_fields', $plugin_woo_gdpr, 'sfld_additional_fields');
        $this->loader->add_action('comment_post', $plugin_woo_gdpr, 'sfld_save_comment_meta_data');
        $this->loader->add_filter('preprocess_comment', $plugin_woo_gdpr, 'sfld_verify_comment_meta_data');
        $this->loader->add_action('add_meta_boxes_comment', $plugin_woo_gdpr, 'sfld_extend_comment_add_meta_box');
        $this->loader-> add_action('edit_comment', $plugin_woo_gdpr, 'sfld_extend_comment_edit_metafields');
        
    }

    private function define_test() : void {

        $plugin_test = new test\SFLD_Simple_Test();
        
    }

}
