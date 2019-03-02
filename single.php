<?php
/**
 * The template for displaying all single posts
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
                <p><a class="metabox__blog-home-link" href="<?php echo site_url('/blog') ?>"><i class="fas fa-home"></i> Back to Blog page </a><span class="metabox__main">Posted by <?php the_author_posts_link(); ?> on <?php echo the_time('l, F jS, Y @ g:ia'); ?> in <?php echo get_the_category_list(' | '); ?></p>
            </div>

            <div class="generic-content">
                <p><?php the_content(); ?></p>
            </div>
        </div>
    </div>

    <?php
        } ?>


<?php get_footer(); ?>