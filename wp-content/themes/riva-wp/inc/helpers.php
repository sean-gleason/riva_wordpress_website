<?php
/**
 * Helper Functions
 *
 * @package TaotiBaseTheme
 * @author Taoti Creative
 */

// These functions help other areas in the code process or retrieve something. Most likely, helper functions will have a return value.

/**
 * PURPOSE : Shortens a string by character count, add optional ellipsis.
 *   NOTES : This will run wp_strip_all_tags() on the given string.
 *
 * @since 0.1.1
 * @param string  $string (string) - the string you want to shorten.
 * @param num     $length (int) - the number of characters to shorten the string to.
 * @param boolean $ellipsis (boolean) - True to add the ellipsis, false to leave it off.
 * @return string $excerpt the shortened string, or original string if it wasn't shortened.
 */
function taoti_substr( $string, $length = 50, $ellipsis = true ) {
    $excerpt = wp_strip_all_tags($string, true);

    if ( strlen($excerpt) > $length ) {
        $excerpt  = substr($excerpt, 0, $length);
        $excerpt .= ( $ellipsis ) ? '<em class="ellipsis">&hellip;</em>' : '';
    }

    return $excerpt;
}

/**
 * PURPOSE : Retrieve a post's primary term for a given taxonomy, or at least get the first term in the list.
 *
 * NOTES :  Yoast has a feature that can mark a term as the "primary term", for posts that have multiple terms selected. This function will attempt to retrieve that first, and fall back on the first term in the list if Yoast is not installed.
 *
 * @since 0.1.1
 * @param num    $post_id (int) The ID for the post.
 * @param string $taxonomy_slug (string) The slug name for the taxonomy.
 * @return obj $primary_term A WP_Term object.
 */
function taoti_get_primary_term( $post_id, $taxonomy_slug = 'category' ) {
    if ( ! $post_id ) {
        global $post;

        if ( isset( $post->ID ) ) {
            $post_id = $post->ID;
        }
    }

    if ( ! $post_id ) {
        return false;
    }

    $primary_term = false;

    $terms = get_the_terms( $post_id, $taxonomy_slug );

    if ( is_array($terms) && ! empty( $terms ) ) {

        // Assume we'll use the first term as the primary term.
        $primary_term = $terms[0];

        // But if Yoast is installed, get the actual primary term.
        if ( class_exists('WPSEO_Primary_Term') ) {
            $wpseo_primary_term_object = new WPSEO_Primary_Term( $taxonomy_slug, $post_id );
            $wpseo_primary_term_id     = $wpseo_primary_term_object->get_primary_term();

            $term_object = get_term( $wpseo_primary_term_id );
            if ( ! is_wp_error( $term_object ) ) {
                $primary_term = $term_object;
            }

        }

    }

    return $primary_term;
}
