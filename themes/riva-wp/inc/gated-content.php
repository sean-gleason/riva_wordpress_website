<?php
add_filter( 'gform_confirmation', 'download_gated_content', 10, 4 );
function download_gated_content( $confirmation, $form, $entry, $ajax ) {
    global $post;
    $download_file = get_field('download_file', $post->ID);

    if( $form['id'] == '1' && $download_file) {
        
        /*
        // Get path to file
        $download_file = getcwd() . substr($download_file, strpos($download_file, '/wp-content/'));
        // Force the download of the file
        header('Content-Type: application/octet-stream');
        header("Content-Transfer-Encoding: Binary");
        header("Content-disposition: attachment; filename=\"" . basename($download_file) . "\"");
        readfile($download_file);
        */
        
        // $confirmation = array( 'redirect' => $download_file );

        $confirmation .= '<br /><a href="' . $download_file . '" target="_blank">Click here to download the article</a>';

    } 

    return $confirmation;
}

// Filter used to have AJAX submissions on Gravity Forms
add_filter( 'gform_init_scripts_footer', '__return_true' );