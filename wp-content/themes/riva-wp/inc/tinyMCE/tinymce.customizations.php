<?php
/**
 * Other customizations/tweaks for the TinyMCE editor
 *
 * @package TaotiBaseTheme
 * @author Taoti Creative
 */

/**
 * Make image links default to "none"
 *
 * When you add an image in TinyMCE it defaults to linking to the original size or to its attachment page.
 * Instead, this function  makes it default to having no link.
 *
 * @see https://www.wpbeginner.com/wp-tutorials/automatically-remove-default-image-links-wordpress/
 * @since 0.1.1
 */
function taoti_imagelink_setup() {
	$image_set = get_option( 'image_default_link_type' );

	if ( 'none' !== $image_set ) {
		update_option('image_default_link_type', 'none');
	}
}
add_action( 'admin_init', 'taoti_imagelink_setup', 10 );

/**
 * Use Paste As Text by default in the editor
 *
 * @since 0.1.1
 * @see https://anythinggraphic.net/paste-as-text-by-default-in-wordpress
 * @see https://developer.wordpress.org/reference/hooks/tiny_mce_before_init/
 * @param array $mce_init is the array with TinyMCE configuration.
 * @return array $mce_init
 */
function taoti_tinymce_paste_as_text( $mce_init ) {
	$mce_init['paste_as_text'] = true;
	return $mce_init;
}
add_filter( 'tiny_mce_before_init', 'taoti_tinymce_paste_as_text' );

/**
 * Remove .wp-caption's inline styles
 *
 * This function remove the inline styles from .wp-caption <div>s, which become difficult to override in the theme's CSS.
 *
 * @since 0.1.1
 * @param array  $attr is inline divs wtihin 'wp_caption' or 'caption'.
 * @param string $content is the returned content from within the opening/closing shortcode brackets. Typically a string.
 * @return string the updated inline styles
 */
function taoti_fixed_img_caption_shortcode( $attr, $content = null ) {
	if ( ! isset( $attr['caption'] ) ) {
		if ( preg_match( '#((?:<a [^>]+>\s*)?<img [^>]+>(?:\s*</a>)?)(.*)#is', $content, $matches ) ) {
			$content         = $matches[1];
			$attr['caption'] = trim($matches[2]);
		}
	}

	$output = apply_filters( 'img_caption_shortcode', '', $attr, $content );
	if ( '' !== $output ) {
		return $output;
	}

	$attr_vars = shortcode_atts(
		array(
			'id'      => '',
			'align'   => 'alignnone',
			'width'   => '',
			'caption' => '',
		),
		$attr
	);

	if ( 1 > (int) $attr_vars['width'] || empty($attr_vars['caption'] ) ) {
		return $content;
	}

	if ( $attr_vars['id'] ) {
		$attr_vars['id'] = 'id="' . esc_attr( $attr_vars['id'] ) . '" ';
	}

	return '<div ' . $attr_vars['id'] . 'class="wp-caption ' . esc_attr( $attr_vars['$align'] ) . '" style="max-width:' . $attr_vars['width'] . 'px">' . do_shortcode($content) . '<p>' . $attr_vars['caption'] . '</p></div>';
}
add_shortcode('wp_caption', 'taoti_fixed_img_caption_shortcode');
add_shortcode('caption', 'taoti_fixed_img_caption_shortcode');

/**
 * Remove the inline styles from .wp-video <div>s
 *
 * @since 0.1.1
 * @param string  $output is the built video output.
 * @param string  $atts is the available video attributes.
 * @param unknown $video appears unnecessary.
 * @param num     $post_id is the id of the post where the content is being saved.
 * @param unknown $library appears unnecessary.
 * @return string $output is the updated output without inline styling.
 */
function taoti_remove_excess_video_attributes( $output, $atts, $video, $post_id, $library ) {
	$style_attribute_pattern = '/ style="[^\"]*"/';
	$filtered_output         = preg_replace( $style_attribute_pattern, '', $output );

	return $filtered_output;
}
add_filter( 'wp_video_shortcode', 'taoti_remove_excess_video_attributes', 10, 5 );
