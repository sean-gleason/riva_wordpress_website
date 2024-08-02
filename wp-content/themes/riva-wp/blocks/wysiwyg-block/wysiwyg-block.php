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
		'name'            => 'wysiwyg-block',
		'title'           => __('WYSIWYG Block'),
		'description'     => __('WYSIWYG content block'),
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


add_filter( 'acf/fields/wysiwyg/toolbars', 'my_toolbars'  );

function my_toolbars( $toolbars ) {

	$toolbars['Full'][1][14] = 'styleselect';




	/*
    echo '<pre>';
        print_r($toolbars);
    echo '</pre >';
    die;*/



    // return $toolbars - IMPORTANT!
    return $toolbars;
}

function remove_h1_from_heading($args) {
	// Just omit h1 from the list
	$args['block_formats'] = 'Paragraph=p;Heading 2=h2;Heading 3=h3;Heading 4=h4;Heading 5=h5;Heading 6=h6;Pre=pre';
	return $args;
}
add_filter('tiny_mce_before_init', 'remove_h1_from_heading' );


/*
 * Callback function to filter the MCE settings
 */

// Callback function to insert 'styleselect' into the $buttons array
function my_mce_buttons_2($buttons) {
    array_unshift($buttons, 'styleselect');
    return $buttons;
}

// Register our callback to the appropriate filter
add_filter('mce_buttons_2', 'my_mce_buttons_2');

function my_mce_before_init_insert_formats($init_array) {
// Define the style_formats array
    $style_formats = array(
        // Each array child is a format with it's own settings
        array(
            'title' => 'Riva Button',
            'block' => 'button',
            'classes' => 'riva-wysiwyg-button rounded-pill',
        ),
    );
    // Insert the array, JSON ENCODED, into 'style_formats'
    $init_array['style_formats'] = json_encode($style_formats);
    return $init_array;
}

// Attach callback to 'tiny_mce_before_init'
add_filter('tiny_mce_before_init', 'my_mce_before_init_insert_formats');