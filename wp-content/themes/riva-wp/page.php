<?php
/**
 * Template: Page
 *
 * @package TaotiBaseTheme
 * @author Taoti Creative
 */

$context          = Timber::context();
$single_page      = Timber::get_post();
$context['post']  = $single_page;
$context['posts'] = Timber::get_posts();

/** Add 'Options' to Pages */
$context['page_options'] = get_fields('options');

/** Yoast SEO Breadcrumbs */
if (function_exists('yoast_breadcrumb')) {
	$context['breadcrumbs'] = yoast_breadcrumb('<nav id="breadcrumbs" class="main-breadcrumbs container">', '</nav>', false);
}

Timber::render(
	array( 'page-' . $single_page->post_name . '.twig', 'page.twig' ),
	$context
);
