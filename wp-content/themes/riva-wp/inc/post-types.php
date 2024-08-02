<?php
/**
 * Helper Functions to add Custom Post Types
 *
 * Note: The Easiest / Fastest method to generate a custom post-type (CPT) is NOT to use this tool.
 * Instead, visit https://generatewp.com/post-type/, enter details, and create a separate function per CPT.
 *
 * @package TaotiBaseTheme
 * @author Taoti Creative
 * @todo Retire this _entirely_ in favor of a more OOP oriented approach. (See 'Elegant', 'LeagleCup', or 'Flynt' for examples.)
 * @see https://generatewp.com/post-type/
 */

/**
 * Custom function register WordPress Post Types
 *
 * Usage:
 *   Copy the array below for 'product' and edit as needed. $taoti_magic_post_type_maker_array should be an array of arrays, and those arrays make it easier to create custom post types.
 *   The 'slug', 'singular', and 'plural' parameters are explained below in the example array's comments.
 *   For the 'register_args' array, add whichever arguments you need to the array (Except for the 'labels' argument, that's automatically generated for you).
 *   Use the documentation on https://codex.wordpress.org/Function_Reference/register_post_type
 *
 * Common arguments:
 *   The most common arguments are here for you to copy/paste, but again you can add whichever arguments are supported by the register_post_type() function.
 * 'menu_icon'  => 'dashicons-clipboard',
 * 'description' => 'Manage your PLURAL POST NAME here.',
 * 'menu_position' => 10,
 * 'hierarchical' => true,
 * 'public' => true,
 * 'has_archive' => true,
 * 'exclude_from_search' => false,
 *
 * @since 0.1.1
 * @see https://developer.wordpress.org/plugins/post-types/registering-custom-post-types/
 */
function taoti_register_post_types() {

	// Add all your post type info into this array.
	$taoti_magic_post_type_maker_array = array(
		/** Custom Post Type: Insights */
		array(
			'slug'          => 'insights',
			'singular'      => 'Insight',
			'plural'        => 'Insights',
			'register_args' => array(
				'menu_icon'                => 'dashicons-media-document',
				'description'              => 'Insights Post Type.',
				'cptp_permalink_structure' => '%postname%/',
				'rewrite'                  => array(
					'with_front' => false,
					'slug'       => 'insights',
				),
				'capability_type'          => array( 'insight', 'insights' ),
				'map_meta_cap'             => true,
				'show_in_rest'             => true,
				'supports'                 => array( 'title', 'editor', 'page-attributes', 'thumbnail', 'excerpt' ),
				'show_in_nav_menus'        => true,
				'exclude_from_search'      => false,
				'publicly_queryable'       => true,
				'has_archive'              => true,
			),
		),

		/** Custom Post Type: Leadership */
		array(
			'slug'          => 'leadership',
			'singular'      => 'Leadership',
			'plural'        => 'Leadership',
			'register_args' => array(
				'menu_icon'                => 'dashicons-businessman',
				'description'              => 'Leadership Post Type',
				'cptp_permalink_structure' => '%postname%/',
				'rewrite'                  => array(
					'with_front' => false,
					'slug'       => 'about/leadership',
				),
				'capability_type'          => array( 'leadership', 'leaderships' ),
				'map_meta_cap'             => true,
				'show_in_rest'             => true,
				'supports'                 => array( 'title', 'editor', 'page-attributes', 'thumbnail', 'excerpt' ),
				'show_in_nav_menus'        => true,
				'exclude_from_search'      => false,
				'publicly_queryable'       => true,
				'has_archive'              => true,
			),
		),

		/** Custom Post Type: Author */
		array(
			'slug'          => 'author',
			'singular'      => 'Author',
			'plural'        => 'Authors',
			'register_args' => array(
				'menu_icon'                => 'dashicons-welcome-write-blog',
				'description'              => 'Author',
				'cptp_permalink_structure' => '%postname%/',
				'rewrite'                  => array(
					'with_front' => false,
					'slug'       => 'author',
				),
				'capability_type'          => array( 'author', 'authors' ),
				'map_meta_cap'             => true,
				'show_in_rest'             => true,
				'supports'                 => array( 'title', 'thumbnail' ),
				'show_in_nav_menus'        => false,
				'exclude_from_search'      => false,
				'publicly_queryable'       => true,
				'has_archive'              => true,
			),
		),

		/** Custom Post Type: Contract Vehicles */
		array(
			'slug'          => 'contract-vehicle',
			'singular'      => 'Contract Vehicle',
			'plural'        => 'Contract Vehicles',
			'register_args' => array(
				'menu_icon'                => 'dashicons-car',
				'description'              => 'Contract Vehicle Post Type',
				'cptp_permalink_structure' => '%postname%/',
				'rewrite'                  => array(
					'with_front' => false,
					'slug'       => 'contract-vehicles',
				),
				'capability_type'          => array( 'contract-vehicle', 'contract-vehicles' ),
				'map_meta_cap'             => true,
				'show_in_rest'             => true,
				'supports'                 => array( 'title', 'editor', 'page-attributes', 'thumbnail', 'excerpt' ),
				'show_in_nav_menus'        => false,
				'exclude_from_search'      => false,
				'publicly_queryable'       => true,
				'has_archive'              => true,
			),
		),

		/** Custom Post Type: Solution Area */
		array(
			'slug'          => 'solutions',
			'singular'      => 'Solutions',
			'plural'        => 'Solutions',
			'register_args' => array(
				'menu_icon'                => 'dashicons-performance',
				'description'              => 'Solutions Post Type',
				'cptp_permalink_structure' => '%postname%/',
				'rewrite'                  => array(
					'with_front' => false,
					'slug'       => 'solutions',
				),
				'capability_type'          => array( 'solution', 'solutions', 'solutions-area', 'solution-areas' ),
				'map_meta_cap'             => true,
				'show_in_rest'             => true,
				'supports'                 => array( 'title', 'editor', 'page-attributes', 'thumbnail', 'excerpt' ),
				'show_in_nav_menus'        => false,
				'exclude_from_search'      => false,
				'publicly_queryable'       => true,
				'has_archive'              => true,
			),
		),

		/** Custom Post Type: Sector */
		array(
			'slug'          => 'sector',
			'singular'      => 'Sector',
			'plural'        => 'Sectors',
			'register_args' => array(
				'menu_icon'                => 'dashicons-admin-multisite',
				'description'              => 'Sector Post Type',
				'cptp_permalink_structure' => '%postname%/',
				'rewrite'                  => array(
					'with_front' => false,
					'slug'       => 'sector',
				),
				'capability_type'          => array( 'sector', 'sectors' ),
				'map_meta_cap'             => true,
				'show_in_rest'             => true,
				'supports'                 => array( 'title', 'editor', 'page-attributes', 'thumbnail', 'excerpt' ),
				'show_in_nav_menus'        => false,
				'exclude_from_search'      => false,
				'publicly_queryable'       => true,
				'has_archive'              => true,
			),
		),

		/** Custom Post Type: Partnership */
		array(
			'slug'          => 'partnership',
			'singular'      => 'Partnership',
			'plural'        => 'Partnerships',
			'register_args' => array(
				'menu_icon'                => 'dashicons-groups',
				'description'              => 'Partnership Post Type',
				'cptp_permalink_structure' => '%postname%/',
				'rewrite'                  => array(
					'with_front' => false,
					'slug'       => 'partnership',
				),
				'capability_type'          => array( 'partnership', 'partnerships' ),
				'map_meta_cap'             => true,
				'show_in_rest'             => true,
				'supports'                 => array( 'title', 'editor', 'page-attributes', 'thumbnail', 'excerpt' ),
				'show_in_nav_menus'        => false,
				'exclude_from_search'      => false,
				'publicly_queryable'       => true,
				'has_archive'              => true,
			),
		),
	);

	foreach ( $taoti_magic_post_type_maker_array as $post_type_args ) {
		$singular      = $post_type_args['singular'];
		$plural        = $post_type_args['plural'];
		$slug          = $post_type_args['slug'];
		$register_args = $post_type_args['register_args'];

		$capabilities = $register_args['capability_type'];

		// Arguments.
		$final_args = taoti_generate_post_type_args( $register_args );

		// Admin Labels.
		$labels = taoti_generate_label_array(
			array(
				'singular' => $singular,
				'plural'   => $plural,
				'slug'     => $slug,
			)
		);

		$final_args['labels'] = $labels;

		// Finally register the post type.
		register_post_type( $slug, $final_args );

		/**
		 * Add Access to the Post Type
		 *
		 * Note: Additional Roles can be given access as needed.
		 */
		taoti_add_admin_capabilities( 'administrator', $capabilities[0], $capabilities[1] );
		taoti_add_admin_capabilities( 'editor', $capabilities[0], $capabilities[1] );
	}

}
add_action( 'init', 'taoti_register_post_types', 0 );

/**
 * Remove the 'Default' Post Type entirely
 */
/** Remove side menu */
function remove_default_post_type() {
	remove_menu_page( 'edit.php' );
}
add_action( 'admin_menu', 'remove_default_post_type' );

/**
 * Remove +New post in top Admin Menu Bar
 *
 * @param object $wp_admin_bar Is the Admin Bar's current content.
 */
function remove_default_post_type_menu_bar( $wp_admin_bar ) {
	$wp_admin_bar->remove_node( 'new-post' );
}
add_action( 'admin_bar_menu', 'remove_default_post_type_menu_bar', 999 );

/** Remove Quick Draft Dashboard Widget */
function remove_draft_widget() {
	remove_meta_box( 'dashboard_quick_press', 'dashboard', 'side' );
}
add_action( 'wp_dashboard_setup', 'remove_draft_widget', 999 );


/**
 * Custom Permalinks Customization - Only Allow Specific Post Types
 *
 * Removing access to the 'Custom Permalinks' for all post types except 'Page' and 'Resources'.
 *
 * @param string $post_type is the WordPress get_post_type() call.
 */
function taoti_permalinks_exclude_post_types( $post_type ) {
	/** Allowable Post Types */
	if ( 'page' === $post_type ) {
		return '__false';
	}

	return '__true';
}
add_filter( 'custom_permalinks_exclude_post_type', 'taoti_permalinks_exclude_post_types' );

/**
 * Post Type Helper Function - Labels
 *
 * @since 0.1.1
 * @param array $args is the retrieved arguements.
 * @return array $labels are the various labels used for generating a CPT.
 */
function taoti_generate_label_array( $args = [] ) {

	$defaults = [
		'singular' => false,
		'plural'   => false,
		'slug'     => false,
	];

	$merged = array_merge($defaults, $args);

	if ( in_array(false, $merged, true) ) {
		return false;
	}

	$singular           = $merged['singular'];
	$plural             = $merged['plural'];
	$slug               = $merged['slug'];
	$singular_lowercase = strtolower( $singular );
	$plural_lowercase   = strtolower( $plural );

	$labels = array(
		'name'                  => $plural,
		'singular_name'         => $singular,
		'add_new'               => _x('Add New', 'add new post or page', 'base'),
		/* Translators: %s: CPT post name */
		'add_new_item'          => sprintf( _x( 'Add New %s', 'referring to a post/page', 'base' ), $singular ),
		/* Translators: %s: CPT post name */
		'edit_item'             => sprintf( _x( 'Edit %s', 'referring to a post/page', 'base' ), $singular ),
		/* Translators: %s: CPT post name */
		'new_item'              => sprintf( _x( 'New %s', 'referring to a post/page', 'base' ), $singular ),
		/* Translators: %s: CPT post name */
		'view_item'             => sprintf( _x( 'View %s', 'referring to a post/page', 'base' ), $singular ),
		/* Translators: %s: Plural version of CPT post name */
		'view_items'            => sprintf( _x( 'View %s', 'referring to posts/pages', 'base' ), $plural ),
		/* Translators: %s: Plural version of CPT post name */
		'search_items'          => sprintf( _x( 'Search %s', 'referring to posts/pages', 'base' ), $plural ),
		/* Translators: %s: Lowercase version of plural version of CPT post name */
		'not_found'             => sprintf( _x( 'No %s found', 'referring to posts/pages', 'base' ), $plural_lowercase ),
		/* Translators: %s: Lowercase version of plural version of CPT post name */
		'not_found_in_trash'    => sprintf( _x( 'No %s found in Trash.', 'referring to posts/pages', 'base' ), $plural_lowercase ),
		/* Translators: %s: CPT post name */
		'parent_item_colon'     => sprintf( _x( 'Parent %s:', 'referring to a post/page', 'base' ), $singular ),
		/* Translators: %s: Plural version of CPT post name */
		'all_items'             => sprintf( _x( 'All %s', 'referring to posts/pages', 'base' ), $plural ),
		/* Translators: %s: CPT post name */
		'archives'              => sprintf( _x( '%s Archives', 'referring to posts/pages', 'base' ), $singular ),
		/* Translators: %s: CPT post name */
		'attributes'            => sprintf( _x( '%s Attributes', 'referring to posts/pages', 'base' ), $singular ),
		/* Translators: %s: CPT post name */
		'insert_into_item'      => sprintf( _x( 'Insert into %s.', 'referring to a post/page', 'base' ), $singular ),
		/* Translators: %s: CPT post name */
		'uploaded_to_this_item' => sprintf( _x( 'Uploaded to this %s.', 'referring to a post/page', 'base' ), $singular ),
	);

	return $labels;
}

/**
 * Post Type Helper Function - Arguments
 *
 * @since 0.1.1
 * @param array $args is the retrieved arguements.
 * @return array $labels are the various labels used for generating a CPT.
 */
function taoti_generate_post_type_args( $args = [] ) {

	$defaults = array(
		'public'              => true,
		'menu_position'       => 10,
		'hierarchical'        => true,
		'supports'            => array( 'title', 'editor', 'page-attributes', 'thumbnail', 'excerpt' ),
		'has_archive'         => true,
		'exclude_from_search' => false,
	);

	$merged = array_merge($defaults, $args);

	return $merged;
}

/**
 * Post Type Helper Function - Custom Permissions
 *
 * Helper function to add CPT permissions for various Roles
 *
 * @since 0.1.0
 * @param string $role is role to give access for.
 * @param string $singular is the singular capability.
 * @param string $plural is the plural capability.
 * @return void
 */
function taoti_add_admin_capabilities( $role, $singular, $plural ) {

	$singular = strtolower( $singular );
	$plural = strtolower( $plural );

	$role = get_role( $role );

	$role->add_cap( "edit_{$singular}" );
	$role->add_cap( "edit_{$plural}" );
	$role->add_cap( "edit_others_{$plural}" );
	$role->add_cap( "publish_{$plural}" );
	$role->add_cap( "read_{$singular}" );
	$role->add_cap( "read_private_{$plural}" );
	$role->add_cap( "delete_{$singular}" );
	$role->add_cap( "delete_{$plural}" );
	$role->add_cap( "delete_private_{$plural}" );
	$role->add_cap( "delete_others_{$plural}" );
	$role->add_cap( "edit_published_{$plural}" );
	$role->add_cap( "edit_private_{$plural}" );
	$role->add_cap( "delete_published_{$plural}" );
}