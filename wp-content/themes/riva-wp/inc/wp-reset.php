<?php
/**
 * The Great WP Reset
 *
 * Include various customizations/tweaks to WordPress here.
 * Like CSS Reset, but for WordPress.
 *
 * Quality of life improvements for things like adding theme support for featured images, adding excerpts to pages, removing a bunch of useless widgets, and a bunch of stuff.
 *
 * Add/remove/modify anything you need in here for your own theme (never modify anything in `jp-base`, it will cause git conflicts).
 *
 * Note
 *  Tweaks for ACF go in theme-folder/inc/acf/acf.php
 *  Tweaks for TinyMCE go in theme-folder/inc/tinyMCE/{{3 different files}}
 *
 * @package TaotiBaseTheme
 * @author Taoti Creative
 */

/**
 * Remove some default widgets, including some from Jetpack, Constant Contact, and others
 *
 * @since 0.1.1
 */
function taoti_unregister_default_widgets() {
	unregister_widget('WP_Widget_Pages');
	unregister_widget('WP_Widget_Calendar');
	unregister_widget('WP_Widget_Archives');
	unregister_widget('WP_Widget_Links');
	unregister_widget('WP_Widget_Meta');
	unregister_widget('WP_Widget_Search');
	unregister_widget('WP_Widget_Text');
	unregister_widget('WP_Widget_Categories');
	unregister_widget('WP_Widget_Recent_Posts');
	unregister_widget('WP_Widget_Recent_Comments');
	unregister_widget('WP_Widget_RSS');
	unregister_widget('WP_Widget_Tag_Cloud');
	unregister_widget('WP_Nav_Menu_Widget');
	unregister_widget('Twenty_Eleven_Ephemera_Widget');
	unregister_widget( 'Jetpack_Subscriptions_Widget' );
	unregister_widget( 'WPCOM_Widget_Facebook_LikeBox' );
	unregister_widget( 'Jetpack_Gallery_Widget' );
	unregister_widget( 'Jetpack_Gravatar_Profile_Widget' );
	unregister_widget( 'Jetpack_Image_Widget' );
	unregister_widget( 'Jetpack_Readmill_Widget' );
	unregister_widget('Jetpack_RSS_Links_Widget');
	unregister_widget( 'Jetpack_Top_Posts_Widget' );
	unregister_widget( 'Jetpack_Twitter_Timeline_Widget' );
	unregister_widget( 'Jetpack_Display_Posts_Widget' );
	unregister_widget( 'constant_contact_form_widget' );
	unregister_widget( 'constant_contact_events_widget' );
	unregister_widget( 'constant_contact_api_widget' );
	unregister_widget( 'bcn_widget' );
}
add_action('widgets_init', 'taoti_unregister_default_widgets', 11);

/**
 * Configure Theme Supports
 *
 * @todo Update to WordPress 5.3 support requirements for 'html5' to be 'add_theme_support( 'html5', [ 'script', 'style' ] );'
 * @todo Once updated, remove taoti_remove_type_attr() function altogether.
 * @since 0.1.1
 * @see https://developer.wordpress.org/reference/functions/add_theme_support/.
 */
function taoti_theme_setup() {

	/**
	 * Theme Support
	 */
	add_theme_support( 'menus' ); // Navigation Menu setup.
	add_theme_support( 'post-thumbnails' ); // Post Thumnbail setup.
	add_theme_support( 'html5', array( 'style', 'script' ) ); // HTML5 in WP Generated Elemements.
	add_theme_support( 'title-tag' );

}
add_action( 'after_setup_theme', 'taoti_theme_setup' );

/**
 * Remove tags support from posts
 *
 * Enable with the following:
 *   add_action('init', 'taoti_unregister_tags');
 *
 * @since 0.1.1
 * @todo Move into Leptons
 */
function taoti_unregister_tags() {
	unregister_taxonomy_for_object_type('post_tag', 'post');
}

/**
 * Remove dashboard menus
 *
 * Enable with the following:
 *   add_action( 'admin_menu', 'taoti_remove_menus' );
 *
 * @since 0.1.1
 * @todo Move into Lepton.
 */
function taoti_remove_menus() {

	/** Remove top level menu pages */
	remove_menu_page( 'edit-comments.php' );

	/** Remove sub menu pages */
	remove_submenu_page( 'themes.php', 'widgets.php' );

}

/**
 * Yoast SEO - Move Metabox
 *
 * Move the SEO By Yoast plugin's meta box to a lower priority so it appears at the bottom of Edit screens.
 *
 * @since 0.1.1
 * @see https://wordpress.org/support/topic/plugin-wordpress-seo-by-yoast-position-seo-meta-box-priority-above-custom-meta-boxes
 * @return string which forces the metabox to the bottom.
 */
function taoti_yoast_seo_metabox_prio() {
	return 'low';
}
add_filter( 'wpseo_metabox_prio', 'taoti_yoast_seo_metabox_prio' );

/**
 * Taxonomy term order
 *
 * Prevents the taxonomy checkbox lists from reordering themselves when one or more terms are checked.
 *
 * @since 0.1.1
 * @see http://stackoverflow.com/questions/4830913/wordpress-category-list-order-in-post-edit-page
 * @see 'inc/taxonomies.php' for other customizations.
 * @param array $args Available Taxonomy object arguements.
 */
function taoti_taxonomy_checklist_checked_ontop_filter ( $args ) {
	$args['checked_ontop'] = false;
	return $args;
}
add_filter( 'wp_terms_checklist_args', 'taoti_taxonomy_checklist_checked_ontop_filter' );

/**
 * Add excerpts to the 'Page' post type
 *
 * @since 0.1.1
 * @see https://developer.wordpress.org/reference/hooks/excerpt_more/
 */
function taoti_add_excerpts_to_pages() {
	add_post_type_support( 'page', 'excerpt' );
}
add_action( 'init', 'taoti_add_excerpts_to_pages' );

/**
 * Alter the excerpt ellipsis
 *
 * @since 0.1.1
 * @see https://developer.wordpress.org/reference/hooks/excerpt_more/
 * @param string $more_string is the string shown with the 'more' link for trimmed excerpts.
 * @return string update to the $more_string
 */
function taoti_new_excerpt_more( $more_string ) {
	return '&hellip;';
}
add_filter( 'excerpt_more', 'taoti_new_excerpt_more' );

/**
 * Set a custom character length for Excerpts
 *
 * @since 0.1.1
 * @return 20 is the new character length of '20'.
 */
function taoti_custom_excerpt_length() {
	return 20;
}
add_filter( 'excerpt_length', 'taoti_custom_excerpt_length', 999 );

/**
 * Exclude Post Content from Search
 *
 * On the Dashboard, get searches to look in the post title only (exclude the post content from search).
 *
 * @since 0.1.1
 * @todo Move into Lepton.
 * @see http://wpsnipp.com/index.php/functions-php/limit-search-to-post-titles-only/
 * @param object $search is the user-entered search term.
 * @param object $wp_query is $wp_query.
 * @return object $search is the returned query'd information.
 */
function taoti_search_by_title_only( $search, $wp_query ) {

	global $wpdb;

	/**
	 * Skip processing if no search term in query.
	 */
	if ( empty( $search ) ) {
		return $search;
	}

	$q         = $wp_query->query_vars;
	$n         = ! empty($q['exact']) ? '' : '%';
	$search    = '';
	$searchand = '';

	foreach ( (array) $q['search_terms'] as $term) {
		$term      = esc_sql( $wpdb->esc_like($term) );
		$search   .= "{$searchand}($wpdb->posts.post_title LIKE '{$n}{$term}{$n}')";
		$searchand = ' AND ';
	}

	if ( ! empty( $search ) ) {
		$search = " AND ({$search}) ";
		if ( ! is_user_logged_in() ) {
			$search .= " AND ($wpdb->posts.post_password = '') ";
		}
	}

	return $search;

}
if ( is_admin() && ! wp_doing_ajax() ) {
	add_filter( 'posts_search', __NAMESPACE__ . '\\taoti_search_by_title_only', 500, 2 );
}

/**
 * Add categories to pages
 *
 * Enable with the following:
 *   add_action( 'init', 'taoti_add_taxonomies_to_pages' );
 *
 * @todo Move into Lepton.
 * @since 0.1.1
 * @see http://spicemailer.com/wordpress/add-categories-tags-pages-wordpress/
 */
function taoti_add_taxonomies_to_pages() {
	register_taxonomy_for_object_type( 'post_tag', 'page' );
	register_taxonomy_for_object_type( 'category', 'page' );
}

/**
 * Add 'Category' and 'Tags' to 'Post' and 'Page Post types
 *
 * Enable with the following:
 *   if ( ! is_admin() ) {
 *     add_action( 'pre_get_posts', 'taoti_category_and_tag_archives' );
 *   }
 *
 * @todo Move into Lepton.
 * @since 0.1.1
 * @param object $wp_query is the wp_query.
 */
function taoti_category_and_tag_archives( $wp_query ) {
	$my_post_array = array( 'post', 'page' );

	if ( $wp_query->get('category_name') || $wp_query->get('cat') ) {
		$wp_query->set('post_type', $my_post_array);
	}

	if ( $wp_query->get('tag' ) ) {
		$wp_query->set('post_type', $my_post_array);
	}
}

/**
 * Deregister Scripts
 *
 * Drop the 'wp-embed' script altogether.
 *
 * @since 0.1.1
 */
function taoti_deregister_scripts() {
	wp_deregister_script( 'wp-embed' );
}
add_action( 'wp_enqueue_scripts', 'taoti_deregister_scripts' );

/**
 * Filters the output of 'wp_calculate_image_sizes()'
 *
 * Use this to tweak the value of the 'sizes' attribute on images.
 *
 * Example Usage:
 *
 * See what the arguments for this filter look like; example of this output is below.
 *  $args = [
 *   'sizes' => $sizes,
 *   'size' => $size,
 *   'image_src' => $image_src,
 *   'image_meta' => $image_meta,
 *   'attachment_id' => $attachment_id,
 *  ];
 *  echo "<pre>"; print_r($args); echo "</pre>";
 *  die('');
 *
 * Sample of a custom image size being added
 *  if ( isset( $image_meta['sizes']['small-feature'] ) ) {
 *   $sizes = '(max-width: 490px) 490px, ' . $sizes;
 *  }
 *
 * @since 0.1.1
 *
 * @todo Move this function to 'image-sizes.php', as it is not really as 'reset' function, but a helper function.
 * @see https://developer.wordpress.org/reference/functions/wp_calculate_image_sizes/
 * @param string       $sizes         A source size value for use in a 'sizes' attribute.
 * @param array|string $size          Requested size. Image size or array of width and height values in pixels (in that order).
 * @param string|null  $image_src     The URL to the image file or null.
 * @param array|null   $image_meta    The image meta data as returned by wp_get_attachment_metadata() or null.
 * @param int          $attachment_id Image attachment ID of the original image or 0.
 */
function taoti_tweak_image_sizes( $sizes, $size, $image_src, $image_meta, $attachment_id ) {

	if ( isset( $image_meta['sizes']['medium_large'] ) ) {
		$sizes = '(max-width: 768px) 768px, ' . $sizes;
	}

	return $sizes;
}
add_filter( 'wp_calculate_image_sizes', 'taoti_tweak_image_sizes', 10, 5);

/*
// @todo Move this examle code to Lepton.
// EXAMPLE of the arguments that are passed to the 'wp_calculate_image_sizes' filter.
Array
(
	[sizes] => (max-width: 827px) 100vw, 827px
	[size] => Array
		(
			[0] => 827
			[1] => 1121
		)

	[image_src] => http://localhost:8888/taoti-19/web/wp-content/uploads/2018/07/cyclists-hero.png
	[image_meta] => Array
		(
			[width] => 827
			[height] => 1121
			[file] => 2018/07/cyclists-hero.png
			[sizes] => Array
				(
					[thumbnail] => Array
						(
							[file] => cyclists-hero-150x150.png
							[width] => 150
							[height] => 150
							[mime-type] => image/png
						)

					[medium] => Array
						(
							[file] => cyclists-hero-221x300.png
							[width] => 221
							[height] => 300
							[mime-type] => image/png
						)

					[medium_large] => Array
						(
							[file] => cyclists-hero-768x1041.png
							[width] => 768
							[height] => 1041
							[mime-type] => image/png
						)

					[large] => Array
						(
							[file] => cyclists-hero-755x1024.png
							[width] => 755
							[height] => 1024
							[mime-type] => image/png
						)

					[720p] => Array
						(
							[file] => cyclists-hero-827x720.png
							[width] => 827
							[height] => 720
							[mime-type] => image/png
						)

					[small-feature] => Array
						(
							[file] => cyclists-hero-490x490.png
							[width] => 490
							[height] => 490
							[mime-type] => image/png
						)

					[large-feature] => Array
						(
							[file] => cyclists-hero-827x910.png
							[width] => 827
							[height] => 910
							[mime-type] => image/png
						)

				)

			[image_meta] => Array
				(
					[aperture] => 0
					[credit] =>
					[camera] =>
					[caption] =>
					[created_timestamp] => 0
					[copyright] =>
					[focal_length] => 0
					[iso] => 0
					[shutter_speed] => 0
					[title] =>
					[orientation] => 0
					[keywords] => Array
						(
						)

				)

		)

	[attachment_id] => 146
)
*/

/**
 * Disable comments (won't work for existing comments)
 *
 * Deprecated function removed. Taoti instead uses the 'Disable Comments' plugin
 */

/**
 * SVG in media uploader
 *
 * Deprecated function removed.
 *
 * Taoti instead uses the 'Save SVG' plugin.
 */

/**
 * Reset - Login page 'home' URL on Logo
 *
 * This function resets the link URL of the header logo above the login form.
 * Changes the default from 'WordPress' to the site-homepage.
 *
 * @since 0.1.1
 * @see https://developer.wordpress.org/reference/hooks/login_headerurl/
 */
function taoti_login_logo_url() {
	return home_url();
}
add_filter( 'login_headerurl', 'taoti_login_logo_url' );

/**
 * Reset - Header logo Link Text on Login page
 *
 * Filters the link text of the header logo above the login form on the login page.
 *
 * @since 0.1.1
 * @see https://developer.wordpress.org/reference/hooks/login_headertext/
 */
function taoti_login_logo_url_title() {
	return get_bloginfo( 'name' );
}
add_filter( 'login_headertext', 'taoti_login_logo_url_title' );
