<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @package SFLD Simple Features
 */

class SFLD_Simple_Admin_Pages {

    /**
     * Admin pages & sub pages.
     * 
     */
    public function sfld_simple_settings_page() : void {

        add_menu_page(
            __( 'Simple Features Plugin Options', 'sfldsimple' ), // Name of the plugin
            __( 'SFLD', 'sfldsimple' ), // Menu name of the plugin
            'manage_options',
            'sfld-simple',
            [$this, 'sfld_simple_settings_page_markup'],
            'dashicons-screenoptions',
            100
        );
    
        // add_submenu_page( string $parent_slug, string $page_title, string $menu_title, string $capability, string $menu_slug, callable $callback = '', int|float $position = null )
        add_submenu_page(
            'sfld-simple',
            __( 'SFLD various form fields', 'sfldsimple' ),
            __( 'Form', 'sfldsimple' ),
            'manage_options',
            'sfld-simple-form',
            [$this, 'sfld_simple_settings_subpage_markup_2'],
        );

        add_submenu_page(
            'sfld-simple',
            __( 'SFLD Description', 'sfldsimple' ),
            __( 'Description', 'sfldsimple' ),
            'manage_options',
            'sfld-simple-descriptio',
            [$this, 'sfld_simple_example_subpage_markup']
        );

        /**
         * Adds a submenu page for the CPT Courses.
         * 
         */  
        add_submenu_page(
            'edit.php?post_type=courses',
            __( 'SFLD Simple Default Sub Page', 'sfldsimple' ),
            __( 'SFLD Sub Page', 'sfldsimple' ),
            'manage_options',
            'sfld-simple-subpage',
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
            __( 'SFLD Simple Sub Page Info', 'sfldsimple' ),
            __( 'SFLD Info', 'sfldsimple' ),
            'manage_options',
            'sfld-simple-info',
            [$this, 'sfld_simple_management_submenu_page_markup']
        );
    
    }
    
    /**
     * Display callback for the menu page.
     * 
     */
    public function sfld_simple_settings_page_markup() : void {
        // Double check user capabilities
        if ( !current_user_can('manage_options') ) {
            return;
        }
        ?>
        <div class="sfld-simple-wrap">
            <h1><?php esc_html_e( get_admin_page_title() ); ?></h1>
            <p><?php esc_html_e( 'This is one simple plugin with numerous features. :-)', 'sfldsimple' ); ?></p>
        </div>
        <?php
    }
    
    /**
     * Display callback for the submenu page 1.
     * 
     */
    function sfld_simple_example_subpage_markup() {
        // Double check user capabilities
        if ( !current_user_can('manage_options') ) {
            return;
        }
        ?>
        <div class="sfld-simple-wrap">
            <h1><?php esc_html_e( get_admin_page_title() ); ?></h1>
    
            <h2><?php esc_html_e( 'About the author', 'sfldsimple' ); ?></h2>
    
            <?php $options = get_option( 'sfld_simple_options' ); ?>
    
            <?php if ( $options) : ?>
                <ul>
                <?php foreach( $options as $option ): ?>
                    <li><?php echo $option; ?></li>
                <?php endforeach; ?>
                </ul>
    
                <?php if( array_key_exists( 'name', $options ) ): ?>
                    <h2><?php esc_html_e( 'Specific Option', 'sfldsimple' ); ?></h2>
                    <p><?php esc_html_e( $options['sponsor'] ); ?></p>
                <?php endif; ?>
            <?php endif; ?>
        </div>
        <?php
    }

    /**
     * Function for learning how to add options for the first submenu page.
     * 
     */
    public function sfld_simple_example_options() {

        // $options = [
        //   'First Name',
        //   'Second Option',
        //   'Third Option'
        // ];

        $options = [];
        $options['name']      = 'Lazar Dacic';
        $options['location']  = 'Serbia';
        $options['sponsor']   = 'Plugin Dev. Co.';

        if( !get_option( 'sfld_simple_options' ) ) {
            add_option( 'sfld_simple_options', $options );
        }
        update_option( 'sfld_simple_options', $options );
        // delete_option( 'sfld_simple_options' );

    }
    
    /**
     * Display callback for the submenu page 2.
     * 
     */
    public function sfld_simple_settings_subpage_markup_2() : void {
      // Double check user capabilities
        if ( !current_user_can('manage_options') ) {
            return;
        }
        ?>
        <div class="sfld-simple-wrap">
            <h1><?php esc_html_e( get_admin_page_title() ); ?></h1>
            <p><?php esc_html_e( 'Subpage content.', 'sfldsimple' ); ?></p>
        </div>
        <?php
    }
    
    /**
     * Display callback for the submenu page.
     * 
     */
    public function sfld_simple_courses_submenu_page_markup() : void { 
        ?>
        <div class="sfld-simple-wrap">
            <h1><?php esc_html_e( get_admin_page_title() ); ?></h1>
            <p><?php esc_html_e( 'Helpful stuff here!', 'sfldsimple' ); ?></p>
        </div>
        <?php
    }
    
    /**
     * Display callback for the submenu page (tools).
     * 
     */
    public function sfld_simple_management_submenu_page_markup() : void { 
        ?>
        <div class="sfld-simple-wrap">
            <h1><?php esc_html_e( get_admin_page_title() ); ?></h1>
            <p><?php esc_html_e( 'Helpful stuff here!', 'sfldsimple' ); ?></p>
        </div>
        <?php
    }

}
