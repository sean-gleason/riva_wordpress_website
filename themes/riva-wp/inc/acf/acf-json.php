<?php
/**
 * ACF JSON Loader
 *
 * @package TaotiBaseTheme
 * @author Taoti Creative
 */

/**
 * ACF Compile Function
 *
 * Loads the default ACF file for this Module.
 *
 * Note: Any changes, when saved, will be saved in ACF's default save-point.
 *   This loader function only loads the default settings.
 *
 * @since 0.1.2
 * @param array $acf_paths - Current set of ACF directories.
 * @return array $acf_paths - New set of ACF directories to load.
 * @see https://www.advancedcustomfields.com/resources/local-json/
 * @see https://www.awesomeacf.com/snippets/load-acf-json-files-from-multiple-locations/
 */
function taoti_acf_json_load_point( $acf_paths ) {
	// Remove original path (optional).
	unset($acf_paths[0]);

	/**
	 * Load Module ACFs.
	 */

	$module_paths = glob( get_template_directory() . '/modules/*', GLOB_ONLYDIR );

	// Loop through each module and load all/any default acf-json file(s).
	foreach ( $module_paths as $module_path ) {
		$module_name = basename( $module_path );
		$file_name   = get_template_directory() . '/modules/' . $module_name . '/' . $module_name . '.php';

		// As long as the main module php file exists, load any/all associated acf-json files.
		if ( file_exists($file_name) ) {
			$acf_paths[] = get_stylesheet_directory() . '/modules/' . $module_name . '/acf/';
		}
	}

	/**
	 * Load Block ACFs.
	 */
	$block_paths = glob( get_template_directory() . '/blocks/*', GLOB_ONLYDIR );

	// Loop through each module and load all/any default acf-json file(s).
	foreach ( $block_paths as $block_path ) {
		$block_name = basename( $block_path );
		$file_name   = get_template_directory() . '/blocks/' . $block_name . '/' . $block_name . '.php';

		// As long as the main module php file exists, load any/all associated acf-json files.
		if ( file_exists($file_name) ) {
			$acf_paths[] = get_stylesheet_directory() . '/blocks/' . $block_name . '/acf/';
		}
	}

	// Append the path.
	$acf_paths[] = get_stylesheet_directory() . '/inc/acf/json';

	// Return the updated path.
	return $acf_paths;

}
add_filter( 'acf/settings/load_json', 'taoti_acf_json_load_point' );

/**
 * Helper Function to overwrite default acf-json folder.
 *
 * See previous function for notes.
 *
 * @since 0.1.0
 * @param string $path used by ACF to determine where acf.json files are saved.
 * @return string $path
 */
function taoti_acf_json_save_point( $path ) {

	// Update path.
	$path = get_stylesheet_directory() . '/inc/acf/json';

	// Return the updated path.
	return $path;

}
add_filter( 'acf/settings/save_json', 'taoti_acf_json_save_point' );
