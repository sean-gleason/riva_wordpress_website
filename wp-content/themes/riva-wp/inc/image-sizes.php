<?php
/**
 * Helper - Image Sizes
 *
 * @package TaotiBaseTheme
 * @author Taoti Creative
 * @see 'inc/wp-reset.php' for helper function taoti_tweak_image_sizes() to adjust image sizing attributes.
 */

/**
 * Add custom image sizes
 *
 * @since 0.1.1
 * @see https://developer.wordpress.org/reference/functions/add_image_size/
 * @see taoti_custom_size_names() to add human-readable names.
 */
function taoti_image_size_setup() {
	add_image_size('1080p', 1920, 1080, true);
	add_image_size('720p', 1280, 720, true);
	add_image_size('article', 720, 480, true);
}
add_action( 'after_setup_theme', 'taoti_image_size_setup' );

/**
 * Add human-readable names the created image sizes.
 *
 * @since 0.1.1
 * @see https://developer.wordpress.org/reference/functions/add_image_size/
 * @see taoti_image_size_setup() for list of declared custom sizes.
 * @param array $sizes is the array of current sizes, to give human readable names to.
 * @return array $sizes
 */
function taoti_custom_size_names( $sizes ) {

	return array_merge(
		$sizes,
		array(
			'1080p'   => 'Standard 1080p',
			'720p'    => 'Standard 720p',
			'article' => 'Article Photo',
		)
	);

}
add_filter( 'image_size_names_choose', 'taoti_custom_size_names' );
