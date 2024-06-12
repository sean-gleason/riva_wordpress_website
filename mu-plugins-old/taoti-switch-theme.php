<?php
/**
 * Taoti Swtich Theme
 *
 * @package Taoti Swtich Theme
 * @author Taoti Creative
 *
 * @wordpress-plugin
 * Plugin Name: Theme Switcher
 * Plugin URI: https://github.com/Taoti/wordpress-ci
 * Description: Automatically switches to the base theme when WP realizes the twentyX themes have been removed.
 * Version: 1.0.0
 * Author: James Pfleiderer
 * Author URI: https://taoti.com
 * Text Domain: theme-switcher
 */

/**
 * Set Default Theme
 *
 * Since the twentyX themes are deleted from that repo, WordPress will normally complain that 'the twentyX theme does not exist.' until you go to the Dashboard and switch the theme.
 *
 * This plugin will automatically determine if a theme is not set, in which case it will switch to the 'taoti-base-them' theme. Useful for when Pantheon deploys a new site based on our custom WordPress upstream.
 *
 * @return void
 */
function taoti_switch_theme() {

	if ( is_blog_installed() ) {
		$current_theme = wp_get_theme();

		if ( false === $current_theme->exists() ) {
			switch_theme( 'riva-wp' );
		}
	}

}
add_action( 'setup_theme', 'taoti_switch_theme', 1 );
