<?php
/**
 * The template for displaying all Past event page
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package WordPress
 * @subpackage fictionaluniversity
 * @since 1.0.0
 */
    get_header();
    fictionaluniversity_page_banner(array(
        'title'     => 'Our Past Events',
        'tagline'   => 'Here is a list of our Past Events',
        'bg'        => ''
    ));
?>

    <div class="container container--narrow page-section">

        <?php
            $today = date('Ymd');
            $pastEvents = new WP_Query(array(
                'paged'             => get_query_var('paged', 1),
                'posts_per_page'    => 2,
                'post_type'         => 'event',
                'meta_key'          => 'event_date',
                'orderby'           => 'meta_value_num',
                'order'             => 'ASC',
                'meta_query'        => array(
                    array(
                        'key'       => 'event_date',
                        'compare'   => '<',
                        'value'     => $today,
                    ),
                ),
            ));

            while($pastEvents->have_posts()){
                $pastEvents->the_post();
                $formatEventDate = new DateTime(get_field('event_date'));

                get_template_part( 'template-parts/content', 'event' );
                echo '<hr class="fu-divider" />';
            }
        ?>


        <?php

            $pagination = paginate_links(array(
                'total'     => $pastEvents->max_num_pages,
            ));

            if($pagination) echo $pagination . '<hr class="fu-divider" />';
        ?>

        <p class=""><a href="<?php echo get_post_type_archive_link('event') ?>">Click Here to check out Future Events</a></p>


    </div>

    <?php

    get_footer();
?>