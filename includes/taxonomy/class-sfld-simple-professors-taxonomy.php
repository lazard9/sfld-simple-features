<?php

/**
 * Load Custom Taxonomies for CPT Courses
 *
 * @package SFLD Simple Features
 * 
 */

namespace SFLD\includes\taxonomy;

class SFLD_Simple_Professors_Taxonomy
{

    function sfld_simple_professors_taxonomy_init() : void {

        /**
         * Hierarchical taxonomy ~ Categories
         *
         */
        $labels = array(
            'name' => _x( 'Curriculums', 'taxonomy general name' ),
            'singular_name' => _x( 'Curriculum', 'taxonomy singular name' ),
            'search_items' =>  __( 'Search Curriculums' ),
            'all_items' => __( 'All Curriculums' ),
            'parent_item' => __( 'Parent Curriculum' ),
            'parent_item_colon' => __( 'Parent Curriculum:' ),
            'edit_item' => __( 'Edit Curriculum' ), 
            'update_item' => __( 'Update Curriculum' ),
            'add_new_item' => __( 'Add New Curriculum' ),
            'new_item_name' => __( 'New Curriculum Name' ),
            'menu_name' => __( 'Curriculums' ),
        );    
        
        // Hierarchical taxonomy registration
        register_taxonomy('curriculums', array('professors'), array(
            'hierarchical' => true,
            'labels' => $labels,
            'show_ui' => true,
            'show_in_rest' => true,
            'show_admin_column' => true,
            'query_var' => true,
            'rewrite' => array( 'slug' => 'curriculum' ),
        ));

    }

    /*
     * Populate terms for taxonomy Level.
     * 
     */
    public function sfld_insert_curriculums_taxonomy_terms() : void {

        $taxonomyName = 'curriculums';

        $terms = [
            "mathematics" => "Mathematics",
            "geography" => "Geography",
            "physics" => "Physics",
            "biology" => "Biology",
            "chemistry" => "Chemistry",
            "computer-science" => "Computer Science",
            "applied-chemistry" => "Applied Chemistry",
        ];

        foreach ($terms as $slug => $term) {
            wp_insert_term($term, $taxonomyName, [
                'slug' => $slug,
            ]);
        }

    }

}
