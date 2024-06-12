<?php
/**
 * Custom User Role Functions
 *
 * @package TaotiBaseTheme
 * @author Taoti Creative
 */

/**
 * Customize Available Roles
 *
 * Only keep the Administrator, Editor, and Author roles.
 *
 * If the Contributor or Subscriber roles are needed, just uncomment.
 *
 * @since 0.1.1
 */
function taoti_remove_unused_roles() {

	if ( get_role( 'subscriber' ) ) {
			remove_role( 'subscriber' );
	}

	if ( get_role( 'contributor' ) ) {
			remove_role( 'contributor' );
	}

	/**
	 * Remove Yoast `SEO Manager` and 'SEO Editor' roles.
	 */
	if ( get_role('wpseo_manager') ) {
		remove_role( 'wpseo_manager' );
	}

	if ( get_role('wpseo_editor') ) {
		remove_role( 'wpseo_editor' );
	}

}
add_action( 'init', 'taoti_remove_unused_roles' );
