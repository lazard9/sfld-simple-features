<?php defined( 'WPINC' ) or die();

/**
 * GDPR checkbox for Woocommerce product review.
 * This is a standalone plugin!
 *
 * @package SFLD Simple Features 
 */

namespace SFLD\Includes\GDPR;

if ( ! class_exists( 'SFLD_Woo_GDPR', false ) ) : class SFLD_Woo_GDPR
{
   
   function sfld_additional_fields()
   {
      echo '<p class="comment-form-consent">' .
         '<input type="checkbox" id="consent" name="consent" checked>
         <label for="consent">' . sprintf(__('By using this form you agree with the storage and handling of your data by this website %s">GTC</a>', 'sfldsimple'), '<a href="' . esc_url(home_url('/gtc/'))) . '<span class="required"> *</span></label>
      </p>';
   }

   // Save the comment meta data along with comment


   function sfld_save_comment_meta_data($comment_id)
   {
      if ((isset($_POST['consent'])) && ($_POST['consent'] != ''))
         $rating = wp_filter_nohtml_kses($_POST['consent']);
      add_comment_meta($comment_id, 'consent', $rating);
   }

   // Add the filter to check whether the comment meta data has been filled
   function sfld_verify_comment_meta_data($commentdata)
   {
      if (!isset($_POST['consent']))
         wp_die(__('Error: You did not consent.', 'sfldsimple'));
      return $commentdata;
   }

   /**
      * Dashboard
      *
      */
   // Add an edit option to comment editing screen  
   function sfld_extend_comment_add_meta_box()
   {
      add_meta_box(
         'title', 
         __('ABG comment checkbox'), 
         [$this, 'extend_comment_meta_box'], 
         'comment', 'normal', 
         'high');
   }

   function extend_comment_meta_box($comment)
   {
      $consent = get_comment_meta($comment->comment_ID, 'consent', true);
      wp_nonce_field('extend_comment_update', 'extend_comment_update', false);
      ?>
         <p>
            <label for="consent"><?php _e('Consent: ', 'sfldsimple'); ?></label>
            <span class="consentchecked">
            <?php
            if ($consent) {
               $checked = 'checked';
            } else {
               $checked = '';
            }
            echo '<input type="checkbox" id="consent" name="consent" ' . $checked . '>';
            ?>
            </span>
         </p>
      <?php
   }

   // Update comment meta data from comment editing screen 
   function sfld_extend_comment_edit_metafields($comment_id)
   {
      if (!isset($_POST['extend_comment_update']) || !wp_verify_nonce($_POST['extend_comment_update'], 'extend_comment_update')) return;

      if ((isset($_POST['consent'])) && ($_POST['consent'] != '')) :
         $consent = wp_filter_nohtml_kses($_POST['consent']);
         update_comment_meta($comment_id, 'consent', $consent);
      else :
         delete_comment_meta($comment_id, 'consent');
      endif;

   }
} endif;
