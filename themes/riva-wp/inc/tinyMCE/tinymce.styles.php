<?php
/**
 * Styling customizations/tweaks for the TinyMCE editor
 *
 * @package TaotiBaseTheme
 * @author Taoti Creative
 */

/**
 * Adds the Formats dropdown to the TinyMCE toolbar.
 *
 * @since 0.1.1
 * @see https://codex.wordpress.org/TinyMCE_Custom_Styles
 * @param array $buttons - slugs for the TinyMCE toolbar buttons.
 * @return $buttons
 */
function taoti_mce_add_formats_dropdown( $buttons ) {
	array_unshift( $buttons, 'styleselect' );
	return $buttons;
}
add_filter('mce_buttons_2', 'taoti_mce_add_formats_dropdown');

/**
 * Add options to the Formats dropdown in this function, or if you start adding a bunch then split them into their own functions/files.
 *
 * @since 0.1.1
 * @todo Test and deploy WordPress 4.1 update - Use 'wp_json_encode()' instead of 'json_encode'.
 * @see https://codex.wordpress.org/TinyMCE_Custom_Styles
 * @param array $settings - style_formats array of child arrays, each child array defines one of the options.
 * @return $settings
 */
function taoti_mce_add_formats_options( $settings ) {

	$style_formats = array(
		array(
			'title'    => 'Button',
			'selector' => 'a',
			'classes'  => 'button',
		),
	);

	$settings['style_formats'] = json_encode( $style_formats );

	return $settings;
}
add_filter('tiny_mce_before_init', 'taoti_mce_add_formats_options');
