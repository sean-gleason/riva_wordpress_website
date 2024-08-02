<?php

/** RESOURCES QUERY */
function taoti_archive_query_cb()
{
    try {
        $posts_per_page = 9;
        $has_filters = false;
        $tax_query = array();

        if (array_key_exists('terms', $_POST) && count($_POST['terms']) > 0) {
            foreach($_POST['terms'] as $taxonomy => $terms) {

                $tax_query[] = array(
                    'taxonomy' => $taxonomy,
                    'field' => 'term_id',
                    'terms' => $terms
                );
                $has_filters = true;

                if ($has_filters)
                    $tax_query['relation'] = 'AND';
            }
        }

        $args = array(
            'post_type'      => $_POST['post_type'],
            'post_status'    => 'publish',
            'posts_per_page' => -1,
            'tax_query'      => $tax_query
        );

        if ($_POST['orderby'] == 'title') {
            $args['orderby'] = 'title';
            $args['order'] = 'asc';
        } else if ($_POST['post_type'] == 'insights' && $_POST['orderby'] == 'oldest') {
            $args['meta_key'] = 'insight_date';
            $args['meta_type'] = 'DATETIME';
            $args['orderby'] = 'meta_value';
            $args['order'] = 'ASC';
        } else if ($_POST['post_type'] != 'insights' && $_POST['orderby'] == 'oldest') {
            $args['orderby'] = 'date';
            $args['order'] = 'ASC';
        } else if ($_POST['post_type'] == 'insights' && $_POST['orderby'] == 'latest') {
            $args['meta_key'] = 'insight_date';
            $args['meta_type'] = 'DATETIME';
            $args['orderby'] = 'meta_value';
            $args['order'] = 'DESC';
        } else {
            $args['meta_query'] = array(
                'relation' => 'AND',
                'featured_clause' => array(
                    'key' => 'is_featured',
                    'compare' => 'EXISTS',
                ),
                'date_clause' => array(
                    'key' => 'insight_date',
                    'compare' => 'EXISTS',
                ),
            );
            $args['orderby'] = array(
                'featured_clause' => 'DESC',
                'date_clause' => 'DESC'
            );
        }

        if (!empty($_POST['search'])) {
            $args['s'] = $_POST['search'];
        }

        $all_posts = Timber::get_posts($args);
        $html = '';

        if (count($all_posts) > 0) {
            $args['posts_per_page'] = $posts_per_page;
            $args['paged'] = $_POST['paged'];
            $posts = Timber::get_posts($args);
            if ($posts) {
                ob_start();

                foreach ($posts as $post) {
                    if ($_POST['post_type'] == 'leadership') {
                        $context = Timber::context();
                        $context['featured_image'] = get_the_post_thumbnail($post->ID);
                        $context['first_name'] = get_field('first_name', $post->ID);
                        $context['last_name'] = get_field('last_name', $post->ID);
                        $context['job_title'] = get_field('job_title', $post->ID);
                        $context['bio_link'] = get_field('bio_link', $post->ID);
    
                        Timber::render('card-people.twig', $context);
                    } else {

                        $insight_types = wp_get_post_terms( $post->ID, array( 'insight-type' ) );
                        $tag = (count($insight_types) > 0) ? $insight_types[0] : '';
    
                        $image = get_field('listing_image', $post->ID);
    
                        $context = Timber::context();
                        $context['card_image'] = $image['sizes']['720p'];
                        $context['is_featured'] = get_field('is_featured', $post->ID);
                        if ($tag) {
                            $context['card_tag'] = $tag->name;
                            $context['card_tag_link'] = $tag->slug;
                        }
                        $context['card_link'] = get_permalink($post->ID);
                        $context['card_title'] = $post->post_title;
                        $context['card_excerpt'] = get_field('excerpt', $post->ID);
                        $context['card_author'] = get_field('author', $post->ID);
                        $context['card_date'] = get_field('insight_date', $post->ID);
    
                        Timber::render('card.twig', $context);
                    }
                }


                $html = ob_get_clean();
            }
        }

        /*$post_count = count($all_posts);
        $big = 999999;
		$pagination = paginate_links(
			array(
				'base' => 'javascript:doPagination();', // str_replace($big, '%#%', get_pagenum_link($big)),
				'current' => $_POST['paged'],
				'total' => ceil(count($all_posts) / $posts_per_page),
				'show_all' => false,
				'prev_next' => true,
				'prev_text' => __( '<' ),
				'next_text' => __( '>' ),
				'type'      => 'list',
				'add_args' => '',
			)
		);*/

        wp_send_json_success(
            [
                'html'        => $html,
                'count'       => count($all_posts),
                'posts_per_page'    => $posts_per_page,
                // 'pagination' => $pagination
                'see_more' => (sizeof($all_posts) > 0 && $_POST['paged'] != ceil(sizeof($all_posts) / $posts_per_page))
            ]
        );
    } catch (Exception $e) {
        wp_send_json_error(['error' => $e->getMessage()]);
    }
}

add_action('wp_ajax_nopriv_taoti_archive_query', 'taoti_archive_query_cb');
add_action('wp_ajax_taoti_archive_query', 'taoti_archive_query_cb');