<?php
/**
 * The template for displaying search results pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#search-result
 *
 * @package WordPress
 * @subpackage fictionaluniversity
 * @since 1.0.0
 */

get_header();
fictionaluniversity_page_banner(array(
    'title'     => 'Results Found in ' . get_search_query(),
    'tagline'   => ''
));
?>

<div class="container container--narrow page-section">
    <div class="generic-content">
        <?php
            while(have_posts()) {
                the_post();

                if(get_post_type()=="post" or get_post_type()=="page") {
                    echo  '<div class="post-item">';
                        get_template_part('template-parts/content', 'post');
                    echo '</div>';
                }

                if(get_post_type()=="event") {
                    echo  '<div class="post-item">';
                        get_template_part('template-parts/content', 'event');
                    echo '</div>';
                }


                if(get_post_type()=="professor") {
                    get_template_part('template-parts/content', 'professor');

                }
                echo '<hr class="">';

                if(get_post_type()=="program") {
                    get_template_part('template-parts/content', 'program');
                }
            }
        ?>
    </div>
</div>

<?php get_footer();
