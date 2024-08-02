<?php
/**
 * Template: Index
 *
 * @package TaotiBaseTheme
 * @author Taoti Creative
 */

use Timber;

$context          = Timber::context();
$context['post']  = Timber::get_post();
$context['posts'] = Timber::get_posts();

/** Add 'Options' to Pages */
$context['page_options'] = get_fields('options');

$templates = array( 'index.twig' );
if ( is_home() ) {
	array_unshift( $templates, 'front-page.twig', 'home.twig' );
}
Timber::render( $templates, $context );
