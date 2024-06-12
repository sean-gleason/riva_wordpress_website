<?php

/**
 * Helper: Enqueue Non-Critical CSS Styles and Scripts
 *
 * The theme CSS is loaded in the <head> via the 'taoti_do_css' action, so critical and noncritical CSS can be loaded seperately. The standard enqueue functions don't support this sort of thing yet.
 *
 * @package TaotiBaseTheme
 * @author Taoti Creative
 * @see taoti_remove_type_attr() in 'inc/wp-reset.php' for removal of 'type="javascript"' from script tags.
 * @see taoti_deregister_scripts() in 'inc/wp-reset.php' for unregsistered script 'wp-embed'.
 */

/**
 * Load Taoti's Scripts (in Footer)
 *
 * PURPOSE : Dequeue jQuery, load the theme's main JS file, localize common things like the AJAX URL.
 * NOTES: All scripts should load at the end of the page, use TRUE for the 5th parameter of wp_register_script().
 *
 * To add/replace the default jQuery:
 *   wp_enqueue_script('jquery', '//ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js', array(), '3.3.1', true);
 *
 * @since 0.1.1
 * @see https://developer.wordpress.org/reference/functions/wp_enqueue_script/
 */
function taoti_scripts()
{
	if (!is_admin()) {

		// Deregister WordPress jQuery and register Google's, only if you need jQuery.
		if (!is_customize_preview()) {
			wp_deregister_script('jquery');
			wp_enqueue_script('jquery', '/wp-content/themes/riva-wp/js/libraries/jquery.min.js', array(), '3.6.0', true);
		}

		/**
		 * Main Scripts
		 *
		 * This file is concatenated from the files inside of js/development/
		 */
		wp_enqueue_script(
			'scripts',
			get_template_directory_uri() . '/dist/js/main.js',
			array( 'jquery' ),
			filemtime( get_template_directory() . '/dist/js/main.js' ),
			true
		);

		wp_localize_script('scripts', 'ajax_var', array(
			'url'    => admin_url('admin-ajax.php'),
			'nonce'  => wp_create_nonce('my-ajax-nonce')
		));

		/**
		 * Extra - Localizing Script(s) for Translation Example
		 *
		 * This example code can be copied and used to 'localize' a script into WordPress for translation, because WordPress does not (currently) provide js-based translations.
		 *
		 * wp_localize_script(
		 *  'scripts',
		 *  'taoti_js',
		 *  array(
		 *   'ajax_url' => admin_url('admin-ajax.php'),
		 *   'path'     => get_template_directory_uri() . '/js',
		 *  )
		 * );
		 *
		 * @see https://developer.wordpress.org/reference/functions/wp_localize_script/
		 */
	}
}
add_action('wp_enqueue_scripts', 'taoti_scripts');

/**
 * Non-Critical CSS Main Stylesheet
 *
 * @since 0.1.1
 * @see Instructions on loading the non-critical CSS asyncronously - https://github.com/filamentgroup/loadCSS
 * @todo Update code to PROPERLY apply wp_enqueue_style() and/or move this code directly into TWIG files.
 */
function taoti_styles() {

	// Set up the URL to the non-critical CSS file with a version number for cache-busting.
	$css_filemtime = filemtime( get_template_directory() . '/dist/css/main.css' );
	$css_version   = '?v=' . $css_filemtime;
	$css_href      = get_template_directory_uri() . '/dist/css/main.css' . $css_version;
	?>

	<!-- <link rel="preload" href="<?php echo esc_url( $css_href ); ?>" as="style" onload="this.onload=null;this.rel='stylesheet'"> -->
	<link rel="stylesheet" href="<?php echo esc_url( $css_href ); ?>" media="print" onload="this.media='all'; this.onload=null;"><?php // phpcs:ignore ?>
	<noscript><link rel="stylesheet" href="<?php echo esc_url( $css_href ); ?>"></noscript><?php // phpcs:ignore ?>

	<?php

}
add_action('taoti_do_css', 'taoti_styles');

/**
 * Admin area enqueues
 *
 * Usage - Enable using the following:
 *   add_action('admin_enqueue_scripts', 'taoti_admin_theme_enqueues');
 *
 * @since 0.1.1
 */
function taoti_admin_theme_enqueues() {
	// CSS for admin.
	wp_enqueue_style(
		'admin-theme',
		get_template_directory_uri() . '/dist/css/admin.css',
		array(),
		filemtime( get_template_directory() . '/admin/css/admin.css' )
	);

	// JS for admin.
	wp_enqueue_script(
		'admin-scripts',
		get_template_directory_uri() . '/dist/js/dashboard.js',
		array( 'jquery' ),
		filemtime( get_template_directory() . '/dist/js/dashboard.js' ),
		true
	);

	wp_localize_script(
		'admin-scripts',
		'taoti_admin_js',
		array(
			'theme_path' => get_template_directory_uri(),
		)
	);
}

/**
 * Login screen enqueues
 *
 * Usage - Enable using the following:
 *   add_action( 'login_enqueue_scripts', 'taoti_login_stylesheet' );
 *
 * @since 0.1.1
 */
function taoti_login_stylesheet() {
	// CSS for login screen.
	wp_enqueue_style(
		'login-theme',
		get_template_directory_uri() . '/dist/css/login.css',
		array(),
		filemtime( get_template_directory() . '/dist/css/login.css' )
	);
}

/**
 * Post content editor (TinyMCE) enqueues
 *
 * Load a CSS file to use for the editor in the iframe.
 *
 * Usage - Enable using the following:
 *   add_action('admin_init', 'taoti_tinymce_style');
 *
 * @since 0.1.1
 */
function taoti_tinymce_style() {
	// CSS for admin.
	add_editor_style(
		get_template_directory_uri() . '/dist/css/tinymce.css',
		array(),
		filemtime( get_template_directory() . '/dist/css/tinymce.css' )
	);
}
