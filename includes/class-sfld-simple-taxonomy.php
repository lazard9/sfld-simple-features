<?php

/**
 * Load Custom Taxonomies
 *
 * @package SFLD Simple Features
 * 
 */

class SFLD_Simple_Taxonomy
{

    function sfld_simple_taxonomy_init() : void {

        /**
         * Hierarchical taxonomy ~ Categories
         *
         */
 
        $labels = array(
            'name' => _x( 'Subjects', 'taxonomy general name' ),
            'singular_name' => _x( 'Subject', 'taxonomy singular name' ),
            'search_items' =>  __( 'Search Subjects' ),
            'all_items' => __( 'All Subjects' ),
            'parent_item' => __( 'Parent Subject' ),
            'parent_item_colon' => __( 'Parent Subject:' ),
            'edit_item' => __( 'Edit Subject' ), 
            'update_item' => __( 'Update Subject' ),
            'add_new_item' => __( 'Add New Subject' ),
            'new_item_name' => __( 'New Subject Name' ),
            'menu_name' => __( 'Subjects' ),
        );    
        
        // Hierarchical taxonomy registration
        register_taxonomy('subjects', array('courses'), array(
            'hierarchical' => true,
            'labels' => $labels,
            'show_ui' => true,
            'show_in_rest' => true,
            'show_admin_column' => true,
            'query_var' => true,
            'rewrite' => array( 'slug' => 'subject' ),
        ));

        
        /**
         * Nonhierarchical taxonomy
         *
         */
        
        $labels = array(
            'name' => _x( 'Topics', 'taxonomy general name' ),
            'singular_name' => _x( 'Topic', 'taxonomy singular name' ),
            'search_items' =>  __( 'Search Topics' ),
            'popular_items' => __( 'Popular Topics' ),
            'all_items' => __( 'All Topics' ),
            'parent_item' => null,
            'parent_item_colon' => null,
            'edit_item' => __( 'Edit Topic' ), 
            'update_item' => __( 'Update Topic' ),
            'add_new_item' => __( 'Add New Topic' ),
            'new_item_name' => __( 'New Topic Name' ),
            'separate_items_with_commas' => __( 'Separate topics with commas' ),
            'add_or_remove_items' => __( 'Add or remove topics' ),
            'choose_from_most_used' => __( 'Choose from the most used topics' ),
            'menu_name' => __( 'Topics' ),
        ); 
        
        // Non-hierarchical taxonomy registration ~ Tag
        register_taxonomy('topics','courses',array(
            'hierarchical' => false,
            'labels' => $labels,
            'show_ui' => true,
            'show_in_rest' => true,
            'show_admin_column' => true,
            'update_count_callback' => '_update_post_term_count',
            'query_var' => true,
            'rewrite' => array( 'slug' => 'topic' ),
        ));

    }

}
