<h2 class="headline headline--medium headline--post-title"><a href="<?php echo the_permalink() ?>"><?php the_title(); ?></a></h2>

<div class="metabox">
    <p>Posted by <?php the_author_posts_link(); ?> on <?php echo the_time('l, F jS, Y @ g:ia'); ?> in <?php echo get_the_category_list(' | '); ?></p>
</div>

<div class="generic-content">
    <p><?php the_excerpt(); ?></p>
    <p><a class="btn btn--blue" href="<?php echo the_permalink() ?>">Continue Reading...</a></p>
</div>