<?php
/**
 * Block: WYSIWYG
 *
 * @package TaotiBaseTheme
 * @author Taoti Creative
 */

if ( ! function_exists( 'acf_register_block_type' ) ) {
	return;
}

/**
 * Text Content block
 *
 * @see https://developer.wordpress.org/block-editor/reference-guides/block-api/block-supports/
 * @see https://www.advancedcustomfields.com/resources/acf_register_block_type/
 */
acf_register_block_type(
	array(
		'name'            => 'two-columns-wysiwyg-block',
		'title'           => __('Two Columns WYSIWYG Block'),
		'description'     => __('Two Columns WYSIWYG content block'),
		'render_callback' => 'taoti_acf_block_gutenberg_callback',
		'category'        => 'formatting',
		'icon'            => 'editor-paragraph',
		'keywords'        => array( 'wysiwyg' ),
		'mode'            => 'edit',
		'supports'        => array(
			'anchor' => false, // Set to 'true' if this block should be directly linkable via an auto-generated id link.
		),
		'example'         => array(
			'attributes' => array(
				'mode' => 'preview',
				'data' => array(
					'preview_image_help' => get_template_directory_uri() . '/blocks/wysiwyg-block/preview/preview.png',
				),
			),
		),
	)
);
