<?php

/**
 * Load templates
 *
 * @package SFLD Simple Features
 * 
 */

class SFLD_Simple_Templates
{

    /* 
     * Load Course Template
     */
    public function sfld_template_course($template) {
        
        global $post;

        if( 'courses' === $post->post_type && locate_template(array('template_course')) !== $template  ) {
            return  plugin_dir_path( __DIR__ ) . 'templates/post/template_course.php';
        }

        return $template;

    }

    /* 
     * Load Archive Courses Template
     */
    public function sfld_template_arcive_courses($template) {

        if( is_post_type_archive('courses') ) {
            return  plugin_dir_path( __DIR__ ) . 'templates/archive/archive-courses.php';
        }

        return $template;
        
    }

}