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
         * Load Single Course Template
         */
        public function sfld_template_course($template)
        {

            global $post;

            $post_type = $post->post_type;

            /* 
             *  Include template for each CPT single view.
             */
            $post_type_object = get_post_type_object($post_type);
            $rewrite_slug = $post_type_object->rewrite['slug'];
            $post_types_array = [
                'courses',
                'professors',
            ];

            if (in_array($post_type, $post_types_array) && file_exists(SFLD_SIMPLE_DIR . 'templates/post/template-' .  $rewrite_slug .'.php')) {
                $template = SFLD_SIMPLE_DIR . 'templates/post/template-' .  $rewrite_slug .'.php';
            }

            return $template;
        }

        /* 
         * Load Archive Courses Template
         */
        public function sfld_template_arcive_courses($template)
        {

            if (is_post_type_archive('courses') && file_exists(SFLD_SIMPLE_DIR . 'templates/archive/archive-courses.php')) {
                $template = SFLD_SIMPLE_DIR . 'templates/archive/archive-courses.php';
            }

            return $template;
        }
    }
endif;
