<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the note page
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package WordPress
 * @subpackage fictionaluniversity
 * @since 1.0.0
 */

    if(!is_user_logged_in()) {
        wp_redirect(esc_url(site_url('/')));
        exit;
    }

    get_header();
    fictionaluniversity_page_banner(array(
        'title'     => 'My Notes',
        'tagline'   => 'A list of notes',
        'bg'        => ''
    ));
 ?>

 <div class="container container--narrow page-section">
    <div class="create-note">
        <h2 class="headline headline--medium">Create New Note</h2>
        <input class="new-note-title" type="text" placeholder="Title" />
        <textarea cols="30" rows="10" class="new-note-body" placeholder="Your note here ..."></textarea>
        <span class="submit-note">Create Note</span>
    </div>
     <ul id="my-notes">
        <?php
            $userNotes = new WP_Query(array(
                'post_type'         => 'note',
                'posts_per_page'    => -1,
                'author'            => get_current_user_id(),
            ));

            while($userNotes->have_posts()) {
                $userNotes->the_post(); ?>
                <li data-id=<?php the_ID(); ?>>
                    <input readonly type="text" class="note-title-field"
                        value="<?php echo str_replace( 'Private:', '', esc_attr(get_the_title())); ?>"
                    />
                    <span class="edit-note"><i class="fas fa-pencil-alt"></i> Edit</span>
                    <span class="delete-note"><i class="fas fa-trash"></i> Delete</span>
                    <textarea readonly class="note-body-field"><?php echo esc_attr(get_the_content()); ?></textarea>
                    <span class="update-note btn btn--blue btn--small"><i class="fas fa-arrow-right"></i> Save</span>
                </li>
        <?php

            }
        ?>
     </ul>

 </div>


 <?php
  get_footer();