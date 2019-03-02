<?php

    require get_theme_file_path('/inc/search-route.php');
    require get_theme_file_path('/inc/like-route.php');

    function fictionaluniversity_page_banner($args=NULL) {

        if(!$args['title']) {
            $args['title'] = get_the_title();
        }

        if(!$args['tagline']) {
            $args['tagline'] = get_field('page_banner_description');
        }

        if(!$args['bg']) {
            $args['bg'] = get_field('page_banner_background_image') ? get_field('page_banner_background_image')['sizes']['pageBannerImage'] : get_theme_file_uri('/images/ocean.jpg');
        }

        ?>
        <div class="page-banner">
            <div class="page-banner__bg-image" style="background-image: url(<?php echo $args['bg']; ?>)"></div>
            <div class="page-banner__content container container--narrow">
                <h1 class="page-banner__title"><?php echo $args['title']; ?></h1>
                <div class="page-banner__intro">
                    <p><?php echo $args['tagline']; ?></p>
                </div>
            </div>
        </div>
    <?php
    }

    function fictionaluniversity_features() {
        add_theme_support('title-tag');
        add_theme_support('post-thumbnails');
        add_image_size('landscapeImage', 400, 260, true);
        add_image_size('portraitImage', 480, 650, true);
        add_image_size('pageBannerImage', 1920, 300, true);

    }
    add_action('after_setup_theme', 'fictionaluniversity_features');

    function fictional_univeristy_styles_and_scripts() {
        wp_enqueue_script('googleMap', '//maps.googleapis.com/maps/api/js?key=AIzaSyB21jioCxV7nCnkWRNiiptDIp0QsgifJFw&libraries=places', NULL, 1.0, true);
        wp_enqueue_script('fictionaluniversity_main_script', get_theme_file_uri('js/scripts-bundled.js'), NULL, microtime(), true);
        wp_enqueue_style('fontawesome', get_stylesheet_directory_uri() . '/lib/fontawesome/css/all.css');
        wp_enqueue_style('fictionaluniversity_main_stylesheet', get_stylesheet_uri());
        wp_localize_script( 'fictionaluniversity_main_script', 'fictionUniversityData', array(
            'baseUrl'       => get_site_url(),
            'fu_user_nonce' => wp_create_nonce('wp_rest'),
        ));
    }
    add_action('wp_enqueue_scripts', 'fictional_univeristy_styles_and_scripts');

    function fictionaluniversity_post_load_custom_queries($query) {

        if(!is_admin() && is_post_type_archive('event') && $query->is_main_query()) {
            $today = date('Ymd');
            $query->set('meta_key', 'event_date');
            $query->set('orderby', 'meta_value_num');
            $query->set('order', 'ASC');
            $query->set('meta_query', array(
                'key'       => 'event_date',
                'compare'   => '>=',
                'value'     => $today,
            ));
        }

        if(!is_admin() && is_post_type_archive('program') && $query->is_main_query()) {
            $query->set('posts_per_page', '-1');
            $query->set('orderby', 'title');
            $query->set('order', 'ASC');
        }

        if(!is_admin() && is_post_type_archive('campus') && $query->is_main_query()) {
            $query->set('posts_per_page', '-1');
        }
    }
    add_action('pre_get_posts', 'fictionaluniversity_post_load_custom_queries');


    function fiction_university_map_api_key($api) {
        $api['key'] = 'AIzaSyB21jioCxV7nCnkWRNiiptDIp0QsgifJFw';
        return $api;
    }
    add_filter('acf/fields/google_map/api', 'fiction_university_map_api_key');


    function fiction_university_rest_custom_field() {
        register_rest_field( 'post', 'authorName', array(
            'get_callback' => function() { return get_the_author(); },
        ));

        register_rest_field( 'note', 'userNoteCount', array(
            'get_callback' => function() { return count_user_posts(get_current_user_id(), 'note'); },
        ));
    }
    add_action('rest_api_init', 'fiction_university_rest_custom_field');


    function fiction_university_redirect_subs_to_frontend() {
        $currentUser = wp_get_current_user();
        if(count($currentUser->roles)==1 AND $currentUser->roles[0]=="subscriber") {
            wp_redirect(site_url('/'));
            exit;
        }
    }
    add_action('admin_init', 'fiction_university_redirect_subs_to_frontend');

    function fiction_university_hide_admin_bar_for_subscribers() {
        $currentUser = wp_get_current_user();
        if(count($currentUser->roles)==1 AND $currentUser->roles[0]=="subscriber") {
            show_admin_bar(false);
        }
    }
    add_action('wp_loaded', 'fiction_university_hide_admin_bar_for_subscribers');


    function fiction_university_customize_login_header_url() {
        return esc_url(site_url('/'));
    }
    add_filter('login_headerurl', 'fiction_university_customize_login_header_url');

    function fiction_university_login_css() {
        wp_enqueue_style('fictionaluniversity_main_stylesheet', get_stylesheet_uri());
    }
    add_action('login_enqueue_scripts', 'fiction_university_login_css');

    function fiction_university_login_title() {
        return get_bloginfo('name');
    }
    add_filter('login_headertitle', 'fiction_university_login_title');

    //Force Note posts to be private
    function make_note_private($data, $post_arr) {
        if($data['post_type'] == 'note') {
            if(count_user_posts(get_current_user_id(), 'note') > 4 AND !$post_arr['ID']) {
                die("You have reached your note posting limit");
            }
            $data['post_content'] = sanitize_textarea_field($data['post_content']);
            $data['post_title'] = sanitize_text_field($data['post_title']);
        }

        if($data['post_type'] == 'note') {
            $data['post_content'] = sanitize_textarea_field($data['post_content']);
            $data['post_title'] = sanitize_text_field($data['post_title']);
        }

        if($data['post_type'] == 'note' AND $data['post_status'] != "trash") {
            $data['post_status'] = "private";
        }
        return $data;
    }
    add_filter('wp_insert_post_data', 'make_note_private', 10, 2);

