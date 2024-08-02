<?php
/**
 * Template: SearchForm
 *
 * @package TaotiBaseTheme
 * @author Taoti Creative
 */

$context = Timber::get_context();
$site    = new TimberSite();

Timber::render( 'searchform.twig', $context );
