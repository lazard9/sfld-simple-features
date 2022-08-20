<?php

/**
 * Trigger this file on Plugin uninstall
 *
 * @package SFLD Simple Features
 */

if (!defined('WP_UNINSTALL_PLUGIN')) {
	die();
}

global $wpdb;

$options = get_option('sfld_main_settings');

/**
 * Delete custom taxonomies terms
 * 
 */
if (array_key_exists('checkbox-taxonomies', $options)) {

	$predefined_taxonomy = ['level', 'subjects', 'topics', 'curriculums'];

	foreach ($predefined_taxonomy as $taxonomy)	{
		
		register_taxonomy($taxonomy, null);

		$query = 'SELECT t.name, t.term_id
			FROM ' . $wpdb->terms . ' AS t
			INNER JOIN ' . $wpdb->term_taxonomy . ' AS tt
			ON t.term_id = tt.term_id
			WHERE tt.taxonomy = "' . $taxonomy . '"';

		$terms = $wpdb->get_results($query);

		foreach ($terms as $term) {
			wp_delete_term($term->term_id, $taxonomy);
		}
		
	}

}

/**
 * Clear Database stored posts.
 * 
 */
if (array_key_exists('checkbox-cpt', $options)) {

	$all_custom_posts = get_posts(array('post_type' => ['courses', 'professors'], 'numberposts' => -1, 'post_status' => 'any'));

	foreach ($all_custom_posts as $custom_post) {
		wp_delete_post($custom_post->ID, true);
	}

}

// Access the database via SQL
//global $wpdb;
//$wpdb->query( "DELETE FROM wp_posts WHERE post_type = 'courses'" );
//$wpdb->query( "DELETE FROM wp_postmeta WHERE post_id NOT IN (SELECT id FROM wp_posts)" );
//$wpdb->query( "DELETE FROM wp_term_relationships WHERE object_id NOT IN (SELECT id FROM wp_posts)" );

/**
 * Drop Database Table - course_details.
 * 
 */
if (array_key_exists('checkbox-database', $options)) {

	$database_table_name = $wpdb->prefix . 'ld_course_details';
	$wpdb->query("DROP TABLE IF EXISTS $database_table_name");

}

/**
 * Delete data from options table.
 * 
 */
if (array_key_exists('checkbox-settings', $options)) {

	delete_option('sfld_simple_options');
	delete_option('sfld_simple_settings');
	delete_option('sfld_main_settings');
	
}
