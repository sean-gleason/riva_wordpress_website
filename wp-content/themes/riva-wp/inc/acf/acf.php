<?php
/**
 * Customizations for ACF go here.
 *
 * @package TaotiBaseTheme
 * @author Taoti Creative
 */

/**
 * PURPOSE : Filter into ACF to allow URL fields to accept strings that start with "tel:" as valid URLs.
 *   NOTES : https://www.advancedcustomfields.com/resources/acf-validate_value/
 *
 * @param boolean $valid true / false whether valid or not.
 * @param string  $value value from ACF field.
 * @param object  $field is the associated ACF field.
 * @param string  $input user's inputted telephone number.
 * @return boolean $valid confirms that the saved field is valid.
 */
function taoti_acf_validate_url( $valid, $value, $field, $input ) {

    // These are strings that a possible URL can start with and still be a valid URL. Otherwise it only accepts strings that start with 'http://' or 'https://'.
    $valid_url_prefixes = [
        'tel:', // Allow telephone links.
        'mailto:', // Allow email links.
        '#', // Allow jump/null links.
    ];

    foreach ( $valid_url_prefixes as $prefix ) {
        if ( strpos($value, $prefix) === 0 ) {
            // If $value (the string value from the ACF field) starts with one of the prefixes defined above, then this is a valid URL.
            $valid = true;
        }
    }

	return $valid;

}
add_filter('acf/validate_value/type=url', 'taoti_acf_validate_url', 20, 4);

/**
 * Add 'Options' to content, if present.
 *
 * @param array $context is the Timber site-wide context array.
 */
function taoti_timber_context( $context ) {
	// Add the 'Options' to Context, if present.
	if ( get_fields('option') ) {
		$context['options'] = get_fields('option');
	}

	return $context;
}
add_filter( 'timber_context', 'taoti_timber_context'  );

/**
 * ACF - WSYIWYG Customizer
 *
 * Edits the layout and configuration of the 'WYSIWYG' editor within ACF blocks.
 *
 * @param array $toolbars is the array of available toolbars; defaults to 'Full' and 'Basic'.
 * @return array $toolbars is the updated toolbars configuration.
 * @see https://www.advancedcustomfields.com/resources/customize-the-wysiwyg-toolbars/
 */
function taoti_toolbars( $toolbars ) {

	/**
	 * Allow 'wpDatatables' buttons on 'Basic' toolbar
	 *
	 * The 'wpdatatable' and 'wpdatachart' are added to the WYSIWYG editor by wpDatatables.
	 *
	 * @see https://wpdatatables.com/documentation/general/wpdatatables-shortcodes/
	 */
	// Add 'wpdatatable' to 'Basic'.
	$toolbars['Basic'][1][] = 'wpdatatable';

	// Add 'wpdatachart' to 'Basic'.
	$toolbars['Basic'][1][] = 'wpdatachart';

	return $toolbars;

}
add_filter( 'acf/fields/wysiwyg/toolbars', 'taoti_toolbars'  );
