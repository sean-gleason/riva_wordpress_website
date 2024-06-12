<?php
/**
 * Partial Template: Header
 *
 * @package TaotiBaseTheme
 * @author Taoti Creative
 * @todo Add logo for RIVA.
 */

?>
<!DOCTYPE html>
<html lang="en-US">

<head>
    <?php
	/** Use js/development/after-libs/web-font-loader.js to load fonts. */
	?>

    <?php
	/**
	 * Common prefetches
	 * <link rel="dns-prefetch" href="https://fonts.googleapis.com">
	 * <link rel="dns-prefetch" href="https://ajax.googleapis.com">
	 * <link rel="dns-prefetch" href="https://www.google-analytics.com">
	 * <link rel="dns-prefetch" href="https://www.googletagmanager.com">
	 * <link rel="dns-prefetch" href="https://use.typekit.net">
	 */
	?>

    <?php /**

* <link rel="dns-prefetch" href="https://fonts.googleapis.com">

*/ ?>

    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <?php
	/*
	<!-- http://realfavicongenerator.net/ -->
	<link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon.png">
	<link rel="icon" type="image/png" sizes="32x32" href="/favicon-32x32.png">
	<link rel="icon" type="image/png" sizes="16x16" href="/favicon-16x16.png">
	<link rel="manifest" href="/manifest.json">
	<link rel="mask-icon" href="/safari-pinned-tab.svg" color="#45a9ba">
	<meta name="theme-color" content="#ffffff">
	*/
	?>

    <?php wp_head(); ?>

    <?php
		/** Set up critical and non critical CSS. */
		do_action('taoti_do_css');
	?>
    sdds
</head>

<body <?php body_class(); ?>>
    sdsd
    <header id=" header">
        <div id="header-inner">
            <h1 class="page-title"><?php the_title(); ?></h1>
            <!--<a href="<?php echo esc_url( home_url() ); ?>" class="header-logo">
		<?php echo esc_html( file_get_contents( get_template_directory() . '/images/logo_riva.svg' ) ); ?>
	</a>-->
            <?php
			$theme_location = 'main-navigation';
			if ( has_nav_menu( $theme_location ) ) :
				$args = [
					'theme_location' => $theme_location,
					'item_spacing'   => 'discard',
					'container'      => 'nav',
					'menu_class'     => 'menu-' . $theme_location,
				];
				wp_nav_menu( $args );

			endif;
			?>

        </div>
    </header>