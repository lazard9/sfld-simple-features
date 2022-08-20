<?php defined('WPINC') or die();

/**
 * Load templates
 *
 * @package SFLD Simple Features
 */

namespace SFLD\Includes\Templates;

use SFLD\Includes\Abstracts\SFLD_Singleton;

if (!class_exists('SFLD_Templates', false)) : class SFLD_Templates extends SFLD_Singleton
    {
        /**
         * Protected class constructor to prevent direct object creation
         *
         */
        protected function __construct()
        {
        }

        /* 
         * Load Course Template
         */
        public function sfld_template_course($template)
        {

            global $post;

            if ('courses' === $post->post_type && file_exists(SFLD_SIMPLE_DIR . 'templates/post/template-course.php')) {
                return  SFLD_SIMPLE_DIR . 'templates/post/template-course.php';
            }

            return $template;
        }

        /* 
         * Load Archive Courses Template
         */
        public function sfld_template_arcive_courses($template)
        {

            if (is_post_type_archive('courses') && file_exists(SFLD_SIMPLE_DIR . 'templates/archive/archive-courses.php')) {
                return  SFLD_SIMPLE_DIR . 'templates/archive/archive-courses.php';
            }

            return $template;
        }
    }
endif;
