<?php
/**
 * The template for displaying all single Event posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package WordPress
 * @subpackage fictionaluniversity
 * @since 1.0.0
 */

get_header();

    while(have_posts()) {
        the_post();

        fictionaluniversity_page_banner(array(
            'title'     => '',
            'bg'        => '',
            'tagline'   => ''
        ));
    ?>
    <div class="container container--narrow page-section">
        <div class="post-item">
            <div class="generic-content">
                <div class="row group">
                    <div class="one-third">
                        <?php the_post_thumbnail('portraitImage'); ?>
                    </div>
                    <div class="two-thirds">
                        <?php
                            $like_count = new WP_Query(array(
                                'post_type'     => 'like',
                                'meta_query'    => array(
                                    array(
                                        'key'       => 'liked_professor_id',
                                        'compare'   => '=',
                                        'value'     => get_the_ID(),
                                    )
                                )
                            ));

                            $exist_status = 'no';

                            if(is_user_logged_in()) {
                                $exist_query = new WP_Query(array(
                                    'author'        => get_current_user_id(),
                                    'post_type'     => 'like',
                                    'meta_query'    => array(
                                        array(
                                            'key'       => 'liked_professor_id',
                                            'compare'   => '=',
                                            'value'     => get_the_ID(),
                                        )
                                    )
                                ));

                                if($exist_query->found_posts) {
                                    $exist_status = 'yes';
                                }
                            }

                        ?>
                        <span class="like-box" data-like="<?php echo $exist_query->posts[0]->ID; ?>" data-user="<?php echo get_userdata(get_current_user_id())->user_login; ?>" data-prof="<?php the_ID(); ?>" data-exists="<?php echo $exist_status; ?>">
                            <i class="far fa-heart"></i>
                            <i class="fas fa-heart"></i>
                            <span class="like-count"><?php echo $like_count->found_posts; ?></span>
                        </span>
                        <p><?php the_content(); ?></p>
                    </div>
                </div>

            </div>
        </div>

        <?php

            $relatedPrograms = get_field('related_programs');

            if($relatedPrograms) {
                echo '<h3 class="headline headline--small" style="margin-bottom: 0;">Courses Taught: </h3>';

                echo '<ul class="link-list min-list">';
                foreach($relatedPrograms as $programs) {
                ?>
                <li><a href="<?php echo get_the_permalink($programs); ?>"><?php echo get_the_title($programs); ?></a></li>
                <?php
                    } //end foreach
                echo "</ul>";
            } //end if
        ?>
    </div>


    <?php

    }//end while
    get_footer();

?>