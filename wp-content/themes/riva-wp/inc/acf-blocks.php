<?php
/**
 * Helper Functions for ACF Blocks: acf-blocks.php
 *
 * @package TaotiBaseTheme
 * @author Taoti Creative
 * @see https://www.advancedcustomfields.com/resources/acf_register_block_type/ for additional information.
 */

/**
 * Load Blocks and Block Templates
 */
$timber_paths = Timber::$dirname;
$taoti_allowed_blocks = array();

$block_paths = glob(get_template_directory() . '/blocks/*', GLOB_ONLYDIR);

foreach ($block_paths as $block_path) {
    $block_name = basename($block_path);
    $file_name  = get_template_directory() . '/blocks/' . $block_name . '/' . $block_name . '.php';

    // As long as the main module php file exists, include() that file and add the 'views' folder to Timber.
    if (file_exists($file_name)) {
        // Load the main .php file for the Module.
        include $file_name;

        // Add any/all Timber templates for the Module.
        $timber_paths[] = 'blocks/' . $block_name . '/views/';

        // Adds to the allowed blocks list.
        $taoti_allowed_blocks[] = 'acf/' . $block_name;
    }
}

// Set the paths for Timber to look for .twig files in.
Timber::$dirname = $timber_paths;

/**
 * This is the callback that displays the custom ACF block.
 *
 * @param arr  $block The block settings and attributes.
 * @param str  $content The block content (empty string).
 * @param bool $is_preview True during AJAX preview.
 * @return void
 */
function taoti_acf_block_gutenberg_callback($block, $content = '', $is_preview = false) {

    $slug = str_replace('acf/', '', $block['name']);

    $context = Timber::context();

    // Store block values.
    $context['block'] = $block;

    // Store field values.
    $context['content'] = get_fields();

    // Get the preview, if preset.
    $context['is_preview'] = $is_preview;

    if (true == $is_preview && isset($block['data']['preview_image_help'])) {
        echo '<img src="' . esc_url($block['data']['preview_image_help']) . '" style="width:100%; height:auto;">';
        return;
    }

    // Render the block, if present.
    if ( ! empty($context['content']) ) {
        Timber::render(
            'blocks/' . $slug . '/views/' . $slug . '.twig',
            $context
        );
    }
}

/**
 * Filter used to restrict Gutenberg Blocks only to the ones declared in here
 *
 * @param array $allowed_blocks is the group of allowable blocks.
 * @return array $taoti_allowed_blocks is the Taoti declared custom blocks.
 */
function taoti_allowed_block_types_all( $allowed_blocks ) {
    global $taoti_allowed_blocks;

    return $taoti_allowed_blocks;
}
add_filter('allowed_block_types_all', 'taoti_allowed_block_types_all');

/*
*  Populate ACF field (gravity_form_id) with list of gravity forms containing ids
 *************************************************************************************/

function load_gravity_forms_into_acf_select_field( $field ) {
	if (class_exists( 'GFFormsModel' )) { // Hotfix for #36905025
		$forms = GFFormsModel::get_forms();

		if ( $forms ) {
			//Add empty option
			$field['choices']["0"] = 'Select a Form';

			foreach ( $forms as $form ) {
				$field['choices'][$form->id] = $form->title;
			}
		}
	}

	return $field;
}

//Change gravity_form_id to the name of the ACF select field you want to populate
add_filter( 'acf/load_field/name=gravity_form_id', 'load_gravity_forms_into_acf_select_field' );