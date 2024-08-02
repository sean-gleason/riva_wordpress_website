<?php
/**
 * Template: Single
 *
 * @package TaotiBaseTheme
 * @author Taoti Creative
 */

$context          = Timber::context();
$single_post      = Timber::get_post();
$context['post']  = $single_post;
$context['posts'] = Timber::get_posts();

/** Add 'Options' to Pages */
$context['page_options'] = get_fields('options');

/** Yoast SEO Breadcrumbs */
if ( function_exists( 'yoast_breadcrumb' ) ) {
	$context['breadcrumbs'] = yoast_breadcrumb('<nav id="breadcrumbs" class="main-breadcrumbs">', '</nav>', false );
}

/** Get all the POST TYPES terms */
$all_posttype_terms            = get_the_terms( $single_post->ID, 'post_types' );
$context['all_posttype_terms'] = $all_posttype_terms;

if ( $all_posttype_terms ) {
	$context['parent_posttype_term'] = reset( $all_posttype_terms );
}

/**
 * Get Most recent posts in category but not posts that are opinions or offsite
 *
 * Another Option:
 *   $current_category = $current_category[0]->cat_ID;
 */
$current_category = get_the_category( $single_post->ID );

/**
 * Query Timber
 *
 * Example Custom Query:
 *  'tax_query'     => array(
 *    array(
 *     'taxonomy' => '',
 *     'terms' => array(
 *    ),
 *    'field' => 'slug',
 *    'operator' => 'NOT IN',
 *   ),
 *  ),
 */
$context['related_posts'] = Timber::get_posts(
	array(
		'post_type'    => 'insights',
		'post__in' => taoti_get_related_articles($single_post->ID),
		'orderby' => 'meta_value',
		'order' => 'DESC',
		'meta_key' => 'insight_date',
		'meta_type' => 'DATETIME',
	)
);

$insight_types = wp_get_post_terms( $post->ID, array( 'insight-type' ) );
$context['insight_types'] = $insight_types;

// Get all posts to find previous and next articles
$all_posts = Timber::get_posts(
	array(
		'post_type'    => 'insights',
		'numberposts'  => -1,
		'offset'       => 0,
		'post_status'  => 'publish',
		'order'        => 'DESC'
	)
);
$previous_post_id = 0;
$next_post_id = 0;
$found_current = false;

foreach($all_posts as $post) {
	if ($post->ID == $single_post->ID)
		$found_current = true;

	if (!$found_current)
		$previous_post_id = $post->ID;
	else if ($found_current && $next_post_id == 0 && $post->ID != $single_post->ID) 
		$next_post_id = $post->ID;
}

if ($previous_post_id > 0)
	$context['previous_post'] = get_permalink($previous_post_id);
if ($next_post_id > 0)
	$context['next_post'] = get_permalink($next_post_id);

if ( post_password_required( $single_post->ID ) ) {
	Timber::render( 'single-password.twig', $context );
} else {
	Timber::render( array( 'single-' . $single_post->ID . '.twig', 'single-' . $single_post->post_type . '.twig', 'single.twig' ), $context );
}
