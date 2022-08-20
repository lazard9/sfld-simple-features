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

            // In future, template for each CPT single view could be included.
            $post_type_object = get_post_type_object($post->post_type);
            $rewrite_slug = $post_type_object->rewrite['slug'];


            if ('courses' === $post_type && file_exists(SFLD_SIMPLE_DIR . 'templates/post/template-' .  $rewrite_slug .'.php')) {
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
