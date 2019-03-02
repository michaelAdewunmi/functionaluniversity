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
                <p><a class="metabox__blog-home-link" href="<?php echo get_post_type_archive_link('program') ?>"><i class="fas fa-home"></i> View All Programs </a><span class="metabox__main"><?php the_title(); ?></p>
            </div>

            <div class="generic-content">
                <p><?php the_field('program_content'); ?></p>
            </div>
        </div>
        <?php

            $relatedProfessor = new WP_Query(array(
                'post_type'         => 'professor',
                'orderby'           => 'title',
                'order'             => 'ASC',
                'meta_query'        => array(
                    array(
                        'key'       => 'related_programs',
                        'compare'   => 'LIKE', //means "CONTAINS"
                        'value'     => '"' . get_the_ID() . '"',
                    )
                )
            ));

            $pageTitle = get_the_title()=="Sciences" ? "Science" : get_the_title();

            echo '<h3 class="headline headline--small">' . $pageTitle . ' Professors</h3><ul class="professor-cards">';

            while($relatedProfessor->have_posts()) {
                $relatedProfessor->the_post();

            ?>
            <li class="professor-card__list-item">
                <a href="<?php the_permalink(); ?>" class="professor-card">
                    <img src="<?php the_post_thumbnail_url('landscapeImage'); ?>" alt="" class="professor-card__image">
                    <span class="professor-card__name"><?php the_title(); ?></span>
                </a>
            </li>
            <?php
                } //end--while
                echo "</ul>"; // end of first custom query

            wp_reset_postdata();

            echo '<hr class="section-break" /><ul class="min-list link-list">';

            $related_campuses = get_field('related_campuses');
            if($related_campuses) {
                echo '<h2>' . get_the_title() . ' Lectures are available at these Campuses </h2>';
                foreach($related_campuses as $campus) {
                ?>
                <li><a href="<?php echo get_the_permalink($campus); ?>"><?php echo get_the_title($campus); ?></a></li>
                <?php
                }
            }
            echo '</ul>';

            wp_reset_postdata();
            echo '<hr class="section-break" />';
            //custom query for homepage events begins here
            $getRelatedEvents = new WP_Query(array(
                'post_type'       => 'event',
                'meta_key'        => 'event_date',
                'orderby'       => 'meta_value_num',
                'order'           => 'ASC',
                'meta_query'      => array(
                    array(
                        'key'       => 'event_date',
                        'compare'   => '>=',
                        'value'     => $today
                    ),
                    array(
                        'key'       => 'related_programs',
                        'compare'   => 'LIKE', //means "CONTAINS"
                        'value'     => '"' . get_the_ID() . '"',
                    )
                )
            ));

            echo '<h3 class="headline headline--small">Upcoming ' . get_the_title() . ' Events </h3>';
            if(!$getRelatedEvents->have_posts()) echo "<em>There is no upcoming event for this program</em>";

            while($getRelatedEvents->have_posts()) {
                $getRelatedEvents->the_post();

                $formatEventDate = new DateTime(get_field('event_date'));

                get_template_part( 'template-parts/content', 'event' );
            }
        ?>
    </div>



    <?php

        }
        get_footer();
    ?>