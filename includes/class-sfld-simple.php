<?php

/**
 * 
 * Table of Contents (number is code line):
 * 
 * Include admin scripts
 * Include admin scripts
 * Admin pages - menu page, for CPT courses, under Tools
 * Load Course Template
 * Load Archive Courses Template
 * Register CPT Courses
 * Register CPT Professors
 * Register Custom Taxonomies for CPT Courses with additional functionalities for tax Level
 * Register Custom Taxonomies for CPT Professors and autopopulate
 * Register Shortcode to display Swiper.js slider in Course Template
 * Metabox - Select Editor
 * Save Editor to Post Meta
 * Metabox - Add Custom Fields - Courses
 * Save Course Details to the DB
 * 
 * @package SFLD Simple Features
 *  
 */

 
class SFLD_Simple
{

    protected $loader;
    protected $plugin_name;
    protected $plugin_version;

    function __construct() {

        $this->plugin_name = 'sfld-simple';
        $this->plugin_version = '2.0.0';

        $this->load_dependencies();

        $this->define_admin_hooks();
        $this->define_admin_pages_hooks();
        $this->define_public_hooks();
        $this->define_template_hooks();
        $this->define_cpt_hooks();
        $this->define_taxonomy_hooks();
        $this->define_shortcode_hooks();
        $this->define_meta_boxes();
        $this->define_ajax_vote();
        $this->define_ajax_load_more();

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


    private function load_dependencies() : void {

        require_once SFLD_SIMPLE_DIR . 'admin/class-sfld-simple-admin.php';
        require_once SFLD_SIMPLE_DIR . 'admin/class-sfld-simple-admin-pages.php';
        require_once SFLD_SIMPLE_DIR . 'public/class-sfld-simple-public.php';
        require_once SFLD_SIMPLE_DIR . 'includes/class-sfld-simple-templates.php';
        require_once SFLD_SIMPLE_DIR . 'includes/class-sfld-simple-cpt.php';
        require_once SFLD_SIMPLE_DIR . 'includes/class-sfld-simple-courses-taxonomies.php';
        require_once SFLD_SIMPLE_DIR . 'includes/class-sfld-simple-professors-taxonomy.php';
        require_once SFLD_SIMPLE_DIR . 'includes/class-sfld-simple-shortcode.php';
        require_once SFLD_SIMPLE_DIR . 'includes/class-sfld-simple-meta-boxes.php';
        require_once SFLD_SIMPLE_DIR . 'includes/class-sfld-simple-ajax-vote.php';
        require_once SFLD_SIMPLE_DIR . 'includes/class-sfld-simple-ajax-load-more.php';

        require_once SFLD_SIMPLE_DIR . 'includes/class-sfld-simple-loader.php';
        $this->loader = new SFLD_Simple_Loader();

    }

    private function define_admin_hooks() {

        $plugin_admin = new SFLD_Simple_Admin( $this->get_plugin_name(), $this->get_plugin_version() );
        $this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'sfld_enqueue_admin_assets' );
        
    }

    private function define_admin_pages_hooks() {

        $plugin_admin_pages = new SFLD_Simple_Admin_Pages( $this->get_plugin_name(), $this->get_plugin_version() );
        $this->loader->add_action( 'admin_menu', $plugin_admin_pages, 'sfld_simple_settings_page' );
        $this->loader->add_filter( $plugin_admin_pages->get_plugin_action_links(), $plugin_admin_pages, 'sfld_simple_add_settings_link' );
        $this->loader->add_action( 'admin_init', $plugin_admin_pages, 'sfld_simple_options' );
        $this->loader->add_action( 'admin_menu', $plugin_admin_pages, 'sfld_simple_default_sub_pages' );
        
    }
    
    private function define_public_hooks() {

        $plugin_public = new SFLD_Simple_Public( $this->get_plugin_name(), $this->get_plugin_version() );
        $this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'sfld_enqueue_frontend_assets' );

    }

    private function define_template_hooks() {

        $plugin_templates = new SFLD_Simple_Templates();
        $this->loader->add_filter( 'single_template', $plugin_templates, 'sfld_template_course' );
        $this->loader->add_filter( 'template_include', $plugin_templates, 'sfld_template_arcive_courses' );

    }

    private function define_cpt_hooks() {

        $plugin_cpt = new SFLD_Simple_CPT();
        $this->loader->add_filter( 'init', $plugin_cpt, 'sfld_simple_cpt_init' );

    }

    private function define_taxonomy_hooks() {

        $courses_taxonies = new SFLD_Simple_Courses_Taxonomies();
        $this->loader->add_filter( 'init', $courses_taxonies, 'sfld_simple_courses_taxonomies_init', 0 );
        $this->loader->add_action( 'save_post', $courses_taxonies, 'sfld_set_default_object_terms', 100, 2 );
        $this->loader->add_action( 'init', $courses_taxonies, 'sfld_cleanup_level_taxonomy_terms' );
		$this->loader->add_action( 'init', $courses_taxonies, 'sfld_insert_level_taxonomy_terms', 999 );
        $this->loader->add_action( 'add_meta_boxes', $courses_taxonies, 'sfld_add_level_meta_box' );
		$this->loader->add_action( 'save_post', $courses_taxonies, 'sfld_save_level_taxonomy' );

        $professors_taxony = new SFLD_Simple_Professors_Taxonomy();
        $this->loader->add_filter( 'init', $professors_taxony, 'sfld_simple_professors_taxonomy_init', 0 );
        $this->loader->add_action( 'save_post', $professors_taxony, 'sfld_insert_curriculums_taxonomy_terms', 100, 2 );

    }

    private function define_shortcode_hooks() {

        $plugin_shortcode = new SFLD_Simple_Shortcode();
        $this->loader->add_shortcode( 'swiper-slider-01', $plugin_shortcode, 'sfld_create_shortcode_swiper' );
        
    }

    private function define_meta_boxes() {

        $plugin_meta_boxes = new SFLD_Meta_Boxes();
        $this->loader->add_action( 'add_meta_boxes', $plugin_meta_boxes, 'sfld_select_editor' );
        $this->loader->add_action( 'save_post', $plugin_meta_boxes, 'sfld_save_editor' );
        $this->loader->add_action( 'add_meta_boxes', $plugin_meta_boxes, 'sfld_courses_details_main' );
        $this->loader->add_action( 'save_post', $plugin_meta_boxes, 'sfld_save_course_details' );
        
    }

    private function define_ajax_vote() {

        $plugin_ajax_vote = new SFLD_Ajax_Vote();
        $this->loader->add_action( 'wp_ajax_sfld_ajax_user_vote', $plugin_ajax_vote, 'sfld_ajax_user_vote' );
        $this->loader->add_action( 'wp_ajax_nopriv_sfld_ajax_must_login', $plugin_ajax_vote, 'sfld_ajax_must_login' );
        
    }

    private function define_ajax_load_more() {

        $plugin_ajax_load_more = new SFLD_Ajax_Load_More();
        $this->loader->add_action( 'wp_ajax_sfld_ajax_load_more_posts', $plugin_ajax_load_more, 'sfld_ajax_load_more_posts' );
        $this->loader->add_action( 'wp_ajax_nopriv_sfld_ajax_load_more_posts', $plugin_ajax_load_more, 'sfld_ajax_load_more_posts' );
        
    }

    /**
     * Run the loader to execute all of the hooks with WordPress.
     *
     * 
     */
    public function run_hooks() {
        $this->loader->run();
    }
    
}
