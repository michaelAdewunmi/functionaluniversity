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
        'title'     => 'All Campuses',
        'tagline'   => 'A list of all our Campuses',
        'bg'        => ''
    ));

    ?>

    <div class="container container--narrow page-section">
        <div class="acf-map">
            <?php
                while(have_posts()) {
                    the_post();

                    $siteLocation = get_field('map_location');
            ?>

            <div class="marker" data-lat="<?php echo $siteLocation['lat']; ?>" data-lng="<?php echo $siteLocation['lng']; ?>">
                    <h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
                    <p><?php echo $siteLocation['address']; ?></p>
            </div>

            <?php    } ?>
        </div>

    </div>


<?php get_footer(); ?>