<?php
/**
 * Add option pages via ACF
 *
 * @package TaotiBaseTheme
 * @author Taoti Creative
 * @see https://timber.github.io/docs/guides/acf-cookbook/#options-page
 * @see https://www.advancedcustomfields.com/resources/options-page/
 * @see https://gist.github.com/taotiwordpress/b93a20b047c04b3870a7856e700ec78e for code.
 */

/**
 * ACF Options Configuration
 *
 * Adding various site-settings.
 */
if ( function_exists( 'acf_add_options_page' ) ) {
	/**
	 * Example: Single 'Theme Settings' page, with children
	 *
	 * These only create the pages, which must be then populated via custom ACF fields.
	 * This setup creates a 'parent' ACF config page and sub-pages.
	 */
	acf_add_options_page( // 'General' Theme Settings.
		array(
			'page_title' => 'Theme General Settings',
			'menu_title' => 'Theme Settings',
			'menu_slug'  => 'theme-general-settings',
			'capability' => 'edit_posts',
			'redirect'   => false,
		)
	);
	/*acf_add_options_sub_page( // 'Header' Theme Settings.
		array(
			'page_title'  => 'Theme Header Settings',
			'menu_title'  => 'Header',
			'parent_slug' => 'theme-general-settings',
		)
	);*/
	acf_add_options_sub_page( // 'Footer' Theme settings.
		array(
			'page_title'  => 'Theme Footer Settings',
			'menu_title'  => 'Footer',
			'parent_slug' => 'theme-general-settings',
		)
	);
	acf_add_options_sub_page(
		array(
			'page_title'  => 'Analytics Tracking Code',
			'menu_title'  => 'Analytics Tracking Code',
			'parent_slug' => 'theme-general-settings',
		)
	);

	

	/**
	 * Example: Default '404' options page
	 *
	 * @note: This could also be accomplished as a theme setting.
	 */
	// acf_add_options_page(
	// 	array(
	// 		'page_title'  => '404 Page Options',
	// 		'parent_slug' => 'themes.php',
	// 	)
	// );
}
