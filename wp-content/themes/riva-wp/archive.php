<?php
/**
 * Archive Template
 *
 * @package DMAWP
 * @author Taoti Creative
 * @todo When updating to Timber 2.x, check Timber::get_post() and Timber::get_posts().
 *   Current usage for Timber Post would be: 'use Timber\{Post}' and 'new Timber\Post()'.
 *   Updated code will be 'use Timber' -> 'Timber::get_post()'.
 */

/** Initial Template(s) */
$templates = array( 'archive.twig', 'index.twig' );

$context = Timber::context();

/** Add 'Options' to Archives */
$context['page_options'] = get_fields('options');


/** Define the available context variables, based on the archive-type requested */

$archive_post_type = get_post_type();
$archive_template = 'archive-' . $archive_post_type . '.twig';

$context['title'] = post_type_archive_title( '', false );
array_unshift($templates, $archive_template);

$context['posts'] = Timber::get_posts(
	array(
		'post_type' => $archive_post_type,
		'posts_status' => 'publish'
	),
);

/** Get all taxonomies and terms for CPT **/
$filter_terms = array();

if ($archive_post_type == 'insights') { // We just want 2 taxonomies for Insights (Insight Type & Capability)
	$taxonomies = array('insight-type', 'capability');
} else { // Pull them dynamically 
	$taxonomies = get_object_taxonomies( $archive_post_type );
}
//print_r($taxonomies);
//exit();

foreach($taxonomies as $taxonomy) {
	$terms = get_terms(array(
		'taxonomy' => $taxonomy,
		'hide_empty' => false,
	));

	foreach($terms as $term) {
		$filter_terms[$taxonomy][] = array('term_id' => $term->term_id, 'name' => $term->name);
	}
}

$context['filter_terms'] = $filter_terms;

if (! empty($_GET['search']) ) {
	$context['search_term'] = $_GET['search'];
}


if ($archive_post_type == 'insights') {

	// Get Featured Insight
	$args = array(
		'post_type' => 'insights',
		'post_status' => 'publish',
		'posts_per_page' => 1,
		'orderby' => 'date',
		'order' => 'DESC',
		'meta_key'      => 'is_featured',
		'meta_value'    => '1',
		'compare'		=> '='
	);

	$featured_insight = new WP_Query($args);
	if ($featured_insight->have_posts()) {
		while ($featured_insight->have_posts()) {
			$featured_insight->the_post();

			$insight_types = wp_get_post_terms( $post->ID, array( 'insight-type' ) );
			$tag = (count($insight_types) > 0) ? $insight_types[0] : '';

			$image = get_field('featured_image', $post->ID);

			$featured_insight_post = array();
			$featured_insight_post['featured_image'] = $image['sizes']['720p'];
			if ($tag) {
				$featured_insight_post['tag'] = $tag->name;
				$featured_insight_post['tag_link'] = $tag->slug;
			}
			$featured_insight_post['link'] = get_permalink($post->ID);
			$featured_insight_post['title'] = $post->post_title;
			$featured_insight_post['excerpt'] = get_field('excerpt', $post->ID);
			$featured_insight_post['author'] = get_field('author', $post->ID);
			$featured_insight_post['author_image'] = get_the_post_thumbnail($featured_insight_post['author']->ID);
			$featured_insight_post['date'] = get_field('insight_date', $post->ID);
		}

		wp_reset_postdata();
	}
	$context['featured_insight'] = $featured_insight_post;
}

/** Yoast SEO Breadcrumbs */
if ( function_exists( 'yoast_breadcrumb' ) ) {
	$context['breadcrumbs'] = yoast_breadcrumb('<nav id="breadcrumbs" class="main-breadcrumbs">', '</nav>', false );
}

if (is_a(get_queried_object(), 'WP_Term')) {
	$issue_type = get_queried_object();
	$context['issue_type_id'] = $issue_type->term_id;
}

/** Flag to TWIG that this is a Post-Type Archive (and what type) */
$context['archive_type'] = $archive_post_type;
Timber::render( $templates, $context );
