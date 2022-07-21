<?php

/**
 * Ajax load More
 *
 * @package SFLD Simple Features
 * 
 */

class SFLD_Ajax_Load_More
{

   function sfld_ajax_load_more_posts() : void {

      $page = (isset($_POST['pageNumber'])) ? $_POST['pageNumber'] : 2;
      $num_posts = 2;

      header("Content-Type: text/html");

      $args = array(
         'suppress_filters' => true,
         'post_type' => 'courses',
         'posts_per_page' => $num_posts,
         'paged' => $page,
         'post_status' => 'publish',
         'order' => 'ASC',
      );

      $loop = new WP_Query($args);

      $out = '';

      if ($loop -> have_posts()) :  while ($loop -> have_posts()) : $loop -> the_post(); ?>

         <li class="li-course" id="post-<?php the_ID(); ?>">
            <a href="<?php the_permalink(); ?>">
               <div class="li-course-image">
                  <?php if ( has_post_thumbnail() ) {
                        the_post_thumbnail('full', array('class' => 'course'));
                  } ?>
               </div>
               <div class="li-course-name">
                     <h3><?php the_title(); ?></h3>
               </div>
            </a>
         </li>

      <?php
      endwhile; wp_reset_postdata();
      endif;
      
      die($out);
   }

}
