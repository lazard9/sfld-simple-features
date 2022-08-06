<?php

/**
 * Meta Boxes
 *
 * @package SFLD Simple Features
 * 
 */

namespace SFLD\Includes\Metabox;

use \WP_User_Query;

if ( ! class_exists( 'SFLD_Meta_Boxes', false ) ) : class SFLD_Meta_Boxes
{

    /*
     * Metabox - Select Editor 
     * For CPT Courses and default Posts
     * 
     */
    public function sfld_select_editor() : void {

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

		if(isset($_POST['sfld_post_editor']) && is_numeric($_POST['sfld_post_editor']) ) {

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
    
	/*
     * Metabox - Add Custom Fields - Courses
     * For CPT Courses
     * 
     */
    public function sfld_courses_details_main() : void {

        add_meta_box(
            'sfld_courses_details_main',    	// ID
            'Courses Custom Field',         	// Title
            [$this, 'sfld_courses_details'],    // Function
            ['courses'],                    	// Custom Post Type
            'normal',                       	// Priority
            'low',                          	// Position Up/Down
        );

    }

    public function sfld_courses_details( $post_id ) : void {

        global $wpdb;
        // $ID = get_the_id();
        $ourdb = $wpdb->prefix . 'ld_course_details';
        $subtitle = $wpdb->get_var("SELECT `subtitle` FROM `$ourdb` WHERE `ID` = ".$post_id->ID."");
        $price = $wpdb->get_var("SELECT `price` FROM `$ourdb` WHERE `ID` = ".$post_id->ID."");
        $video = $wpdb->get_var("SELECT `video` FROM `$ourdb` WHERE `ID` = ".$post_id->ID."");
        $curriculum = $wpdb->get_var("SELECT `content` FROM `$ourdb` WHERE `ID` = ".$post_id->ID."");

        echo <<<END
            <div class="bg-blue-1 pad">
                <div class="bg-blue-2 ma center pad-b b-r">
                    <h3>Subtitle</h3>
                    <input type="text" name="subtitle" value="{$subtitle}" class="col-85" />
                </div>
                <div class="bg-blue-2 ma center pad-b b-r">
                    <h3>Price</h3>
                    <input type="text" name="price" value="{$price}" class="col-85" />
                </div>
                <div class="bg-blue-2 ma center pad-b b-r">
                    <h3>Video Trailer</h3>
                    <input type="text" name="video-trailer" value="{$video}" class="col-85" />
                </div>
                <div class="bg-blue-2 ma center pad-b b-r">
                    <h3>Curriculum</h3>
                    <input type="text" name="curriculum" value="{$curriculum}" class="col-85" />
                </div>
            </div>
        END; // Heredoc https://www.php.net/manual/en/language.types.string.php#language.types.string.syntax.heredoc
        
    }

    /* Save Course Details to the DB */
    public function sfld_save_course_details() : void {

		$post_type = get_post_type();

		if ( $post_type == 'courses' ) {

			global $wpdb, $post;
			
			// $ID             = get_the_id();
			$title          = get_the_title();
			$thumbnail      = get_the_post_thumbnail_url();
			$price          = $_POST["price"];
			$subtitle       = $_POST["subtitle"];
			$video_trailer  = $_POST["video-trailer"];
			$curriculum     = $_POST["curriculum"];

			$wpdb->insert(
				$wpdb->prefix . 'ld_course_details', // DB table name
				[
					'ID'        => $post->ID 
				]
			);

			$wpdb->update(
				$wpdb->prefix . 'ld_course_details',
				[
					'title'     => $title,
					'thumbnail' => $thumbnail,
					'price'     => $price,
					'subtitle'  => $subtitle,
					'video'     => $video_trailer,
					'content'   => $curriculum,
				],
				[
					'ID'        => $post->ID // ID of post to be updated
				]
			);

		}
            
    }

    /*
     * Add metabox for taxonomy Level.
     * 
     */
    public function sfld_level_meta_box() : void {

        add_meta_box(
            'sfld_level_box',
            __('Level', 'sfldsimple'),
            [$this, 'sfld_level_meta_box_term'],
            ['courses'],
            'side',
            'high'
        );

    }

    /*
     * Make options radio (can select only singe term) for taxonomy Level. 
     * 
     */
    public function sfld_level_meta_box_term( $post ) : void {

       $terms = get_terms( array(
			'taxonomy' => 'level',
			'hide_empty' => false // Retrieve all terms
        ));

        // We assume that there is a single category
        $currentTaxonomyValue = get_the_terms($post->ID, 'level')[0];
	?>
	<p>Choose taxonomy value</p>
	<p>
        <?php foreach($terms as $term): ?>
            <input type="radio" name="level" id="taxonomy_term_<?php echo $term->term_id;?>" value="<?php echo $term->term_id;?>"<?php if($term->term_id==$currentTaxonomyValue->term_id) echo "checked"; ?>>
            <label for="taxonomy_term_<?php echo $term->term_id;?>"><?php echo $term->name; ?></label>
            </input><br/>
        <?php endforeach; ?>
    </p>
    <?php
    }

    /*
     * Save term for taxonomy Level. 
     * 
     */
    function sfld_save_level_taxonomy($post_id) : void {
        if ( isset( $_REQUEST['level'] ) ) 
            wp_set_object_terms($post_id, (int)sanitize_text_field( $_POST['level'] ), 'level');
    }

} endif;
