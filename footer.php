<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the #content div and all content after
 *
 * @package Eveny
 */
?>

	</div><!-- #content -->

	<footer id="colophon" class="site-footer" role="contentinfo">
		<div class="container">
			<div class="row">
				<!-- FOOTER WIDGETS -->
				<?php if ( is_active_sidebar( 'footer-widget-1' ) ) { ?>
						<div class="col-lg-3 col-sm-6 widget-area">
							<?php dynamic_sidebar( 'footer-widget-1' ); ?>
						</div>
				<?php } ?>
				<?php if ( is_active_sidebar( 'footer-widget-2' ) ) { ?>
						<div class="col-lg-3 col-sm-6 widget-area">
							<?php dynamic_sidebar( 'footer-widget-2' ); ?>
						</div>
				<?php } ?>
				<?php if ( is_active_sidebar( 'footer-widget-3' ) ) { ?>
						<div class="col-lg-3 col-sm-6 widget-area">
							<?php dynamic_sidebar( 'footer-widget-3' ); ?>
						</div>
				<?php } ?>
				<?php if ( is_active_sidebar( 'footer-widget-4' ) ) { ?>
						<div class="col-lg-3 col-sm-6 widget-area">
							<?php dynamic_sidebar( 'footer-widget-4' ); ?>
						</div>
				<?php } ?>
			</div>
			<div class="site-info">
				<?php
					$footer_text = get_theme_mod( 'footer_copyright_text' );

					if ( $footer_text ) {
						echo $footer_text;
					} else {
						_e( '&copy; Copyright 2014.', 'eveny' ); ?>
						<a href="<?php echo esc_url( __( 'http://demo.themeskingdom.com/eveny', 'eveny' ) ); ?>"><?php printf( __( 'Powered by %s.', 'eveny' ), 'WordPress' ); ?></a>
						<?php printf( __( '%1$s Theme by %2$s.', 'eveny' ), 'EVENY', '<a href="http://themeskingdom.com/" rel="designer">' . __( 'Themeskingdom', 'eveny' ) . '</a>' );
					}
				?>
			</div><!-- .site-info -->
		</div>
	</footer><!-- #colophon -->

	<a href="#" class="back-to-top">
		<i class="icon-top"></i>
	</a>

</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>
