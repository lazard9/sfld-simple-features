<?php defined( 'WPINC' ) or die();

/**
 * Meta Boxes
 *
 * @package SFLD Simple Features
 * 
 */

namespace SFLD\Includes\CPT;

use \WP_User_Query;

if ( ! class_exists( 'SFLD_Select_Editor', false ) ) : class SFLD_Select_Editor
{

    /*
     * Metabox - Select Editor 
     * For CPT Courses and default Posts
     * 
     */
    public function sfld_select_editor_main() : void {

		add_meta_box(
            'sfld_editor_id', 
            'Post Editor', 
            [$this, 'sfld_meta_box_html'], 
            ['courses', 'post'], 
            'normal', 
            'low'
        );

	}

	public function sfld_save_editor( $post_id ) : void {

        // var_dump($_POST['sfld_post_editor']);

		if( isset($_POST['sfld_post_editor']) && is_numeric($_POST['sfld_post_editor']) ) {

			$editor_id = sanitize_text_field($_POST['sfld_post_editor']);

			update_post_meta($post_id, 'sfld_post_editor', $editor_id );

		}

	}

	public function sfld_meta_box_html() : void {

		$user_query = new WP_User_Query([
			'role' => 'editor',
			'number' => '-1',
			'fields' => [
				'display_name',
				'ID',
			],
		]);

		$editors = $user_query->get_results();

		if( ! empty( $editors ) ) {

		    $select_editor = '<label for="post_editor">Editor: </label>';
			$select_editor .= '<select name="sfld_post_editor" id="post_editor">';
			$select_editor .= '<option> - Select One -</option>';			
            foreach ($editors as $editor) {
                $select_editor .= '<option value="'.$editor->ID.'" '. selected(get_post_meta(get_the_ID(), 'sfld_post_editor', true ), $editor->ID, false).'>'.$editor->display_name.'</option>';
            }
            $select_editor .= '</select>';
            
            echo $select_editor;

		} else {
			echo '<p>No Editors Found.</p>';
		}

	}

} endif;
