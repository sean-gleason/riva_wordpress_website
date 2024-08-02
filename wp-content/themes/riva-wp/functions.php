<?php
/**
 * Taoti Base Theme functions and definitions
 *
 * @package TaotiBaseTheme
 * @file functions.php
 * @author Taoti Creative
 */

// Autoloader.
$composer_autoload = __DIR__ . '/vendor/autoload.php';
if ( file_exists( $composer_autoload ) ) {
	require_once $composer_autoload;
	$timber = new Timber\Timber();
}

/**
 * This ensures that Timber is loaded and available as a PHP class.
 * If not, it gives an error message to help direct developers on where to activate
 */
if ( ! class_exists( 'Timber' ) ) {
	add_action(
		'admin_notices',
		function() {
			echo '<div class="error"><p>Timber not activated. Make sure you activate the plugin in <a href="' . esc_url( admin_url( 'plugins.php#timber' ) ) . '">' . esc_url( admin_url( 'plugins.php' ) ) . '</a></p></div>';
		}
	);

	add_filter(
		'template_include',
		function( $template ) {
			return get_stylesheet_directory() . '/no-timber/index.html';
		}
	);
	return;
}

/** Function Includes. */
require_once __DIR__ . '/inc/acf/acf.php';
require_once __DIR__ . '/inc/acf/acf-json.php';
require_once __DIR__ . '/inc/wp-reset.php';
require_once __DIR__ . '/inc/post-types.php';
require_once __DIR__ . '/inc/taxonomies.php';
require_once __DIR__ . '/inc/helpers.php';
require_once __DIR__ . '/inc/globals.php';
require_once __DIR__ . '/inc/excerpt.php';
require_once __DIR__ . '/inc/walkers.php';
require_once __DIR__ . '/inc/enqueue.php';
require_once __DIR__ . '/inc/image-sizes.php';
require_once __DIR__ . '/inc/shortcodes.php';
require_once __DIR__ . '/inc/navigation.php';
require_once __DIR__ . '/inc/options.php';
require_once __DIR__ . '/inc/customizer.php';
require_once __DIR__ . '/inc/admin-bar.php';
// require_once __DIR__ . '/inc/tinyMCE/tinymce.styles.php';
// require_once __DIR__ . '/inc/tinyMCE/tinymce.toolbars.php';
// require_once __DIR__ . '/inc/tinyMCE/tinymce.customizations.php';
require_once __DIR__ . '/inc/user-roles.php';
require_once __DIR__ . '/inc/archive-ajax.php';
require_once __DIR__ . '/inc/gated-content.php';
require_once __DIR__ . '/inc/related-articles.php';

/** Modules */
require_once __DIR__ . '/inc/modules.php';

/** Blocks */
require_once __DIR__ . '/inc/acf-blocks.php';

/**
 * Add Access to the Post Type
 *
 * Note: Additional Roles can be given access as needed.
 */
taoti_add_admin_capabilities( 'administrator', 'event-webinar', 'events-webinars' );
taoti_add_admin_capabilities( 'editor', 'event-webinar', 'events-webinars' );
