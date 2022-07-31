<?php

/**
 * Fired during plugin activation
 *
 * @package SFLD Simple Features
 * 
 */

namespace SFLD\includes;

class SFLD_Simple_Activator
{

    public static function activate() {
        
        self::sfld_create_database_table();
        
    }

    /**
     * On purpose in activation hook for testing!
     * Create Database Table - course_details.
     * 
     */
    private function sfld_create_database_table() : void {
        
        global $wpdb;

        $database_table_name = $wpdb->prefix . 'ld_course_details';
        $charset = $wpdb->get_charset_collate;
        $course_details = "CREATE TABLE IF NOT EXISTS $database_table_name(
                ID          INT(9) NOT NULL,
                title       TEXT(100) NOT NULL,
                subtitle    TEXT(500) NOT NULL,
                video       varchar(100) NOT NULL,
                price       DOUBLE(10,2) NOT NULL,
                thumbnail   TEXT NOT NULL,
                content     TEXT NOT NULL,
                PRIMARY KEY (ID)
            ) $charset; ";
        include_once( ABSPATH . 'wp-admin/includes/upgrade.php');
        dbDelta($course_details);
    }

}