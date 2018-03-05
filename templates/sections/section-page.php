<?php
/**
 * The template for displaying Page content on template-front.php.
 *
 * @package Eveny
 *
 * @since Eveny 1.0
 */

$page_id = esc_html( get_theme_mod( 'page_content_select' ) );

?>

<div class="template-front-page">
    <div class="container clear">

		<?php
			echo apply_filters( 'the_content', get_post_field( 'post_content', $page_id ) );
		?>

    </div><!-- container -->
</div><!-- template-front-events -->

<?php wp_reset_postdata(); ?>
