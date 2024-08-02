<?php
/**
 * Block: People List
 *
 * @package TaotiBaseTheme
 * @author Taoti Creative
 */

if ( ! function_exists( 'acf_register_block_type' ) ) {
	return;
}

/**
 * Tab Content block
 *
 * @see https://developer.wordpress.org/block-editor/reference-guides/block-api/block-supports/
 * @see https://www.advancedcustomfields.com/resources/acf_register_block_type/
 */
acf_register_block_type(
	array(
		'name'            => 'people-list',
		'title'           => __('People List'),
		'description'     => __('A customizable block with a List Of People.'),
		'render_callback' => 'taoti_acf_block_gutenberg_callback',
		'category'        => 'common',
		'icon'            => 'groups',
		'keywords'        => array( 'three', 'cta', 'columns' ),
		'mode'            => 'edit',
		'align'           => 'full',
		'supports'        => array(
			'anchor' => true, // Set to 'false' if this block should NOT be directly linkable via an auto-generated id link.
		),
		'example'         => array(
			'attributes' => array(
				'mode' => 'preview',
				'data' => array(
					'preview_image_help' => get_template_directory_uri() . '/blocks/people-list/preview/preview.png',
				),
			),
		),
	)
);