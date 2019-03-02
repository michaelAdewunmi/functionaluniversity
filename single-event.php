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
            <div class="metabox metabox--position-up metabox--with-home-link">
                <p><a class="metabox__blog-home-link" href="<?php echo get_post_type_archive_link('event') ?>"><i class="fas fa-home"></i> Back to Events Home </a><span class="metabox__main"><?php the_title(); ?></p>
            </div>

            <div class="generic-content">
                <p><?php the_content(); ?></p>
            </div>
        </div>
        <?php

            $relatedPrograms = get_field('related_programs');

            if($relatedPrograms) {

                echo '<div class="link-list min-list">';
                // echo '<hr class="fu-divider" style="background-color: #ececec" />';
                echo '<span style="font-style: italic; font-weight: 600;">Related Programs: </span>';

                foreach($relatedPrograms as $programs) {
                ?>
                    <!-- <li><a href="<?php //echo get_the_permalink($programs); ?>"><?php //echo get_the_title($programs); ?></a></li> -->
                    <span><a href="<?php echo get_the_permalink($programs); ?>"><?php echo get_the_title($programs); ?></a></span> |
                <?php
                    } //end foreach
                echo "</div>";
            } //end if
        ?>
    </div>


    <?php

    }//end while
    get_footer();

?>