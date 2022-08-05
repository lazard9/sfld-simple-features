<?php

/**
 * Ajax load More
 *
 * @package SFLD Simple Features
 * 
 */

namespace SFLD\Includes\Ajax;
use \WP_Query;

class SFLD_Ajax_Load_More
{

   public function sfld_ajax_load_more_posts() : void {

		if ( ! check_ajax_referer( 'load_more_post_nonce', 'ajax_nonce', false ) ) {
			wp_send_json_error( __( 'Invalid security token sent.', 'text-domain' ) );
			wp_die( '0', 400 );
		}

		// Check if it's an ajax call.
		$is_ajax_request = ! empty( $_SERVER['HTTP_X_REQUESTED_WITH'] ) && strtolower( $_SERVER['HTTP_X_REQUESTED_WITH'] ) === 'xmlhttprequest';
		
		/**
		 * Page number.
		 * If get_query_var( 'paged' ) is 2 or more, its a number pagination query.
		 * If $_POST['page'] has a value which means its a loadmore request, which will take precedence.
		 */
		$page_no = get_query_var( 'paged' ) ? get_query_var( 'paged' ) : 1;
		$page_no = ! empty( $_POST['page'] ) ? filter_var( $_POST['page'], FILTER_VALIDATE_INT ) + 1 : $page_no;

		// Default Argument.
		$args = [
			'post_type'      => 'courses',
			'post_status'    => 'publish',
			'posts_per_page' => 2,
			'paged'          => $page_no,
		];

		$lm_query = new WP_Query( $args );

		if ( $lm_query->have_posts() ):
			// Loop Posts.
			while ( $lm_query->have_posts() ): $lm_query->the_post();
            	include SFLD_SIMPLE_DIR . 'template-parts/components/course-card.php';
			endwhile;
		else:
			// Return response as zero, when no post found.
			wp_die( '0' );
		endif;

		wp_reset_postdata();

		/**
		 * Check if its an ajax call
		 *
		 * @see https://wordpress.stackexchange.com/questions/116759/why-does-wordpress-add-0-zero-to-an-ajax-response
		 */
		if ( $is_ajax_request ) {
			wp_die();
		}
      
	}

}
