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
        'title'     => 'All University Programs',
        'tagline'   => 'Get to know about all our Programs Here',
        'bg'        => ''
    ));
?>

    <div class="container container--narrow page-section">
        <ul class="link-last min-list">
            <?php while(have_posts()) {
                the_post();
            ?>
            <li><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></li>

            <hr class="fu-divider" />
            <?php   } ?>
        </ul>

        <?php
            echo paginate_links();
        ?>

    </div>


<?php get_footer(); ?>