<?php

    function university_register_api_custom_rest() {
        //Register a route to be accessed through the Ajax request
        register_rest_route('fictionaluniversity/v1', 'search', array(
            'methods'   => WP_REST_SERVER::READABLE,
            'callback'  => 'university_search_results'
        ));
    }
    add_action('rest_api_init', 'university_register_api_custom_rest');

    function university_search_results($data) {
        //Custom Query for pulling out ALL Post types from database
        $mainQuery = new WP_Query(array(
            'post_type' => array('post', 'page', 'program', 'event', 'professor', 'campus'),
            's'         => sanitize_text_field($data['keyword']),
        ));

        $resultsArray = array(
            'generalInfo'  => array(),
            'programs'       => array(),
            'events'         => array(),
            'professors'     => array(),
            'campuses'      => array()
        );
        while($mainQuery->have_posts()) {
            $mainQuery->the_post();

            //if Custom query brings up a post type of post or page. Set up a JSON with the following fields
            if(get_post_type() == "post" or get_post_type() == "page") {
                array_push($resultsArray['generalInfo'], array(
                    'postType'      => get_post_type(),
                    'title'         => get_the_title(),
                    'permalink'     => get_the_permalink(),
                    'authorName'    => get_the_author(),
                ));
            }


            //if query brings up a post type of programs. Set up a JSON with the following fields
            if(get_post_type() == "program") {
                //push related campus into the campus result array for JSON output.
                $relatedCampuses = get_field('related_campuses');
                if($relatedCampuses) {
                    foreach($relatedCampuses as $campus) {
                        array_push($resultsArray['campuses'], array(
                            'title'     => get_the_title($campus),
                            'permalink'     => get_the_permalink($campus)
                        ));
                    }
                }

                array_push($resultsArray['programs'], array(
                    'postType'      => get_post_type(),
                    'title'         => get_the_title(),
                    'permalink'     => get_the_permalink(),
                    'authorName'    => get_the_author(),
                    'id'            => get_the_id(),
                ));
            }

            //if Custom query brings up a post type of event. Set up a JSON with the following fields
            if(get_post_type() == "event") {
                $formatEventDate = new DateTime(get_field('event_date'));

                array_push($resultsArray['events'], array(
                    'postType'          => get_post_type(),
                    'title'             => get_the_title(),
                    'permalink'         => get_the_permalink(),
                    'eventMonth'        => $formatEventDate->format('M'),
                    'eventDay'          => $formatEventDate->format('d'),
                    'eventDescription'  => wp_trim_words(get_the_content(), 18),
                ));
            }


            //if Custom query brings up a post type of professor. Set up a JSON with the following fields
            if(get_post_type() == "professor") {
                array_push($resultsArray['professors'], array(
                    'postType'      => get_post_type(),
                    'title'         => get_the_title(),
                    'permalink'     => get_the_permalink(),
                    'authorName'    => get_the_author(),
                    'thumbnailUrl'  => get_the_post_thumbnail_url(0, 'landscapeImage')
                ));
            }

            //if Custom query brings up a post type of campus. Set up a JSON with the following fields
            if(get_post_type() == "campus") {
                array_push($resultsArray['campuses'], array(
                    'postType'      => get_post_type(),
                    'title'         => get_the_title(),
                    'link'          => get_the_permalink(),
                    'authorName'    => get_the_author(),
                ));
            }
        }

        //Additional JSON set up to ensure there is relational queries which returns JSON Fields related to the search term.

        if($resultsArray['programs']) {

            /*Create new Array for cmparison in case there are more than one program matching the search keyword*/
            $checkAllRelatedPrograms = array(
                'relation'      => 'OR',
            );
            foreach($resultsArray['programs'] as $program) {
                array_push($checkAllRelatedPrograms, array(
                    'key'       => 'related_programs',
                    'compare'   => 'LIKE',
                    'value'     => '"' . $program['id'] . '"',
                ));
            }

            $relationalMetaQuery = new WP_Query(array(
                'post_type'         => array('professor', 'event'),
                'meta_query'        => $checkAllRelatedPrograms,
            ));


            while($relationalMetaQuery->have_posts()) {
                $relationalMetaQuery->the_post();

                if(get_post_type() == "professor") {
                    array_push($resultsArray['professors'],  array(
                        'postType'      => get_post_type(),
                        'title'         => get_the_title(),
                        'permalink'     => get_the_permalink(),
                        'authorName'    => get_the_author(),
                        'thumbnailUrl'  => get_the_post_thumbnail_url(0, 'landscapeImage')
                    ));
                }

                if(get_post_type() == "event") {
                    $formatEventDate = new DateTime(get_field('event_date'));
                    array_push($resultsArray['events'],  array(
                        'postType'          => get_post_type(),
                        'title'             => get_the_title(),
                        'permalink'         => get_the_permalink(),
                        'eventMonth'        => $formatEventDate->format('M'),
                        'eventDay'          => $formatEventDate->format('d'),
                        'eventDescription'  => wp_trim_words(get_the_content(), 18),
                    ));
                }

            }

            $resultsArray['professors'] = array_values(array_unique($resultsArray['professors'], SORT_REGULAR));
            $resultsArray['events'] = array_values(array_unique($resultsArray['events'], SORT_REGULAR));

        }


        return $resultsArray;
    }