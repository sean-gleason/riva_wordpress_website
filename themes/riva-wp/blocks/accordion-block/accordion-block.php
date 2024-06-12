<?php
/**
 * Block: Accordion
 *
 * @package TaotiBaseTheme
 * @author Taoti Creative
 */

if ( ! function_exists( 'acf_register_block_type' ) ) {
	return;
}

/**
 * Accordion Content block
 */
acf_register_block_type(
	array(
		'name'            => 'accordion-block',
		'title'           => __('Accordion Block'),
		'description'     => __('A customizable block of accordion content items.'),
		'render_callback' => 'taoti_acf_block_gutenberg_callback',
		'category'        => 'common',
		'icon'            => 'menu-alt3',
		'keywords'        => array( 'accordion', 'posts' ),
		'mode'            => 'edit',
		'align'           => 'full',
		'supports'        => array(
			'anchor' => false, // Set to 'true' if this block should be directly linkable via an auto-generated id link.
		),
		'example'         => array(
			'attributes' => array(
				'mode' => 'preview',
				'data' => array(
					'preview_image_help' => get_template_directory_uri() . '/blocks/accordion-block/preview/preview.png',
				),
			),
		),
	),
);
