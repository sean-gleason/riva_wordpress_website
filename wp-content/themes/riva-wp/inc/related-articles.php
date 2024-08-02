<?php
/** 
 * This is used to get the IDs for the related articles (insights)
 */
function taoti_get_related_articles( $post_id ) {
    $related_articles = array();
    $capability = wp_get_post_terms( $post_id, array( 'capability' ) );
    if (sizeof($capability) > 0) {
        $term_id = $capability[0]->term_id;

        $args = array(
            'post_type' => 'insights',
            'post_status' => 'publish',
            'posts_per_page' => 4,
            'orderby' => 'meta_value',
            'order' => 'DESC',
            'meta_key' => 'insight_date',
            'meta_type' => 'DATETIME',
            'post__not_in' => array( $post_id ),
            'tax_query' => array(
                array(
                    'taxonomy' => 'capability',
                    'field'    => 'term_id',
                    'terms'    => $term_id,
                ),
            ),
        );
        $posts = new WP_Query($args);
        if ($posts->have_posts()) {
            while ($posts->have_posts()) {
                $posts->the_post();
                $related_articles[] = get_the_ID();
            }
            wp_reset_postdata();
        }
    }


    $remaining_news = 4 - sizeof($related_articles); // Check if we could get 3 posts

    // If we still don't have 4 related, pull others by same insight type
    if ($remaining_news > 0) { 
        $insight_type = wp_get_post_terms( $post_id, array( 'insight-type' ) );
        if (sizeof($insight_type) > 0) {
            $term_id = $insight_type[0]->term_id;
    
            $args = array(
                'post_type' => 'insights',
                'post_status' => 'publish',
                'posts_per_page' => $remaining_news,
                'orderby' => 'meta_value',
                'order' => 'DESC',
                'meta_key' => 'insight_date',
                'meta_type' => 'DATETIME',
                'post__not_in' => array_merge( array($post_id), $related_articles ),
                'tax_query' => array(
                    array(
                        'taxonomy' => 'insight-type',
                        'field'    => 'term_id',
                        'terms'    => $term_id,
                    ),
                ),
            );
            $posts = new WP_Query($args);
            if ($posts->have_posts()) {
                while ($posts->have_posts()) {
                    $posts->the_post();
                    $related_articles[] = get_the_ID();
                }
                wp_reset_postdata();
            }
        }
    }

    // If we still don't have 4 related, pull any other insight type
    $remaining_news = 4 - sizeof($related_articles); // Check if we could get 3 posts
    if ($remaining_news > 0) { 
        $args = array(
            'post_type' => 'insights',
            'post_status' => 'publish',
            'posts_per_page' => $remaining_news,
            'orderby' => 'meta_value',
            'order' => 'DESC',
            'meta_key' => 'insight_date',
            'meta_type' => 'DATETIME',
            'post__not_in' => array_merge( array($post_id), $related_articles )
        );
        $posts = new WP_Query($args);
        if ($posts->have_posts()) {
            while ($posts->have_posts()) {
                $posts->the_post();
                $related_articles[] = get_the_ID();
            }
            wp_reset_postdata();
        }
    }

    return $related_articles;
}