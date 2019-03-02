<?php
/**
 * The template for displaying archive pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package WordPress
 * @subpackage fictionaluniversity
 * @since 1.0.0
 */

    get_header();
    fictionaluniversity_page_banner(array(
        'title'     => 'All Events',
        'tagline'   => 'See what is happening in fiction University',
        'bg'        => ''
    ));

    ?>

    <div class="container container--narrow page-section">
        <?php
            while(have_posts()) {
                the_post();
                $formatEventDate = new DateTime(get_field('event_date'));

                get_template_part( 'template-parts/content', 'event' );
                echo '<hr class="fu-divider" />';
            }

            echo paginate_links();
            if(paginate_links()) echo '<hr class="fu-divider" />';
        ?>


        <p class="">Looking for an Info on Past Events? <a href="<?php echo site_url('/past-events') ?>">Click Here to view all past Events</a></p>

    </div>


<?php get_footer(); ?>