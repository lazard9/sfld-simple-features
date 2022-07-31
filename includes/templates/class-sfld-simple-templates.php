<?php

/**
 * Load templates
 *
 * @package SFLD Simple Features
 */

namespace SFLD\includes\templates;

class SFLD_Simple_Templates
{

    /* 
     * Load Course Template
     */
    public function sfld_template_course($template) {
        
        global $post;

        if( 'courses' === $post->post_type && locate_template(array('template_course')) !== $template  ) {
            return  SFLD_SIMPLE_DIR . 'templates/post/template_course.php';
        }

        return $template;

    }

    /* 
     * Load Archive Courses Template
     */
    public function sfld_template_arcive_courses($template) {

        if( is_post_type_archive('courses') ) {
            return  SFLD_SIMPLE_DIR . 'templates/archive/archive-courses.php';
        }

        return $template;
        
    }

}