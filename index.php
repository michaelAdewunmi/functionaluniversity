<?php
/**
 * The main template file
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package WordPress
 * @subpackage fictionaluniversity
 * @since 1.0.0
 */
    get_header();
    fictionaluniversity_page_banner(array(
        'title'     => 'Welcome to our Blog',
        'tagline'   => 'This is where you read our latest news',
        'bg'        => ''
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

<?php
    get_footer();
?>