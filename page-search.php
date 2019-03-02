<?php
/**
 *  The template for displaying the search page
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
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

        <?php
            $parentID = wp_get_post_parent_id(get_the_ID());
            if($parentID) {
        ?>
            <div class="metabox metabox--position-up metabox--with-home-link">
                <p><a class="metabox__blog-home-link" href="<?php echo get_permalink($parentID) ?>"><i class="fas fa-home"></i> Back to <?php echo get_the_title($parentID) ?></a><span class="metabox__main"><?php the_title(); ?></span></p>
            </div>
        <?php } ?>



        <?php
        $testArray = get_pages(array(
            'child_of' => get_the_ID(),
        ));

        if($parentID or $testArray ) { ?>
            <div class="page-links">
            <h2 class="page-links__title"><a href="<?php get_permalink($parentID); ?>"><?php echo get_the_title($parentID); ?></a></h2>
            <ul class="min-list">
                <?php
                    if($parentID) {
                        $idForGettingChildren = $parentID;
                    }else{
                        $idForGettingChildren = get_the_ID();
                    }
                    wp_list_pages(array(
                        'title_li'  => NULL,
                        'child_of'  => $idForGettingChildren,
                    ));
                ?>
            </ul>
            </div>
        <?php } ?>

        <div class="generic-content">
            <form class="search-form" action="<?php echo esc_url(site_url('/')); ?>" method="get">
                    <label class="headline headline--medium" for="s">Perform a New Search</label>

                    <div class="search-form-row">
                    <input class="s" type="search" name="s" id="s" placeholder="What are you looking for?" />
                    <input class="search-submit" type="submit" value="Search" />
                    </div>

            </form>
        </div>

    </div>

    </div>

    <?php }

    get_footer();
?>