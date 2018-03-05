<?php
/**
 * The template for displaying Quotes on template-front.php.
 *
 * @package Eveny
 *
 * @since Eveny 1.0
 */

?>
<?php
$args = array(
	'post_type'              => array( 'quote' ),
	'post_status'            => array( 'publish' ),
	'nopaging'               => true,
);
?>

<div class="template-front-quotes">
    <div class="container clear">

        <?php $query = new WP_Query( $args ); ?>

        <?php if ( $query->have_posts() ) : ?>

            <div class="event-list">
                <div class="quote-slider-wrap">

                    <div class="quote-slider">

                            <?php while ( $query->have_posts() ) : $query->the_post(); ?>

                                <article class="quote">
                                 
                                    <p class="quote-content"><?php the_field('quote_content'); ?> </p>
                                    <h4 class="quote-name"><?php the_field('quote_name'); ?></h4>
                                    
                                </article>

                            <?php endwhile; ?>

                    </div><!-- quote-slider -->

                    <?php wp_reset_postdata(); ?>

                </div><!-- event-slider-wrap -->
            </div><!-- event-list -->

        <?php else : ?>

            <?php
                printf( '<h1 class="entry-title">%s</h1>',
                    esc_html__( 'Noch keine Zitate eingetragen.', 'eveny' )
                    // esc_url( site_url() . '/konzerte' ),
                    // esc_html__( 'Konzertarchiv', 'eveny' )
                );
            ?>

        <?php endif; ?>

    </div><!-- container -->
</div><!-- template-front-events -->

<?php wp_reset_postdata(); ?>
