<?php

add_action('rest_api_init', 'fiction_university_like_routes');

function fiction_university_like_routes() {
    register_rest_route('fiction-university/v1', 'manage-like', array(
        'methods'       => 'POST',
        'callback'      => 'create_like'
    ));

    register_rest_route('fiction-university/v1', 'manage-like', array(
        'methods'       => 'DELETE',
        'callback'      => 'delete_like'
    ));
}

function create_like($data) {
    if(is_user_logged_in()) {
        $professor_id = sanitize_text_field($data['professorId']);

        $exist_query = new WP_Query(array(
            'author'        => get_current_user_id(),
            'post_type'     => 'like',
            'meta_query'    => array(
                array(
                    'key'       => 'liked_professor_id',
                    'compare'   => '=',
                    'value'     => $professor_id
                )
            )
        ));

        if($exist_query->found_posts == 0 AND get_post_type($professor_id) == 'professor') {
            return wp_insert_post(array(
                'post_type'     => 'like',
                'post_status'   => 'publish',
                'post_title'    => 'A Like by ' .  sanitize_text_field($data['userName']),
                'post_content'  => 'I am liking this post',
                'meta_input'    => array(
                    'liked_professor_id' => $professor_id
                ),
            ));
        } else {
            die("Invalid professor Id");
        }


    } else {
        die("Sorry! You must be logged in to use this feature");
    }
}

function delete_like($data) {
    $like_id = sanitize_text_field($data['likeId']);
    if(get_current_user_id() == get_post_field('post_author', $like_id) AND get_post_type($like_id) == 'like') {
        wp_delete_post($like_id, true);
        return "Congrats!";
    } else {
        die("Sorry! You do not have the permission to delete this like");
    }
}