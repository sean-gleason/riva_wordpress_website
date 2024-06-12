<?php
/**
 * Edit TinyMCE toolbar stuff
 *
 * @package TaotiBaseTheme
 * @author Taoti Creative
 */

/**
 * Set options for the TinyMCE editor when it starts, like which buttons to use or things toggled on/off. Each customization is explained further within this function.
 *
 * @param array $args - array of parameters for TinyMCE editor, look up the `tiny_mce_before_init` filter for more details.
 * @return $args
 */
function taoti_tinymce_set_init_options( $args ) {
	// Always show kitchen sink in WYSIWYG Editor.
	$args['wordpress_adv_hidden'] = false;

	// Set the block formats. Prevent the client from using <h1> since those are usually included as the page title in the templates, and further customizations you need.
	$args['block_formats'] = 'Paragraph=p;Heading 2=h2;Heading 3=h3;Heading 4=h4;Heading 5=h5;Heading 6=h6';

	return $args;
}
add_filter( 'tiny_mce_before_init', 'taoti_tinymce_set_init_options' );

/**
 * Customize the buttons on the TinyMCE toolbars, for the Basic WYSIWYG (via ACF). Look through the function and comment/uncomment as needed for the project.
 *
 * @todo Audit this function for code elegance.
 * @param array $toolbars - array - each item in the array corresponds to a buton in the TinyMCE toolbar. Example print_routput below.
 * @return $toolbars
 */
function taoti_tinymce_toolbar_buttons( $toolbars ) {
	/*
	Use: echo "<pre>"; print_r($toolbars); echo "</pre>";
	Here's what gets output when you print_r($toolbars):
	Array
	(
		[Basic] => Array
		(
			[1] => Array
			(
				[0] => bold
				[1] => italic
				[2] => underline
				[3] => blockquote
				[4] => strikethrough
				[5] => bullist
				[6] => numlist
				[7] => alignleft
				[8] => aligncenter
				[9] => alignright
				[10] => undo
				[11] => redo
				[12] => link
				[13] => unlink
				[14] => fullscreen
			)
		)
	)
	*/

	$toolbar_options = array(
		'fullscreen',
		'justifyleft',
		'justifycenter',
		'justifyright',
		'blockquote',
		'strikethrough',
		'underline',
		// 'bullist'
		// 'numlist'
		'alignleft',
		'aligncenter',
		'alignright',
		// 'link',
		// 'unlink',
	);

	/**
	 * Removing the $toolbar_options buttons from the light WYSIWYG
	 */
	foreach ( $toolbar_options as $toolbar_option ) {
		if ( false !== $toolbars['Basic'][1][ $toolbar_option ] ) {
			unset( $toolbars['Basic'][1][ $toolbar_option ] );
		}
	}

	/**
	 * Add the Paste as PlainText to the light WYSIWYG
	 */
	if ( isset( $toolbars['Basic'][1] ) ) {
		$toolbars['Basic'][1][] = 'pastetext';
	}

	return $toolbars;
}
add_filter( 'acf/fields/wysiwyg/toolbars', 'taoti_tinymce_toolbar_buttons'  );

/**
 * Customize the FIRST row of the Full TinyMCE WYSIWYG buttons
 *
 * Dev-Testing:
 *   echo "<pre>"; print_r($buttons); echo "</pre>";
 *
 * @since 0.1.1
 * @param array $buttons - List of available $buttons from TinyMCE.
 */
function taoti_tinymce_buttons_full_row1( $buttons ) {
	/*
	Array (
		[0] => bold
			[1] => italic
			[2] => strikethrough
			[3] => bullist
			[4] => numlist
			[5] => blockquote
			[6] => hr
			[7] => alignleft
			[8] => aligncenter
			[9] => alignright
			[10] => link
			[11] => unlink
			[12] => wp_more
			[13] => spellchecker
			[14] => fullscreen
			[15] => wp_adv
	)
	*/

	// Remove things like 'strikethrough' and alignment options - things we generally leave up to the design and not to a WYSIWYG.
	$remove = array( 'strikethrough', 'alignleft', 'aligncenter', 'alignright', 'wp_more', 'fullscreen' );

	return array_diff( $buttons, $remove );
}
add_filter( 'mce_buttons', 'taoti_tinymce_buttons_full_row1' );

/**
 * For the SECOND row of the Full TinyMCE WYSIWYG buttons
 *
 * Dev-Testing
 *   echo "<pre>"; print_r($buttons); echo "</pre>";
 *
 * @since 0.1.1
 * @param array $buttons - The array of button attributes.
 */
function taoti_tinymce_buttons_full_row2( $buttons ) {
	/*
	Array (
			[0] => formatselect
			[1] => underline
			[2] => alignjustify
			[3] => forecolor
			[4] => pastetext
			[5] => removeformat
			[6] => charmap
			[7] => outdent
			[8] => indent
			[9] => undo
			[10] => redo
			[11] => wp_help
	)
	*/
	/**
	 * Remove the format dropdown select and text color selector
	 */
	$remove = array( 'underline', 'strikethrough', 'alignjustify', 'forecolor', 'outdent', 'indent', 'wp_help' );

	return array_diff( $buttons, $remove );
}
add_filter( 'mce_buttons_2', 'taoti_tinymce_buttons_full_row2' );
