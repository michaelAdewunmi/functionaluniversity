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
        'title'     => get_the_archive_title(),
        'tagline'   => get_the_archive_description(),
        'bg'        => '',
    ));
    ?>


    <div class="container container--narrow page-section">

        <?php while(have_posts()) {
            the_post(); ?>
        <div class="post-item">
            <h2 class="headline headline--medium headline--post-title"><a href="<?php echo the_permalink() ?>"><?php the_title(); ?></a></h2>

            <div class="metabox">
                <p>Posted by <?php the_author_posts_link(); ?> on <?php echo the_time('l, F jS, Y @ g:ia'); ?> in <?php echo get_the_category_list(' | '); ?></p>
            </div>

            <div class="generic-content">
                <p><?php the_excerpt(); ?></p>
                <p><a class="btn btn--blue" href="<?php echo the_permalink() ?>">Continue Reading...</a></p>
            </div>
        </div>

        <?php
            }
            echo paginate_links();
        ?>
    </div>


<?php get_footer(); ?>