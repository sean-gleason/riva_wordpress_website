<?php
/**
 * Template 404 Page
 *
 * @package TaotiBaseTheme
 * @author Taoti Creative
 * @see index.php, single.php, and page.php.
 */

$context         = Timber::context();
$single_page     = Timber::get_post();
$context['post'] = $single_page;

/** Add 404 Flag to Context */
$context['is_404'] = true;

/** Add 'Options' to Pages */
$context['page_options'] = get_fields('options');

/** Yoast SEO Breadcrumbs */
if ( function_exists( 'yoast_breadcrumb' ) ) {
	$context['breadcrumbs'] = '<div class="breadcrumbs"></div>';
}

Timber::render(
	array( '404.twig' ),
	$context
);
