<?php
/**
 * The template for displaying all single Campus posts
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
                <p><a class="metabox__blog-home-link" href="<?php echo get_post_type_archive_link('campus') ?>"><i class="fas fa-home"></i> See All Campuses </a><span class="metabox__main"><?php the_title(); ?></p>
            </div>

            <div class="generic-content">
                <p><?php the_content(); ?></p>
            </div>

            <div class="acf-map">
                <?php $siteLocation = get_field('map_location'); ?>
                <div class="marker" data-lat="<?php echo $siteLocation['lat']; ?>" data-lng="<?php echo $siteLocation['lng']; ?>">
                        <h3><?php the_title(); ?></h3>
                        <p><?php echo $siteLocation['address']; ?></p>
                </div>
            </div>
        </div>
        <?php

            $relatedCampus = new WP_Query(array(
                'post_per_page'     => -1,
                'post_type'         => 'program',
                'orderby'           => 'title',
                'order'             => 'ASC',
                'meta_query'        => array(
                    array(
                        'key'       => 'related_campuses',
                        'compare'   => 'LIKE', //means "CONTAINS"
                        'value'     => '"' . get_the_ID() . '"',
                    )
                )
            ));

            $pageTitle = get_the_title()=="Sciences" ? "Science" : get_the_title();

            echo '<h3 class="headline headline--small">Programs Available at this Campus</h3><ul class="min-list link-list">';

            while($relatedCampus->have_posts()) {
                $relatedCampus->the_post();

            ?>
            <li><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></li>
            <?php
                } //end--while
                echo "</ul>"; // end of first custom query

            wp_reset_postdata();
            ?>
    </div>



    <?php

        }
        get_footer();
    ?>