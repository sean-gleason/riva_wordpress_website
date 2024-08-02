<?php
/**
 * Helper: Admin Bar
 *
 * Customize the WP Admin Bar.
 *
 * @package TaotiBaseTheme
 * @author Taoti Creative
 */

/**
 * Taoti Customizing Toolbar
 *
 * Add 'Edit' and 'View' buttons to the toolbar for custom options pages that manage post type archives.
 *
 * @since 0.1.1
 * @see https://codex.wordpress.org/Function_Reference/add_node
 */
function taoti_admin_bar_customize() {
    global $wp_admin_bar;

    /**
     * Example
     *
     * If viewing the reviews archive, add a link to the toolbar to the ACF edit screen.
     *
     * Usage:
     *  add_action( 'admin_bar_menu', 'taoti_admin_bar_customize', 75 );
     */
    if ( is_post_type_archive('review') ) {
        $args = array(
            'id'    => 'edit', // This is what adds the pencil icon to the button.
            'title' => 'Edit Reviews Page',
            'href'  => admin_url('edit.php?post_type=review&page=acf-options-reviews-archive-page'),
        );
        $wp_admin_bar->add_node( $args );
    }
    // If on the ACF edit screen for the reviews archive, add a 'view' link to the toolbar.
    if ( function_exists('get_current_screen') ) {
        $screen = get_current_screen();

        if ( is_admin() && isset($screen->id) && 'review_page_acf-options-reviews-archive-page' === $screen->id ) {
            $args = array(
                'title' => 'View Reviews Archive',
                'href'  => get_post_type_archive_link( 'review' ),
            );
            $wp_admin_bar->add_node( $args );
        }
    }
}

/**
 * Remove the Admin Bar's 'WordPress' link
 *
 * PURPOSE : For logged in users (admins) hide the WordPress link in the admin bar.
 *
 * @since 0.1.1
 * @see For the Dashboard area, the same button is hidden in `styles/scss/admin/style-admin.scss`.
 */
function taoti_hide_wp_link_in_admin_bar() {
    if ( is_user_logged_in() ) : ?>
        <style>#wp-admin-bar-wp-logo{display:none}</style>
        <?php
    endif;

}
add_action( 'wp_head', 'taoti_hide_wp_link_in_admin_bar' );
