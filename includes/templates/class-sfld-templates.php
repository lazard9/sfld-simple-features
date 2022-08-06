<?php defined( 'WPINC' ) or die();

/**
 * Load templates
 *
 * @package SFLD Simple Features
 */

namespace SFLD\Includes\Templates;

if ( ! class_exists( 'SFLD_Templates', false ) ) : class SFLD_Templates
{

    /* 
     * Load Course Template
     */
    public function sfld_template_course($template) {
        
        global $post;

        if( 'courses' === $post->post_type && locate_template(array('template-course')) !== $template  ) {
            return  SFLD_SIMPLE_DIR . 'templates/post/template-course.php';
        }

        return $template;

    }

    /* 
     * Load Archive Courses Template
     */
    public function sfld_template_arcive_courses($template) {

        if( is_post_type_archive('courses') && locate_template(array('archive-course')) !== $template ) {
            return  SFLD_SIMPLE_DIR . 'templates/archive/archive-courses.php';
        }

        return $template;
        
    }

} endif;