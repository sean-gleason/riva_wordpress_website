<?php
/**
 * Modules.php
 *
 * This file runs include() on the main module files and adds their 'views' folders to Timber.
 *
 * Additional paths can be added here, as well.
 *
 * @package TaotiBaseTheme
 * @author Taoti Creative
 * @see https://timber.github.io/docs/guides/template-locations/ for additional information.
 * @see the_page_builder() for extension to template array specifcially for Page Builder components created.
 */

// Set up an array of all the directories within the 'modules' folder.
$module_paths = glob( get_template_directory() . '/modules/*', GLOB_ONLYDIR );

// A blank array for the modules' 'views' folders to be added to.
$timber_paths = [];

// Loop through each folder 'modules' and figure out what the main module php file would be called, based on the name of the module folder.
foreach ( $module_paths as $module_path ) {
	$module_name = basename( $module_path );
	$file_name   = get_template_directory() . '/modules/' . $module_name . '/' . $module_name . '.php';

	// As long as the main module php file exists, include() that file and add the 'views' folder to Timber.
	if ( file_exists($file_name) ) {
		// Load the main .php file for the Module.
		include $file_name;

		// Add any/all Timber templates for the Module.
		$timber_paths[] = 'modules/' . $module_name . '/views';
	}
}

// Add the 'views' folder at the end of the array, to use this folder as a backup in case there is no view in the module.
$timber_paths[] = 'views';

// Set the paths for Timber to look for .twig files in.
Timber::$dirname = $timber_paths;
