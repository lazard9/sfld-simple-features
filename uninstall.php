<?php

/**
 * Trigger this file on Plugin uninstall
 *
 * @package SFLD Simple Features
 */

if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) {
	die;
}

/**
 * Clear Database stored data.
 * 
 */
$courses = get_posts( array( 'post_type' => ['courses', 'professors'], 'numberposts' => -1 ) );

foreach( $courses as $course ) {
	wp_delete_post( $course->ID, true );
}


/**
 * Drop Database Table - course_details.
 * 
 */
global $wpdb;

$database_table_name = $wpdb->prefix . 'ld_course_details';
$wpdb->query( "DROP TABLE IF EXISTS $database_table_name" );

/**
 * Delete data from options table.
 * 
 */
delete_option( 'sfld_simple_options' );

// Access the database via SQL
//global $wpdb;
//$wpdb->query( "DELETE FROM wp_posts WHERE post_type = 'courses'" );
//$wpdb->query( "DELETE FROM wp_postmeta WHERE post_id NOT IN (SELECT id FROM wp_posts)" );
//$wpdb->query( "DELETE FROM wp_term_relationships WHERE object_id NOT IN (SELECT id FROM wp_posts)" );