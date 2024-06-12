<?php
/**
 * Timber Navigation Setup
 *
 * Sets up the navigation menus.
 *
 * @package TaotiBaseTheme
 * @author Taoti Creative
 */

/**
 * Register Menus
 *
 * See https://timber.github.io/docs/guides/menus/.
 *
 * Note: Changes must be reflected in taoti_add_to_context().
 *
 * @since 0.1.1
 */
function taoti_register_menus() {

	// Register Navigation Menus with WordPress.
	register_nav_menus(
		array(
			'main-navigation'    => __( 'Main Navigation', 'taoti-base-theme' ),
			'utility-navigation' => __( 'Utility Navigation', 'taoti-base-theme'),
			'footer-navigation'  => __( 'Footer Navigation', 'taoti-base-theme'),
			'footer-utility-navigation'  => __( 'Footer Utility', 'taoti-base-theme'),
		)
	);

}
add_action( 'init', 'taoti_register_menus' );

/**
 * Add Menus to Timber's Context
 *
 * See taoti_register_menus() for list of added menus.
 *
 * @since 0.1.1
 * @param object $context is Timber's context.
 * @todo When updating to Timber 2.x, update 'new Timber\Menu' to 'Timber::get_menu()'.
 * @return object $context.
 */
function taoti_add_to_context( $context ) {
	$context['main_navigation'] = new Timber\Menu( 'main-navigation' );

	if ( has_nav_menu( 'utility-navigation' ) ) {
		$context['utility_navigation'] = new Timber\Menu( 'utility-navigation' );
	}
	if ( has_nav_menu( 'footer-navigation' ) ) {
		$context['footer_navigation'] = new Timber\Menu( 'footer-navigation' );
	}
	if ( has_nav_menu( 'footer-utility-navigation' ) ) {
		$context['footer_utility_navigation'] = new Timber\Menu( 'footer-utility-navigation' );
	}

	$page = 'page';
	if (is_front_page()) {
		$page = 'homepage';
		$context['home_hero_class'] = 'riva-home';
	} else if (is_archive()) {
		$page = 'archive';
	} else if (is_single()) {
		$queried_object = get_queried_object();

		if ($queried_object->post_type == 'insights') {
			$page = 'single-insights';
		} else if ( 'leadership' === $queried_object->post_type ) {
			$page = 'leadership';
			//$featured_image = get_the_post_thumbnail($queried_object->ID);
			$featured_image =  wp_get_attachment_image_src( get_post_thumbnail_id( $queried_object->ID ), 'single-post-thumbnail' );
			$context['bio_featured_image'] = $featured_image[0];
		} else {
			$page = 'single';
		}
	}
	$context['page_type'] = $page;

	return $context;
}
add_filter( 'timber/context', 'taoti_add_to_context' );