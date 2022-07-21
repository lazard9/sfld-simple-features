<?php
get_header();

    echo '<div style="max-width: 800px; margin: auto; padding: 60px 20px;">';

        $num_posts = 4;

        $args = array(
            'post_type' => 'courses',
            'posts_per_page' => $num_posts,
            'post_status' => 'publish',
            'order' => 'ASC',
            // 'meta_key' => 'ordinal_number',
            // 'orderby' => 'meta_value_num',
            // 'order' => 'asc',
            // 'post__in' => get_option( 'sticky_posts' ),
            //'ignore_sticky_posts' => true,
        );

        $loop = new WP_Query($args);

        if( $loop->have_posts() ) : 
        ?>
            <ul id="ajax-posts" class="ul-courses">
                <?php
                while ($loop->have_posts()) : $loop->the_post();
                ?>
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
                ?>
            </ul>

            <button id="more_posts" class="load-more" data-category="1" type="button">LOAD MORE</button>
        <?php
        endif;

    echo '</div>';

get_footer();