<?php
/**
 * Template: Front-Page
 *
 * Note: This template only loads as a fallback due to errors.
 *
 * @package TaotiBaseTheme
 * @author Taoti Creative
 * @see index.php, single.php, and page.php.
 */

$context          = Timber::context();
$single_page      = Timber::get_post();
$context['post']  = $single_page;
$context['posts'] = Timber::get_posts();

/** Add 'Options' to Pages */
$context['page_options'] = get_fields('options');

Timber::render(
	array( 'front-page.twig', 'home.twig' ),
	$context
);

