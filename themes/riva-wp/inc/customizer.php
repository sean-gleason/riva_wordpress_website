<?php
/**
 * Helper: WordPress 'Customizer' Controls
 *
 * Rebuild and use the 'Customizer' toolkits.
 *
 * @package TaotiBaseTheme
 * @author Taoti Creative
 */

/**
 * PURPOSE : Options for Appearance > Customize. Add to this function to set up your own sections and options in the WordPress Customizer.
 *
 * NOTE: Options for contact details, social URLs, and the 404 page are set up here as a starting point. Use these, remove them, or add more.
 *
 * Additional Option:
 *   $wp_customize->remove_panel('widgets');
 *
 * @since 0.1.1
 * @param object $wp_customize - WP Customizer object.
 * @return object $wp_customize
 */
function taoti_remove_customizer_defaults( $wp_customize ) {
	$wp_customize->remove_section('title_tagline');
	$wp_customize->remove_section('colors');
	$wp_customize->remove_section('header_image');
	$wp_customize->remove_section('background_image');
	$wp_customize->remove_section('static_front_page');
	$wp_customize->remove_section('custom_css');

	return $wp_customize;
}
add_action( 'customize_register', 'taoti_remove_customizer_defaults' );

/**
 * Section - 404 Page Customization
 *
 * @since 0.1.1
 * @param object $wp_customize - WP Customizer object.
 * @return object $wp_customize
 */
function taoti_customizer_404_page( $wp_customize ) {

	$wp_customize->add_section(
		'taoti_section_404_page',
		array(
			'title'       => __( '404 Page', 'taoti' ),
			'description' => 'Add a custom title and message to your 404 page.',
			'priority'    => 100,
		)
	);

	// 404 page title
	$wp_customize->add_setting(
		'taoti_404_page_title',
		array(
			'default'   => 'Not Found (404)',
			'transport' => 'postMessage',
		)
	);

	$wp_customize->add_control(
		'taoti_404_page_title',
		array(
			'label'       => __( 'Page Title', 'taoti' ),
			'section'     => 'taoti_section_404_page',
			'settings'    => 'taoti_404_page_title',
			'type'        => 'text',
			'description' => 'Set the main page title.',
		)
	);

	// 404 page content
	$wp_customize->add_setting(
		'taoti_404_content',
		array(
			'default'   => 'The content you were looking for could not be found.',
			'transport' => 'postMessage',
		)
	);

	$wp_customize->add_control(
		'taoti_404_content',
		array(
			'label'       => __( 'Message', 'taoti' ),
			'section'     => 'taoti_section_404_page',
			'settings'    => 'taoti_404_content',
			'type'        => 'textarea',
			'description' => 'Set the message that lets a user know what to do.',
		)
	);

	return $wp_customize;
}
add_action( 'customize_register', 'taoti_customizer_404_page' );

/**
 * Customizer 'Live Preview' Theming
 *
 * Re-theme the Customizer.
 *
 * @since 0.1.1
 */
function taoti_customizer_live_preview() {
		wp_enqueue_script(
			'taoti-themecustomizer',
			get_template_directory_uri() . '/js/admin/theme-customizer.js',
			array( 'jquery', 'customize-preview' ),
			'1.0',
			true
		);
}
add_action( 'customize_preview_init', 'taoti_customizer_live_preview', 0, 99 );
