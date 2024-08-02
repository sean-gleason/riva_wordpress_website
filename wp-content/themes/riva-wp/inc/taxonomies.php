<?php
/**
 * Helper functions for generating custom taxonomies
 *
 * @package TaotiBaseTheme
 * @author Taoti Creative
 */

/**
 * Taoti Register Taxonomies
 *
 * Usage
 * Copy the array below for 'product-type' and edit as needed. $taoti_magic_taxonomy_maker_array should be an array of arrays, and those arrays make it easier to create custom taxonomies.
 * The 'slug', 'singular', and 'plural' parameters are explained below in the example array's comments.
 * 'applicable_post_types' is an array of the post type slugs that this taxonomy should apply to.
 * For the 'register_args' array, add whichever arguments you need to the array (Except for the 'labels' argument, that's automatically generated for you). The defaults will should work well 99% of the time, but you can add/override anything with this array.
 * Use the documentation on https://codex.wordpress.org/Function_Reference/register_taxonomy
 * The most common argument you might need for taxonomies is 'hierarchical'. `true` means there are parent/child relationships (like categories) and `false` is a flat structure (like tags).
 * If you don't need to add anything to the 'register_args' array, just leave it as an empty array.
 *
 * @since 0.1.1
 */
function taoti_registers_taxonomies() {

	$taoti_magic_taxonomy_maker_array = array(
		/**
		 * Taxonomies for 'People' Post Type
		 *
		 *   - Insight Type
		 */
		array(
			'slug'                  => 'insight-type',
			'singular'              => 'Type',
			'plural'                => 'Types',
			'applicable_post_types' => array(
				'insights',
			),
			'register_args'         => array(
				'hierarchical' => true,
				'rewrite'      => array(
					'with_front' => false,
				),
				'show_in_rest' => true,
			),
		),
		array(
			'slug'                  => 'sector-type',
			'singular'              => 'Sector Type',
			'plural'                => 'Sector Types',
			'applicable_post_types' => array(
				'insights',
				'solution-area',
			),
			'register_args'         => array(
				'hierarchical' => true,
				'rewrite'      => array(
					'with_front' => false,
				),
				'show_in_rest' => true,
			),
		),
		array(
			'slug'                  => 'capability',
			'singular'              => 'Capability',
			'plural'                => 'Capabilities',
			'applicable_post_types' => array(
				'insights',
				'solution-area',
			),
			'register_args'         => array(
				'hierarchical' => true,
				'rewrite'      => array(
					'with_front' => false,
				),
				'show_in_rest' => true,
			),
		),
		array(
			'slug'                  => 'insight-topic',
			'singular'              => 'Insight Topic',
			'plural'                => 'Insight Topics',
			'applicable_post_types' => array(
				'insights',
			),
			'register_args'         => array(
				'hierarchical' => true,
				'rewrite'      => array(
					'with_front' => false,
				),
				'show_in_rest' => true,
			),
		),
		array(
			'slug'                  => 'topic-cluster',
			'singular'              => 'Topic Cluster',
			'plural'                => 'Topic Cluster',
			'applicable_post_types' => array(
				'insights',
			),
			'register_args'         => array(
				'hierarchical' => true,
				'rewrite'      => array(
					'with_front' => false,
				),
				'show_in_rest' => true,
			),
		),
		array(
			'slug'                  => 'client',
			'singular'              => 'Client',
			'plural'                => 'Clients',
			'applicable_post_types' => array(
				'insights',
			),
			'register_args'         => array(
				'hierarchical' => true,
				'rewrite'      => array(
					'with_front' => false,
				),
				'show_in_rest' => true,
			),
		),
		array(
			'slug'                  => 'partnership-type',
			'singular'              => 'Partnership Type',
			'plural'                => 'Partnership Types',
			'applicable_post_types' => array(
				'partnership',
			),
			'register_args'         => array(
				'hierarchical' => true,
				'rewrite'      => array(
					'with_front' => false,
				),
				'show_in_rest' => true,
			),
		),
		array(
			'slug'                  => 'leadership-type',
			'singular'              => 'Leadership Type',
			'plural'                => 'Leadership Types',
			'applicable_post_types' => array(
				'leadership',
			),
			'register_args'         => array(
				'hierarchical' => true,
				'rewrite'      => array(
					'with_front' => false,
				),
				'show_in_rest' => true,
			),
		),
	);

	foreach ( $taoti_magic_taxonomy_maker_array as $tax_args ) {

		// Collect the data from the array.
		$singular              = $tax_args['singular'];
		$plural                = $tax_args['plural'];
		$slug                  = $tax_args['slug'];
		$applicable_post_types = $tax_args['applicable_post_types'];
		$register_args         = $tax_args['register_args'];

		// Generate the arguments that will be passed to register_taxonomy().
		$final_args = taoti_generate_tax_args_array( $slug, $register_args );

		// Generate the labels and add them to $final_args.
		$labels = taoti_generate_tax_labels_array(
			array(
				'singular' => $singular,
				'plural'   => $plural,
			)
		);

		$final_args['labels'] = $labels;

		// Finally register the taxonomy.
		register_taxonomy( $slug, $applicable_post_types, $final_args );
	}
}
add_action( 'init', 'taoti_registers_taxonomies', 0 );

/**
 * Taoti Generate Taxonomy Labels
 *
 * @since 0.1.1
 * @see taoti_registers_taxoomies().
 * @param array $args is list of Taxonomy Arguements.
 */
function taoti_generate_tax_labels_array( $args = [] ) {

	$defaults = [
		'singular' => false,
		'plural'   => false,
	];

	$merged = array_merge($defaults, $args);

	if ( in_array(false, $merged, true) ) {
		return false;
	}

	$singular           = $merged['singular'];
	$plural             = $merged['plural'];
	$singular_lowercase = strtolower( $singular );
	$plural_lowercase   = strtolower( $plural );

	$labels = array(
		'name'                       => $plural,
		'singular_name'              => $singular,
		'menu_name'                  => $plural,
		/* Translators: %s: Custom Taxonomy plural name */
		'all_items'                  => sprintf( _x( 'All %s', 'referring to a taxonomy', 'base' ), $plural ),
		/* Translators: %s: Custom Taxonomy name */
		'edit_item'                  => sprintf( _x( 'Edit %s', 'referring to a taxonomy', 'base' ), $singular ),
		/* Translators: %s: Custom Taxonomy name */
		'view_item'                  => sprintf( _x( 'View %s', 'referring to a taxonomy', 'base' ), $singular ),
		/* Translators: %s: Custom Taxonomy name */
		'update_item'                => sprintf( _x( 'Update %s', 'referring to a taxonomy', 'base' ), $singular ),
		/* Translators: %s: Custom Taxonomy name */
		'add_new_item'               => sprintf( _x( 'Add New %s', 'referring to a taxonomy', 'base' ), $singular ),
		/* Translators: %s: Custom Taxonomy name */
		'new_item_name'              => sprintf( _x( 'New %s Name', 'referring to a taxonomy', 'base' ), $singular ),
		/* Translators: %s: Custom Taxonomy name */
		'parent_item'                => sprintf( _x( 'Parent %s', 'referring to a taxonomy', 'base' ), $singular ),
		/* Translators: %s: Custom Taxonomy name */
		'parent_item_colon'          => sprintf( _x( 'Parent %s:', 'referring to a taxonomy', 'base' ), $singular ),
		/* Translators: %s: Custom Taxonomy plural name */
		'search_items'               => sprintf( _x( 'Search %s', 'referring to a taxonomy', 'base' ), $plural ),
		/* Translators: %s: Custom Taxonomy plural name */
		'popular_items'              => sprintf( _x( 'Popular %s', 'referring to a taxonomy', 'base' ), $plural ),
		/* Translators: %s: Custom Taxonomy lowercase version of plural name */
		'separate_items_with_commas' => sprintf( _x( 'Separate %s with commas', 'referring to a taxonomy', 'base' ), $plural_lowercase ),
		/* Translators: %s: Custom Taxonomy lowercase version of plural name */
		'add_or_remove_items'        => sprintf( _x( 'Add or remove %s', 'referring to a taxonomy', 'base' ), $plural_lowercase ),
		/* Translators: %s: Custom Taxonomy lowercase version of plural name */
		'choose_from_most_used'      => sprintf( _x( 'Choose from the most used  %s', 'referring to a taxonomy', 'base' ), $plural_lowercase ),
		/* Translators: %s: Custom Taxonomy lowercase version of plural name */
		'not_found'                  => sprintf( _x( 'No %s found.', 'referring to a taxonomy', 'base' ), $plural_lowercase ),
		/* Translators: %s: Custom Taxonomy lowercase version of plural name */
		'back_to_items'              => sprintf( _x( 'Back to %s', 'referring to a taxonomy', 'base' ), $plural_lowercase ),
	);
	return $labels;
}

/**
 * Taoti Generate Taxonomy Arguments
 *
 * @since 0.1.1
 * @see taoti_registers_taxoomies().
 * @param string $slug is the custom Taxonomy's slug.
 * @param array  $args is list of Taxonomy Arguements.
 */
function taoti_generate_tax_args_array( $slug, $args = [] ) {
	// These are the default arguments we use for taxonomies 99% of the time.
	$defaults = array(
		'hierarchical'      => true,
		'show_admin_column' => true,
		'rewrite'           => array(
			'slug' => $slug,
		),
	);

	$merged = array_merge($defaults, $args);

	return $merged;
}
