<?php
/**
 * Block: Text & Image
 *
 * @package TaotiBaseTheme
 * @author Taoti Creative
 */

if ( ! function_exists( 'acf_register_block_type' ) ) {
	return;
}

/**
 * Text & Image Content block
 *
 * @see https://developer.wordpress.org/block-editor/reference-guides/block-api/block-supports/
 * @see https://www.advancedcustomfields.com/resources/acf_register_block_type/
 */
acf_register_block_type(
	array(
		'name'            => 'image-with-caption',
		'title'           => __('Image With Caption'),
		'description'     => __('Page Builder Block with an image and a caption.'),
		'render_callback' => 'taoti_acf_block_gutenberg_callback',
		'category'        => 'formatting',
		'icon'            => 'format-image',
		'keywords'        => array( 'text', 'image', 'caption' ),
		'mode'            => 'edit',
		'supports'        => array(
			'anchor' => false, // Set to 'true' if this block should be directly linkable via an auto-generated id link.
		),
		'example'         => array(
			'attributes' => array(
				'mode' => 'preview',
				'data' => array(
					'preview_image_help' => get_template_directory_uri() . '/blocks/image-with-caption/preview/preview.png',
				),
			),
		),
	)
);
