<?php
/**
 * The header for our theme.
 *
 * Displays all of the <head> section and everything up till <div id="content">
 *
 * @package Eveny
 */
?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="http://gmpg.org/xfn/11">
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
	<link rel="shortcut icon" href="<?php echo esc_url( get_theme_mod( 'eveny_favicon_setting' ) ); ?>" />

	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>

	<?php

		global $is_retina;

		if ( $is_retina ) {

			$retina_class = 'retina-logo';
			$logo         = get_theme_mod( 'eveny_retina_logo_setting' );

			if ( empty ( $logo ) ) {
				$logo = get_theme_mod( 'eveny_logo_setting' );
			}

		} else {

			$retina_class = '';
			$logo         = get_theme_mod( 'eveny_logo_setting' );

		}

	?>

	<div class="mobile-preloader verticalize-container">
		<div class="site-branding verticalize">

			<!-- Logo -->
			<?php if ( get_theme_mod( 'eveny_logo_setting' ) ) : ?>
				<a class="site-logo" href="<?php echo esc_url( get_home_url() ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name' ) ); ?>" rel="home">
					<img class="<?php echo esc_attr( $retina_class ); ?>" src="<?php echo esc_url( $logo ); ?>" alt="<?php echo esc_attr( get_bloginfo( 'name' ) ); ?>">
				</a>
			<?php endif; ?>
			<h1 class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php esc_html( bloginfo( 'name' ) ); ?></a></h1>
			<h2 class="site-description"><?php esc_html( bloginfo( 'description' ) ); ?></h2>

		</div><!-- .site-branding -->
	</div>

	<div id="page" class="hfeed site">
		<a class="skip-link screen-reader-text" href="#content"><?php esc_html_e( 'Skip to content', 'eveny' ); ?></a>

		<!-- Custom header on front page template -->
		<?php

			if ( is_page_template( 'templates/template-front.php' ) ) :
				$custom_header_enable = get_theme_mod( 'custom_header_enable' );

				if ( 0 != $custom_header_enable ) {
					get_header( 'custom' );
				}

			endif;

		?>

		<header id="masthead" class="site-header" role="banner">
			<div class="container clear">
				<div class="site-header__wrapper">

					<div class="site-branding">

						<!-- Logo -->
						<?php if ( get_theme_mod( 'eveny_logo_setting' ) ) : ?>
							<a class="site-logo" href="<?php echo esc_url( get_home_url() ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name' ) ); ?>" rel="home">
								<img class="<?php echo esc_attr( $retina_class ); ?>" src="<?php echo esc_url( $logo ); ?>" alt="<?php echo esc_attr( get_bloginfo( 'name' ) ); ?>">
							</a>
						<?php endif; ?>
						<h1 class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php esc_html( bloginfo( 'name' ) ); ?></a></h1>
						<h2 class="site-description"><?php esc_html( bloginfo( 'description' ) ); ?></h2>

					</div><!-- .site-branding -->

					<nav id="site-navigation" class="main-navigation" role="navigation">
						<button class="menu-toggle" aria-controls="menu" aria-expanded="false"><span class="menu-icon"></span></button>
						<?php get_template_part( '/templates/contents/content', 'navigation' ); ?>
					</nav><!-- #site-navigation -->

					<?php if ( has_nav_menu( 'social' ) ) : ?>
						<nav class="social-box">
							<a href="#" class="social-open"><?php esc_html_e( 'Connect', 'eveny' ); ?></a>
							<a href="#" class="social-close"><i class="icon-close"></i></a>
							<?php get_template_part( '/templates/contents/content', 'social-menu' ); ?>
						</nav>
					<?php endif; ?>

				</div>
			</div><!-- .container -->
		</header><!-- #masthead -->
		<div class="cookie-info">
			<p>Wir setzen auf unserer Webseite Cookies und Plugins zum Zwecke der Kundenbindung und Nutzererfahrung ein. Weitere Informationen finden Sie 
				<a href="<?php echo home_url(); ?>/datenschutzerklaerung">hier</a>. Bitte klicken Sie auf <a class="dismiss-cookie-notification" href="">Ja</a>, wenn Sie damit einverstanden sind.
				<a class="dismiss-cookie-notification" href="">&#10006;</a>		
		</div>
    
	</div>

	<div id="content" class="site-content">
