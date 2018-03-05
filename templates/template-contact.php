<?php
session_start();
/**
 * Template Name: Contact Us
 *
 * @package  Eveny
 */

get_header();

$content_class = 'col-lg-10';
$hide_map      = esc_attr( get_theme_mod( 'eveny_contact_map_setting' ) );
$contact_form  = esc_attr( get_theme_mod( 'eveny_contact_form_setting' ) );

if ( is_active_sidebar( 'sidebar-1' ) ) {
    $content_class = 'col-lg-9 col-md-8';
}

// Google MAP
if ( ! $hide_map ) :

    if ( '' == get_theme_mod( 'eveny_contact_contact_map_api', '' ) ) {
        echo '<h5 align="center">You have to enter Google Maps API key in Customizer Contact Settings in order to display Google Map!</h5>';
    }

    // Display Generated Google Map
    get_template_part( '/templates/contents/contact', 'map' );

endif;

?>

<div class="container">

    <div class="row">

        <div id="primary" class="content-area <?php echo esc_attr( $content_class ); ?>">
            <main id="main" class="site-main" role="main">

                <header class="entry-header contact-header">
                    <?php printf( '<h1 class="entry-title">%s</h1>', esc_html( get_the_title() ) ); ?>
                </header><!-- .entry-header -->

                    <?php if ( have_posts() ) : ?>

                        <?php while ( have_posts() ) : the_post(); ?>

                            <article id="post-<?php the_ID(); ?>" <?php post_class( 'clear' ); ?>>

                                <?php the_content(); ?>

                            </article>

                        <?php endwhile; ?>

                    <?php endif;?>

                    <?php if ( empty( $contact_form ) ) { ?>
                            <!-- Display Contact form -->
                            <?php get_template_part( '/templates/contents/contact', 'form' ); ?>
                    <?php } ?>

            </main><!-- #main -->
        </div><!-- #primary -->

        <?php get_sidebar(); ?>

    </div><!-- row -->
</div><!-- container -->

<?php get_footer(); ?>
