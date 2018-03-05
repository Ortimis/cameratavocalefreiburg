<?php
/**
 * The template for displaying 404 pages (not found).
 *
 * @package Eveny
 */

get_header();

$content_class = 'col-lg-12';

if ( is_active_sidebar( 'sidebar-1' ) ) {
	$content_class = 'col-lg-9 col-md-8';
}

?>

<div class="container">
	<div class="row">
		<div id="primary" class="content-area  <?php echo esc_attr( $content_class ); ?>">
			<main id="main" class="site-main" role="main">

				<section class="error-404 not-found">

					<header class="page-header">
						<h1 class="page-title"><?php esc_html_e( 'Die gesuchte Seite existiert leider nicht.', 'eveny' ); ?></h1>
					</header>

					<div class="page-content">

						<?php

							printf( '<p>%s<a href="%s">%s</a></p>',
									__( 'Überprüfen Sie die Adresse auf Rechtschreibfehler, oder besuchen Sie die', 'eveny' ),
									esc_url( get_home_url() ),
									__( 'Startseite', 'eveny' )
							  );
						?>

					</div><!-- .page-content -->

				</section><!-- .error-404 -->

			</main><!-- #main -->
		</div><!-- #primary -->
	</div><!-- .row -->
</div><!-- .container -->

<?php get_footer(); ?>
